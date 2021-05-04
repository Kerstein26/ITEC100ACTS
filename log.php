<?php
session_start();
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {
	function validate($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	date_default_timezone_set('Asia/Manila');
	$currentDate = date('Y-m-d H:i:s');
	$currentDate_timestamp = strtotime($currentDate);

	if (empty($uname)) {
		header("Location: index.php?error=Username is required");
		exit();
	} else if (empty($pass)) {
		header("Location: index.php?error=Password is required");
		exit();
	} else {
		//HASHING PASSWORD
		$pass = md5($pass);
		$sql = "SELECT * FROM users WHERE user_name = '$uname' AND password = '$pass'";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
			$_SESSION['user_name'] = $row['user_name'];
			$_SESSION['name'] = $row['name'];
			$_SESSION['id'] = $row['id'];
			$_SESSION["verify"] = true;

			$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
			$code = substr(str_shuffle($permitted_chars), 0, 6);

			date_default_timezone_set('Asia/Manila');

			$currentDate = date('Y-m-d H:i:s');
			$currentDate_timestamp = strtotime($currentDate);
			$endDate_months = strtotime("+5 minutes", $currentDate_timestamp);
			$packageEndDate = date('Y-m-d H:i:s', $endDate_months);

			$user_id = $_SESSION["id"];
			$sql = "INSERT INTO code (user_id, code, created_at, expiration) VALUES('$user_id', '$code', '$currentDate', '$packageEndDate')";
			
			if (mysqli_query($conn, $sql)) {
				header("Location: verify.php");
			}

			exit();
		} else {
			header("Location: index.php?error=Incorrect Username or Password");
			exit();
		}
	}
}
?>