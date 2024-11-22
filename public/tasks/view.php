<?php
$pageTitle = "View Task";
require_once('../../private/initialize.php');
include '../partials/header.php';
include '../partials/navbar.php';

require_login();


// Get the task ID from the query string
$taskId = $_GET['id'] ?? null;

if ($taskId) {
    Task::set_database($database);
    $task = Task::find_by_id($taskId);

    if ($task->user_id) {
        $sql = "SELECT name FROM users where id = " . $task->user_id;
        $result = $database->query($sql);

        $user = $result->fetch_object();
    }

    if (!$task) {
        echo "<p class='alert alert-danger'>Task not found.</p>";
    }
} else {
    echo "<p class='alert alert-danger'>No task ID provided.</p>";
}
?>

<div class="container mt-5">
    <?php if (isset($task)) : ?>
        <h2 class="mb-4">Task: <?php echo htmlspecialchars($task->name); ?></h2>

        <table class="table table-bordered">
            <tr>
                <th>Task Name</th>
                <td><?php echo htmlspecialchars($task->name); ?></td>
            </tr>
            <tr>
                <th>Description</th>
                <td><?php echo htmlspecialchars($task->description ?? ''); ?></td>
            </tr>
            <tr>
                <th>Assigned User</th>
                <td><?php echo isset($user) ? htmlspecialchars($user->name ?? '') : ''; ?></td>
            </tr>
            <tr>
                <th>Priority</th>
                <td><?php echo htmlspecialchars($task->priority ?? ''); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo htmlspecialchars($task->status ?? ''); ?></td>
            </tr>
            <tr>
                <th>Due Date</th>
                <td><?php echo htmlspecialchars($task->due_date ?? ''); ?></td>
            </tr>
            <tr>
                <th>Created At</th>
                <td><?php echo htmlspecialchars($task->created_at ?? ''); ?></td>
            </tr>
        </table>

        <a href="index.php" class="btn btn-primary">Back to Task List</a>
        <a href="form.php?edit=<?php echo $taskId; ?>" class="btn btn-secondary">Edit Task</a>
        <a href="index.php?delete=<?php echo $task->id; ?>" class="btn btn-danger " onclick="return confirm('Are you sure?')">Delete Task</a>
    <?php endif; ?>
</div>

<?php include '../partials/footer.php'; ?>