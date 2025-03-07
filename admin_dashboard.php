<?php
// admin_dashboard.php
session_start();
require_once 'config.php';
require_once 'functions.php';

// Check if user is admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

$conn = db_connect();

// Fetch available events
$sql = "SELECT id, name, date, time, location, max_participants, status FROM events";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching events: " . $conn->error);
}

// Fetch number of registrants per event
$sql_registrants = "SELECT event_id, COUNT(*) as count FROM registrations GROUP BY event_id";
$result_registrants = $conn->query($sql_registrants);

if (!$result_registrants) {
    die("Error fetching registrants: " . $conn->error);
}

$registrants = array();
while ($row = $result_registrants->fetch_assoc()) {
    $registrants[$row['event_id']] = $row['count'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Admin Dashboard</h1>
        <h2>Available Events</h2>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Max Participants</th>
                    <th>Status</th>
                    <th>Registrants</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['time']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo htmlspecialchars($row['max_participants']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo isset($registrants[$row['id']]) ? htmlspecialchars($registrants[$row['id']]) : 0; ?></td>
                    <td>
                        <a href="edit_event.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_event.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                        <a href="view_registrants.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View Registrants</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <p>
            <a href="create_event.php" class="btn btn-primary">Create New Event</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>