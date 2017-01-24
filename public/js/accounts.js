Accounts.prepareCollection = function(){

    $("input[name=amount]").bind('keyup', function(e){
        total = Number($("input#h_rem_amount").val().replace(",",""));
        rem = total - Number($(this).val());
        $("input#rem_amount").val(Utils.toMillions(rem));
    });

    $(".datepicker").datepicker({
        date: Date.now(), // set init date
        format: "yyyy-mm-dd", // set output format
        effect: "slide", // none, slide, fade
        position: "bottom", // top or bottom,
        locale: 'en', // 'ru' or 'en', default is $.Metro.currentLocale
    });

    $("select[name=pm]").bind('change', function(){
        th = $(this).val();
        $(".pms").hide();
        $("#"+th).show();
    });

    $("#search-so-form").submit(function(event){
        event.preventDefault();
        Utils.get('accounts/so-details', function(data){
            if(data.success){
                pd = data.pd;
                pay_bkp = data.breakup;
                data = data.so_detail;

                $("input#so_id").val(pd.id);
                if(pd.latest == 0){
                    str = '<div class="my-label" style="background-color: #e40429"><label>This is Old Invoice</label></div>';
                    $("button#btn-save").attr("disabled", true);
                    $("input[name=amount]").attr("disabled", true);
                } else{
                    $("button#btn-save").attr("disabled", false);
                    $("input[name=amount]").attr("disabled", false);
                    str = '<div class="my-label" style="background-color: #6cc414"><label>This is Latest Invoice</label></div>';
                }

                if(pd.rem_amount == pd.amount_paid){
                    $("button#btn-save").attr("disabled", true);
                    $("input[name=amount]").attr("disabled", true);
                }

                str += '<h4>Invoice Detail</h4>';
                str += '<table class="table bordered">\
                <tr><th>Code</th><th>Name</th><th>Quantity</th><th>Unit Cost</th><th>Total</th></tr>';
                $.each(data, function(key, data){
                    total = data.quantity * data.unit_price;
                    str += '<tr><td>'+data.code+'</td><td>'+data.brand+'</td><td>'+data.quantity+'</td><td>'+data.unit_price+'</td><td class="amount">'+total+'</td></tr>';
                });

                t_amount_received = pd.blnc+pd.total_bill-pd.rem_amount+pd.amount_received;
                grand_total = pd.total_bill+pd.blnc-t_amount_received;
                rem_amount = pd.rem_amount - pd.amount_received;
                $("input#total_bill").val(Utils.toMillions(grand_total));
                $("input#rem_amount").val(Utils.toMillions(rem_amount));
                $("input#h_rem_amount").val(Utils.toMillions(rem_amount));
                $("input[name=amount]").val(0);
                
                str += '<tr><td colspan="4" style="text-align:center">Previous Balance</td><td class="amount">'+Utils.toMillions(pd.blnc)+'</td></tr>';
                str += '<tr><td colspan="4" style="text-align:center">Total Paid Amount</td><td class="amount">'+Utils.toMillions(t_amount_received)+'</td></tr>';
                str += '<tr><th colspan="4">Remaining Balance</th><th class="amount">'+Utils.toMillions(grand_total)+'</th></tr>';
                str += '</table>';
                $("div#po-details .span12").html(str);

                // Payments breakup
                sr = 1;
                str = '<h4>Payment Breakup</h4>';
                str += '<table class="table bordered">\
                <tr><th>Sr.</th><th>Date</th><th>Description</th><th>Amount</th><th>Balance</th></tr>';
                str += '<tr><td>'+sr+'</td><td>'+pd.invoice_date+'</td><td>Previous Balance</td><td class="amount">'+pd.blnc+'</td><td class="amount">'+pd.blnc+'</td></tr>'; sr++;
                str += '<tr><td>'+sr+'</td><td>'+pd.invoice_date+'</td><td>Bill Total</td><td class="amount">'+pd.total_bill+'</td><td class="amount">'+(pd.blnc+pd.total_bill)+'</td></tr>';sr++;
                pmode = {
                    'CA' : 'CASH',
                    'CH' : 'CHEQUE',
                    'BT' : 'Bank Transfer'
                };

                $.each(pay_bkp, function(key, data){
                    str += '<tr><td>'+sr+'</td><td>'+data.invoice_date+'</td><td>'+data.description+'</td><td class="amount">'+data.amount_received+'</td><td class="amount">'+(data.rem_amount - data.amount_received)+'</td></tr>';
                    sr++;
                });

                $("div#payment-breakup .span12").html(str);
                $("div#payment-breakup").show();
                
            } else{
                Utils.smartError("search-po-form", data.error);
            }
        }, $("#search-so-form").serialize()
        )
    });
}

