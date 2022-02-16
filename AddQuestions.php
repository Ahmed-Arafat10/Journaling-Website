<?php
include("ConfigDB.php");

//If user hasnt logged in this will force him to go to login page
Authunticate();

// Insert Into `Question` Table New Question For Today's Date
if (isset($_POST['QuestionsBTN'])) {
    $Question = $_POST['QuestionsIN'];
    $InsertQueryQuestionT = " INSERT INTO `predefined-questions` VALUES (NULL,'$Question')";
    $ExceuteAboveQuery = mysqli_query($DB, $InsertQueryQuestionT);
    if ($ExceuteAboveQuery) PrintMessage("Done Adding New Question", "Normal");
    else echo PrintMessage("Failed Adding New Question", "Danger");
}


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
    <div style="margin-top: 50px;" class="row justify-content-center align-items-center h-100">
        <div class="container">
            <div class="Predefined-Questions">
                <h1 style="font-style: italic;">Questions</h1>
                <form action="" method="POST">
                    <label style="font-weight: bold;"  for="QuestionsIN"> Note :</label>
                    <input style="font-weight: bold;" class="form-control" type="text" name="QuestionsIN" id="" placeholder="Enter New Question">
                    <div class="row justify-content-center align-items-center">
                        <button style="margin-top: 15px;" type="submit" name="QuestionsBTN" class="btn btn-outline-primary text-center">Add Question</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>