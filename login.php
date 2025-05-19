<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "session";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $_SESSION["admin_logged_in"] = true;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect email or password!";
        }

        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"> <
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <form method="POST" onsubmit="return validateLoginForm();">
            <div class="input-group">
                <i class="bi bi-envelope-fill"></i>
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <i class="bi bi-lock-fill"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <button type="submit"><i class="bi bi-box-arrow-in-right"></i> Login</button>
            <?php if (!empty($error)): ?>
                <p class="error"><?= ($error) ?></p>
            <?php endif; ?>
        </form>
    </div>

    <script src="./login.js"></script>
</body>
</html>

