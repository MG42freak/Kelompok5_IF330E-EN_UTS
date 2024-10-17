<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Event</h1>
        <form action="edit_event_bg.php" method="post">
            <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
            
            <div class="mb-3">
                <label for="name" class="form-label">Event Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($event['name']); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="date" class="form-label">Date:</label>
                <input type="date" id="date" name="date" class="form-control" value="<?php echo $event['date']; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="time" class="form-label">Time:</label>
                <input type="time" id="time" name="time" class="form-control" value="<?php echo $event['time']; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="location" class="form-label">Location:</label>
                <input type="text" id="location" name="location" class="form-control" value="<?php echo htmlspecialchars($event['location']); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($event['description']); ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="max_participants" class="form-label">Maximum Participants:</label>
                <input type="number" id="max_participants" name="max_participants" class="form-control" value="<?php echo $event['max_participants']; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select id="status" name="status" class="form-select">
                    <option value="open" <?php echo $event['status'] == 'open' ? 'selected' : ''; ?>>Open</option>
                    <option value="closed" <?php echo $event['status'] == 'closed' ? 'selected' : ''; ?>>Closed</option>
                    <option value="canceled" <?php echo $event['status'] == 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                </select>
            </div>
            
            <div class="mb-3">
                <input type="submit" value="Update Event" class="btn btn-primary">
            </div>
        </form>
        <p><a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a></p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
