<?php
$error = '';
$success = '';
$emailValue = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $password = trim($_POST['password']);
  $emailValue = htmlspecialchars($email); // Preserve for re-fill

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format.";
  } elseif (strlen($password) < 6) {
    $error = "Password must be at least 6 characters.";
  } else {
    // Replace these with your actual DB credentials
    $conn = new mysqli("localhost", "root", "", "smartauth_db");

    if ($conn->connect_error) {
      $error = "Database connection failed.";
    } else {
      $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
        $error = "Email already registered.";
      } else {
        $stmt->close();
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashed);

        if ($stmt->execute()) {
          $success = "Registration successful. You can now <a href='index.html'>login</a>.";
          $emailValue = ''; // Clear form
        } else {
          $error = "Registration failed. Try again.";
        }
      }

      $stmt->close();
      $conn->close();
    }
  }
}
?>
