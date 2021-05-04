<?php
session_start();

if (isset($_POST['logout'])) {
  include 'db_conn.php';

  date_default_timezone_set('Asia/Manila');
  $currentDate = date('Y-m-d H:i:s');
  $currentDate_timestamp = strtotime($currentDate);

  $id = $_SESSION["id"];

  $sql = "INSERT INTO `activitylog` (user_id, activity, dateandtime) VALUES ('$id', 'Logged Out', '$currentDate')";
  $result = mysqli_query($conn, $sql);
}

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

header("Location: index.php");
?>