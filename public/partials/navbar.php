<link href="css/styles.css" rel="stylesheet"> <!-- Link to your CSS -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= url_for('index.php') ?>">Task Manager</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= url_for('index.php') ?>">Home</a>
                </li>
                <?php
                if ($session->is_logged_in()) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url_for('tasks') ?>">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url_for('logout.php') ?>">Logout</a>
                    </li>
                <?php
                } else {
                ?>
                    <a class="nav-link" href="<?= url_for('login.php') ?>">Login/Register</a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>