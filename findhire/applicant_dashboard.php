<?php
session_start();

// Check if the user is logged in and has the Applicant role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Applicant') {
    echo "Access Denied. You are not authorized to view this page.";
    exit;
}

// Include database connection (example connection)
include 'db_connection.php';

// Fetch all job posts available for application
$query = "SELECT * FROM job_posts";
$result = $conn->query($query);

// Fetch applicant's applications
$application_query = "SELECT * FROM applications WHERE applicant_id = ?";
$stmt = $conn->prepare($application_query);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$applications_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard</title>
    <!-- Add your CSS file or use a framework like Bootstrap -->
</head>
<body>

<h1>Applicant Dashboard</h1>

<h2>Available Job Posts</h2>
<table>
    <tr>
        <th>Job Title</th>
        <th>Description</th>
        <th>Apply</th>
    </tr>

    <?php while ($job_post = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($job_post['title']); ?></td>
            <td><?php echo htmlspecialchars($job_post['description']); ?></td>
            <td><a href="apply_for_job.php?job_id=<?php echo $job_post['id']; ?>">Apply</a></td>
        </tr>
    <?php endwhile; ?>
</table>

<h2>Your Applications</h2>
<table>
    <tr>
        <th>Job Title</th>
        <th>Status</th>
    </tr>

    <?php while ($application = $applications_result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($application['job_post_id']); ?></td>
            <td><?php echo htmlspecialchars($application['status']); ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<h2>Send Message to HR</h2>
<form method="POST" action="send_message.php">
    <textarea name="message" placeholder="Write your message to HR"></textarea>
    <button type="submit">Send Message</button>
</form>

<a href="logout.php">Logout</a>

</body>
</html>
