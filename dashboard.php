<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location:index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id LIMIT 1";
$sql_query = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($sql_query);

if (!$user) {
    echo "User not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Dashboard</h3>
        <?php
        if($_SESSION['user_id'] && $user['is_admin']==0)
        {
            ?>
            <a href="user-list.php">User-list</a>
            <a href="show-task.php">Show Task</a>
      <?php
        }
      ?>
     
        <a href="logout.php">Logout</a>
    </div>
<?php if ($user['is_admin'] == 0 && $_SESSION['user_id']): ?>
    <!-- Admin Content: Create User -->
    <form class="kio" method="POST" action="backend/submit_form.php">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first-name" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last-name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                <span class="input-group-text">
                    <i id="toggle-password" class="fa fa-eye" onclick="togglePasswordVisibility()"></i>
                </span>
            </div>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="generate-password" name="auto-generate" onclick="togglePasswordField()">
            <label class="form-check-label" for="auto_generate">Auto-generate strong password</label>
        </div>
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
<?php else: ?>
    <!-- User Content: Submit Tasks -->
    <div class="container mt-5">
    <h2 class="text-center mb-4">Submit Tasks</h2>
    <form method="POST" action="backend/submit_task.php">
        <div class="task-item">
            <h5>Task 1</h5>
            <div class="mb-3">
                <label for="start_time_1" class="form-label">Start Time</label>
                <input type="datetime-local" class="form-control" id="start_time_1" name="start_time_1" required>
            </div>
            <div class="mb-3">
                <label for="stop_time_1" class="form-label">Stop Time</label>
                <input type="datetime-local" class="form-control" id="stop_time_1" name="stop_time_1" required>
            </div>
            <div class="mb-3">
                <label for="notes_1" class="form-label">Notes</label>
                <textarea class="form-control" id="notes_1" name="notes_1" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit Tasks</button>
    </form>
</div>

    </div>
<?php endif; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/main.js"></script>
</body>
</html>
