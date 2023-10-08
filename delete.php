<?php
include_once 'db.php';
include_once 'Task.php';

$database = new Database();
$db = $database->getConnection();
$task = new Task($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $task_id = $data->id; // Get task ID from the request

    // Debug: Print the task ID to the console
    echo "Task ID: " . $task_id;

    // Attempt to delete the task
    $result = $task->deleteTask($task_id);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting task']);
    }
}
?>
