<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../auth/login.php");
    exit;
}

function template_header($title) {
	$username  = $_SESSION["username"];

echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>My CMS</title>
		<link href="/sir-crud/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>Hello $username</h1>
    		<!--<a href="../languages/read.php"><i class="fas fa-address-book"></i>Languages</a>-->

			<a href="../../auth/logout.php">Logout</a>
    	</div>
    </nav>
EOT;
}
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>