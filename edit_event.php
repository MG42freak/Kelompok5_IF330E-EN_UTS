<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
</head>
<body>
    <h1>Edit Event</h1>
    <form action="edit_event_bg.php" method="post">
        <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
        
        <label for="name">Event Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($event['name']); ?>" required><br>
        
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $event['date']; ?>" required><br>
        
        <label for="time">Time:</label>
        <input type="time" id="time" name="time" value="<?php echo $event['time']; ?>" required><br>
        
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required><br>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($event['description']); ?></textarea><br>
        
        <label for="max_participants">Maximum Participants:</label>
        <input type="number" id="max_participants" name="max_participants" value="<?php echo $event['max_participants']; ?>" required><br>
        
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="open" <?php echo $event['status'] == 'open' ? 'selected' : ''; ?>>Open</option>
            <option value="closed" <?php echo $event['status'] == 'closed' ? 'selected' : ''; ?>>Closed</option>
            <option value="canceled" <?php echo $event['status'] == 'canceled' ? 'selected' : ''; ?>>Canceled</option>
        </select><br>
        
        <input type="submit" value="Update Event">
    </form>
    <p><a href="admin_dashboard.php">Back to Dashboard</a></p>
</body>
</html>
