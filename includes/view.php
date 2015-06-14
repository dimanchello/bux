<?php
$query = mysqli_query($connect, "SELECT * FROM tb_adver WHERE id = 1");
$result = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
	<title>Тест</title>
</head>

<!--<frameset rows="*,76" border="0" id="money">-->
<!--    <frame name="site" id="site" src="http://shopforbux.ru">-->
<!---->
<!--</frameset>-->

<body style="min-height: 100%; height: 100%; border: 2px solid #000000;">
<iframe src="http://shopforbux.ru" id="money" style="width: 100%; height: 90%" align="left">
    Ваш браузер не поддерживает плавающие фреймы!
</iframe>



<script>
    alert(window.innerHeight);
    var test = document.getElementById("money");
    $("#money").ready(function(){
//        alert(1);
//        $("#money").append('<frame name="timer" src="includes/_timer.php?id=<?//=$result['id'];?>//">');
    });
</script>
</body>
</html>