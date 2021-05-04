<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
	header("location: home.php");
	exit;
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>LOGIN</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<form action="log.php" method="post">
		<h2>WELCOME</h2>
		<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<b><label>Username</label>
			<input type="text" name="uname" placeholder="Enter Username"><br>

			<label>Password</label>
			<input type="password" name="password" placeholder="Enter Password"><br></b>
		<button type="submit">LOGIN</button>
		<a href="registration.php" class="ca">SIGN UP</a>
		<center>
			<a href="newaccount.php" class="ca">FORGOT PASSWORD</a>
		</center>
	</form>
</body>

</html>