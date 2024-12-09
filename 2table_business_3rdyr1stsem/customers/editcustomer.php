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
	<a href="customerlist.php?barber_id=<?php echo $_GET['barber_id']; ?>">
	View The Customers</a>
	<h1>Edit the customer!</h1>
	<?php $getCustomerByID = getCustomerByID($pdo, $_GET['customer_id']); ?>
	<form action="../core/handleforms.php?customer_id=<?php echo $_GET['customer_id']; ?>
	&barber_id=<?php echo $_GET['barber_id']; ?>" method="POST">
		<p>
			<label for="firstName">Customer Name</label> 
			<input type="text" name="cname" 
			value="<?php echo $getCustomerByID['cname']; ?>">
		</p>
		<p>
			<label for="ctype">Customer Type</label> 
			<input type="text" name="customer_type" 
			value="<?php echo $getCustomerByID['customer_type']; ?>">
			<input type="submit" name="editCustomerBtn">
		</p>
	</form>
</body>
</html>