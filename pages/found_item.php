<?php
session_start();

// PREREQUISITE: Check if user is logged in; if not, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=access_denied");
    exit();
}


$is_page = true;
require_once '../includes/db.php';
include '../includes/header.php';

$stmt = $pdo->query("SELECT * FROM found_items ORDER BY id DESC");
$found_items = $stmt->fetchAll();
$current_user_id = $_SESSION['user_id'] ?? 0;
?>

<h2>Found Items Registry</h2>

<?php if(isset($_SESSION['username'])): ?>
    <p style="background: #eef2f5; padding: 10px; border-radius: 5px;">
        Welcome, <strong><?php echo htmlspecialchars($_SESSION['fullname']); ?></strong> | <a href="logout.php" style="color: #d9534f; font-weight: bold;">Logout</a>
    </p>
<?php else: ?>
    <p style="background: #fdf7f7; padding: 10px; border-radius: 5px;">
        <a href="login.php" style="font-weight:bold;">Login</a> or <a href="register.php" style="font-weight:bold;">Register</a> to post and manage items.
    </p>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green; font-weight: bold; background: #dff0d8; padding: 10px; border-radius:4px;">Found item registered successfully!</p>
<?php endif; ?>
<?php if (isset($_GET['updated'])): ?>
    <p style="color: green; font-weight: bold; background: #dff0d8; padding: 10px; border-radius:4px;">Found item updated successfully!</p>
<?php endif; ?>

<div class="registry-list" style="margin-top: 20px;">
    <?php foreach ($found_items as $item): ?>
        <div class="item-card" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #fff;">
            <div class="item-title" onclick="toggleFoundDetails(<?php echo $item['id']; ?>)" style="cursor: pointer; color: #ff6600; font-weight: bold; font-size: 16px;">
                🔑 <?php echo htmlspecialchars($item['item_name']); ?> 
                <span style="font-size: 0.8em; color: #666; float: right;">(Click for details ▼)</span>
            </div>

            <div id="found-details-<?php echo $item['id']; ?>" class="item-details" style="display: none; margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee;">
                <p><strong>Finder Name:</strong> <?php echo htmlspecialchars($item['finder_name']); ?></p>
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($item['phone_number']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($item['description']); ?></p>
                <p><strong>Date Found:</strong> <?php echo htmlspecialchars($item['date_found']); ?></p>
                <p><strong>Place Found:</strong> <?php echo htmlspecialchars($item['place_found']); ?></p>

                <?php if (!empty($item['item_photo'])): ?>
                    <p><img src="../<?php echo htmlspecialchars($item['item_photo']); ?>" alt="Item Photo" width="150" style="border-radius:4px; border: 1px solid #ccc;"></p>
                <?php endif; ?>

                <!-- Show Edit and Delete Buttons ONLY if the logged-in user is the owner -->
                <?php if ($current_user_id == $item['user_id']): ?>
                    <div style="margin-top: 15px; padding: 10px; background: #f9f9f9; border-left: 3px solid #ff6600;">
                        <form action="../actions/handle_found_action.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            
                            <!-- 1. Edit Button -->
                            <a href="edit_found.php?id=<?php echo $item['id']; ?>" style="background:#f0ad4e; color:white; padding:5px 12px; text-decoration:none; border-radius:3px; margin-right:5px; font-weight:bold; font-size:13px;">Edit</a>
                            
                            <!-- 2. Delete Button -->
                            <button type="submit" name="action" value="delete" onclick="return confirm('Are you sure you want to delete this post?')" style="background:#d9534f; color:white; border:none; padding:6px 12px; border-radius:3px; cursor:pointer; font-weight:bold; font-size:13px;">Delete</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div style="margin-top: 25px;">
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="register_found.php" class="btn" style="background: #ff6600; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold;">+ Register New Found Item</a>
    <?php else: ?>
        <p><a href="login.php" style="color: #004080; font-weight: bold;">Login</a> to register a found item.</p>
    <?php endif; ?>
</div>

<script>
function toggleFoundDetails(id) {
    var div = document.getElementById('found-details-' + id);
    div.style.display = (div.style.display === 'block') ? 'none' : 'block';
}
</script>

<?php include '../includes/footer.php'; ?>