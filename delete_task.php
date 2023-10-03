<?php
class TaskDeleter {
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

    public function deleteTask($taskId) {
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $taskId);

        if ($stmt->execute()) {
            return "Task deleted successfully.";
        } else {
            return "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    public function __destruct() {
        $this->conn->close();
    }
}

// Example usage of the TaskDeleter class
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $taskId = $_POST['id'];
    $taskDeleter = new TaskDeleter();
    $result = $taskDeleter->deleteTask($taskId);
    echo $result;
}
?>
