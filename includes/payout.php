<center>
Хотите вывести средства? Тогда введите ваш R-кошелёк в поле ниже и создайте заявку на вывод, в течении 3-х суток,
деньги будут переведены на ваш счет.<hr>
<b><span id = "msg"></span></b>
<br /><br />
Минимальная сумма для вывода: <?php echo getConfig('minimum', $connect); ?> р.
<br /><br />
<form action = "" method = "post">
<table>
	<tr>
		<td>Ваш WMR кошелёк: </td><td><input type = "text" name = "wallet" id = "wallet" maxlength = "100" value = ""></td>
	</tr>
	<tr>
		<td>Сумма: </td><td><input type = "text" name = "amount" id = "amount" value = "<?php echo getUserParam($connect)['balance']; ?>"></td>
	</tr>
</table>
<input type = "submit" id = "process" value = "Заказать выплату">
</form>
</center>
<br />
<center>
<table border = "1" cellspacing="0" style = "width: 80%;">
<tr>
	<th>WMR кошелёк</th>
	<th>Дата события</th>
	<th>Сумма выплаты</th>
	<th>Статус</th>
</tr>
<?php
$sql = mysqli_query($connect, "SELECT * FROM tb_payout WHERE username = '".$_SESSION['username']."'"); 
if(mysqli_num_rows($sql) > 0){
	while($res = mysqli_fetch_assoc($sql)){
		$amount = $res["amount"];
		$date = date("Y.m.d - G:i:s", $res["date_pay"]);
		$wallet = $res["wallet"];
		$ok = intval($res["ok"]);
		
		if($ok == 0){
			$result = "<b style = 'font-weight: bold; color: red;'>Ожидает</b>";
		}else{
			$result = "<b style = 'font-weight: bold; color: green;'>Выплачено</b>";
		}
		
		echo "
			<tr style = 'text-align: center;'>
				<td>$wallet</td>
				<td>$date</td>
				<td>$amount</td>
				<td>$result</td>
			</tr>
		";
	}
	echo '</table>';
}else{
	echo "</table><b>Ваших заказов не обнаружено</b>";
}
?>
<br />
</table>

<script type="text/javascript">
$("#process").click(function(){
	var wallet = $("#wallet").val();
	var amount = parseFloat($("#amount").val());
	var error = 0;

	if(String.trim(amount) == 'NaN' || amount <= 0){
		$('#amount').css({"background-color":"#FFEEEE", "border":"1px solid red"}).focus();
		error++;
	}else{
		$('#amount').css({"background-color":"", "border":""});
	}

	if(wallet.length > 13){
		$('#wallet').css({"background-color":"#FFEEEE", "border":"1px solid red"}).focus();
		error++;
	}else{
		$('#wallet').css({"background-color":"", "border":""});
	}

	if(wallet.length == 0){
		$('#wallet').css({"background-color":"#FFEEEE", "border":"1px solid red"}).focus();
		error++;
	}else{
		$('#wallet').css({"background-color":"", "border":""});
	}

	if(error == 0){
		$('#msg').html('<img src = "images/ajax.gif" name = "ajax">');

		$.post("<?php echo baseUrl(); ?>/ajax/ajax_payout.php", {'amount':amount, 'wallet':wallet}, function(data){
			var ajax_error = data.split(':');

			if(ajax_error[0] == 'error'){
				switch(ajax_error[1]){
					case 'wallet':
						$('#wallet').css({"background-color":"#FFEEEE", "border":"1px solid red"}).focus();
					break;

					case 'amount':
						$('#amount').css({"background-color":"#FFEEEE", "border":"1px solid red"}).focus();
					break;

					case 'minimum':
						$('#amount').css({"background-color":"#FFEEEE", "border":"1px solid red"}).focus();
					break;
				}
			}else if(ajax_error[0] == 'success'){
				$("#msg").html('Вы успешно заказали выплату на сумму ' + ajax_error[1] + ' р.');
			}
		});
	}

	return false;
});
</script>