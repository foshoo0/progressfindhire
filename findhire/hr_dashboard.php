<?php
require_once 'dbconfig.php'; 
require_once 'models.php'; 

// Fetch all job posts
$getAllJobPost = getAllJobPost($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard</title>
</head>
<body>

<h1>HR Dashboard</h1>

<h2>Your Job Posts</h2>
<form action="handleforms.php" method="POST">
    <p>
        <label for="title">Job Title</label> 
        <input type="text" name="title">
    </p>
    <p>
        <label for="description">Description</label> 
        <input type="text" name="description">
    </p>
    <p>
        <label for="requirements">Requirements</label> 
        <input type="text" name="requirements">
    </p>
    <p>
        <label for="deadline">Deadline</label> 
        <input type="date" name="deadline">
        <input type="submit" name="insertJobPostBtn" value="Create Job Post">
    </p>
</form>

<?php foreach ($getAllJobPost as $row) { ?>
    <div class="container" style="border-style: solid; width: 50%; height: 300px; margin-top: 20px;">
        <h3>Job Title: <?php echo $row['title']; ?></h3>
        <h3>Description: <?php echo $row['description']; ?></h3>
        <h3>Requirements: <?php echo $row['requirements']; ?></h3>
        <h3>Deadline: <?php echo $row['deadline']; ?></h3>

        <div class="editAndDelete" style="float: right; margin-right: 20px;">
            <a href="editjobpost.php?id=<?php echo $row['id']; ?>" style="display: block; margin-bottom: 10px;">Edit</a>
        </div>
    </div>
<?php } ?>

<a href="logout.php">Logout</a>

</body>
</html>
