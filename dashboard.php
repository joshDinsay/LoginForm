<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5 text-center">
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</h2>
  <img src="<?php echo $_SESSION['profile_pic']; ?>" class="rounded-circle mt-3" style="width: 150px; height: 150px;">
  <br><br>
  <a href="logout.php" class="btn btn-danger">Logout</a>
</div>
</body>
</html>
