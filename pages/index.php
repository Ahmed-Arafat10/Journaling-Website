<?php

# relative path
require_once('../class/DB.php'); # import

$name = "Ahmed Arafat";
//echo $name;
//echo "<h1>$name</h1>";

$myObj = new \App\DB();
//$myObj->checkConnection();
//$myObj->Connection->query("SELECT * FROM `users`");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Welcome Back, <?php echo $name ?></h1>
</body>
</html>