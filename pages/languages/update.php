<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the language id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $level = isset($_POST['level']) ? $_POST['level'] : '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE languages SET id = ?, name = ?, level = ? WHERE id = ?');
        $stmt->execute([$id, $name, $level, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM languages WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $language = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$language) {
        exit('Language doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update language #<?=$language['id']?></h2>
    <form action="update.php?id=<?=$language['id']?>" method="post">
        <label for="id">ID</label>        
        <input type="text" name="id" placeholder="1" value="<?=$language['id']?>" id="id">
        <label for="name">Name</label>
        <input type="text" name="name" placeholder="Name" value="<?=$language['name']?>" id="name">
        <label for="email">Level</label>
        <input type="text" name="level" placeholder="Level" value="<?=$language['level']?>" id="level">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>