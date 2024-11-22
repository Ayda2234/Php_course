<?php
require_once('../private/initialize.php');
include 'partials/header.php';

if (is_post_request()) {
    $user = new User($_POST['user']);
    try {
        if ($user->save()) {
            redirect_to(url_for('login.php'));
        }
    } catch (Exception $e) {
        $user->errors[] = $e->getMessage();
    }
}
?>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h2 class="text-center">Register</h2>
            <?php echo isset($user?->errors) ? display_errors($user->errors) : '' ?>
            <form action="register.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="user[name]" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="user[username]" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="user[password]" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="user[confirm_password]" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <div class="text-center mt-3">
                <p>Do you have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>
</div>
<?php include 'partials/footer.php'; ?>