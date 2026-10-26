<?php include 'includes/header.php'; ?>

<div class="hero-section" style="text-align: center; padding: 40px 0;">
    <h1>Campus Property Recovery System</h1>
    <p>A digital hub for campus students to securely register and recover lost or found property.</p>
    
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