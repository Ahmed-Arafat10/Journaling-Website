<?php
include("ConfigDB.php");

$UserID = $_SESSION['UserID'];

// Delete A Task in `to-do-list` table
if (isset($_GET['DeleteTask'])) {
    $ID = $_GET['DeleteTask'];
    $DeleteQuery = " DELETE FROM `to-do-list` WHERE ID = $ID";
    $ExecuteAboveQuery = mysqli_query($DB, $DeleteQuery);
    if ($ExecuteAboveQuery) PrintMessage("Done Deleting Task","Danger");
    else PrintMessage("Failed Deleting Task","Danger");
}


//Mark Task As Completed Task in `to-do-list` table
if (isset($_GET['MarkAsCompleteTask'])) {
    $ID = $_GET['MarkAsCompleteTask'];
    $FinshTaskOrNot =  $_GET['TEST'];
    if ($FinshTaskOrNot == 1)  $DeleteQuery = " UPDATE `to-do-list` SET Is_Done = 0 WHERE ID = $ID";
    else $DeleteQuery = " UPDATE `to-do-list` SET Is_Done = 1 WHERE ID = $ID";
    $ExecuteAboveQuery = mysqli_query($DB, $DeleteQuery);
    if (!$FinshTaskOrNot) PrintMessage("Mark Task As Completed Task","Normal");
    else PrintMessage("Mark Task As UnCompleted Task","Danger");
}


//Delete From `Diary` Table
if (isset($_GET['DeleteDiary'])) {
    $ID = $_GET['DeleteDiary'];
    $DeleteQuery = " DELETE FROM `diary` WHERE ID = $ID";
    $ExecuteAboveQuery = mysqli_query($DB, $DeleteQuery);
    if ($ExecuteAboveQuery) PrintMessage("Done Deleting Diary","Danger");
    else PrintMessage("Failed Deleting Diary","Danger");
}


//Delete Answer Of Predefined Question in  `answer_of_questions` Table
if (isset($_GET['DeleteAnswer'])) {
    $ID = $_GET['DeleteAnswer'];
    $DeleteQuery = " DELETE FROM `answer_of_questions` WHERE ID = $ID";
    $ExecuteAboveQuery = mysqli_query($DB, $DeleteQuery);
    if ($ExecuteAboveQuery) PrintMessage("Done Deleting Answer Of Question","Danger");
    else PrintMessage("Failed Deleting Answer Of Question","Danger");
}

