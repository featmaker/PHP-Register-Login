$(document).ready(function() {
	var nameFlag = true;
	var emailFlag = true;
	var pwdFlag = true;

	$('#username').keyup(function() {
		var length = $(this).val().length;
		if ( length >= 2 && length <= 20 ) {
			$.post('admin/Register.php', {username: $(this).val(),type:'name'}, function(data, textStatus, xhr) {
				if (textStatus == 'success') {
					if (data == '1') {
						$('#dis_un').text('UserName is already registered');
						nameFlag = false;
					}else{
						$('#dis_un').text('');
						nameFlag = true;
					}
				}
			});
		}else{
			$('#dis_un').text('');
		}
	});

	$('#remail').blur(function() {
		if ($(this).val() != '') {
			var reg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
			if (reg.test($(this).val())) {
				$.post('admin/Register.php', {email: $(this).val(),type: 'email'}, function(data, textStatus, xhr) {
					if (textStatus == 'success') {
						if (data == 1) {
							$('#dis_em').text('E-mail is already registered');
							emailFlag = false;
						}else{
							$('#dis_em').text('');
							emailFlag = true;
						}
					}
				});
			}else{
				$('#dis_em').text('E-mail format is incorrect');
				emailFlag = false;
			}
		}else{
			$('#dis_em').text('');
		}
	});

	$('#password').blur(function(){
		if ($(this).val() == '') {
			$('#dis_pwd').text('Password cannot be empty');
		}else if($(this).val().length < 6){
			$('#dis_pwd').text('Passwords must be at least six');
		}else{
			$('#dis_pwd').text('');
		}
	});

	$('#confirm').blur(function() {
		var val = $('#password').val();
		if (val != '') {
			if ($(this).val() == '') {
				$('#dis_con_pwd').text('Please confirm your password');
				pwdFlag = false;
			}else if($(this).val() != val){
				$('#dis_con_pwd').text('Confirm password inconsistent');
				pwdFlag = false;
			}else{
				$('#dis_con_pwd').text('');
				pwdFlag = true;
			}
		}else{
			$('#dis_con_pwd').text('');
			pwdFlag = false;
		}
	});

	$('#reg').click(function() {
		if (!(nameFlag && emailFlag && pwdFlag)) {
			alert('Please check page info!');
			return false;
		}
	});
});
