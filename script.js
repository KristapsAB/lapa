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
$(document).ready(function() {
    function redirectToLogin() {
        window.location.href = 'login.php';
    }

    $('#loginToggle').click(function() {
        redirectToLogin();
    });

});
$(document).ready(function() {
    function redirectToRegister() {
        window.location.href = 'register.php';
    }


    $('#registerButton').click(function() {
        redirectToRegister();
    });

});
function openEditModal(taskId) {

    var task = tasks[taskId];


    $('#editTaskModal').modal('show');

  
    $('#editedTitle').val(task.title);
    $('#editedDescription').val(task.description);
    $('#editedDueDate').val(task.due_date);


    $('#saveEditedTask').click(function() {

        var editedTitle = $('#editedTitle').val();
        var editedDescription = $('#editedDescription').val();
        var editedDueDate = $('#editedDueDate').val();

       
        $.ajax({
            type: 'POST',
            url: 'edit_task.php',
            data: {
                id: taskId,
                edited_title: editedTitle,
                edited_description: editedDescription,
                edited_due_date: editedDueDate
            },
            success: function(response) {
                alert(response); 
                $('#editTaskModal').modal('hide'); 
                fetchAndDisplayTasks(); 
            },
            error: function() {
                alert('An error occurred while editing the task.');
            }
        });
    });
}
function sortTasks(sortOption) {
    var taskList = $('#task-list');
    var taskItems = taskList.children('.task-item').toArray();

    taskItems.sort(function (a, b) {
        var valueA, valueB;

        switch (sortOption) {
            case 'title':
                valueA = $(a).find('.task-title').text().toLowerCase();
                valueB = $(b).find('.task-title').text().toLowerCase();
                break;
            case 'due_date':
                valueA = $(a).find('.task-due-date').text();
                valueB = $(b).find('.task-due-date').text();
                break;
            case 'status':
                valueA = $(a).find('.task-status').text().toLowerCase();
                valueB = $(b).find('.task-status').text().toLowerCase();
                break;
            default:
                valueA = '';
                valueB = '';
                break;
        }

        if (valueA < valueB) {
            return -1;
        } else if (valueA > valueB) {
            return 1;
        }
        return 0;
    });

    taskList.empty();

    for (var i = 0; i < taskItems.length; i++) {
        taskList.append(taskItems[i]);
    }
}

