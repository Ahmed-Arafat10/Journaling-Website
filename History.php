<?php
include("ConfigDB.php");


$UserID = $_SESSION['UserID'];

$WantedDateID = NULL;
$WantedDate = NULL;
if (isset($_POST['SearchBTN'])) {
    $WantedDate = $_POST['WantedDate'];
    $SelectQuery = "SELECT * FROM `date` WHERE Date = '$WantedDate' ";
    $ExecuteAboveQuery = mysqli_query($DB, $SelectQuery);
    $NumRows = mysqli_num_rows($ExecuteAboveQuery);
    //Debug
    //echo "this". $NumRows;
    if ($NumRows) {
        $FetchData = mysqli_fetch_assoc($ExecuteAboveQuery);
        $WantedDateID = $FetchData['ID'];
        $WantedDate = $FetchData['Date'];
    } else PrintMessage("This Date Has No Information", "Danger");
}

//Debug
// echo $WantedDateID;

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
</head>

<body>

    <div class="History-Date container">

        <h3>Date That Have Avaialable Information</h3>
        <div class="row justify-content-center align-items-center h-100">
            <!-- <label  for="">Date: </label> -->
            <select class="form-control col-md" name="" id="">
                <?php
                $JoinQuery = "SELECT * FROM `date`";
                $ExecuteAboveQuery = mysqli_query($DB, $JoinQuery);
                foreach ($ExecuteAboveQuery as $DATE) {
                ?>
                    <option value="">
                        <!-- <td> <?php echo  $DATE['ID'] ?> </td> -->
                        <td> <?php echo  $DATE['Date'] ?> </td>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!-- Search Form -->
    <div style="margin-top: 50px;" class="row justify-content-center align-items-center h-100">
        <form action="" method="POST">
            <!-- <label for="">Date:</label> -->
            <input class="form-control" required type="date" name="WantedDate" id="">
            <button type="submit" name="SearchBTN" class="btn btn-outline-primary text-center col-md">Search</button>
        </form>
    </div>
    <!-- Search Form -->

    <div class="To-Do-List">
        <h1>To-Do-List of <b> <?php echo $WantedDate ?> </b> </h1>
        <table class="table table-dark container">
            <tr>
                <!-- <th>Date</th> -->
                <th>Task</th>
                <th>Edit Task</th>
                <!-- <th>Delete Task</th> -->
            </tr>

            <?php
            $JoinQuery = "SELECT Note , DATE.Date AS DD ,Todo.ID AS Task_ID , Todo.Is_Done AS Done
            FROM `to-do-list` AS Todo 
            INNER JOIN `date` as DATE
            ON Todo.Date_ID  = DATE.ID WHERE DATE.ID = '$WantedDateID' AND Todo.User_ID = $UserID ORDER BY Done ASC ";
            $ExecuteAboveQuery = mysqli_query($DB, $JoinQuery);
            $FinshTaskOrNot = NULL;
            foreach ($ExecuteAboveQuery as $Task) {
            ?>
                <tr>
                    <!-- <td> <?php echo  $Task['DD'] ?> </td> -->
                    <?php if ($Task['Done'] == '1') : ?>
                        <td> <del> <?php echo  $Task['Note'] ?> </del></td>
                    <?php else : ?>
                        <td> <?php echo  $Task['Note'] ?></td>
                    <?php endif ?>
                    <td> <a href="EditData.php?EditTask=<?php echo $Task['Task_ID'] ?>"> <button class="btn btn-warning text-center">Edit</button> </a> </td>
                    <!-- <td> <a href="TodayList.php?DeleteTask=<?php echo  $Task['Task_ID'] ?>"> <button>Delete</button></a> </td> -->
                    <td></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="Diary">
        <h1> Diary Of <b> <?php echo $WantedDate ?> </b> </h1>
        <table class="table table-dark container">
            <tr>
                <!-- <th>Date</th> -->
                <th>Diary</th>
                <th>Edit Diary</th>
                <!-- <th>Delete Task</th> -->
            </tr>

            <?php
            $JoinQuery =
                "SELECT da.Date AS DATE ,di.ID AS DiaryID , di.Diary  AS DIARY FROM `diary` AS di
                INNER JOIN `date` as da ON di.Date_ID  = da.ID 
                 WHERE (da.ID = '$WantedDateID' AND di.User_ID = $UserID) ";
            $ExecuteAboveQuery = mysqli_query($DB, $JoinQuery);
            foreach ($ExecuteAboveQuery as $Diary) {
            ?>
                <tr>
                    <!-- <td> <?php echo  $Diary['DATE'] ?> </td> -->
                    <td> <?php echo  $Diary['DIARY'] ?> </td>
                    <td> <a href="EditData.php?EditDiary=<?php echo $Diary['DiaryID'] ?>"> <button class="btn btn-warning text-center">Edit</button> </a> </td>
                    <!-- <td> <a href="TodayList.php?DeleteDiary=<?php echo $Diary['DiaryID'] ?>"> <button>Delete</button> </a> </td> -->
                    <td></td>
                </tr>
            <?php } ?>
        </table>
    </div>



    <div class="AnswerOfPredefinedQuestions">
        <h1>Answer Of Predefined Questions Of <b> <?php echo $WantedDate ?> </b> </h1>
        <table class="table table-dark container    ">
            <tr>
                <!-- <td>Date</td> -->
                <td>Question</td>
                <td>Answer</td>
                <td>Edit Answer</td>
                <!-- <td>Delete Answer</td> -->
            </tr>

            <?php $JoinQuery = "SELECT ANSWER_TABLE.ID AS ANS_ID , ANSWER_TABLE.Answer AS ANS , DATE_TABLE.Date AS TODAY_DATE , QUESTION_TABLE.Question AS QUESTION
                                 FROM `answer_of_questions` AS ANSWER_TABLE
                                  INNER JOIN `date` AS DATE_TABLE 
                                 ON ANSWER_TABLE.Date_ID = DATE_TABLE.ID 
                                INNER JOIN `predefined-questions` AS QUESTION_TABLE 
                                ON ANSWER_TABLE.QuestionID = QUESTION_TABLE.ID
                                 WHERE DATE_TABLE.ID = '$WantedDateID' AND ANSWER_TABLE.User_ID = $UserID  ";
            $ExecuteAboveQuery = mysqli_query($DB, $JoinQuery);
            foreach ($ExecuteAboveQuery as $AnswerOfQuestions) {
            ?>
                <tr>

                    <td> <?php echo  $AnswerOfQuestions['QUESTION'] ?> </td>
                    <td> <?php echo  $AnswerOfQuestions['ANS'] ?> </td>
                    <td> <a href="EditData.php?EditAnswer=<?php echo $AnswerOfQuestions['ANS_ID'] ?>&QUESTION=<?php echo $AnswerOfQuestions['QUESTION']; ?>"><button class="btn btn-warning text-center">Edit</button> </a> </td>
                    <!-- <td> <a href="TodayList.php?DeleteAnswer=<?php echo $AnswerOfQuestions['ANS_ID']; ?>"> <button>Delete</button> </a> </td> -->
                </tr>

            <?php } ?>
        </table>
    </div>



</body>

</html>
