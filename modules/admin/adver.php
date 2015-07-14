<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 100%;">
    <thead>
    <tr>
        <th class="mdl-data-table__cell--non-numeric">Название</th>
        <th class="mdl-data-table__cell--non-numeric">URL</th>
        <th>Визитов заказано</th>
        <th>Просмотрено</th>
        <th>Таймер</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $query = mysqli_query($connect, "SELECT * FROM tb_adver WHERE status = 1");
    if(mysqli_num_rows($query) > 0){
        while($res = mysqli_fetch_assoc($query)){
            echo '
             <tr>
                <td class="mdl-data-table__cell--non-numeric">' . $res["name"] . '</td>
                <td class="mdl-data-table__cell--non-numeric">' . $res["url"] . '</td>
                <td>' . $res["visit_all"] . '</td>
                <td>' . $res["visited"] . '</td>
                <td>' . $res["timer"] . '</td>
                <td class="mdl-data-table__cell"><a href="'.createUrl("edit_adver", ['id'=>$res["id"]], 'admin').'" class="mdl-button mdl-js-button mdl-button--raised">Редактировать</a></td>
             </tr>
            ';
        }
    }
    ?>
    </tbody>
</table>