<?php
include 'db_conn.php';

if (isset($_POST['save'])) {
  $uname = stripslashes($_POST['uname']); // removes backslashes
  $uname = mysqli_real_escape_string($conn, $uname); //escapes special characters in a string

  $newpassword = stripslashes($_POST['newpassword']);
  $newpassword = mysqli_real_escape_string($conn, $newpassword);

  date_default_timezone_set('Asia/Manila');
  $currentDate = date('Y-m-d H:i:s');
  $currentDate_timestamp = strtotime($currentDate);

  if (empty($uname)) {
    header("Location: newaccount.php?error=Username is required");
    exit();
  } else if (empty($newpassword)) {
    header("Location: newaccount.php?error=Password is required");
    exit();
  } else if (strlen(trim($_POST["newpassword"])) < 8) {
    header("Location: newaccount.php?error=Password should be 8 characters");
    exit();
  } else if (!preg_match("#[a-z]+#", $_POST["newpassword"])) {
    header("Location: newaccount.php?error=The password need atleast one lowercase letter");
    exit();
  } else if (!preg_match("#[A-Z]+#", $_POST["newpassword"])) {
    header("Location: newaccount.php?error=The password need atleast one uppercase letter");
    exit();
  } else if (!preg_match("#[0-9]+#", $_POST["newpassword"])) {
    header("Location: newaccount.php?error=The password need atleast one number");
    exit();
  } else if (!preg_match("/\W/", $_POST["newpassword"])) {
    header("Location: newaccount.php?error=The password need atleast one special character");
    exit();
  } else {
    $newpassword = md5($newpassword);
    $query = "UPDATE `users` SET password = '$newpassword' WHERE user_name = '$uname'";
    mysqli_query($conn, $query) or die(mysqli_error($conn));

    if (mysqli_affected_rows($conn) > 0) {
      $stmt = $conn->prepare("SELECT id FROM users WHERE user_name = ? LIMIT 1");

      if (
        $stmt &&
        $stmt->bind_param('s', $uname) &&
        $stmt->execute() &&
        $stmt->store_result() &&
        $stmt->bind_result($id) &&
        $stmt->fetch()
      ) {
        $sql = "INSERT INTO `activitylog` (user_id, activity, dateandtime) VALUES ('$id', 'Changed Password', '$currentDate')";
        if (mysqli_query($conn, $sql)) {
          header("Location: newaccount.php?success=Password Changed Successfully");
          exit();
        }

        $stmt->close();
      }
    } else {
      header("Location: newaccount.php?error=Incorrect");
      exit();
    }
  }
}
