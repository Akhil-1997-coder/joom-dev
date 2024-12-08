<?php
session_start();
include 'includes/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$sno =1;

if (isset($_GET['download_csv'])) {
    $filename = "user_list_" . date('Y-m-d') . ".csv";

    $sql = "SELECT id, first_name, last_name, email, is_admin FROM users";
    $result = mysqli_query($conn, $sql);

 
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=$filename");

    $output = fopen('php://output', 'w');

    fputcsv($output, ['S.No', 'First Name', 'Last Name', 'Email', 'Role']);

    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [
           $sno++,
            $row['first_name'],
            $row['last_name'],
            $row['email'],
            $row['is_admin'] == 0 ? 'Admin' : 'User'
        ]);
    }

    fclose($output);
    exit();
}

$sql = "SELECT id, first_name, last_name, email, is_admin FROM users";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">User List</h2>

    <div class="text-end mb-3">
        <a href="?download_csv=true" class="btn btn-success">Download CSV</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>S.No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $sno++; ?></td>
                            <td><?php echo $row['first_name']; ?></td>
                            <td><?php echo $row['last_name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['is_admin'] == 0 ? 'Admin' : 'User'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No users found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
