<?php
session_start();

if (!isset($_SESSION["verify"]) || $_SESSION["verify"] !== true) {
    header("location: index.php");
    exit;
}

require_once "db_conn.php";

$code_err = "";

if (isset($_POST['login'])) {
    if (empty(trim($_POST["code"]))) {
        header("Location: verify.php?error=PLEASE ENTER CODE");
        exit();
    } else {
        date_default_timezone_set('Asia/Manila');
        $currentDate = date('Y-m-d H:i:s');
        $currentDate_timestamp = strtotime($currentDate);
        $code = $_POST['code'];
        $id = $_SESSION["id"];

        $sql = "SELECT code FROM code WHERE user_id = '$id' AND NOW() >= created_at AND NOW() <= expiration ORDER BY id_code DESC limit 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                if ($row["code"] == $code) {
                    $_SESSION["loggedin"] = true;

                    $sql = "INSERT INTO `activitylog` (user_id, activity, dateandtime) VALUES ('$id', 'Logged In', '$currentDate')";
                    
                    if (mysqli_query($conn, $sql)) {
                        header("Location: home.php");
                        exit();
                    }
                } else {
                    header("Location: verify.php?error=WRONG CODE");
                    exit();
                }
            }
        } else {
            header("Location: verify.php?error=THE CODE IS EXPIRED");
            exit();
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>AUTHENTICATION</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <form action="verify.php" method="post">
        <h2>VERIFICATION CODE</h2>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <label>
            <center>ENTER CODE</center>
        </label>
        <input type="text" name="code"><br>
        <a href="random.php" class="ca" target="blank">GET CODE</a>
        <button type="submit" name="login">LOGIN</button>
    </form>
</body>

</html>