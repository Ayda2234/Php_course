<?php
require_once('../private/initialize.php');
include 'partials/header.php';
$errors = [];
if (is_post_request()) {
    if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
        $user = User::find_by_username($_POST['username']);
        if (!$user) {
            $session->message("Username not found");
        } else {
            $password_verified = password_verify($_POST['password'], $user->password);
            if ($password_verified) {
                $session->login($user);
                redirect_to(url_for('tasks'));
            } else {
                $session->message("Password incorrect!");
            }
        }
    } else {
        $session->message("Username and Password should not be empty!");
    }
}
?>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h2 class="text-center">Login</h2>
            <?php echo !empty($errors) ? display_errors($errors) : '' ?>
            <?php echo display_session_message() ?>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <div class="text-center mt-3">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </div>
</div>
<?php include 'partials/footer.php'; ?>