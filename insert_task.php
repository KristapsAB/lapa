<?php
class TaskAdder {
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

    public function addTask($title, $description, $due_date, $status) {
        $sql = "INSERT INTO tasks (title, description, due_date, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ssss', $title, $description, $due_date, $status);

        if ($stmt->execute()) {
            return "Task added successfully.";
        } else {
            return "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    public function __destruct() {
        $this->conn->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    $taskAdder = new TaskAdder();
    $result = $taskAdder->addTask($title, $description, $due_date, $status);
    echo $result;
}
?>
