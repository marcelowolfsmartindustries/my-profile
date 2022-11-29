<?php 
    session_start();
    $username = $_SESSION["username"];
?>
    <!DOCTYPE html>
<html>
<body>
<h1> Hello <?php echo $username ?></h1>
<p>My first paragraph.</p>
</body>
</html>