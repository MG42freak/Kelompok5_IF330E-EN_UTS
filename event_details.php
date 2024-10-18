<?php
// event_details.php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = db_connect();

if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']);
    $sql = "SELECT * FROM events WHERE id = $event_id AND status = 'open'";
    $result = $conn->query($sql);
    $event = $result->fetch_assoc();

    // Check if user is already registered
    $user_id = $_SESSION['user_id'];
    $sql_check = "SELECT * FROM registrations WHERE user_id = $user_id AND event_id = $event_id";
    $result_check = $conn->query($sql_check);
    $is_registered = $result_check->num_rows > 0;
} else {
    header("Location: user_dashboard.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4"><?php echo htmlspecialchars($event['name']); ?></h1>
        <p><strong>Date:</strong> <?php echo $event['date']; ?></p>
        <p><strong>Time:</strong> <?php echo $event['time']; ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($event['description']); ?></p>

        <?php if ($event['image_url']): ?>
            <div class="mb-4">
                <img src="<?php echo htmlspecialchars($event['image_url']); ?>" alt="Event Image" class="img-fluid">
            </div>
        <?php endif; ?>

        <?php if (!$is_registered): ?>
            <form action="register_event.php" method="post">
                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                <button type="submit" class="btn btn-primary">Register for Event</button>
            </form>
        <?php else: ?>
            <p class="text-success">You are already registered for this event.</p>
            <form action="cancel_registration.php" method="post">
                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel your registration?');">Cancel Registration</button>
            </form>
        <?php endif; ?>

        <p class="mt-3"><a href="user_dashboard.php" class="btn btn-secondary">Back to Dashboard</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
