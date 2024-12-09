<?php 
session_start();
require_once 'dbconfig.php'; 
require_once 'models.php';

if (isset($_SESSION['username'])) {
	// Safe to access $_SESSION['username']
	$currentUserID = getUserIDByUsername($pdo, $_SESSION['username']);
}

if (isset($_POST['insertJobPostBtn'])) {

	//Here we used the currendUserID to record who created that record
	$query = insertJobPost($pdo, $_POST['title'], $_POST['description'], 
		$_POST['requirements'], $_POST['deadline']);

	if ($query) {
		//REDIRECT TO THE SAME LOCATION
		header("Location: hr_dashboard.php");
	}
	else {
		echo "Insertion failed";
	}

}

if (isset($_POST['EditJobPostBtn'])) {
	// Retrieve 'id' from POST data
    $id = $_POST['id'];
	//We use again here the currentUserID to get know who edited the record based on the current user that logged in
	$query = updateJobPost($pdo, $_POST['title'], $_POST['description'], 
		$_POST['requirements'], $_POST['deadline'], $id);

	if ($query) {
		//REDIRECT TO THE SAME LOCATION
		header("Location: hr_dashboard.php");
	}

	else {
		echo "Edit failed";;
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

?>