<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($event['name']); ?></h1>
    <p>Date: <?php echo $event['date']; ?></p>
    <p>Time: <?php echo $event['time']; ?></p>
    <p>Location: <?php echo htmlspecialchars($event['location']); ?></p>
    <p>Description: <?php echo htmlspecialchars($event['description']); ?></p>
    <?php if ($event['image_url']): ?>
        <img src="<?php echo htmlspecialchars($event['image_url']); ?>" alt="Event Image">
    <?php endif; ?>
    <?php if (!$is_registered): ?>
        <form action="register_event.php" method="post">
            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
            <input type="submit" value="Register for Event">
        </form>
    <?php else: ?>
        <p>You are already registered for this event.</p>
        <form action="cancel_registration.php" method="post">
            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
            <input type="submit" value="Cancel Registration" onclick="return confirm('Are you sure you want to cancel your registration?');">
        </form>
    <?php endif; ?>
    <p><a href="user_dashboard.php">Back to Dashboard</a></p>
</body>
</html>