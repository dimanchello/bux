<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
</head>

<span id="timer"><?php echo $_GET['id'] + 5; ?></span>

<script>
    var inteval_ID;

    $(document).ready(function () {
        inteval_ID = setInterval(check, 1000);
    });

    function check() {
        if (document.getElementById("timer").innerHTML > 0)
            document.getElementById("timer").innerHTML--;
        else {
//            $.ajax({
//                type: 'POST',
////                url: "<?php ////echo Yii::app()->controller->createUrl('sites/check'); ?>////",
////                data: {"id": "<?php ////echo $model->id; ?>////", "key": "<?php ////echo md5($model->url); ?>////"},
//                cache: false,
//                success: function (data) {
//                    if (data == "stop")
//                        alert("1");
////                        window.top.location.href = "<?php ////echo Yii::app()->controller->createUrl('sites/checknew'); ?>////";
//                    else
//                        window.top.location.href = data;
//                },
//            });
            alert("Таймер закончил свой счет");
            clearInterval(inteval_ID);
        }
    }
</script>