<center><span id="error"></span></center>

<br/>

<?php
$query = mysqli_query($connect, "SELECT * FROM tb_adver WHERE status=1");
if(mysqli_num_rows($query) > 0){
    while($result = mysqli_fetch_assoc($query)){
        if(canLookAds($result['id'], $connect))
            echo "<div class = 'ads' id='ads" . $result['id'] . "' onclick='go(" . $result['id'] . ")'><span id='ads'>" . $result['name'] . "</span></div>";
    }
}else{
    echo "<center>Сайтов к просмотру нету</center>";
}
?>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">


<div id="dialog-message">
    <iframe id="site" style="width: 100%; height: 90%; display: none;"></iframe>
    <table border="0">
        <tr>
            <td><img src="<?php echo baseUrl(); ?>/images/timer.png" id="imgtimer" style="display: none;" width="32" height="32"></td>
            <td><span id="timer"></span></td>
        </tr>
    </table>
    <span id="hash"></span>
</div>

<script>
    function go(id) {
        $.post("<?php echo baseUrl(); ?>/ajax/ajax_ads.php", {'id': id, 'type': 'get'}, function (data) {
            $(function () {
                data = data.split('  ');
                var name = data[0];
                var url = data[1];
                var timer = data[2];
                var hash = data[3];

                var inteval_ID;


                if (data == "error") {
                    $("#error").text("Вы не можете просмотреть этот сайт");
                } else {
                    $("#dialog-message").dialog({
                        modal: true,
                        title: name,
                        width: window.innerWidth,
                        height: window.innerHeight,
                        close: function () {
                            clearInterval(inteval_ID);
                        }
                    });

                    var iframe = document.getElementById("site");
                    iframe.src = url;
                    iframe.style.display = "block";

                    var timg = document.getElementById("imgtimer");
                    timg.style.display = "block";

                    $("#timer").html(timer);

                    function check() {
                        if (document.getElementById("timer").innerHTML > 0) {
                            document.getElementById("timer").innerHTML--;
                        } else {
                            $.post("<?php echo baseUrl(); ?>/ajax/ajax_ads.php", {
                                'id': id,
                                'hash': hash,
                                'type': 'check'
                            }, function () {
                                $("#timer").text("Успешно начислено 0.01 р");
                                $("#ads" + id).fadeOut(4000);
                            });
                            clearInterval(inteval_ID);
                        }
                    }

                    inteval_ID = setInterval(check, 1000);
                }
            });
        });
    }
</script>