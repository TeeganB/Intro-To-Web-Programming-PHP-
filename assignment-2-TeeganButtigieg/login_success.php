<?php
session_start();
// Redirect to sign in page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required metadata -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Success</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
  <p>You have successfully Logged In!</p>

<?php include 'includes/footer.php'; ?>
</body>
</html>