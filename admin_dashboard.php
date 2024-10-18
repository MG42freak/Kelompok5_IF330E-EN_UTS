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
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo $row['max_participants']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo isset($registrants[$row['id']]) ? $registrants[$row['id']] : 0; ?></td>
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