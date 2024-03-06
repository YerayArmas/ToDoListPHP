<!DOCTYPE html>
<?php
// Connecting to DataBase
$db = mysqli_connect('localhost', 'yeray', 'reboot', 'ToDo');
// server, db user, password, database

$errors = '';

if (isset($_POST['submit'])) {
    $task = $_POST['task'];
    if (empty($task)) {
        $errors = 'You must fill in with a task!';
    } else {
        mysqli_query($db, "INSERT INTO tasks (task) VALUES ('$task')"); // table "tasks", column "task"
        header('location: index.php');
        exit; // Add exit to prevent further execution
    }
}

if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];
    mysqli_query($db, "DELETE FROM tasks WHERE id=$id");
    header('location: index.php');
}

$tasks = mysqli_query($db, "SELECT * FROM tasks");

// Prints errors (debugging)           ini_set('display_errors', 1);  
//                                       error_reporting(E_ALL);
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

    <div class="container">
        <h2 style="color: darkblue">ToDo List with PHP & MySql</h2>
    </div>

    <form method="POST" action="index.php">
        <div class="input-container">
            <?php if (isset($errors)) { ?>
                <p><?php echo $errors; ?></p>
            <?php } ?>
            <input type="text" name="task" class="input">
        </div>
        <button type="submit" name="submit" class="btn">Submit</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Number</th>
                <th>Task to do</th>
                <th>Delete</th>
            </tr>
        </thead>

        <tbody>

            <?php $i = 1;
            while ($row = mysqli_fetch_array($tasks)) { ?>

                <tr>
                    <td><?php echo $i; ?></td>
                    <td class="Phrase"><?php echo $row['task']; ?></td>
                    <td class="del">
                        <a href="index.php?del_task=<?php echo $row['id']; ?>">X</a>
                    </td>
                </tr>

            <?php $i++;
            } ?>

        </tbody>
    </table>

</body>

</html>