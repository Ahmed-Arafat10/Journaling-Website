<?php

namespace App;

class Task
{
    public function create()
    {
        if (isset($_POST['addNewTaskBtn'])) {
            $task = $_POST['taskInput'];
            $date = date('Y-m-d H:i:s');
            $db = new DB();
            $userID = $_SESSION['userID'];
            $insertQuery = "INSERT INTO `to-do-list` VALUES (NULL,?,0,?,?)";
            $prepareStmt = $db->connection->prepare($insertQuery);
            $prepareStmt->bind_param('sis', $task, $userID, $date);
            $checkQuery = $prepareStmt->execute();
            if ($checkQuery) {
                Alert::printMessage("Task added successfully", "success");
                header("Location: TaskView.php");
            } else
                Alert::printMessage("Task not added", "danger");
        }
    }

    public function readOperation_getTodaysTasks()
    {
        $userID = $_SESSION['userID'];
        $date = date('Y-m-d');
        $selectQuery = "SELECT * FROM `to-do-list` WHERE user_id = ? AND DATE(date) = ? ORDER BY is_done ASC, date DESC";
        $db = new DB();
        $prepareStmt = $db->connection->prepare($selectQuery);
        $prepareStmt->bind_param('is', $userID, $date);
        $prepareStmt->execute();
        return $prepareStmt->get_result();
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}