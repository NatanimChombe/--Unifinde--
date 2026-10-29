<?php
session_start();
require_once '../includes/db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['fullname'] = $user['fname'] . ' ' . $user['lname'];
        header("Location: lost_item.php");
        exit();
    } else {
        $error = "Invalid Username or Password.";
    }
}
$is_page = true;
include '../includes/header.php';
?>

<h2>User Login</h2>
<?php if(isset($_GET['registered'])): ?><p style="color:green;">Registration successful! Please login.</p><?php endif; ?>
<?php if($error): ?><p style="color:red;"><?php echo $error; ?></p><?php endif; ?>

<form method="POST" style="max-width: 400px;">
    <div style="margin-bottom: 10px;"><label>Username:</label><br><input type="text" name="username" required style="width:100%; padding:8px;"></div>
    <div style="margin-bottom: 15px;"><label>Password:</label><br><input type="password" name="password" required style="width:100%; padding:8px;"></div>
    <button type="submit" style="background:#ff6600; color:white; padding:10px 15px; border:none; border-radius:4px;">Login</button>
</form>
<p>Don't have an account? <a href="register.php">Register here</a></p>

<?php include '../includes/footer.php'; ?>