Accounts.saveNewCollection = function(){
    if(Number($("input[name=amout]").val()) > Number($("input#h_rem_amount").val())){
        Utils.msgWarning('Amount exceeded. Invalid amount.')
        return false;
    }

    forms = "#search-so-form";
    if($("select[name=pm]").val()!= "CA")
        forms += ", #form-"+$("select[name=pm]").val();
    Utils.post("accounts/save-new-collection", function(data){
        if(data.success){
            $("#dashboard_content").load('accounts/new-collection', function(){
                Accounts.prepareCollection();
            });
            Utils.msgSuccess(data.msg);
        } else{
            Utils.smartError(data.form, data.error);
        }
    }, $(forms).serialize());
}

Accounts.printCustomerInvoice = function(){
    if($("input[name=so_id]").val() == "" || $("input[name=so_number]").val() == ""){
        Utils.msgError('Please enter SO number');
        return false;
    }
    if(Number($("input[name=so_id]").val()) > 0){
        window.open('accounts/print-customer-invoice?id='+$("input[name=so_id]").val());
    } else{
        Utils.msgError('Invalid SO number');
    }
}

Accounts.printBonusDetails = function(emp_id){
    ap_id = $("select[name=ap_id]").val();
    window.open('accounts/print-emp-bonus-breakup?emp_id='+emp_id+'&ap_id='+ap_id);
}

Accounts.cancelCollection = function(){
    $("#dashboard_content").load('accounts/new-collection', function(){
        Accounts.prepareCollection();
    });
}

