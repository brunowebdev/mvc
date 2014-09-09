<?php
include_once('../controller/PostController.php');
$PostController = new PostController();
$PostController->add();
?>

<form method="post">
    <label>Titulo: <input type="text" name="title"></label>
    <label>Content: <textarea name="content"></textarea></label>
    <input type="submit" value="Save">
</form>