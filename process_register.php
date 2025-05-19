<?php
require 'db.php';

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$age = intval($_POST['age']);
$gender = $_POST['gender'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "SELECT * FROM users WHERE email = ? OR phone = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: register.php?msg=Email or phone already exists&type=error");
    exit();
}
$sql = "INSERT INTO users (name, email, phone, age, gender, password) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssiss", $name, $email, $phone, $age, $gender, $password);

if ($stmt->execute()) {
    header("Location: register.php?msg=Registration successful&type=success");
} else {
    header("Location: register.php?msg=Registration failed&type=error");
}

$conn->close();
?>