Accounts.preparePayment = function(){

    $("input[name=amount]").bind('keyup', function(e){
        total = Number($("input#h_rem_amount").val().replace(",",""));
        rem = total - Number($(this).val());
        $("input#rem_amount").val(Utils.toMillions(rem));
    });

    $(".datepicker").datepicker({
        date: Date.now(), // set init date
        format: "yyyy-mm-dd", // set output format
        effect: "slide", // none, slide, fade
        position: "bottom", // top or bottom,
        locale: 'en', // 'ru' or 'en', default is $.Metro.currentLocale
    });

    $("select[name=pm]").bind('change', function(){
        th = $(this).val();
        $(".pms").hide();
        $("#"+th).show();
    });

    $("#search-po-form").submit(function(event){
        event.preventDefault();
        Utils.get('accounts/po-details', function(data){
            if(data.success){
                pd = data.pd;
                pay_bkp = data.breakup;
                data = data.po_detail;

                $("input#po_id").val(pd.id);
                if(pd.latest == 0){
                    str = '<div class="my-label" style="background-color: #e40429"><label>This is Old Invoice</label></div>';
                    $("button#btn-save").attr("disabled", true);
                    $("input[name=amount]").attr("disabled", true);
                } else{
                    $("button#btn-save").attr("disabled", false);
                    $("input[name=amount]").attr("disabled", false);
                    str = '<div class="my-label" style="background-color: #6cc414"><label>This is Latest Invoice</label></div>';
                }

                if(pd.rem_amount == pd.amount_paid){
                    $("button#btn-save").attr("disabled", true);
                    $("input[name=amount]").attr("disabled", true);
                }

                str += '<h4>Invoice Detail</h4>';
                str += '<table class="table bordered">\
                <tr><th>Code</th><th>Name</th><th>Quantity</th><th>Unit Cost</th><th>Total</th></tr>';
                $.each(data, function(key, data){
                    total = data.quantity * data.unit_cost;
                    str += '<tr><td>'+data.code+'</td><td>'+data.brand+'</td><td>'+data.quantity+'</td><td>'+data.unit_cost+'</td><td class="amount">'+total+'</td></tr>';
                });

                t_amount_paid = pd.blnc+pd.total_bill-pd.rem_amount+pd.amount_paid;
                grand_total = pd.total_bill+pd.blnc-t_amount_paid;
                rem_amount = pd.rem_amount - pd.amount_paid;
                $("input#total_bill").val(Utils.toMillions(grand_total));
                $("input#rem_amount").val(Utils.toMillions(rem_amount));
                $("input#h_rem_amount").val(Utils.toMillions(rem_amount));
                $("input[name=amount]").val(0);
                
                str += '<tr><td colspan="4" style="text-align:center">Previous Balance</td><td class="amount">'+Utils.toMillions(pd.blnc)+'</td></tr>';
                str += '<tr><td colspan="4" style="text-align:center">Total Paid Amount</td><td class="amount">'+Utils.toMillions(t_amount_paid)+'</td></tr>';
                str += '<tr><th colspan="4">Remaining Balance</th><th class="amount">'+Utils.toMillions(grand_total)+'</th></tr>';
                str += '</table>';
                $("div#po-details .span12").html(str);

                // Payments breakup
                sr = 1;
                str = '<h4>Payment Breakup</h4>';
                str += '<table class="table bordered">\
                <tr><th>Sr.</th><th>Date</th><th>Description</th><th>Amount</th><th>Balance</th></tr>';
                str += '<tr><td>'+sr+'</td><td>'+pd.invoice_date+'</td><td>Previous Balance</td><td class="amount">'+pd.blnc+'</td><td class="amount">'+pd.blnc+'</td></tr>'; sr++;
                str += '<tr><td>'+sr+'</td><td>'+pd.invoice_date+'</td><td>Bill Total</td><td class="amount">'+pd.total_bill+'</td><td class="amount">'+(pd.blnc+pd.total_bill)+'</td></tr>';sr++;
                pmode = {
                    'CA' : 'CASH',
                    'CH' : 'CHEQUE',
                    'BT' : 'Bank Transfer'
                };

                $.each(pay_bkp, function(key, data){
                    str += '<tr><td>'+sr+'</td><td>'+data.invoice_date+'</td><td>'+data.description+'</td><td class="amount">'+data.amount_paid+'</td><td class="amount">'+(data.rem_amount - data.amount_paid)+'</td></tr>';
                    sr++;
                });

                $("div#payment-breakup .span12").html(str);
                $("div#payment-breakup").show();
                
            } else{
                Utils.smartError("search-po-form", data.error);
            }
        }, $("#search-po-form").serialize()
        )
    });
}

Accounts.saveNewPayment = function(){
    if(Number($("input[name=amout]").val()) > Number($("input#h_rem_amount").val())){
        Utils.msgWarning('Amount exceeded. Invalid amount.')
        return false;
    }

    forms = "#search-po-form";
    if($("select[name=pm]").val()!= "CA")
        forms += ", #form-"+$("select[name=pm]").val();
    Utils.post("accounts/save-new-payment", function(data){
        if(data.success){
            $("#dashboard_content").load('accounts/new-payment', function(){
                Accounts.preparePayment();
            });
            Utils.msgSuccess(data.msg);
        } else{
            Utils.smartError(data.form, data.error);
        }
    }, $(forms).serialize());
}

