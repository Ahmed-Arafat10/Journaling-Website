<?php

require_once('../vendor/autoload.php');

$authObj = new \App\Authenticate();
$authObj->redirectIfNotAuth();

$taskObject = new \App\Task();

// foreach for while
$allTasks = $taskObject->getTodaysTasks(); // object of class mysqli_result

//var_dump($allTasks);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="\viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/index.css?v=<?php echo time() ?>">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet'
          href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap'>
    <title>Tasks List</title>
</head>
<body>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/IA/pages/Layout/Navbar.php') ?>

<div class="To-Do-List">
    <h3 style="margin:15px auto">
        To-Do-List of <b style="color:cadetblue;"> <?php echo date("Y-m-d"); ?>
        </b>
    </h3>
    <table class="table table-dark container">
        <tr>
            <th>Task</th>
            <!--            <th>Mark As Complete</th>-->
            <th>Edit Task</th>
            <th>Delete Task</th>
        </tr>

        <?php foreach ($allTasks as $task): ?>
            <tr>
                <?php if ($task['is_done'] == 1): ?>
                    <td>
                        <del><?php echo $task['note'] ?></del>
                    </td>
                <?php else: ?>
                    <td>
                        <?php echo $task['note'] ?>
                    </td>
                <?php endif; ?>
                <td>
                    <a href="#"">
                        <button class="btn btn-warning text-center">Edit</button>
                    </a>
                </td>
                <td>
                    <a href="#">
                        <button class="btn btn-danger text-center">Delete</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<hr>


</body>
</html>
