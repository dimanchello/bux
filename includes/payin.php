<center>
<table>
	<tr><td>Введите сумму ($):</td><td><input type = "text" name = "amount" value = "1"></td></tr>
	<tr>
	<td align = "right">Платежная система:</td><td>
	<select name = "payment">
		<option value = "webmoney">WebMoney</option>
	</select>
	</td>
	</tr>
</table>
<br />
<input type = "button" name = "process" value = "Оплатить"><br /><br />
<span name = "ajax"></span>

<script type="text/javascript">
	$('input[name="process"]').click(function(){
		var amount = $('input[name="amount"]').val();
		var payment = $('select[name="payment"]').val();
		var error = 0;

		if(amount <= 0 || amount.length == 0){
			$('input[name="amount"]').css({"background-color":"#FFEEEE", "border":"1px solid red"});
			error++;
		}else{
			$('input[name="amount"]').css({"background-color":"white", "border":"1px solid #D1D1D1"});
		}

		if(payment == null){
			$('input[name="payment"]').css({"background-color":"#FFEEEE", "border":"1px solid red"});
			error++;
		}else{
			$('input[name="payment"]').css({"background-color":"white", "border":"1px solid #D1D1D1"});
		}

		if(error == 0){
			$('span[name="ajax"]').html('<img src = "images/ajax.gif">');

			$.post('<?php echo baseUrl(); ?>/ajax/ajax_payin.php', {'amount': amount, 'payment':payment}, function(data){
				$('span[name="ajax"]').html(data);
			});
		}

		return false;
	});
</script>
</center>
<div style = "height: 10px;"></div>