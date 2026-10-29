<?php 
session_start();
include 'includes/header.php'; 
?>

<div class="hero-section" style="text-align: center; padding: 40px 0;">
    <h1>Campus Property Recovery System</h1>
    <p>A digital hub for campus students to securely register and recover lost or found property.</p>
    
    <?php if(isset($_SESSION['username'])): ?>
        <!-- User is logged in: Show greeting and Logout button -->
        <div style="margin-top: 15px; background: #eef2f5; display: inline-block; padding: 10px 20px; border-radius: 5px;">
            <p style="margin: 0; font-weight: bold; color: #004080; display: inline-block; margin-right: 15px;">
                Welcome back, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!
            </p>
            <a href="pages/logout.php" style="background: #d9534f; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 14px;">Logout</a>
        </div>
    <?php else: ?>
        <!-- User is a guest: Show Login and Register options -->
        <div style="margin-top: 15px;">
            <a href="pages/login.php" style="color: #004080; font-weight: bold; text-decoration: underline; margin-right: 15px;">Login</a>
            <a href="pages/register.php" style="color: #ff6600; font-weight: bold; text-decoration: underline;">Register Account</a>
        </div>
    <?php endif; ?>

    <div class="flex-cards" style="display: flex; gap: 20px; margin-top: 30px; justify-content: center;">
        <div class="card" style="background: #eef2f5; padding: 25px; border-radius: 8px; flex: 1; max-width: 350px;">
            <h3>Lost Items</h3>
            <p>Misplaced something on campus? Browse or search through lost properties.</p>
            <a href="pages/lost_item.php" class="btn" style="display:inline-block; margin-top:15px; background:#004080; color:#fff; padding:10px 15px; text-decoration:none; border-radius:4px;">View Lost Registry</a>
        </div>
        
        <div class="card" style="background: #eef2f5; padding: 25px; border-radius: 8px; flex: 1; max-width: 350px;">
            <h3>Found Items</h3>
            <p>Found a stray item? Register it here to help return it to its owner.</p>
            <a href="pages/found_item.php" class="btn" style="display:inline-block; margin-top:15px; background:#ff6600; color:#fff; padding:10px 15px; text-decoration:none; border-radius:4px;">View Found Registry</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>