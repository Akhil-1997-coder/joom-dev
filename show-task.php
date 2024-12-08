<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$sno = 1;

if (isset($_GET['download_csv'])) {
    $filename = "task_list_" . date('Y-m-d') . ".csv";

    $sql = "SELECT task_id, start_time, stop_time, notes, description FROM tasks";
    $result = mysqli_query($conn, $sql);

    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=$filename");

    $output = fopen('php://output', 'w');

    fputcsv($output, ['S.No', 'Start Time', 'Stop Time', 'Notes', 'Description']);

    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [
            $sno++,
            $row['start_time'],
            $row['stop_time'],
            $row['notes'],
            $row['description']
        ]);
    }

    fclose($output);
    exit();
}

$sql = "SELECT task_id, start_time, stop_time, notes, description FROM tasks";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Task List</h2>

    <div class="text-end mb-3">
        <a href="?download_csv=true" class="btn btn-success">Download CSV</a>
    </div>


    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>S.No</th>
                    <th>Start Time</th>
                    <th>Stop Time</th>
                    <th>Notes</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $sno++; ?></td>
                            <td><?php echo $row['start_time']; ?></td>
                            <td><?php echo $row['stop_time']; ?></td>
                            <td><?php echo $row['notes']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No tasks found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
