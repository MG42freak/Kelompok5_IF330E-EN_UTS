<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <h2>Available Events</h2>
    <table border="1">
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
                <a href="edit_event.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete_event.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                <a href="view_registrants.php?id=<?php echo $row['id']; ?>">View Registrants</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <p><a href="create_event.php">Create New Event</a></p>
    <p><a href="user_management.php">User Management</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>