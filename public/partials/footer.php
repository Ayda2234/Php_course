<footer class="bg-light text-center text-lg-start mt-auto">
  <div class="container p-4">
    <div class="row">
      <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
        <h5 class="text-uppercase">About Task Manager</h5>
        <p>
          Task Manager is a simple web application built to help you manage and track your daily tasks. Built using PHP and Bootstrap 5.
        </p>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase">Quick Links</h5>
        <ul class="list-unstyled mb-0">
          <li>
            <a href="<?= url_for('index.php') ?>" class="text-dark">Home</a>
          </li>
          <li>
            <a href="<?= url_for('tasks') ?>" class="text-dark">Tasks</a>
          </li>
          <li>
            <a href="<?= url_for('login.php') ?>" class="text-dark">Login/Register</a>
          </li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase">Contact</h5>
        <ul class="list-unstyled">
          <li>
            <a href="mailto:info@taskmanager.com" class="text-dark">info@taskmanager.com</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="text-center p-3 bg-dark text-white">
    © <?php echo date("Y"); ?> Task Manager. All rights reserved.
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
db_disconnect($database);
