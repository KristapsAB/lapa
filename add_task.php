<?php
class TaskManager {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'task_management');

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function addTask($title, $description, $due_date, $status) {
        $title = $this->conn->real_escape_string($title);
        $description = $this->conn->real_escape_string($description);
        
        $sql = "INSERT INTO tasks (title, description, due_date, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $title, $description, $due_date, $status);
            if ($stmt->execute()) {
                $stmt->close();
                return "Task added successfully.";
            } else {
                return "Error: " . $stmt->error;
            }
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    public function __destruct() {
        $this->conn->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskManager = new TaskManager();
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    $result = $taskManager->addTask($title, $description, $due_date, $status);
    echo $result;
}
?>
