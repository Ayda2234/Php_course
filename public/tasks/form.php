<?php
require_once('../../private/initialize.php');
include '../partials/header.php';
include '../partials/navbar.php';

require_login();

Task::set_database($database);
if (is_post_request()) {
    if (!$_POST['edit']) {
        if (isset($_POST['edit']));
        $task = new Task($_POST);
        $result = $task->save();
        if ($result) {
            redirect_to('view.php?id=' . $task->id);
        } else {
            // TODO: show error message
        }
    } else {
        $task = Task::find_by_id($_POST['edit']);
        if (!$task) {
            // TODO: show error
            exi('task not found');
        } else {
            $task->merge_attributes($_POST);

            $result = $task->save();
            if ($result) {
                // TODO: show success message
                redirect_to(url_for('/tasks/view.php?id=' . $task->id));
            } else {
                //TODO: show error message
            }
        }
    }
}

$is_editing_mode = isset($_GET['edit']) && !empty($_GET['edit']);
if ($is_editing_mode) {
    $task = Task::find_by_id($_GET['edit']);
    if (!$task) {
        exit('Task not found');
    }

    if ($task->user_id) {
        $sql = "SELECT id,name FROM users where id = " . $task->user_id;
        $result = $database->query($sql);
        $task_user = $result->fetch_object();
    }
}

$users_query = $database->query("SELECT id,name from users");
?>
<div class="container mt-5">
    <h2>Add/Edit Task</h2>
    <?php echo isset($task) ? display_errors($task->errors) : '' ?>
    <form action="form.php" method="POST">
        <input type="hidden" name="edit" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : false ?>" />
        <div class="mb-3">
            <label for="name" class="form-label">Task Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $is_editing_mode ? $task->name : '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Task Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" value="<?= $is_editing_mode ? $task->description : '' ?>"></textarea>
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">Assigned User</label>
            <select class="form-select" id="user_id" name="user_id">
                <option></option>
                <?php
                while ($user = $users_query->fetch_object()) {
                    $selected = ($is_editing_mode) ? ($task_user->id == $user->id ? 'selected' : '') : '';
                    echo '<option value="' . $user->id . '" ' . $selected  . '>' . $user->name . ' </option>';
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select class="form-select" id="priority" name="priority" required>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="due_date" name="due_date">
        </div>
        <button type="submit" class="btn btn-success">Save Task</button>
    </form>
</div>
<?php include '../partials/footer.php'; ?>