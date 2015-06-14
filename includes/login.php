<center>
<table id = "Table" style = "width: 50%;">
<tr>
	<td class = "regTable"><span style = "font-weight: bold;">Введите логин:</span></td>
	<td><input type = "text" name = "username"></td>
</tr>
<tr>
	<td class = "regTable"><span style = "font-weight: bold;">Введите пароль:</span></td>
	<td><input type = "password" name = "password"></td>
</tr>
</table>

<input type="button" name="process_login" value="Войти">

<script type="text/javascript">
	$('input[name="process_login"]').click(function(){
		var username = $('input[name="username"]').val();
		var password = $('input[name="password"]').val();

		var error = 0;

		if(username.length == 0){
			$('input[name="username"]').css({"background-color":"#FFEEEE", "border":"1px solid red"});
			error++;
		}else{
			$('input[name="username"]').css({"background-color":"white", "border":"0px solid red"});
		}

		if(password.length == 0){
			$('input[name="password"]').css({"background-color":"#FFEEEE", "border":"1px solid red"});
			error++;
		}else{
			$('input[name="password"]').css({"background-color":"white", "border":"0px solid red"});
		}

		if(error == 0){
			$.post('<?php echo baseUrl(); ?>/ajax/ajax_login.php', {'username':username, 'password':password}, function(data){
				var ajax_error = data.split(':');
				if(ajax_error[0] == 'error'){
					switch(ajax_error[1]){
						case 'username':
							$('input[name="username"]').css({"background-color":"#FFEEEE", "border":"1px solid red"});
						break;

						case 'password':
							$('input[name="password"]').css({"background-color":"#FFEEEE", "border":"1px solid red"});
						break;

						case 'success':
							location.replace('index.php');
						break;
					}
				}
			});
		}

		return false;
	});
</script>