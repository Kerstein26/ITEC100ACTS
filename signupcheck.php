<?php
session_start();

include "db_conn.php";

if (
	isset($_POST['uname']) && isset($_POST['email'])
	&& isset($_POST['password']) && isset($_POST['cpassword'])
) {
	function validate($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	$cpass = validate($_POST['cpassword']);
	$email = validate($_POST['email']);

	$users_data = 'username=' . $uname . '&name=' . $name;

	if (empty($uname)) {
		header("Location: registration.php?error=Username is required&$users_data");
		exit();
	} else if (empty($pass)) {
		header("Location: registration.php?error=Password is required&$users_data");
		exit();
	} else if (strlen(trim($_POST["password"])) < 8) {
		header("Location: registration.php?error=Password should be 8 characters&$users_data");
		exit();
	} else if (!preg_match("#[a-z]+#", $_POST["password"])) {
		header("Location: registration.php?error=The password need atleast one lowercase letter&$users_data");
		exit();
	} else if (!preg_match("#[A-Z]+#", $_POST["password"])) {
		header("Location: registration.php?error=The password need atleast one uppercase letter&$users_data");
		exit();
	} else if (!preg_match("#[0-9]+#", $_POST["password"])) {
		header("Location: registration.php?error=The password need atleast one number&$users_data");
		exit();
	} else if (!preg_match("/\W/", $_POST["password"])) {
		header("Location: registration.php?error=The password need atleast one special character&$users_data");
		exit();
	} else if (empty($cpass)) {
		header("Location: registration.php?error=Please confirm your password&$users_data");
		exit();
	} else if (empty($email)) {
		header("Location: registration.php?error=Email is required&$users_data");
		exit();
	} else if ($pass !== $cpass) {
		header("Location: registration.php?error=The confirmation password does not match&$users_data");
		exit();
	} else {
		$pass = md5($pass);
		$sql = "SELECT * FROM users WHERE user_name = '$uname' ";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
			header("Location: registration.php?error=The username is already taken&$users_data");
			exit();
		} else {
			$sql2 = "INSERT INTO users(user_name, password, email, name) VALUES ('$uname','$pass', '$email', '$name')";
			$result2 = mysqli_query($conn, $sql2);
			if ($result2) {
				header("Location: registration.php?success=The account is succesfully created");
				exit();
			} else {
				header("Location: registration.php?error=Error&$users_data");
				exit();
			}
		}
	}
} else {
	header("Location: registration.php");
	exit();
}
