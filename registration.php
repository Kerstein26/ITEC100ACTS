<!DOCTYPE html>
<html>

<head>
	<title>REGISTRATION</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<form action="signupcheck.php" method="post">
		<h2>Register Now</h2>
		<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<?php if (isset($_GET['success'])) { ?>
			<p class="success"><?php echo $_GET['success']; ?></p>
		<?php } ?>
		<b><label>Username</label>
			<input type="text" name="uname" placeholder="Enter your Username">
			<label>Email</label>
			<input type="email" name="email" placeholder="Enter your Email"><br>
			<label>Password</label>
			<input type="password" name="password" placeholder="Enter your Password"><br>
			<label>Confirm Password</label>
			<input type="password" name="cpassword" placeholder="Confirm your Password"><br></b>
		<button type="submit">SIGN UP</button>
		<a href="index.php" class="ca">SIGN IN HERE</a>
	</form>
</body>

</html>