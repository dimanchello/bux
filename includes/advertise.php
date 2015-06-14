<center>
<table id = "Table" style = "width: 50%;">
<tr>
	<td class = "regTable"><span style = "font-weight: bold;">Введите название:</span></td>
	<td><input type = "text" name = "adv_name"></td>
</tr>
<tr>
	<td class = "regTable"><span style = "font-weight: bold;">Введите url:</span></td>
	<td><input type = "text" name = "adv_url"></td>
</tr>
<tr>
	<td class = "regTable"><span style = "font-weight: bold;">Количество визитов:</span></td>
	<td><input type = "text" name = "adv_visit"></td>
</tr>
<tr>
	<td class = "regTable"><span style = "font-weight: bold;">Выберите таймер:</span></td>
	<td>
		<select name="adv_timer">
			<option value="20">20</option>
			<option value="40">40</option>
			<option value="60">60</option>
		</select> сек.
	</td>
</tr>
<tr>
	<td class = "regTable"><span style = "font-weight: bold;">Способ оплаты:</span></td>
	<td>
		<select name="adv_payment">
			<?php if(!isGuest()): ?><option value="input">Внутренний баланс</option><?php endif; ?>
			<option value="webmoney">Счет WebMoney</option>
		</select>
	</td>
</tr>
</table>

<br />

<input type = "button" name = "process" value = "Добавить">

<br /><br />
<span name = 'ajax'></span>
</center>

<script type="text/javascript">
	$('input[name="process"]').click(function(){
		var name = $('input[name="adv_name"]').val();
		var url = $('input[name="adv_url"]').val();
		var visit = $('input[name="adv_visit"]').val();
		var timer = $('select[name="adv_timer"]').val();
		var payment = $('select[name="adv_payment"]').val();
		var error = 0;

		if(String.trim(name.length) < 3){
			$('input[name="adv_name"]').css({"background-color":"#FFEEEE", "border":"1px solid red"});
			error++;
		}else{
			$('input[name="adv_name"]').css({"background-color":"", "border":""});
		}

		if(!url.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/)){
			$('input[name="adv_url"]').css({"background-color":"#FFEEEE", "border":"1px solid red"});
			error++;
		}else{
			$('input[name="adv_url"]').css({"background-color":"", "border":""});
		}

		if(!parseInt(visit) || visit <= 0){
			$('input[name="adv_visit"]').css({"background-color":"#FFEEEE", "border":"1px solid red"});
			error++;
		}else{
			$('input[name="adv_visit"]').css({"background-color":"", "border":""});
		}

		if(!parseInt(visit)){
			$('input[name="adv_timer"]').css({"background-color":"#FFEEEE", "border":"1px solid red"});
			error++;
		}else{
			$('input[name="adv_timer"]').css({"background-color":"", "border":""});
		}

		if(error == 0){
			$('span[name="ajax"]').html('<img src = "images/ajax.gif">');

			$.post('<?php echo baseUrl(); ?>/ajax/ajax_advertise.php', {'name': name, 'url':url, 'visit':visit, 'timer':timer, 'payment':payment}, function(data){
				$('span[name="ajax"]').html(data);
			});
		}

		return false;
	});
</script>