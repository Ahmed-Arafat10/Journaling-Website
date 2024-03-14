<?php
include("ConfigDB.php");

//Initialize with NULL value
$Day_ID = NULL;
//Check if todat's date already exist in `Date` Table 
$SelectQueryFromDateT = "SELECT * FROM `date` WHERE Date = '$TodayDate' ";
$ExceuteSelectQuery = mysqli_query($DB, $SelectQueryFromDateT);
$NumOfRows = mysqli_num_rows($ExceuteSelectQuery);
//If todat's date does not exist in `Date` Table, THEN insert it in Table 
if (!$NumOfRows) {
    $InsertQueryToDateT = "INSERT INTO `Date` VALUES(NULL,'$TodayDate')";
    $ExceuteInsertQuery = mysqli_query($DB, $InsertQueryToDateT);
}

// SELECT Today's Date row to be able to store it's ID in $Day_ID variable after fetching row
$SelectQueryFromDateT = "SELECT * FROM `date` WHERE Date = '$TodayDate' ";
$ExceuteSelectQuery = mysqli_query($DB, $SelectQueryFromDateT);
$FetchData = mysqli_fetch_assoc($ExceuteSelectQuery);
$Day_ID = $FetchData['ID'];

//VIP: To Make Today's Date ID Global amoung ALL Pages
$_SESSION['Day_ID'] =  $Day_ID;


//Debug
// echo "Today's ID is : " . $Day_ID;



//Store Name and ID of logged in user in this two variables
if(isset($_SESSION['User'])) $UserName = $_SESSION['User'];
$UserID = $_SESSION['UserID'];



//If user hasnt logged in this will force him to go to login page
Authunticate();


//When user click on logout button, distroy $_Session array from memory & unset all key -> Value
if (isset($_GET['LogOut'])) {
    session_unset();
    session_destroy();
    setcookie("RememberMe","",time() - 3600);
    header('location:index.php');
}


//After User Login In Login Page And Redirected To This Page This Will Print Welcome Alert
if (isset($_GET['DoneLogIn'])) {

    PrintMessage("Welcome Back, $UserName", "Normal");
    //echo $_COOKIE['RememberMe'];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahmed Arafat's Journaling</title>
</head>

<body>

</body>

</html>