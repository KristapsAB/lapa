$(document).ready(function() {
    function fetchAndDisplayTasks() {
        $.ajax({
            type: 'GET',
            url: 'get_tasks.php',
            success: function(response) {
                $('#task-list').html(response);
                attachDeleteHandlers();
                attachStatusCheckboxHandlers();
                attachEditHandlers();
            },
            error: function() {
                alert('An error occurred while fetching tasks.');
            }
        });
    }

    function attachDeleteHandlers() {
        $('.delete-button').click(function(e) {
            e.preventDefault();

            var taskId = $(this).data('task-id');

            $.ajax({
                type: 'POST',
                url: 'delete_task.php',
                data: { id: taskId },
                success: function(response) {
                    alert(response);
                    fetchAndDisplayTasks();
                },
                error: function() {
                    alert('An error occurred while deleting the task.');
                }
            });
        });
    }

    function attachStatusCheckboxHandlers() {
        $('.status-checkbox').change(function() {
            var taskId = $(this).data('task-id');
            var newStatus = this.checked ? 'Completed' : 'Not Completed';

            $.ajax({
                type: 'POST',
                url: 'update_status.php',
                data: { id: taskId, status: newStatus },
                success: function(response) {
                    alert(response);
                    fetchAndDisplayTasks();
                },
                error: function() {
                    alert('An error occurred while updating the status.');
                }
            });
        });
    }

    function attachEditHandlers() {
        $('.edit-button').click(function(e) {
            e.preventDefault();

            var taskId = $(this).data('task-id');

            openEditModal(taskId);
        });
    }

    function openEditModal(taskId) {
        alert('Edit task with ID: ' + taskId);
    }

    $('#task-form').submit(function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'add_task.php',
            data: formData,
            success: function(response) {
                alert(response);
                $('#task-form')[0].reset();
                fetchAndDisplayTasks();
            },
            error: function() {
                alert('An error occurred while adding the task.');
            }
        });
    });

    fetchAndDisplayTasks();
});
