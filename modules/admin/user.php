<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 100%;">
    <thead>
    <tr>
        <th class="mdl-data-table__cell--non-numeric">Логин</th>
        <th>Реферер</th>
        <th>Баланс</th>
        <th>Статус</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $query = mysqli_query($connect, "SELECT * FROM tb_users WHERE status > 0");
    if(mysqli_num_rows($query) > 0){
        while($res = mysqli_fetch_assoc($query)){
            echo '
             <tr>
                <td class="mdl-data-table__cell--non-numeric">' . $res["username"] . '</td>
                <td>' . ($res["referer"] == null ? "Нету реферера" : $res["referer"]) . '</td>
                <td>' . $res["balance"] . '</td>
                <td>' . $res["status"] . '</td>
             </tr>
            ';
        }
    }
    ?>
    </tbody>
</table>