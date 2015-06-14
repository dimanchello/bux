<center>
<table id = "Table" style = "width: 50%;">
<tr>
	<td class = "regTable"><span style = "font-weight: bold;">Введите логин:</span></td>
	<td><input type = "text" name = "reg_username"></td>
</tr>
<tr>
	<td class = "regTable"><span style = "font-weight: bold;">Введите пароль:</span></td>
	<td><input type = "password" name = "reg_password"></td>
</tr>
<tr>
	<td class = "regTable"><span style = "font-weight: bold;">Повторите пароль:</span></td>
	<td><input type = "password" name = "reg_rpassword"></td>
</tr>
<tr>
	<td class = "regTable"><span style = "font-weight: bold;">Введите Email:</span></td>
	<td><input type = "text" name = "reg_email"></td>
</tr>
<?php if(isset($_COOKIE["ref"])): ?>
<tr>
<td class = "regTable"><span style = "font-weight: bold;">Вас пригласил(-а):</span></td>
<td>ID: <?php echo $_COOKIE["ref"]; ?></td>
</tr>
<?php endif; ?>
</table>
<br />

<input type = "submit" style = "width: auto; height: 40px; font-weight: bolder;" value = "Зарегистрироваться" name = "process">

<br /><br />

<span name = 'awnser'></span>

<script type="text/javascript">
	$('input[name="process"]').click(function(){
		var reg_username = $('input[name="reg_username"]').val();
		var reg_password = $('input[name="reg_password"]').val();
		var reg_rpassword = $('input[name="reg_rpassword"]').val();
		var reg_email = $('input[name="reg_email"]').val();

		var error = 0;

		if(reg_username.length == 0){
			$('input[name="reg_username"]').css({"background-color":"#FFEEEE", "border":"1px solid red"}).focus();
			error++;
		}else{
			$('input[name="reg_username"]').css({"background-color":"", "border":""});
		}

		if(reg_password.length == 0){
			$('input[name="reg_password"]').css({"background-color":"#FFEEEE", "border":"1px solid red"}).focus();
			error++;
		}else{
			$('input[name="reg_password"]').css({"background-color":"", "border":""});
		}

		if(reg_rpassword.length == 0 || reg_rpassword != reg_password){
			$('input[name="reg_rpassword"]').css({"background-color":"#FFEEEE", "border":"1px solid red"}).focus();
			error++;
		}else{
			$('input[name="reg_rpassword"]').css({"background-color":"", "border":""});
		}

		if(reg_email.length == 0 || !reg_email.match(/^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/)){
			$('input[name="reg_email"]').css({"background-color":"#FFEEEE", "border":"1px solid red"}).focus();
			error++;
		}else{
			$('input[name="reg_email"]').css({"background-color":"", "border":""});
		}

		if(error == 0){
			$('span[name="awnser"]').html('<img src = "images/ajax.gif" name = "ajax">');

			$.post('<?php echo baseUrl(); ?>/ajax/ajax_register.php', {'email':reg_email, 'username':reg_username, 'password':reg_password, 'rpassword':reg_rpassword}, function(data){
				$('span[name="awnser"]').html(data);
			});
		}

		return false;
	});
</script>

</center>