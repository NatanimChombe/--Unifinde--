<?php
require_once '../includes/db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname    = trim($_POST['fname']);
    $mname    = trim($_POST['mname']);
    $lname    = trim($_POST['lname']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hashing

    try {
        $stmt = $pdo->prepare("INSERT INTO users (fname, mname, lname, username, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$fname, $mname, $lname, $username, $password]);
        header("Location: login.php?registered=1");
        exit();
    } catch (PDOException $e) {
        $error = "Username already taken or database error.";
    }
}
$is_page = true;
include '../includes/header.php';
?>

<h2>Campus User Registration</h2>
<?php if($error): ?><p style="color:red;"><?php echo $error; ?></p><?php endif; ?>

<form method="POST" style="max-width: 500px;">
    <div style="margin-bottom: 10px;"><label>First Name (FName):</label><br><input type="text" name="fname" required style="width:100%; padding:8px;"></div>
    <div style="margin-bottom: 10px;"><label>Middle Name (MName):</label><br><input type="text" name="mname" required style="width:100%; padding:8px;"></div>
    <div style="margin-bottom: 10px;"><label>Last Name (LName):</label><br><input type="text" name="lname" required style="width:100%; padding:8px;"></div>
    <div style="margin-bottom: 10px;"><label>Username:</label><br><input type="text" name="username" required style="width:100%; padding:8px;"></div>
    <div style="margin-bottom: 15px;"><label>Password:</label><br><input type="password" name="password" required style="width:100%; padding:8px;"></div>
    <button type="submit" style="background:#004080; color:white; padding:10px 15px; border:none; border-radius:4px;">Register Account</button>
</form>
<p>Already have an account? <a href="login.php">Login here</a></p>

<?php include '../includes/footer.php'; ?>