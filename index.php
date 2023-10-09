<?php
session_start(); 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
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
    <label for="sort-by">Sort by:</label>
    <select id="sort-by">
        <option value="title">Title</option>
        <option value="due_date">Due Date</option>
        <option value="status">Status</option>
    </select>
    <button id="sort-button">Sort</button>
</div>
    <div id="task-list">
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
