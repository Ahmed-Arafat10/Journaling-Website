<?php
// Connect To Database
$UserNameOfDB = "root"; //2
$Password = ""; //3
$HostName = "Localhost"; //1
$DataBaseName = "journaling"; //4
$DB = mysqli_connect($HostName, $UserNameOfDB, $Password, $DataBaseName);

/* //Debug
if ($DB) echo PrintMessage("Done Connecting To DB", "Normal");
else echo PrintMessage("FAILED Connecting To DB", "Danger");
*/

// Set Time Zone To Cairo
date_default_timezone_set('Africa/Cairo');

// Store Vlaue Of Today'S Date With This Format (2022-1-9) In This Variable
$TodayDate =  date("Y-m-d");

#Debug
//echo $TodayDate;
//If User didnt logged in yet this function will force him to go to login page , so he wont be able to access any page unless he logged in
function Authunticate()
{
    if (!isset($_SESSION['User'])) header('location:Login.php');
}

// Create Global Array $_Session
session_start();


// A Function That Print an alert if it takes "Danger" parameter, its color will be read, if "Normal" its color will be blue
function PrintMessage($text, $Type)
{
    if ($Type == "Danger") echo "<div style='text-align:center;margin-bottom:0;' class = 'alert alert-danger' role = 'alert' >" . $text . "</div>";
    else echo "<div style='text-align:center;margin-bottom:0;' class = 'alert alert-primary' role = 'alert' >" . $text . "</div>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Nav Bar Start That will be Shared in All Pages thats why it is in this page as this page is inluded in all pages to connect to Databse-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php"><span style="color:salmon;">J</span>ournaling</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="TodayList.php">Today's List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="AddData.php">Add Data</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="History.php">History</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="AddQuestions.php">Add Questions</a>
                </li>
                <?php if (!isset($_SESSION['User'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="Login.php">Login</a>
                    </li>
                <?php else : ?>
                    <li style="width:50px;" class="nav-item">
                        <a id="Logout" class="nav-link" href="index.php?LogOut=1">Logout</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </nav>
    <!-- Nav Bar End-->
</body>

</html>