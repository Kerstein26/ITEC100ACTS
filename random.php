<?php
session_start();
require_once "db_conn.php"; //$db_conn

if (!isset($_SESSION["verify"]) || $_SESSION["verify"] !== true) {
    header("location: index.php");
    exit;
}

$id = $_SESSION['id'];
$authentication_code = 'EXPIRED';

$stmt = $conn->prepare("SELECT code FROM code WHERE user_id = ? AND NOW() >= created_at AND NOW() <= expiration ORDER BY id_code DESC LIMIT 1");

if (
    $stmt &&
    $stmt->bind_param('i', $id) &&
    $stmt->execute() &&
    $stmt->store_result() &&
    $stmt->bind_result($code) &&
    $stmt->fetch()
) {
    $authentication_code = $code;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>CODE</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <form action="" method="post">
        <h2>ENTER THIS CODE</h2>
        <label>
            <center>
                <h3><?php echo $authentication_code; ?></h3>
            </center>
        </label>
        </head>
    </form>
</body>

</html>