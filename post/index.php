<?php 
include_once('../controller/PostController.php');
$PostController = new PostController();
$PostController->index();
$results = $PostController->registry->get('results');
?>

<form method="post">
    <table width="100%">
        <?php foreach ($results as $result): ?>
            <tr>
                <td><input type="checkbox" name="post_id[]" value="<?php echo $result->getId(); ?>"/></td>
                <td><?php echo $result->getId(); ?></td>
                <td><?php echo $result->getTitle(); ?></td>
                <td><a href="update.php?id=<?php echo $result->getId();?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <input type="submit" value="Delete selected"/>
</form>