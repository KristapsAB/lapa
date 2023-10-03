<?php
class TaskStatusUpdater {
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

    public function updateTaskStatus($taskId, $newStatus) {
        $sql = "UPDATE tasks SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $newStatus, $taskId);

        if ($stmt->execute()) {
            return "Status updated successfully.";
        } else {
            return "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    public function __destruct() {
        $this->conn->close();
    }
}

// Example usage of the TaskStatusUpdater class
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
    $taskId = $_POST['id'];
    $newStatus = $_POST['status'];

    $taskStatusUpdater = new TaskStatusUpdater();
    $result = $taskStatusUpdater->updateTaskStatus($taskId, $newStatus);
    echo $result;
}
?>
