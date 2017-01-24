var Utils = [],
    doc = $(document),
    win = $(win),
    body = $("body");
var Stock = [],
    Order=[],
    Login = [],
    Employe = [],
    Admin = [],
    
    reqOptions = {}, gr_obj = {};
var typingTimer; //timer identifier
var doneTypingInterval = 1500; //time in ms, 2.5 second for example
PNotify.prototype.options.styling = "brighttheme";
PNotify.stack_bottomright = {
    "dir1": "up",
    "dir2": "left",
    "firstpos1": 0,
    "firstpos2": 25
};

    $.fn.serializeObject = function(){
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

/*google.charts.load('current', {'packages':['corechart']});*/
Utils.toMillions = function(number) {
    splitAt = 3;
    //number = Math.round(number, 2);
    number = number.toString().split('').reverse().join("");
    n = number.split('.');
    number = n[n.length - 1];
    number = number.match(new RegExp('.{1,' + splitAt + '}', 'g'));
    r = '';
    for (i = number.length - 1; i > 0; i--) {
        number[i] = number[i].split('').reverse().join("");
        r += number[i] + ',';
    };
    number[i] = number[i].split('').reverse().join("");
    r += number[i];
    if (n.length == 2) r += '.' + n[0];
    return r;
};
Utils.showDialog = function(title, content, extras = {}) {
    settings = {
        overlay: true,
        shadow: true,
        flat: false,
        icon: '',
        title: 'Flat window',
        draggable: true,
        sysButtons: {
            // btnMin: true,
            // btnMax: true,
            btnClose: true
        },
        content: '',
        padding: 10,
        onShow: function(_dialog) {
            $.Dialog.title(title);
            $.Dialog.content(content);
            $.Metro.initInputs();
        }
    }
    $.extend(settings, extras);
    $.Dialog(settings);
}
Utils.dataTable = function(selector, cols, callback) {
    total = [], pageTotal = [];
    dt = $(selector).DataTable({
        "footerCallback": function(row, data, start, end, display) {
            var api = this.api(),
                data;
            // Remove the formatting to get integer data for summation
            var intVal = function(i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
            i = 0;
            $.each(cols, function(index, col) {
                // Total over all pages
                total[i] = api.column(col).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                // Total over this page
                pageTotal[i] = api.column(col, {
                    page: 'current'
                }).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                i++;
            }); //each
            i = 0;
            if (typeof callback === "undefined") {
                $.each(cols, function(index, col) {
                    $(api.column(col).footer()).html(Utils.toMillions(Math.round(pageTotal[i])) + '(' + Math.round(total[i]) + ')');
                });
            } else {
                callback(pageTotal, total);
            }
        } //footerCallback
    }); //DataTable
    return dt;
};
Utils.startWait = function() {
    $("#overlay").show();
};
Utils.stopWait = function() {
    $("#overlay").hide();
};
Utils.loadPage = function(this_) {
    Utils.startWait();
    link = this_.attr("data-link");
    $("#dashboard_content").load(link, function() {
        switch (link) {
            case "stock/manage-stock":
                Stock.preparedatatable();
                break;
            case "supplier/suppliers-main":
                Stock.preparedatatable();
                break;
            case "po/new-po":
                PO.preparePo();
                break;
        }
        Utils.stopWait();
    });
}
Utils.msgSuccess = function(msg) {
    // $.notify(msg, "success");
    $(function() {
        new PNotify({
            title: 'Success',
            text: msg,
            type: 'success',
            hide: true,
            delay: 2000,
            icon: false,
            buttons: {
                sticker: false,
                sticker_hover: false
            },
            animate_speed: "slow",
            animate: {
                animate: true,
                in_class: "rotateInDownLeft",
                out_class: "rotateOutUpRight",
            },
            addclass: "stack-bottomright",
            stack: PNotify.stack_bottomright
        });
    });
}
Utils.msgWarning = function(msg) {
    // $.notify(msg, "success");
    $(function() {
        new PNotify({
            title: 'Warning',
            text: msg,
            type: 'warning',
            hide: true,
            delay: 2000,
            icon: false,
            buttons: {
                sticker: false,
                sticker_hover: false
            },
            animate_speed: "slow",
            animate: {
                animate: true,
                in_class: "rotateInDownLeft",
                out_class: "rotateOutUpRight",
            },
            addclass: "stack-bottomright",
            stack: PNotify.stack_bottomright
        });
    });
}
Utils.msgError = function(msg) {
    // $.notify(msg, "error");
    $(function() {
        new PNotify({
            title: 'Error',
            text: msg,
            type: 'error',
            hide: true,
            delay: 2000,
            icon: false,
            buttons: {
                sticker: false,
                sticker_hover: false
            },
            animate_speed: "slow",
            animate: {
                animate: true,
                in_class: "rotateInDownLeft",
                out_class: "rotateOutUpRight",
            },
            addclass: "stack-bottomright",
            stack: PNotify.stack_bottomright
        });
    });
}
Utils.smartError = function(form_name, errors) {
    $("#" + form_name + " :input").each(function() {
        $(this).removeClass('has-error');
    });
    arr = [];
    er = $.parseJSON(errors);
    elist = '<ul>';
    $.each(er, function(key, value) {
        $.each(value, function(k, v) {
            if (arr.indexOf(v) == -1) {
                arr.push(v);
                elist += '<li>' + v + '</li>';
            }
        });
        // if(key.indexOf('.') == -1){
        // 	$("#"+key).addClass('has-error');
        // 	$("input[name="+key+"]").addClass('has-error');
        // }
        a = key.split('.');
        if (a.length > 1) key = a[0] + '[' + a[1] + ']';
        $("#" + key).addClass('has-error');
        $("input[name='" + key + "']").addClass('has-error');
    });
    elist += '</ul>';
    // $("#"+error_div).html(elist);    
    // $("#"+error_div).fadeIn(4000, "linear");
    // $("#"+error_div).show();
    Utils.msgError(elist);
}
Utils.post = function(url, success, input, error, extras) {
    reqOptions = {};
    if (typeof extras === "undefined") {
        extras = {};
    }
    if (typeof extras['dataType'] === "undefined") {
        extras['dataType'] = 'json';
    }
    if (typeof extras['type'] === "undefined") {
        extras['type'] = 'post';
    }
    extras['url'] = url;
    extras['data'] = input;
    extras['success'] = function(data, status, xhr) {
        Utils.stopWait();   
        
        if (typeof success === "undefined" || success == "default") {
            Utils.msgSuccess('Action performed Successfully');
        } else if(data.access == false){
            Utils.msgError("You are not authorized for this");
        } else{
            success(data, status, xhr);
        } 
    };
    extras['error'] = function(data) {
        
        Utils.stopWait();
        if (typeof error === "undefined" || error == "default") {
            Utils.msgError("Some error has occured!");
        } else {
            error(data);
        }
    };
    reqOptions = extras;
    Utils.startWait();
    $.ajax(extras);
    return false;
};
Utils.get = function(url, success, input, error) {
    Utils.post(url, success, input, error, {
        type: 'get'
    });
}
Stock.showDetails = function(id) {
    Utils.startWait();
    $("#dashboard_content").load('stock/edit-stock?id=' + id, function() {
        Utils.stopWait();
    });
}
Stock.preparedatatable = function() {
    $('#data_table').dataTable();
}
Stock.save = function() {
    var check_suplier = $("[name='supplier_id']").val();
    if (check_suplier != 0) {
        Utils.post('stock/save-stock', function(data) {
            if (data.success) {
                Utils.msgSuccess('New Stock added Successfully!');
                $("#dashboard_content").load('stock/manage-stock');
                Stock.preparedatatable();
            } else {
                Utils.smartError('stockForm', data.error);
            }
        }, $('#stockForm').serialize());
    } else {
        Utils.msgError("Please select the Supplier");
    }
}
Stock.saveNewStockCategory = function() {
    Utils.post('stock/save-stock-category', function(data) {
        if (data.success) {
            Utils.msgSuccess('Menu Category saved Successfully!');
            $("#dashboard_content").load('stock/manage-categories');
            Stock.preparedatatable();
        } else {
            Utils.smartError('stockCategoryForm', data.error);
        }
    }, $('#stockCategoryForm').serialize());
}
Stock.showStockCategory = function(id) {
    $("#dashboard_content").load('stock/edit-stock-category?id=' + id);
}
Stock.edit = function() {
    var check_suplier = $("[name='supplier_id']").val();
    if (check_suplier != 0) {
        Utils.post('stock/edit-stock', function(data) {
            if (data.success) {
                Utils.msgSuccess('Stock updated Successfully!');
                $("#dashboard_content").load('stock/manage-stock');
                console.log('Data table is working');
                setTimeout(function() {
                    Stock.preparedatatable();
                }, 1000);
            } else {
                Utils.smartError('stockForm', data.error);
            }
        }, $('#stockForm').serialize());
    } else {
        Utils.msgError("Please select the Supplier");
    }
}
Stock.confirmDelete = function(id) {
    str = '<button type="button" class="button danger" data-dismiss="modal" onClick="Stock.delete(' + id + ')">Yes</button>';
    str += '&nbsp;&nbsp;<button type="button" class="button default" onclick="$.Dialog.close()">No</button>';
    var content_h = '<div class="modal-content">\
				<div class="modal-header">\
					<h4 id="super-modal-title">Confirm Delete</h4>\
				</div>\
<div class="modal-body" id="super-modal-body">\
				<p>Are you sure to delete selected Menu?</p></div>\
				<div class="modal-footer" id="super-modal-footer">' + str + '</div></div>'
    Utils.showDialog('Stock Delete', content_h);
}
Stock.delete = function(id) {
    Utils.post('stock/delete-stock', function(data) {
        if (data.success) {
            $.Dialog.close();
            Utils.msgSuccess(data.msg);
            $("#dashboard_content").load('stock/manage-stock');
            Stock.preparedatatable();
        } else {
            Utils.msgError(data.error);
        }
    }, {
        id: id
    });
}
//////////end of stock................



/////////end of customer..........
Employe.prepareMain = function() {
    Utils.stopWait();
    $('button[action=edit]').bind('click', function() {
        id = $(this).attr('data-id');
        Utils.startWait();
        $('#dashboard_content').load('employe/new-employe?id=' + id, function() {
            Utils.stopWait();
        });
    });
}
Employe.save = function() {
    Utils.post('employe/save-employe', function(data) {
        if (data.success) {
            Utils.msgSuccess('New Customer added Successfully!');
            $("#dashboard_content").load('employe/employees-main');
            console.log('data table is working');
            Stock.preparedatatable();
        } else {
            Utils.smartError('employeForm', data.error);
        }
    }, $('#employeForm').serialize());
}

Employe.saveAppUser=function(){

    Utils.startWait();
     Utils.post('employe/save-appuser', function(data) {
        if (data.success) {
            Utils.msgSuccess('New App User added Successfully!');
            $("#dashboard_content").load('employe/employees-main');
            console.log('data table is working');
            //Stock.preparedatatable();
            Utils.stopWait();
        } else {
            Utils.msgError('Some thing wents wrong!');
            Utils.stopWait();
        }
    }, $('#employeForm').serialize());
     Utils.stopWait();
    }

$(document).on('change','select[name=emp_id]',function() {

        Utils.startWait();
        emp_id=$(this).val();
        if(emp_id==0){
            Utils.msgError('Please select valid user!');
            Utils.stopWait();
            return false
           
        }

         Utils.post('employe/app-user', function(data) {
        if (data.success) {
            
            if(data.app_data!=null){
                app_u=data.app_data;
                $('select[name=role_id]').val(app_u.role_id);
                $('input[name=username]').val(app_u.username);
                $('input[name=password]').val(app_u.password);
                $('input[name=username]').attr('readonly','readonly');               
            }else{

                $('select[name=role_id]').val(0);
                $('input[name=username]').val("");
                $('input[name=password]').val("");
                $('input[name=username]').removeAttr('disabled');
            }
            //Stock.preparedatatable();
            Utils.stopWait();
        } else {
            $('#employeForm')[0].reset()
            Utils.stopWait();
        }
     }, {'emp_id':emp_id});
     Utils.stopWait();   
  });

Employe.showDetails = function(id) {
    Utils.startWait();
    $("#dashboard_content").load('employe/edit-employe?id=' + id, function() {
        Utils.stopWait();
    });
}
Employe.saveNewEmployeCategory = function() {
    Utils.post('employe/save-employe-category', function(data) {
        if (data.success) {
            Utils.msgSuccess('New employe roll added Successfully!');
            $("#dashboard_content").load('employe/employe-category-main');
            Stock.preparedatatable();
        } else {
            Utils.smartError('employeCategoryForm', data.error);
        }
    }, $('#employeCategoryForm').serialize());
}
Employe.showEmployeCategory = function(id) {
    $("#dashboard_content").load('employe/edit-employe-category?id=' + id);
}


Admin.saveRole = function(){
    Utils.post("admin/save-role", function(data) {
        if (data.success) {
            Utils.msgSuccess(data.msg);
            $("#dashboard_content").load("admin/roles");
        } else {
            Utils.smartError('rolesForm', data.error);
        }
    }, $("form#rolesForm").serialize());
}

Admin.editRole = function(id){
    $("#dashboard_content").load("admin/user-privileges?role_id="+id);
}

Admin.saveNewAppRole =function(){

     Utils.post("admin/save-app-role", function(data) {
        if (data.success) {
            Utils.msgSuccess(data.msg);
            $("#dashboard_content").load("admin/roles");
        } else {
            Utils.smartError('rolesForm', data.error);
        }
    }, $("form#employeRoleForm").serialize());
}

$('.cats').click(function(){
    cat_id=$(this).attr('cat-id');
    console.log($(this).attr('cat-id'));
    $.ajax({
        type:'GET',
        data:{'cat_id':cat_id},
        url:'stock/cat-by-id',
        dataType:'json',
        success:function(data){
        if(data.success==true){ 
                var menuss="<table id='select_menu'><tr><th>Menu Name</th><th>Full</th><th>Half</th><th>Action</th></tr>";
                $(data.data).each(function(i){
                menuss+="<tr data-menu-name='"+data.data[i].name+"' data-menu-id='"+data.data[i].id+"' data-menu-cat-id='"+data.data[i].cat_id+"'><td>"+data.data[i].name+"</td><td><div class='input-control radio'><label><input type='radio' name='qty_"+data.data[i].id+"' value='"+data.data[i].full+"' data-qty='full' /><span class='check'></span>"+data.data[i].full+"</label></div></td><td><div class='input-control radio'><label><input type='radio' value='"+data.data[i].half+"' data-qty='half' name='qty_"+data.data[i].id+"' /><span class='check'></span>"+data.data[i].half+"</label></div></td><td class='remove_menu_td'><i class='remove_menu icon-remove'></i></td></tr>";
                })
                menuss+="</table>";
              $('.menus').html(menuss);
              $('.menus').append( "<div class='action-btns'><button type=button class='button default' onClick='Order.set_menus()'  id='btnSave_Ses'>save</button>&nbsp;&nbsp;<button type=button class='button default' onclick='location.reload();' id='btn_cancel'>Cancel</button></div>" ); 
              /*<button type=button>*/
               // console.log('test-data',data);
            }
        },
        error:function(data){
       }
    })  
})


$(document).on('click','.remove_menu',function(){
    menu_id=$(this).parents('tr').attr('data-menu-id');
    $(this).parents('tr').find('input[name=qty_'+menu_id+']').attr('checked',false)
})

Order.set_menus=function(){

   var menu_arr=[];
    if($('#select_menu input[name^=qty]:checked').length>0){
    $('#select_menu input[name^=qty]:checked').each(function(){ 
        
    menu_obj={
      menu_name: $(this).parents('tr').attr('data-menu-name'),
      menu_id: $(this).parents('tr').attr('data-menu-id'),
      menu_cat_id: $(this).parents('tr').attr('data-menu-cat-id'),
      menu_price:$(this).val(),
      menu_qty:$(this).attr('data-qty')
    }
     menu_arr.push(menu_obj); 
 }); 
    var arr_obj={
        data:menu_arr
    }

     Utils.post("stock/save-session", function(data) {
        if (data.success) {
            Utils.msgSuccess(data.msg);
            td="";
            total=0;
            counter=0;
            //$(menu_arr).each(function(i){
               /*total=parseInt(total)+parseInt(menu_arr[i].menu_price);
                $("#my_order tbody").html("");  
                td+="<tr><td>"+[i]+"</td>";
                td+="<td>"+menu_arr[i].menu_name+"</td>";
                td+="<td>"+menu_arr[i].menu_qty+"</td>";
                td+="<td>"+menu_arr[i].menu_price+"</td>";
                td+="<td><i class='remove_menu icon-remove'></i></td></tr>";
            });
            td+="<tr><td colspan='4' align='right'><strong>Total:</strong> "+total+"</td><td></td></tr>";
            $("#my_order tbody").append(td);
            if($('#btn_cancel_order').lenght>0 || $('#btn_cancel_order').lenght!='undefined' ){
                $(".btn_removes").remove();
            }
            $('#my_order').after( "<div class='action-btns btn_removes'><button type=button class='button default' onclick='Order.save_menue_db()' id='btnadd_more'>Confirm for Cock</button>&nbsp;&nbsp;<button type=button class='button default' onclick='Order.remove_ses();' id='btn_cancel_order'>Cancel</button></div>" );*/
            location.reload();
        } else {
           
        }
    }, arr_obj)
 }
     else{
        Utils.msgError("Please Select the Menu from list!");
     }
}

Order.save_menue_db= function(){

    Utils.post("stock/save-db-session", function(data) {
        if (data.success) {
            Utils.msgSuccess(data.msg);
              location.reload();
        } else {
           
        }
    }) 

}

Order.remove_ses= function(){

     Utils.post("stock/remove-session", function(data) {
        if (data.success) {
            Utils.msgSuccess(data.msg);
              location.reload();
        } else {
           
        }
    })
}
$(function() {
    $(document).on('click', ".nav", function() {
        link = $(this).attr("data-link");
        $("#dashboard_content").load(link, function() {
            // Utils.stopWait();
            $(".datepicker").datepicker({
                date: Date.now(), // set init date
                format: "yyyy-mm-dd", // set output format
                effect: "slide", // none, slide, fade
                position: "bottom", // top or bottom,
                locale: 'en', // 'ru' or 'en', default is $.Metro.currentLocale
            });

            switch (link) {
                case "stock/manage-stock":
                    Stock.preparedatatable();
                    break;
                
            }
        });
    });

  

});