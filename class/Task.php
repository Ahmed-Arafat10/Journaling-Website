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

    public function getTaskById($taskId)
    {
        $selectStatement = 'SELECT * FROM `to-do-list` WHERE id = ?';
        $myDBObject = new \App\DB();
        $queryStmtObject = $myDBObject->Connection->prepare($selectStatement);
        $queryStmtObject->bind_param('i', $taskId);
        $queryStmtObject->execute();
        return ($queryStmtObject->get_result())->fetch_assoc();// mysqli_result
    }

    public function updateTask($taskId)
    {
        if (isset($_POST['updateTaskBtn'])) {
            $updatedTask = $_POST['taskInput'];
            $updateStatement = 'UPDATE `to-do-list` SET note = ? WHERE id = ?';
            $myDBObject = new \App\DB();
            $queryStmtObject = $myDBObject->Connection->prepare($updateStatement);
            $queryStmtObject->bind_param('si', $updatedTask, $taskId);
            $checkQuery = $queryStmtObject->execute();
            if ($checkQuery)
                header('location: TaskView.php');
            else
                Alert::PrintMessage("Failed To Update Task", "Danger");
        }
    }

    public function deleteTask()
    {
        if (isset($_GET['taskToDelete'])) {
            $taskId = $_GET['taskToDelete'];
            $deleteStatement = 'DELETE FROM `to-do-list` WHERE id = ?';
            $myDBObject = new \App\DB();
            $queryStmtObject = $myDBObject->Connection->prepare($deleteStatement);
            $queryStmtObject->bind_param('i', $taskId);
            $checkQuery = $queryStmtObject->execute();
            if ($checkQuery)
                header('location: TaskView.php');
            else
                Alert::PrintMessage("Failed To Delete Task", "Danger");
        }
    }

    public function updateTaskStatus()
    {
        if (isset($_GET['taskStatus'])) {
            $taskStatus = $_GET['taskStatus'];// 0 1
            $taskId = $_GET['taskId'];
            $updateStatement = 'UPDATE `to-do-list` SET is_done = ? WHERE id = ?';
            $myDBObject = new \App\DB();
            $queryStmtObject = $myDBObject->Connection->prepare($updateStatement);
            $queryStmtObject->bind_param('ii', $taskStatus, $taskId);
            $checkQuery = $queryStmtObject->execute();
            if ($checkQuery)
                header('location: TaskView.php');
            else
                Alert::PrintMessage("Failed To Update Task Status", "Danger");
        }
    }

}