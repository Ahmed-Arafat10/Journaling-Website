<?php

namespace App;

class Task
{
    public function createNewTask()
    {
        //taskInput
        //addNewTaskBtn
        // CRUD
        if (isset($_POST['addNewTaskBtn'])) {
            $task = $_POST['taskInput'];
            $date = date("Y-m-d H:i:s");
            $insertStatement = 'INSERT INTO `to-do-list` VALUES(NULL,?,0,?,?)';
            $myDBObject = new \App\DB();
            $queryObject = $myDBObject->Connection->prepare($insertStatement);
            $queryObject->bind_param('sis', $task, $_SESSION['userID'], $date);
            $checkQuery = $queryObject->execute();
            if ($checkQuery)
                \App\Alert::PrintMessage("Done Inserting New Task", "Normal");
            else
                Alert::PrintMessage("Failed To Insert New Task", "Danger");
        }
    }


    public function getTodaysTasks()
    {
        // SELECT * FROM `to-do-list` WHERE user_id = 3 AND Date(date) = '2025-04-20';
        $selectStatement = 'SELECT * FROM `to-do-list` WHERE user_id = ? AND Date(date) = ? ORDER BY is_done ASC';
        $date = date("Y-m-d");
        $myDBObject = new \App\DB();
        $queryStmtObject = $myDBObject->Connection->prepare($selectStatement);
        $queryStmtObject->bind_param('is', $_SESSION['userID'], $date);
        $queryStmtObject->execute();
        return $queryStmtObject->get_result();// mysqli_result
    }
}