<?php
session_start();

$conn = new mysqli("localhost", "root", "", "smartauth_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $conn->real_escape_string($_POST['email']);
$password = $_POST['password'];

$result = $conn->query("SELECT * FROM users WHERE email = '$email'");

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['profile_pic'] = $user['profile_pic'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Incorrect password'); window.location='index.html';</script>";
    }
} else {
    echo "<script>alert('Email not found'); window.location='index.html';</script>";
}
$conn->close();
?>
