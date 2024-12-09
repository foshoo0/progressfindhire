<?php
require_once 'dbconfig.php';

function insertJobPost($pdo, $title, $description, 
	$requirements, $deadline) {

	$sql = "INSERT INTO job_posts (title, description, 
	requirements, deadline) VALUES(?,?,?,?)"; //SQL CODE

	$stmt = $pdo->prepare($sql); //PREPARE EXECUTE CYCLE
	$executeQuery = $stmt->execute([$title, $description, 
	$requirements, $deadline]);

	if ($executeQuery) {
		return true;
	}
}

function getAllJobPost($pdo) {
	$sql = "SELECT * FROM job_posts";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getJobPostByID($pdo, $id) {
	$sql = "SELECT * FROM job_posts WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
} 

function updateJobPost($pdo, $title, $description, 
	$requirements, $deadline, $id) {

	$sql = "UPDATE job_posts
				SET title = ?,
					description = ?,
					requirements = ?, 
					deadline = ?
				WHERE id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$title, $description, 
	$requirements, $deadline, $id]);
	
	if ($executeQuery) {
		return true;
	}

}


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

function getUserIDByUsername($pdo, $username) {
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    return $row ? $row['id'] : null;
}

?>