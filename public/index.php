<?php
require_once('../private/initialize.php');
include 'partials/header.php';
include 'partials/navbar.php';
?>

<div class="container">
    <div class="jumbotron mt-5">
        <h1 class="display-4">Welcome to Task Manager!</h1>
        <p class="lead">This is a simple task management application built with PHP.</p>
        <hr class="my-4">
        <?php
        if ($session->is_logged_in()) {
        ?>
            <p>Get started by managing your tasks easily.</p>
            <a class="btn btn-primary btn-lg" href="<?= url_for('tasks') ?>" role="button">Tasks list</a>
        <?php
        } else {
        ?>
            <p>Get started by registering or logging in, and manage your tasks easily.</p>
            <a class="btn btn-primary btn-lg" href="<?= url_for('login.php') ?>" role="button">Login/Register</a>
        <?php
        }
        ?>

    </div>
</div>
<?php include 'partials/footer.php'; ?>