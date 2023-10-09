<?php
session_start(); 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the selected sort option
    $sort_by = $_POST['sort-by'];

    // Construct the SQL query to sort tasks by the selected field
    $query = "SELECT * FROM tasks ORDER BY $sort_by";

    // Execute the query and display the results
    // ...
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Task Management System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php include('header.php'); ?>
    <h1>Task Management System</h1>

    <form id="task-form">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea><br>

        <label for="due_date">Due Date:</label>
        <input type="date" id="due_date" name="due_date"><br>   

        <input type="submit" value="Add Task">
    </form>

    <div id="sorting-options">
        <form method="post">
            <label for="sort-by">Sort by:</label>
            <select id="sort-by" name="sort-by">
                <option value="title">Title</option>
                <option value="due_date">Due Date</option>
                <option value="status">Status</option>
            </select>
            <button type="submit">Sort</button>
        </form>
    </div>

    <div id="task-list">
        <?php
            // Display tasks sorted by default field (e.g. title)
            $query = "SELECT * FROM tasks ORDER BY title";
            // Execute the query and display the results
            // ...
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
