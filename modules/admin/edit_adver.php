<?php
$id = intval($_GET['id']);
$query = mysqli_query($connect, "SELECT * FROM tb_adver WHERE id = {$id}");
if(mysqli_num_rows($query) > 0){
    $result = mysqli_fetch_assoc($query);
}

if(isset($_POST['form'])){
    var_dump($_POST['form']);
}
?>
<center>
    <form name="form">
        <div class="mdl-textfield mdl-textfield--floating-label mdl-js-textfield textfield-demo">
            <input class="mdl-textfield__input" type="text" id="name" value="<?=$result['name'];?>" required />
            <label class="mdl-textfield__label" for="name">Название</label>
            <span class="mdl-textfield__error">Поле заполнено не верно!</span>
        </div>

        <br/>

        <div class="mdl-textfield mdl-textfield--floating-label mdl-js-textfield textfield-demo">
            <input class="mdl-textfield__input" type="url" id="url" value="<?=$result['url'];?>" required />
            <label class="mdl-textfield__label" for="url">URL</label>
            <span class="mdl-textfield__error">Поле заполнено не верно!</span>
        </div>

        <br/>

        <div class="mdl-textfield mdl-textfield--floating-label mdl-js-textfield textfield-demo">
            <input class="mdl-textfield__input" type="text" id="visit_all" value="<?=$result['visit_all'];?>" pattern="-?[0-9]*(\.[0-9]+)?" required />
            <label class="mdl-textfield__label" for="visit_all">Визитов заказано</label>
            <span class="mdl-textfield__error">Это должно быть числом!</span>
        </div>

        <br/>

        <div class="mdl-textfield mdl-textfield--floating-label mdl-js-textfield textfield-demo">
            <input class="mdl-textfield__input" type="text" id="visited" value="<?=$result['visited'];?>" pattern="-?[0-9]*(\.[0-9]+)?" required />
            <label class="mdl-textfield__label" for="visited">Просмотрено</label>
            <span class="mdl-textfield__error">Это должно быть числом!</span>
        </div>

        <br/>

        <div class="mdl-textfield mdl-textfield--floating-label mdl-js-textfield textfield-demo">
            <input class="mdl-textfield__input" type="text" id="timer" value="<?=$result['timer'];?>" pattern="-?[0-9]*(\.[0-9]+)?" required />
            <label class="mdl-textfield__label" for="url">Таймер</label>
            <span class="mdl-textfield__error">Это должно быть числом!</span>
        </div>

        <br />

        <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--primary" value="Сохранить">
        <input type="submit" class="mdl-button mdl-js-button mdl-button--raised" value="Удалить">
    </form>
</center>