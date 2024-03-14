<?php

require_once '../vendor/autoload.php';

\App\Date::storeTodaysDateIfNeeded();

\App\Authentication::auth();

\App\Authentication::logOut();

\App\Alert::alertAfterSignIn();

$userName = $_SESSION['username'];
$UserID = $_SESSION['user_id'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/index.css?v=<?php echo time() ?>">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <title>Ahmed Arafat's Journaling</title>
</head>

<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/Journaling/php/Layout/NavBar.php' ?>

</body>

</html>