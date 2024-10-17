<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Event</title>
</head>
<body>
    <h1>Create New Event</h1>
    <form action="create_event_bg.php" method="post" enctype="multipart/form-data">
        <label for="name">Event Name:</label>
        <input type="text" id="name" name="name" required><br>
        
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br>
        
        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required><br>
        
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required><br>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>
        
        <label for="max_participants">Maximum Participants:</label>
        <input type="number" id="max_participants" name="max_participants" required><br>
        
        <label for="image">Event Image:</label>
        <input type="file" id="image" name="image"><br>
        
        <input type="submit" value="Create Event">
    </form>
    <p><a href="admin_dashboard.php">Back to Dashboard</a></p>
</body>
</html>