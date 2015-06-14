<?php
session_start();

//Если запрос не AJAX, закрываем доступ.
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest'){
	exit('Access dained');
}

require("../system/connect.php");
require("../system/function.php");

if(isset($_POST)){
	$username = strtolower(secureData($_POST["username"]));
	$password = secureData($_POST["password"]);
	$rpassword = secureData($_POST['rpassword']);
	$pass_temp = secureData($_POST["password"]);
	$email = secureData($_POST["email"]);

	if(validateData($username, 'empty') || validateData($password, 'empty') || validateData($email, 'empty')){
		exit("Поля не заполнены");
	}
	
	if($password != $rpassword){
		exit("Пароли не совпадают");
	}

	if(!validateData($email, 'email')){
		exit("Email адрес указан не верно");
	}

	$referer = isset($_COOKIE["ref"]) ? $_COOKIE["ref"] : null;
	$date = time();
	
	$password = password_hash($password, PASSWORD_DEFAULT); //2 раза зашифровываем пароль, чтобы подоборать не могли

	$sql = mysqli_query($connect, "SELECT * FROM tb_users WHERE username = '$username' OR email = '$email'");
	if(mysqli_num_rows($sql) > 0){
		exit("Пользователь с такими данными уже зарегистрирован");
	}
	
	if($referer != NULL){
		mysqli_query($connect, "INSERT INTO tb_ref_data(username, referer, profit) VALUES('$username', '$referer', '0');") or die(mysql_error());
        mysqli_query($connect, "UPDATE tb_users SET referals = referals + 1 WHERE id = '$referer'");
        // addHistory("Реферал", "У вас ноывй реферал ".$username, $referer);
    }
    
	mysqli_query($connect, "INSERT INTO tb_users(username, password, email, referer, date_reg, date_last) VALUES('$username','$password','$email', '$referer','$date','$date');");
	setConfig('users', getConfig('users', $connect) + 1, $connect);

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	
	$message_reg = "
				<html>
				<body>
				<fieldset style = \"background: #63c668; border: 3px solid gray; text-align: center;\">
				<b>Успешная регистрация</b><br>
				$username, Вы успешно зарегистрировались, 
				ниже указаны ваши данные для входа <br> 
				<center>
				<table border = '1' style = 'width: 200px;'>
				<tr>
					<td style = 'text-align: right;'>Логин: </td><td style = 'text-align: left;'>$username</td>
				</tr>
				<tr>
					<td style = 'text-align: right;'>Пароль: </td><td style = 'text-align: left;'>$pass_temp</td>
				</tr>
				<tr>
					<td style = 'text-align: right;'>Факультет: </td><td style = 'text-align: left;'>$faculty</td>
				</tr>
				</table>
				</center>
				Адрес сайта: http://" .$_SERVER["HTTP_HOST"] ."
				</fieldset>
				</body>
				</html>
	";
	
	// $_SESSION["username"] = $username;
	// $_SESSION["password"] = $pass_temp;
	// generateUserCache();

	unset($pass_temp);
	
	mail($email, "Успешно", $message_reg, $headers);

	echo "$username, Вы успешно зарегистрировались.";
}
?>