Accounts.printSupplierInvoice = function(){
    if($("input[name=po_id]").val() == "" || $("input[name=po_number]").val() == ""){
        Utils.msgError('Please enter PO number');
        return false;
    }
    if(Number($("input[name=po_id]").val()) > 0){
        window.open('accounts/print-supplier-invoice?id='+$("input[name=po_id]").val());
    } else{
        Utils.msgError('Invalid PO number');
    }
}

Accounts.cancelPayment = function(){
    $("#dashboard_content").load('accounts/new-payment', function(){
        Accounts.preparePayment();
    });
}

Accounts.confirmPOModal = function(id){
    str = '<button type="button" class="button danger" data-dismiss="modal" onClick="Accounts.confirmPO(' + id + ')">Yes</button>';
    str += '&nbsp;&nbsp;<button type="button" class="button default" onclick="$.Dialog.close()">No</button>';
    var content_h = '<div class="modal-content">\
                <div class="modal-header">\
                    <h4 id="super-modal-title">Confirm Purchase Order</h4>\
                </div>\
    <div class="modal-body" id="super-modal-body">\
                <p>Are you sure to confirm PO? After confirmation You will not be able to change it further.</p></div>\
                <div class="modal-footer" id="super-modal-footer">' + str + '</div></div>'
    Utils.showDialog('Confirm Purchase Order', content_h);   
}

Accounts.confirmPO = function(id){
    $.Dialog.close();
    Utils.get("accounts/confirm-po", function(data){
        if(data.success){
            $("#dashboard_content").load('po/po-main');
            Utils.msgSuccess(data.msg);
        } else{
            Utils.smartError(data.form, data.error);
        }
    }, {id: id});   
}

Accounts.allAP = function(){
    $("#dashboard_content").load("accounts/accounting-period-main");
}

Accounts.prepareNewAP = function(){
    $(".datepicker").datepicker({
        date: Date.now(), // set init date
        format: "yyyy-mm-dd", // set output format
        effect: "slide", // none, slide, fade
        position: "bottom", // top or bottom,
        locale: 'en', // 'ru' or 'en', default is $.Metro.currentLocale
    });
}

Accounts.saveNewAP = function(){
    Utils.post('accounts/save-accounting-period', 
        function(data){
            if(data.success){
                Utils.msgSuccess('New Accounting Period started Successfully!');
                $("#dashboard_content").load('accounts/accounting-period-main');
            } else{
                Utils.smartError('apForm', data.error);
            }
        }, 
        $('#apForm').serialize()
    );
}


Accounts.invoicePaymentLogDetail = function(){
    $("#invoice-log-details").load('accounts/invoice-payment-log-details?'+$("#invoiceLogForm").serialize());
}

Accounts.invoiceCollectionLogDetail = function(){
    $("#invoice-log-details").load('accounts/invoice-collection-log-details?'+$("#invoiceLogForm").serialize());
}


Accounts.confirmSOModal = function(id){
    str = '<button type="button" class="button danger" data-dismiss="modal" onClick="Accounts.confirmSO(' + id + ')">Yes</button>';
    str += '&nbsp;&nbsp;<button type="button" class="button default" onclick="$.Dialog.close()">No</button>';
    var content_h = '<div class="modal-content">\
                <div class="modal-header">\
                    <h4 id="super-modal-title">Confirm Sale Order</h4>\
                </div>\
    <div class="modal-body" id="super-modal-body">\
                <p>Are you sure to confirm SO? After confirmation You will not be able to change it further.</p></div>\
                <div class="modal-footer" id="super-modal-footer">' + str + '</div></div>'
    Utils.showDialog('Confirm Sale Order', content_h);   
}

