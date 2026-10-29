<?php
session_start();
$is_page = true;
require_once '../includes/db.php';
include '../includes/header.php';

$stmt = $pdo->query("SELECT * FROM lost_items ORDER BY id DESC");
$lost_items = $stmt->fetchAll();
$current_user_id = $_SESSION['user_id'] ?? 0;
?>

<h2>Lost Items Registry</h2>
<?php if(isset($_SESSION['username'])): ?>
    <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['fullname']); ?></strong> | <a href="logout.php">Logout</a></p>
<?php else: ?>
    <p><a href="login.php">Login</a> or <a href="register.php">Register</a> to post and manage items.</p>
<?php endif; ?>

<div class="registry-list">
    <?php foreach ($lost_items as $item): ?>
        <div class="item-card" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #fff;">
            <div class="item-title" onclick="toggleDetails(<?php echo $item['id']; ?>)" style="cursor: pointer; color: #004080; font-weight: bold;">
                📦 <?php echo htmlspecialchars($item['item_name']); ?> 
                <span style="font-size: 0.8em; color: #666;">(Click for details ▼)</span>
            </div>

            <div id="details-<?php echo $item['id']; ?>" class="item-details" style="display: none; margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee;">
                <p><strong>Student Name:</strong> <?php echo htmlspecialchars($item['student_name']); ?></p>
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($item['phone_number']); ?></p>
                <p><strong>Special Sign:</strong> <?php echo htmlspecialchars($item['special_sign']); ?></p>
                <p><strong>Date Lost:</strong> <?php echo htmlspecialchars($item['date_lost']); ?></p>
                <p><strong>Place Lost:</strong> <?php echo htmlspecialchars($item['place_lost']); ?></p>

                <?php if (!empty($item['item_photo'])): ?>
                    <p><img src="../<?php echo htmlspecialchars($item['item_photo']); ?>" alt="Photo" width="150" style="border-radius:4px;"></p>
                <?php endif; ?>

                <!-- Show Action Buttons ONLY if the logged-in user is the owner -->
                <?php if ($current_user_id == $item['user_id']): ?>
                    <div style="margin-top: 15px; padding: 10px; background: #f9f9f9; border-left: 3px solid #004080;">
                        <form action="../actions/handle_lost_action.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            
                            <!-- 1. Edit Button -->
                            <a href="edit_lost.php?id=<?php echo $item['id']; ?>" style="background:#f0ad4e; color:white; padding:5px 10px; text-decoration:none; border-radius:3px; margin-right:5px;">Edit</a>
                            
                            <!-- 2. Delete Button -->
                            <button type="submit" name="action" value="delete" onclick="return confirm('Are you sure you want to delete this post?')" style="background:#d9534f; color:white; border:none; padding:6px 10px; border-radius:3px; cursor:pointer; margin-right:5px;">Delete</button>
                            
                            <!-- 3. Found Button (Migrates to resolved table) -->
                            <button type="submit" name="action" value="found" onclick="return confirm('Has this item been found/accepted? It will close this listing.')" style="background:#5cb85c; color:white; border:none; padding:6px 10px; border-radius:3px; cursor:pointer;">Found / Claimed</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div style="margin-top: 25px;">
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="register_lost.php" class="btn" style="background: #ff6600; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">+ Register New Lost Item</a>
    <?php else: ?>
        <p><a href="login.php">Login</a> to register a lost item.</p>
    <?php endif; ?>
</div>

<script>
function toggleDetails(id) {
    var div = document.getElementById('details-' + id);
    div.style.display = (div.style.display === 'block') ? 'none' : 'block';
}
</script>

<?php include '../includes/footer.php'; ?>