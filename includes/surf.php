<?php
$query = mysqli_query($connect, "SELECT * FROM tb_adver WHERE status=1");
if(mysqli_num_rows($query) > 0){
    while($result = mysqli_fetch_assoc($query)){
        echo "<div class = 'ads' onclick='go(".$result['id'].")'><span id='ads'>".$result['name']."</span></div><br />";
    }
}else{
    echo "<center>Сайтов к просмотру нету</center>";
}
?>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">


<div id="dialog-message">
    <span id="timer"></span>
    <span id="hash"></span>
</div>

<script>
    function go(id) {
        $.post("<?php echo baseUrl(); ?>/ajax/ajax_ads.php", {'id': id, 'type': 'get'}, function (data) {
            $(function () {
                if(data != "error") {
                    data = data.split('  ');
                    var name = data[0];
                    var url = data[1];
                    var timer = data[2];
                    var hash = data[3];

                    $("#dialog-message").dialog({
                        modal: true,
                        title: name,
                        width: window.innerWidth,
                        height: window.innerHeight
                    });
                    $('<iframe src="' + url + '" style="width: 100%; height: 90%;">').insertBefore($("#timer"));
                    $("#timer").html(timer);

                    inteval_ID = setInterval(check, 1000);

                    function check() {
                        if (document.getElementById("timer").innerHTML > 0)
                            document.getElementById("timer").innerHTML--;
                        else {
                            $.post("<?php echo baseUrl(); ?>/ajax/ajax_ads.php", {
                                'id': id,
                                'hash': hash,
                                'type': 'check'
                            }, function (data) {
                                if (data == "error") {
                                    $("#dialog-message").dialog("close");
                                } else {
                                    $("#timer").text("Успешно начислено 0.01 р");
                                }
                            });
                            clearInterval(inteval_ID);
                        }
                    }
                }else{
                    $("#timer").text("Возникла ошибка");
                }
            });
        });
    }
</script>