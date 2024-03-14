<?php
include("ConfigDB.php");

//For Updating Note in `to-do-list` Table
$Note = ""; // Store Diary Of `Note` Column Of `to-do-list` Table
if (isset($_GET['EditTask'])) {
    $ID = $_GET['EditTask'];
    $SelectQuery = "SELECT * FROM `to-do-list` WHERE ID = $ID";
    $ExecuteAboveQuery = mysqli_query($DB, $SelectQuery);
    $FetchData = mysqli_fetch_assoc($ExecuteAboveQuery);
    $Note = $FetchData['Note'];
}

if (isset($_POST['UpdateNoteBTN'])) {
    $ID = $_GET['EditTask'];
    $UpdatedNote = $_POST['UpdatedNote'];
    $UpdateQuery = "UPDATE `to-do-list` SET Note = '$UpdatedNote' WHERE ID = $ID";
    $ExecuteAboveQuery = mysqli_query($DB, $UpdateQuery);
    header("location:TodayList.php?DONEUPDATE=1");
}




$Diary = ""; // Store Diary Of `Diary` Column Of `Diary` Table
//Fetch Diary from `Diary` Table To print value of it in Input Tag
if (isset($_GET['EditDiary'])) {
    $ID = $_GET['EditDiary'];
    $SelectQuery = "SELECT * FROM `diary` WHERE ID = $ID";
    $ExecuteAboveQuery = mysqli_query($DB, $SelectQuery);
    $FetchData = mysqli_fetch_assoc($ExecuteAboveQuery);
    $Diary = $FetchData['Diary'];
}


//For Updating Diary in `Diary` table
if (isset($_POST['UpdateDiaryBTN'])) {
    $ID = $_GET['EditDiary'];
    $UpdatedDiary = $_POST['UpdatedDiary'];
    $UpdateQuery = "UPDATE `diary` SET Diary = '$UpdatedDiary' WHERE ID = $ID";
    $ExecuteAboveQuery = mysqli_query($DB, $UpdateQuery);
    header("location:TodayList.php?DONEUPDATE=1");
}


$Question = "";
$Answer = "";
//Fetch Question & Answer from `answer_of_questions` Table To print value of it in Input Tag
if (isset($_GET['EditAnswer'])) {
    $ID = $_GET['EditAnswer'];
    $SelectQuery = "SELECT * FROM `answer_of_questions` WHERE ID = $ID";
    $ExecuteAboveQuery = mysqli_query($DB, $SelectQuery);
    $FetchData = mysqli_fetch_assoc($ExecuteAboveQuery);
    $Answer = $FetchData['Answer'];
    $Question = $_GET['QUESTION'];
}

//For Updating Answers in `answer_of_questions` table
if (isset($_POST['UpdateAnswerBTN'])) {
    $ID = $_GET['EditAnswer'];
    $UpdatedAnswer = $_POST['UpdateAnswer'];
    $UpdateQuery = "UPDATE `answer_of_questions` SET Answer = '$UpdatedAnswer' WHERE ID = $ID";
    $ExecuteAboveQuery = mysqli_query($DB, $UpdateQuery);
    header("location:TodayList.php?DONEUPDATE=1");
}


    
//If user hasnt logged in this will force him to go to login page
Authunticate();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        textarea{
            unicode-bidi:plaintext;
        }
    </style>
</head>

<body>



<div style="margin-top: 50px;" class="row justify-content-center align-items-center h-100">
    <form action="" method="POST">
        <?php if (isset($_GET['EditTask'])) :
             
            ?>
            <textarea class="form-control" type="text" name="UpdatedNote"><?php echo $Note?></textarea>
            <button type="submit" name="UpdateNoteBTN" class="btn btn-outline-primary text-center col-md">Update</button>
        <?php endif ?>

        <?php if (isset($_GET['EditDiary'])) : ?>
            <textarea class="form-control" type="text" name="UpdatedDiary"><?php echo $Diary ?></textarea> 
            <button type="submit" name="UpdateDiaryBTN" class="btn btn-outline-primary text-center col-md">Update</button>
        <?php endif ?>


        <?php if (isset($_GET['EditAnswer'])) : ?>
            <label for=""><?php echo $Question ;?></label>
            <input class="form-control" type="text" name="UpdateAnswer" value="<?php echo $Answer ?>">
            <button type="submit" name="UpdateAnswerBTN" class="btn btn-outline-primary text-center col-md">Update</button>
        <?php endif ?>
    </form>
</div>

</body>

</html>