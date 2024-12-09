<?php
require_once 'dbconfig.php';

//FUNCTION USED IN INSERTING A BARBER RECORD
function insertBarber($pdo, $fname, $lname, 
	$role_duty, $contact_number,$user_id) {

	$sql = "INSERT INTO barbers (fname, lname, 
    role_duty, contact_number, created_by) VALUES(?,?,?,?,?)"; //SQL CODE

	$stmt = $pdo->prepare($sql); //PREPARE EXECUTE CYCLE
	$executeQuery = $stmt->execute([$fname, $lname, 
    $role_duty, $contact_number, $user_id]);

	if ($executeQuery) {
		return true;
	}
}
//FUNCTION TO GET ALL THE BARBERS ALSO ITS RECORD, FOR US TO BE ABLE TO SHOW IT ON THE PAGE
function getAllBarbers($pdo) {
	$sql = "SELECT * FROM barbers";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}
//FUNCTION TO GET THE BARBERS ID BASED ON WHICH BARBER THE USER CHOOSE
function getBarberByID($pdo, $barber_id) {
	$sql = "SELECT * FROM barbers WHERE barber_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$barber_id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
} //FOR US TO BE ABLE TO MODIFY (E.G EDIT, DELETE)

//FUNCTION TO MODIFY THE RECORD OF THE BARBER, ALSO THE CURRENT TIME OF THE LAST UPDATE THAT HAS BEEN MADE
function updateBarber($pdo, $fname, $lname, 
	$role_duty, $contact_number, $barber_id, $user_id) {

	$sql = "UPDATE barbers
				SET fname = ?,
					lname = ?,
					role_duty = ?, 
					contact_number = ?,
					updated_by = ?,
					last_updated = CURRENT_TIMESTAMP
				WHERE barber_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$fname, $lname, 
		$role_duty, $contact_number, $barber_id, $user_id]);
	
	if ($executeQuery) {
		return true;
	}

}
//FUNCTION TO REMOVE THE BARBER FROM THE TABLE
function deleteBarber($pdo, $barber_id) {
	$deleteBarberCus = "DELETE FROM customers WHERE barber_id = ?";
	$deleteStmt = $pdo->prepare($deleteBarberCus);
	$executeDeleteQuery = $deleteStmt->execute([$barber_id]);

	if ($executeDeleteQuery) {
		$sql = "DELETE FROM barbers WHERE barber_id = ?";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$barber_id]);

		if ($executeQuery) {
			return true;
		}

	}
	
}
//FUNTION TO INSERT A CUSTOMER BASE ON WHICH BARBER ID THE USER CHOOSE
function insertCustomer($pdo, $cname, $customer_type, $barber_id, $user_id) {
	$sql = "INSERT INTO customers (cname, customer_type, barber_id, created_by) VALUES (?,?,?,?)";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$cname, $customer_type, $barber_id, $user_id]);
	if ($executeQuery) {
		return true;
	}

}

//FUNCTION TO GET ALL THE RECORDS OF THE CUSTOMER TO SHOW IT IN A TABLE FORM BASED ON WHICH BARBER HE OR SHE CHOOSE
function getCustomersByBarber($pdo, $barber_id) {
	
	$sql = "SELECT 
				customers.customer_id AS customer_id,
				customers.cname AS cname,
				customers.customer_type AS customer_type,
				customers.time_joined AS time_joined,
				CONCAT(barbers.fname,' ',barbers.lname) AS stylist
			FROM customers
			JOIN barbers ON customers.barber_id = barbers.barber_id
			WHERE customers.barber_id = ? 
			GROUP BY customers.cname;
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$barber_id]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}
//FUNCTION TO GET THE SPECIFIC RECORD OF A CUSTOMER BASED ON ITS ID
function getCustomerByID($pdo, $customer_id) {
	$sql = "SELECT 
				customers.customer_id AS customer_id,
				customers.cname AS cname,
				customers.customer_type AS customer_type,
				customers.time_joined AS time_joined,
				CONCAT(barbers.fname,' ',barbers.lname) AS stylist
			FROM customers
			JOIN barbers ON customers.barber_id = barbers.barber_id
			WHERE customers.customer_id  = ? 
			GROUP BY customers.cname";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$customer_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}
//FUNCTION TO MODIFY A CUSTOMER RECORD
function updateCustomer($pdo, $cname, $customer_type, $customer_id, $user_id) {
	$sql = "UPDATE customers
			SET cname = ?,
				customer_type = ?,
				updated_by = ?,
				last_updated = CURRENT_TIMESTAMP
			WHERE customer_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$cname, $customer_type, $customer_id, $user_id]);

	if ($executeQuery) {
		return true;
	}
}
//FUNCTION TO REMOVE A CUSTOMER FROM THE TABLE AND FROM THE RECORDS OF THE BARBER AS ITS CUSTOMER
function deleteCustomer($pdo, $customer_id) {
	$sql = "DELETE FROM customers WHERE customer_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$customer_id]);
	if ($executeQuery) {
		return true;
	}
}


//login, reg, logout functions


// TO REGISTER USER
function insertNewUser($pdo, $username, $password) {

	$checkUserSql = "SELECT * FROM user_passwords WHERE username = ?";
	$checkUserSqlStmt = $pdo->prepare($checkUserSql);
	$checkUserSqlStmt->execute([$username]);

	if ($checkUserSqlStmt->rowCount() == 0) {

		$sql = "INSERT INTO user_passwords (username,password) VALUES(?,?)";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$username, $password]);

		if ($executeQuery) {
			$_SESSION['message'] = "User successfully inserted";
			return true;
		}

		else {
			$_SESSION['message'] = "An error occured from the query";
		}

	}
	else {
		$_SESSION['message'] = "User already exists";
	}

	
}

// TO LOGIN USER
function loginUser($pdo, $username, $password) {
	$sql = "SELECT * FROM user_passwords WHERE username=?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$username]); 

	if ($stmt->rowCount() == 1) {
		$userInfoRow = $stmt->fetch();
		$usernameFromDB = $userInfoRow['username']; 
		$passwordFromDB = $userInfoRow['password'];

		if ($password == $passwordFromDB) {
			$_SESSION['username'] = $usernameFromDB;
			$_SESSION['message'] = "Login successful!";
			return true;
		}

		else {
			$_SESSION['message'] = "Password is invalid, but user exists";
		}
	}

	
	if ($stmt->rowCount() == 0) {
		$_SESSION['message'] = "Username doesn't exist from the database. You may consider registration first";
	}

}
//FUNCTION TO GET THE USER_ID OF WHO IS CURRENTLY LOGGED IN
function getUserIDByUsername($pdo, $username) {
    $sql = "SELECT user_id FROM user_passwords WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    return $row ? $row['user_id'] : null;
}
?>