<?php
// signup_process.php

$conn = new mysqli("localhost", "root", "", "smartauth_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fullname = $conn->real_escape_string($_POST['fullname']);
$email = $conn->real_escape_string($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$target_dir = "uploads/";
$profile_pic = $target_dir . basename($_FILES["profile_pic"]["name"]);
move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $profile_pic);

$sql = "INSERT INTO users (fullname, email, password, profile_pic) VALUES ('$fullname', '$email', '$password', '$profile_pic')";
if ($conn->query($sql) === TRUE) {
    header("Location: index.html?success=1");
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>
