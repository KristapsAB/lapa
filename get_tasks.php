<?php
class TaskFetcher {
    private $conn;

    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "task_management";

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function fetchTasks() {
        $sql = "SELECT * FROM tasks";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $tasks = array();
            while ($row = $result->fetch_assoc()) {
                $taskId = $row['id'];
                $status = $row['status'];
                $completed = ($status === 'Completed') ? 'checked' : '';

                $tasks[] = [
                    'title' => $row['title'],
                    'description' => $row['description'],
                    'due_date' => $row['due_date'],
                    'status' => $status,
                    'completed' => $completed,
                    'task_id' => $taskId,
                ];
            }
            return $tasks;
        } else {
            return array();
        }
    }

    public function __destruct() {
        $this->conn->close();
    }
}

$taskFetcher = new TaskFetcher();
$tasks = $taskFetcher->fetchTasks();

if (!empty($tasks)) {
    echo '<ul>';
    foreach ($tasks as $task) {
        echo '<li>' . $task['title'] . ' - ' . $task['description'] . ' - Due: ' . $task['due_date'] . ' - Status: <input type="checkbox" class="status-checkbox" data-task-id="' . $task['task_id'] . '" ' . $task['completed'] . '> ' . $task['status'] . ' <button class="edit-button" data-task-id="' . $task['task_id'] . '">Edit</button> <button class="delete-button" data-task-id="' . $task['task_id'] . '">Delete</button></li>';
    }
    echo '</ul>';
} else {
    echo 'No tasks found.';
}
?>
