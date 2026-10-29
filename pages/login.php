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
        
        // Greeting set to First Name + Middle Name
        $_SESSION['fullname'] = $user['fname'] . ' ' . $user['mname'];
        
        header("Location: lost_item.php");
        exit();
    } else {
        $error = "Invalid Username or Password.";
    }
}
$is_page = true;
include '../includes/header.php';
?>

<div class="auth-container" style="max-width: 400px; margin: 30px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <h2>User Login</h2>

    <?php if(isset($_GET['error']) && $_GET['error'] === 'access_denied'): ?>
        <p style="color: red; background: #fdf7f7; padding: 10px; border: 1px solid #ebccd1; border-radius: 4px; font-size: 14px;">
            ⚠️ You must log in first to register a lost or found item/Veiw Found Items.
        </p>
    <?php endif; ?>

    <?php if(isset($_GET['registered'])): ?>
        <p style="color: green; background: #dff0d8; padding: 10px; border-radius: 4px;">Registration successful! Please login below.</p>
    <?php endif; ?>

    <?php if($error): ?>
        <p style="color: red; background: #fdf7f7; padding: 10px; border-radius: 4px;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold;">Username:</label><br>
            <input type="text" name="username" required style="width:100%; padding:8px; margin-top:5px; box-sizing:border-box;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold;">Password:</label><br>
            <input type="password" name="password" required style="width:100%; padding:8px; margin-top:5px; box-sizing:border-box;">
        </div>
        
        <button type="submit" style="width:100%; background:#ff6600; color:white; padding:10px; border:none; border-radius:4px; font-weight:bold; cursor:pointer;">Login</button>
    </form>
    
    <p style="text-align: center; margin-top: 15px;">Don't have an account? <a href="register.php" style="color: #004080; font-weight: bold;">Register here</a></p>
</div>

<?php include '../includes/footer.php'; ?>