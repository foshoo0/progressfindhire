<?php require_once '../core/models.php'; ?>
<?php require_once '../core/dbconfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<h1>Are you sure you want to delete this barber?</h1>
	<?php $getBarberByID = getBarberByID($pdo, $_GET['barber_id']); ?>
	<div class="container" style="border-style: solid; width: 50%; height: 300px; margin-top: 20px;">
		<h2>FirstName: <?php echo $getBarberByID['fname']; ?></h2>
		<h2>LastName: <?php echo $getBarberByID['lname']; ?></h2>
		<h2>Date Of Birth: <?php echo $getBarberByID['role_duty']; ?></h2>
		<h2>Specialization: <?php echo $getBarberByID['contact_number']; ?></h2>
		<h2>Date & Time Added: <?php echo $getBarberByID['time_joined']; ?></h2>

		<div class="deleteBtn" style="float: left; margin-right: 10px;">
			<form action="../core/handleforms.php?barber_id=<?php echo $_GET['barber_id']; ?>" method="POST">
				<input type="submit" name="deleteBarberBtn" value="Delete">
			</form>			
		</div>	

	</div>
</body>
</html>
