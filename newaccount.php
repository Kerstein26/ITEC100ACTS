<!DOCTYPE html>
<html>

<head>
	<title>LOGIN</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<form action="changepass.php" method="post">
		<h2> Change your Password </h2>
		<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<?php if (isset($_GET['success'])) { ?>
			<p class="success"><?php echo $_GET['success']; ?></p>
		<?php } ?>
		<b><label>Enter Username</label>
			<input type="text" name="uname" placeholder="Enter Username"><br>
			<label>New Password</label>
			<input type="password" name="newpassword" placeholder="Enter Password"><br></b>
		<a href="index.php" class="ca">DONE</a>
		<button type="submit" name="save">SAVE</button>
	</form>
</body>

</html>