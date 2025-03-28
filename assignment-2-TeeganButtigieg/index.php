<?php
session_start();
include 'includes/header.php';

// MySQL connection 
try {
    $conn = new PDO('mysql:host=localhost;dbname=assignment2teeganbuttigieg', 'root', 'mysql');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}

// Initialize messages
$reg_error = $reg_success = $login_error = "";

// If the registration form is submitted
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Validate input
    if (empty($username) || empty($password)) {
        $reg_error = "Username and password are required for registration.";
    } else {
        // Hash the password using password_hash
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user into the database 
        try {
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password_hash);
            if ($stmt->execute()) {
                $reg_success = "Registration successful! Please log in.";
            }
        } catch (PDOException $e) {
            $reg_error = "Registration error: " . $e->getMessage();
        }
    }
}

// If the login form is submitted
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Validate input
    if (empty($username) || empty($password)) {
        $login_error = "Username and password are required for login.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password'])) {
                // Set session variables and redirect to login success page
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                header("Location: login_success.php");
                exit;
            } else {
                $login_error = "Invalid username or password.";
            }
        } catch (PDOException $e) {
            $login_error = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required metadata -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign In Page</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Sign In</h1>

  <!-- Registration Form -->
  <form action="index.php" method="post" novalidate>
    <h2>Create Account</h2>
    <?php if (!empty($reg_error)) echo "<p class='error'>{$reg_error}</p>"; ?>
    <?php if (!empty($reg_success)) echo "<p class='success'>{$reg_success}</p>"; ?>
    <label for="username_reg">Username:</label>
    <input type="text" name="username" id="username_reg" required>
    
    <label for="password_reg">Password:</label>
    <input type="password" name="password" id="password_reg" required>
    
    <button type="submit" name="register">Register</button>
  </form>

  <!-- Login Form -->
  <form action="index.php" method="post" novalidate>
    <h2>Login</h2>
    <?php if (!empty($login_error)) echo "<p class='error'>{$login_error}</p>"; ?>
    <label for="username_login">Username:</label>
    <input type="text" name="username" id="username_login" required>
    
    <label for="password_login">Password:</label>
    <input type="password" name="password" id="password_login" required>
    
    <button type="submit" name="login">Login</button>
  </form>

<?php include 'includes/footer.php'; ?>
</body>
</html>

<?php
$conn = null;
?>
