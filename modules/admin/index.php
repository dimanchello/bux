<?php
if(isset($_POST['firstname'])){
    echo $_POST['firstname'];
}
?>

<form action="" method="post" class="newform">
    <input type="text" name="firstname">
    <input type="submit">
</form>