if(isset($_GET['DONEUPDATE']))
{
    PrintMessage("Done Updating","Normal");
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
          td{
            unicode-bidi:plaintext;
        }
    </style>
</head>

<body>

    <div class="To-Do-List">
        <h3 style="margin:15px auto">To-Do-List of <b style="color:cadetblue;"> <?php echo $TodayDate ?> </b> </h3>
        <table class="table table-dark container">
            <tr>
                <!-- <th>Date</th> -->
                <th>Task</th>
                <th>Mark As Complete</th>
                <th>Edit Task</th>
                <th>Delete Task</th>
            </tr>

            <?php
            $JoinQuery = "SELECT Note , DATE.Date AS DD ,Todo.ID AS Task_ID , Todo.Is_Done AS Done 
            FROM `to-do-list` AS Todo INNER JOIN `date` as DATE 
            ON Todo.Date_ID  = DATE.ID WHERE DATE.Date = '$TodayDate' AND Todo.User_ID = $UserID ORDER BY Done ASC ";
            $ExecuteAboveQuery = mysqli_query($DB, $JoinQuery);
            $FinshTaskOrNot = NULL;
            foreach ($ExecuteAboveQuery as $Task) {
            ?>
                <tr>
                    <!-- <td> <?php echo  $Task['DD'] ?> </td> -->
                    <?php if ($Task['Done'] == '1') : ?>
                        <td> <del> <?php $FinshTaskOrNot = 1;
                                    echo  $Task['Note'] ?> </del></td>
                    <?php else : ?>
                        <td> <?php $FinshTaskOrNot = 0;
                                echo  $Task['Note'] ?></td>
                    <?php endif ?>
                    <?php if ($Task['Done'] == '1') : ?>
                        <td> <a href="TodayList.php?MarkAsCompleteTask=<?php echo $Task['Task_ID'] ?>&TEST=<?php echo $FinshTaskOrNot ?>"><button class="btn btn-info text-center">Undone</button> </a> </td>
                    <?php else : ?>
                        <td> <a href="TodayList.php?MarkAsCompleteTask=<?php echo $Task['Task_ID'] ?>&TEST=<?php echo $FinshTaskOrNot ?>"><button class="btn btn-primary text-center">Done</button> </a> </td>
                    <?php endif ?>
                    <td> <a href="EditData.php?EditTask=<?php echo $Task['Task_ID'] ?>"> <button class="btn btn-warning text-center">Edit</button> </a> </td>
                    <td> <a href="TodayList.php?DeleteTask=<?php echo  $Task['Task_ID'] ?>"> <button class="btn btn-danger text-center">Delete</button> </a> </td>
                    <td></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <hr>

    <div class="Diary">
        <h3> Diary Of <b style="color:cadetblue;"> <?php echo $TodayDate ?> </b> </h3>
        <table class="table table-dark container">
            <tr>
                <!-- <th>Date</th> -->
                <th>Diary</th>
                <th>Edit</th>
                <th>Delete Task</th>
            </tr>

            <?php
            $JoinQuery = "SELECT da.Date AS DATE ,di.ID AS DiaryID , di.Diary  AS DIARY FROM `diary` AS di INNER JOIN `date` as da ON di.Date_ID  = da.ID 
                            WHERE da.Date = '$TodayDate' AND di.User_ID = $UserID";
            $ExecuteAboveQuery = mysqli_query($DB, $JoinQuery);
            foreach ($ExecuteAboveQuery as $Diary) {
            ?>
                <tr>
                    <!-- <td> <?php echo  $Diary['DATE'] ?> </td> -->
                    <td> <?php echo  $Diary['DIARY'] ?> </td>
                    <td> <a href="EditData.php?EditDiary=<?php echo $Diary['DiaryID'] ?>"> <button class="btn btn-warning text-center">Edit</button> </a> </td>
                    <td> <a href="TodayList.php?DeleteDiary=<?php echo $Diary['DiaryID'] ?>"> <button class="btn btn-danger text-center">Delete</button> </a> </td>
                    <td></td>
                </tr>
            <?php } ?>
        </table>
    </div>


    <div class="AnswerOfPredefinedQuestions">
        <h3>Answer Of Predefined Questions Of <b style="color:cadetblue;"> <?php echo $TodayDate ?> </b></h3>
        <table class="table table-dark container">
            <tr>
                <!-- <td>Date</td> -->
                <td>Question</td>
                <td>Answer</td>
                <td>Edit Answer</td>
                <td>Delete Answer</td>
            </tr>

            <?php $JoinQuery =
                "SELECT ANSWER_TABLE.ID AS ANS_ID , ANSWER_TABLE.Answer AS ANS , DATE_TABLE.Date AS TODAY_DATE , QUESTION_TABLE.Question AS QUESTION
            FROM `answer_of_questions` AS ANSWER_TABLE INNER JOIN `date` AS DATE_TABLE 
            ON ANSWER_TABLE.Date_ID = DATE_TABLE.ID 
            INNER JOIN `predefined-questions` AS QUESTION_TABLE 
            ON ANSWER_TABLE.QuestionID	= QUESTION_TABLE.ID WHERE DATE_TABLE.Date = '$TodayDate' AND ANSWER_TABLE.User_ID = $UserID ";
            $ExecuteAboveQuery = mysqli_query($DB, $JoinQuery);
            foreach ($ExecuteAboveQuery as $AnswerOfQuestions) {
            ?>
                <tr>
                    <!-- <td> <?php echo  $AnswerOfQuestions['TODAY_DATE'] ?> </td> -->
                    <td> <?php echo  $AnswerOfQuestions['QUESTION'] ?> </td>
                    <td> <?php echo  $AnswerOfQuestions['ANS'] ?> </td>
                    <td> <a href="EditData.php?EditAnswer=<?php echo $AnswerOfQuestions['ANS_ID'] ?>&QUESTION=<?php echo $AnswerOfQuestions['QUESTION']; ?>"> <button class="btn btn-warning text-center">Edit</button> </a> </td>
                    <td> <a href="TodayList.php?DeleteAnswer=<?php echo $AnswerOfQuestions['ANS_ID']; ?>"> <button class="btn btn-danger     text-center">Delete</button> </a> </td>
                </tr>

            <?php } ?>
        </table>
    </div>



</body>

</html>