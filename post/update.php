<?php
include_once('../controller/PostController.php');
$PostController = new PostController();
$PostController->edit();
$results = $PostController->registry->get('results');
?>

<form method="post">
    <label>Titulo: <input type="text" name="title" value="<?php echo $results[0]->getTitle();?>"></label>
    <label>Content: <textarea name="content"><?php echo $results[0]->getContent();?></textarea></label>
    <input type="submit" value="Save">
</form>