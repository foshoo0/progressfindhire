<?php require_once '../core/models.php'; ?>
<?php require_once '../core/dbconfig.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
		body {
			color: black; /* Ensure all text is black */
			font-family: Arial, sans-serif;
		}
		h1, h2 {
			color: black; /* Set header text to black */
		}
		.container {
			border: 2px solid black; /* Black border for the container */
			width: 50%;
			height: 300px;
			margin-top: 20px;
			padding: 10px;
		}
		/* Link styling */
		a {
			color: black; /* Unvisited and visited link color */
			text-decoration: none; /* Remove underline */
		}
		a:hover {
			text-decoration: none; /* No underline on hover */
		}
		.deleteBtn input {
			background-color: white; /* Default button background */
			border: 2px solid black; /* Black border for the button */
			color: black; /* Black text on the button */
			padding: 5px 10px;
			cursor: pointer;
		}
		.deleteBtn input:hover {
			background-color: black; /* Hover effect: black background */
			color: white; /* White text when hovered */
		}
	</style>
</head>
<body>
    <a href="customerlist.php?barber_id=<?php echo $_GET['barber_id']; ?>">
	<h1>Are you sure you want to delete this customer?</h1>
    <?php $getCustomerByID = getCustomerByID($pdo, $_GET['customer_id']); ?>
	<div class="container" style="border-style: solid; width: 50%; height: 300px; margin-top: 20px;">
		<h2>Customer Name: <?php echo $getCustomerByID['cname'] ?></h2>
		<h2>Customer Type: <?php echo $getCustomerByID['customer_type'] ?></h2>
		<h2>Date Added: <?php echo $getCustomerByID['time_joined'] ?></h2>

		<div class="deleteBtn" style="float: left; margin-right: 10px;">
			<form action="../core/handleforms.php?customer_id=<?php echo $_GET['customer_id']; ?>&barber_id=<?php echo $_GET['barber_id']; ?>" method="POST">
				<input type="submit" name="deleteCustomerBtn" value="Delete">
			</form>			
			
		</div>	

	</div>
</body>
</html>
