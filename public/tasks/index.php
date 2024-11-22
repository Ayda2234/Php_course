<?php
require_once('../../private/initialize.php');
include '../partials/header.php';
include '../partials/navbar.php';

require_login();
if (is_get_request() && isset($_GET['delete'])) {
    $task = Task::find_by_id($_GET['delete']);

    if ($task) {
        $task->delete();
        // TODO: show message
        redirect_to('index.php');
    } else {
        //TODO: Show error message
    }
}
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between mb-5">
        <h2>Your Tasks</h2>
        <a href="form.php" class="btn btn-primary">Add New Task</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Task</th>
                <th>Assigned User</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            Task::set_database($database);
            $tasks =  Task::find_all();
            foreach ($tasks as $task) {
            ?>
                <tr>
                    <td><?= $task->id ?></td>
                    <td><?= $task->name ?></td>
                    <td><?= $task->user ?? '' ?></td>
                    <td><?= $task->priority ?? '' ?></td>
                    <td><?= $task->status ?? '' ?></td>
                    <td><?= $task->due_date ?? '' ?></td>
                    <td><?= $task->created_at ?></td>
                    <td>
                        <a href="view.php?id=<?php echo $task->id; ?>" class="btn btn-primary btn-sm">View</a>
                        <a href="form.php?edit=<?php echo $task->id; ?>" class="btn btn-secondary btn-sm">Edit</a>
                        <a href="index.php?delete=<?php echo $task->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<?php include '../partials/footer.php'; ?>