<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registrants</title>
</head>
<body>
    <h1>View Registrants</h1>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Registration Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo $row['registration_date']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <p><a href="admin_dashboard.php">Back to Dashboard</a></p>
    <p><a href="export_registrants.php?id=<?php echo $event_id; ?>">Export to CSV</a></p>
</body>
</html>