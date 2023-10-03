<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $taskId = $_POST['id'];
    
    $editedTitle = $_POST['edited_title'];
    $editedDescription = $_POST['edited_description'];
    $editedDueDate = $_POST['edited_due_date'];
    
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "task_management"; 

    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

  
    $sql = "UPDATE tasks SET title = ?, description = ?, due_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $editedTitle, $editedDescription, $editedDueDate, $taskId);

    if ($stmt->execute()) {
        echo "Task details updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
