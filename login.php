<?php
session_start();
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  $conn = new mysqli("localhost", "your_user", "your_password", "your_db");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("SELECT password_hash FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows === 1) {
    $stmt->bind_result($hash);
    $stmt->fetch();
    
    if (password_verify($password, $hash)) {
      $_SESSION['user'] = $email;
      header("Location: dashboard.php");
      exit();
    } else {
      $error = "Incorrect password.";
    }
  } else {
    $error = "Email not found.";
  }

  $stmt->close();
  $conn->close();
}
?>
