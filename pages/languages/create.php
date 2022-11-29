<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $level = isset($_POST['level']) ? $_POST['level'] : '';
    // Insert new record into the languages table
    $stmt = $pdo->prepare('INSERT INTO languages VALUES (?, ?, ?)');
    $stmt->execute([$id, $name, $level]);
    // Output message
    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Create language</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <label for="name">Name</label>
        <input type="text" name="name" placeholder="Portuguese" id="name">
        <label for="level">Level</label>
        <input type="text" name="level" placeholder="Very good!" id="level">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>