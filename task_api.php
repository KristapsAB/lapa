<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$tasks = [
    ['id' => 1, 'title' => 'Task 1', 'description' => 'Description 1', 'due_date' => '2023-10-10', 'status' => 'Pending'],
    ['id' => 2, 'title' => 'Task 2', 'description' => 'Description 2', 'due_date' => '2023-10-12', 'status' => 'In Progress'],
    ['id' => 3, 'title' => 'Task 3', 'description' => 'Description 3', 'due_date' => '2023-10-15', 'status' => 'Completed'],
];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($tasks);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $newTask = [
        'id' => count($tasks) + 1,
        'title' => $data['title'],
        'description' => $data['description'],
        'due_date' => $data['due_date'],
        'status' => 'Pending' 
    ];
    $tasks[] = $newTask;
    echo json_encode($newTask);
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $taskId = $data['id'];
    $newStatus = $data['status'];

    foreach ($tasks as &$task) {
        if ($task['id'] === $taskId) {
            $task['status'] = $newStatus;
            echo json_encode(['message' => 'Status updated successfully']);
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $taskId = $data['id'];

    foreach ($tasks as $key => $task) {
        if ($task['id'] === $taskId) {
            unset($tasks[$key]);
            echo json_encode(['message' => 'Task deleted successfully']);
            break;
        }
    }
}
?>
