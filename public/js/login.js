Login = [];
Login.submit = function() {
		$.ajax({ 
			type: 'post',
			cache: false,
			url: 'Signin',
			dataType: 'json',
			data: $('form#LoginForm').serialize(),
			success: function(data) {
				if(data.success == false){
					//Utils.stopWait();
					
					$.Notify({
						    caption: 'Error',
						    content: 'Incorrect Username and Password',
						    keepOpen: true,
						    type:'alert'
					});

					
				} else{ 
					if(data.role_id=='admin'){
					window.location.href="dashboard";
				}if(data.role_id=='waiter'){
					window.location.href="Waiter";
				}if(data.role_id=='user'){
					
					window.location.href="customer";
				}
					
				}
			}, //success: function
			error: function(xhr, textStatus, thrownError) {
				$.Notify({
						    caption: 'Error',
						    content: 'Some thing wents wrong contact system admin',
						    keepOpen: true,
						    type:'alert'
					});
			}
		});
		return false;
	};//Login.submit