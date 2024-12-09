<?php require_once '../core/handleforms.php'; ?>
<?php require_once '../core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<?php $getBarberByID = getBarberByID($pdo, $_GET['barber_id']); ?>
	<h1>Edit the Barber!</h1>
	<form action="../core/handleforms.php?barber_id=<?php echo $_GET['barber_id']; ?>" method="POST">
		<p>
			<label for="firstName">First Name</label> 
			<input type="text" name="fname" value="<?php echo $getBarberByID['fname']; ?>">
		</p>
		<p>
			<label for="LastName">Last Name</label> 
			<input type="text" name="lname" value="<?php echo $getBarberByID['lname']; ?>">
		</p>
		<p>
			<label for="Role">Role</label> 
			<input type="text" name="role_duty" value="<?php echo $getBarberByID['role_duty']; ?>">
		</p>
		<p>
			<label for="Contact Number">Contact Number</label> 
			<input type="text" name="contact_number" value="<?php echo $getBarberByID['contact_number']; ?>">
			<input type="submit" name="EditBarberBtn">
		</p>
	</form>
</body>
</html>