Accounts.confirmSO = function(id){
    $.Dialog.close();
    Utils.get("accounts/confirm-so", function(data){
        if(data.success){
            $("#dashboard_content").load('so/so-main');
            Utils.msgSuccess(data.msg);
        } else{
            Utils.smartError(data.form, data.error);
        }
    }, {id: id});   
}

    Accounts.prepareNewExpense = function(){
        $(".datepicker").datepicker({
            date: Date.now(), // set init date
            format: "yyyy-mm-dd", // set output format
            effect: "slide", // none, slide, fade
            position: "bottom", // top or bottom,
            locale: 'en', // 'ru' or 'en', default is $.Metro.currentLocale
        });

        $('select[name="type"]').bind('change', function(event){
            if( $(this).val() == 'CH')
                $('.cheque').show();
            else
                $('.cheque').hide();
        });
        $('select[name="type"]').trigger('change');
    }

    Accounts.saveExpense = function(){
        Utils.post('accounts/save-expense', 
            function(data){
                if(data.success){
                    Utils.msgSuccess('New Expense recorded Successfully!');
                    $("#dashboard_content").load('accounts/expense-main');
                } else{
                    Utils.smartError('expenseForm', data.error);
                }
            }, 
            $('#expenseForm').serialize()
        );
    }

    Accounts.prepareExpenseMain = function(id = null){
        // $('#data_table').dataTable();
        $('select[name="ap"]').bind('change', function(event){
            Utils.startWait();
            ap_id = $(this).val();
            $("#dashboard_content").load('accounts/expense-main?ap='+ap_id, function(){
                Utils.stopWait();
                Accounts.prepareExpenseMain(ap_id);
            }); 
        });
        if(id != null)
            $('select[name="ap"]').val(id);

        Utils.dataTable('.table', [4], function(pt, t){
            $('tfoot th').eq(0).html('Grand Total: '+Utils.toMillions(t[0].toFixed(2)));
            $('tfoot th').eq(1).html(Utils.toMillions(pt[0].toFixed(2)));
        });
    }

    Accounts.showExpenseDetails = function(id){
        Utils.startWait();
        $("#dashboard_content").load('accounts/new-expense?id='+id, function(){
            Utils.stopWait();
            Accounts.prepareNewExpense();
        });
    }

    Accounts.prepareNewIncome = function(){
        $(".datepicker").datepicker({
            date: Date.now(), // set init date
            format: "yyyy-mm-dd", // set output format
            effect: "slide", // none, slide, fade
            position: "bottom", // top or bottom,
            locale: 'en', // 'ru' or 'en', default is $.Metro.currentLocale
        });
        $('select[name="type"]').bind('change', function(event){
            if( $(this).val() == 'CH')
                $('.cheque').show();
            else
                $('.cheque').hide();
        });
        $('select[name="type"]').trigger('change');
    }

    Accounts.saveIncome = function(){
        Utils.post('accounts/save-income', 
            function(data){
                if(data.success){
                    Utils.msgSuccess('New Income recorded Successfully!');
                    $("#dashboard_content").load('accounts/income-main');
                } else{
                    Utils.smartError('incomeForm', data.error);
                }
            }, 
            $('#incomeForm').serialize()
        );
    }

    Accounts.prepareIncomeMain = function(id = null){
        // $('#data_table').dataTable();
        $('select[name="ap"]').bind('change', function(event){
            Utils.startWait();
            ap_id = $(this).val();
            $("#dashboard_content").load('accounts/income-main?ap='+ap_id, function(){
                Utils.stopWait();
                Accounts.prepareIncomeMain(ap_id);
            }); 
        });
        if(id != null)
            $('select[name="ap"]').val(id);
        Utils.dataTable('.table', [4], function(pt, t){
            $('tfoot th').eq(0).html('Grand Total: '+Utils.toMillions(t[0].toFixed(2)));
            $('tfoot th').eq(1).html(Utils.toMillions(pt[0].toFixed(2)));
        });
    }

    Accounts.showIncomeDetails = function(id){
        Utils.startWait();
        $("#dashboard_content").load('accounts/new-income?id='+id, function(){
            Utils.stopWait();
            Accounts.prepareNewIncome();
        });
    }

    Accounts.salesmenBonusesDetail = function(){
        $("#bonuses-details").load('accounts/salesman-bonus-details?'+$("#invoiceLogForm").serialize());
    }
