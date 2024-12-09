<?php 
require_once '../core/models.php'; 
require_once '../core/dbconfig.php'; 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
	<style>
		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 50px;
		}

		th, td {
			border: 1px solid black;
			padding: 8px;
			text-align: left;
		}

		th {
			background-color: #f2f2f2;
		}

		td a {
			margin-right: 10px;
			color: blue;
			text-decoration: none;
		}

		td a:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<a href="../index.php">Return to home</a>
	
	<form action="../core/handleforms.php?barber_id=<?php echo $_GET['barber_id']; ?>" method="POST">
		<p>
			<label for="firstName">Customer Name</label> 
			<input type="text" name="cname">
		</p>
		<p>
			<label for="firstName">Customer Type</label> 
			<input type="text" name="customer_type">
			<input type="submit" name="insertCustomerBtn" value="Add Customer">
		</p>
	</form>

	<table>
	  <tr>
	    <th>Customer ID</th>
	    <th>Customer Name</th>
	    <th>Customer Type</th>
	    <th>Stylist</th>
	    <th>Date Added</th>
	    <th>Actions</th>
	  </tr>
	  <?php $getCustomersByBarber = getCustomersByBarber($pdo, $_GET['barber_id']); ?>
	  <?php foreach ($getCustomersByBarber as $row) { ?>
	  <tr>
	  	<td><?php echo $row['customer_id']; ?></td>	  	
	  	<td><?php echo $row['cname']; ?></td>	  	
	  	<td><?php echo $row['customer_type']; ?></td>	  	
	  	<td><?php echo $row['stylist']; ?></td>	  	
	  	<td><?php echo $row['time_joined']; ?></td>
	  	<td>
	  		<a href="editcustomer.php?customer_id=<?php echo $row['customer_id']; ?>&barber_id=<?php echo $_GET['barber_id']; ?>">Edit</a>
	  		<a href="deletecustomer.php?customer_id=<?php echo $row['customer_id']; ?>&barber_id=<?php echo $_GET['barber_id']; ?>">Delete</a>
	  	</td>	  	
	  </tr>
	  <?php } ?>
	</table>
</body>
</html>
