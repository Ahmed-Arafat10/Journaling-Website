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

    public function update($taskId)
    {
        if (isset($_POST['updateTaskBtn'])) {
            $task = $_POST['taskInput'];
            $userID = $_SESSION['userID'];
            $db = new DB();
            $insertQuery = "UPDATE `to-do-list` SET task = ? WHERE id = ? AND user_id = ?";
            $prepareStmt = $db->connection->prepare($insertQuery);
            $prepareStmt->bind_param('sii', $task, $taskId, $userID);
            $checkQuery = $prepareStmt->execute();
            if ($checkQuery) {
                header("Location: TaskView.php");
            } else
                Alert::printMessage("Task is not updated, please try again", "danger");
        }
    }

    public function delete()
    {
        if (isset($_GET['taskIdToDelete'])) {
            $taskId = $_GET['taskIdToDelete'];
            $userID = $_SESSION['userID'];
            $deleteQuery = "DELETE FROM `to-do-list` WHERE id = ? AND user_id = ?";
            $db = new DB();
            $prepareStmt = $db->connection->prepare($deleteQuery);
            $prepareStmt->bind_param('ii', $taskId, $userID);
            $checkQuery = $prepareStmt->execute();
            if ($checkQuery) {
                header("Location: TaskView.php");
            } else {
                Alert::printMessage("Task not deleted", "danger");
            }
        }
    }

    public function changeTaskStatus()
    {
        if (isset($_GET['taskStatus']) && isset($_GET['taskId'])) {
            $newTaskStatus = $_GET['taskStatus']; // "0" / "1"
            if (!in_array($newTaskStatus, ["0", "1"])) {
                Alert::printMessage("Invalid task status", "danger");
                return;
            }
            $taskId = $_GET['taskId'];
            $userID = $_SESSION['userID'];
            $updateQuery = "UPDATE `to-do-list` SET is_done = ? WHERE id = ? AND user_id = ?";
            $db = new DB();
            $prepareStmt = $db->connection->prepare($updateQuery);
            $prepareStmt->bind_param('iii', $newTaskStatus, $taskId, $userID);
            $checkQuery = $prepareStmt->execute();
            if ($checkQuery) {
                header("Location: TaskView.php");
            } else {
                Alert::printMessage("Task status not updated", "danger");
            }
        }
    }

    public function getTaskById($taskId)
    {
        $userID = $_SESSION['userID'];
        $updateQuery = "SELECT task FROM `to-do-list` WHERE id = ? AND user_id = ?";
        $db = new DB();
        $prepareStmt = $db->connection->prepare($updateQuery);
        $prepareStmt->bind_param('ii', $taskId, $userID);
        $prepareStmt->execute();
        return ($prepareStmt->get_result())->fetch_assoc();
    }
}