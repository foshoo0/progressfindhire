<?php 
require_once 'handleforms.php';
require_once 'models.php';

// Check if the 'id' parameter is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the job post details by ID
    $getJobPostByID = getJobPostById($pdo, $id); // Assuming this function exists in models.php

    // Check if the job post exists
    if (!$getJobPostByID) {
        header("Location: hr_dashboard.php?error=JobPostNotFound");
        exit;
    }
} else {
    header("Location: hr_dashboard.php?error=InvalidJobPostIDs");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job Post</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Edit Your Job Post!</h1>
    <form action="handleforms.php" method="POST">
        <!-- Include a hidden input to pass the job post ID -->
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($getJobPostByID['id']); ?>">

        <p>
            <label for="title">Job Title</label> 
            <input type="text" name="title" value="<?php echo htmlspecialchars($getJobPostByID['title'] ?? ''); ?>">
        </p>
        <p>
            <label for="description">Description</label> 
            <input type="text" name="description" value="<?php echo htmlspecialchars($getJobPostByID['description'] ?? ''); ?>">
        </p>
        <p>
            <label for="requirements">Requirements</label> 
            <input type="text" name="requirements" value="<?php echo htmlspecialchars($getJobPostByID['requirements'] ?? ''); ?>">
        </p>
        <p>
            <label for="deadline">Deadline</label> 
            <input type="date" name="deadline" value="<?php echo htmlspecialchars($getJobPostByID['deadline'] ?? ''); ?>">
        </p>
        <p>
            <button type="submit" name="EditJobPostBtn">Update Job Post</button>
        </p>
    </form>
</body>
</html>
