<?php 
session_start();
require_once 'dbconfig.php'; 
require_once 'models.php';

// Retrieve the current user's ID from the session
if (isset($_SESSION['username'])) {
	// Safe to access $_SESSION['username']
	$currentUserID = getUserIDByUsername($pdo, $_SESSION['username']);
}

//BUTTON TO INSERT BARBER
if (isset($_POST['insertBarberBtn'])) {

	//Here we used the currendUserID to record who created that record
	$query = insertBarber($pdo, $_POST['fname'], $_POST['lname'], 
		$_POST['role_duty'], $_POST['contact_number'], $currentUserID);

	if ($query) {
		//REDIRECT TO THE SAME LOCATION
		header("Location: ../index.php");
	}
	else {
		echo "Insertion failed";
	}

}
//BUTTON TO UPDATE BARBER
if (isset($_POST['EditBarberBtn'])) {
	//We use again here the currentUserID to get know who edited the record based on the current user that logged in
	$query = updateBarber($pdo, $_POST['fname'], $_POST['lname'], 
		$_POST['role_duty'], $_POST['contact_number'], $currentUserID, $_GET['barber_id']);

	if ($query) {
		//REDIRECT TO THE SAME LOCATION
		header("Location: ../index.php");
	}

	else {
		echo "Edit failed";;
	}

}
//BUTTON TO DELETE A BARBER AND ITS RECORD ALL IN ONE
if (isset($_POST['deleteBarberBtn'])) {
	$query = deleteBarber($pdo, $_GET['barber_id']);

	if ($query) {
		//ONCE DELETED THE LOCATION WILL HEAD BACK TO THE INDEX FILE
		header("Location: ../index.php");
	}

	else {
		echo "Deletion failed";
	}
}

//BUTTON TO INSERT CUSTOMER
if (isset($_POST['insertCustomerBtn'])) {
	//Same on how we track who created the record in barbers table
	$query = insertCustomer($pdo, $_POST['cname'], $_POST['customer_type'], $_GET["barber_id"], $currentUserID);

	
	if ($query) {
		//SINCE CUSTOMER IS A NEW SET OF TABLE THIS WILL BRING US TO THIS LOCATION BASE ON barber_id
		header("Location: ../customers/customerlist.php?barber_id=" .$_GET['barber_id']);
	}
	else {
		echo "Insertion failed";
	}
}
//BUTTON TO UPDATE CUSTOMER
if (isset($_POST['editCustomerBtn'])) {
	//Since the customer_id here is essetial so the code know which customer to edit, we put the currentUserID function second to the last
	$query = updateCustomer($pdo, $_POST['cname'], $_POST['customer_type'], $currentUserID, $_GET['customer_id']);

	if ($query) {
		//SAME LOCATION IN INSERTING A CUSTOMER RECORD
		header("Location: ../customers/customerlist.php?barber_id=" .$_GET['barber_id']);
	}
	else {
		echo "Update failed";
	}

}
//BUTTON FOR DELETING A CUSTOMER
if (isset($_POST['deleteCustomerBtn'])) {
	$query = deleteCustomer($pdo, $_GET['customer_id']);

	if ($query) {
		//SAME LOCATION
		header("Location: ../customers/customerlist.php?barber_id=" .$_GET['barber_id']);
	}
	else {
		echo "Deletion failed";
	}
}

// BUTTON FOR REGISTER
if (isset($_POST['registerUserBtn'])) {
    $username = $_POST['username'];
	$password = sha1($_POST['password']); //HASHING PASSWORD

	if (!empty($username) && !empty($password)) { //THIS WILL NOT REQUIRED IF THE FIELD ARE EMPTY

		$insertQuery = insertNewUser($pdo, $username, $password); // VARIABLE USING FUNCTION TO INSERT A RECORD TO THE TABLE

		if ($insertQuery) {
			//ONCE REGUSTERED IT WILL GO BACK TO THE LOGIN PAGE
			header("Location: ../login.php");
		}
		else {
			//IF THE insertQuery RETURN FALSE IT WILL STAY ON THE SAME PAGE
			header("Location: ../register.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure the input fields 
		are not empty for registration!";

		header("Location: ../login.php");
	}

}


// BUTTON FOR LOGIN
if (isset($_POST['loginUserBtn'])) {
    $username = $_POST['username'];
    $password = sha1($_POST['password']); // HASHED THE PASSWORD

	if (!empty($username) && !empty($password)) { //REQUIRE THE FIELD TO BE FILLED UP

		$loginQuery = loginUser($pdo, $username, $password); // USING loginUser FUNCTION TO VERIFY THE INPUTS
	
		if ($loginQuery) {
			//IF THE loginQuery RETURN TRUE, THIS WILL PROCEED TO THE INDEX FILE PAGE
			header("Location: ../index.php");
		}
		else {
			//IF THE loginQuery RETURN FALSE, THE WILL STAY IN THE LOGIN PAGE FILE
			header("Location: ../login.php");
		}

	}

	else {
		$_SESSION['message'] = "Please make sure the input fields 
		are not empty for the login!";
		header("Location: ../login.php");
	}
 
}
// FOR LOGOUT
if (isset($_GET['logoutAUser'])) {
    unset($_SESSION['username']); //terminate the session
    header('Location: ../login.php');
}


?>