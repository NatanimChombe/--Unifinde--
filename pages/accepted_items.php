<?php
session_start();
$is_page = true;
require_once '../includes/db.php';
include '../includes/header.php';

// Fetch all successfully resolved/accepted items from the database
$stmt = $pdo->query("SELECT * FROM accepted_items ORDER BY id DESC");
$accepted_items = $stmt->fetchAll();
?>

<h2>Successfully Recovered / Accepted Items</h2>
<p>This registry displays items that have been successfully claimed or resolved.</p>

<?php if(isset($_SESSION['username'])): ?>
    <p style="background: #eef2f5; padding: 10px; border-radius: 5px;">
        Welcome, <strong><?php echo htmlspecialchars($_SESSION['fullname']); ?></strong> | <a href="logout.php" style="color: #d9534f; font-weight: bold;">Logout</a>
    </p>
<?php endif; ?>

<div class="registry-list" style="margin-top: 20px;">
    <?php if (count($accepted_items) > 0): ?>
        <?php foreach ($accepted_items as $item): ?>
            <div class="item-card" style="border: 1px solid #d4edda; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f8f9fa;">
                <!-- Clickable title to toggle details -->
                <div class="item-title" onclick="toggleAcceptedDetails(<?php echo $item['id']; ?>)" style="cursor: pointer; color: #28a745; font-weight: bold; font-size: 16px;">
                    ✅ <?php echo htmlspecialchars($item['item_name']); ?> (Resolved)
                    <span style="font-size: 0.8em; color: #666; float: right;">(Click for details ▼)</span>
                </div>

                <!-- Hidden details box -->
                <div id="accepted-details-<?php echo $item['id']; ?>" class="item-details" style="display: none; margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee;">
                    <p><strong>Student Name:</strong> <?php echo htmlspecialchars($item['student_name']); ?></p>
                    <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($item['phone_number']); ?></p>
                    <p><strong>Special Sign:</strong> <?php echo htmlspecialchars($item['special_sign']); ?></p>
                    <p><strong>Date Lost:</strong> <?php echo htmlspecialchars($item['date_lost']); ?></p>
                    <p><strong>Place Lost:</strong> <?php echo htmlspecialchars($item['place_lost']); ?></p>
                    <p><strong>Archived Date:</strong> <?php echo htmlspecialchars($item['archived_at']); ?></p>

                    <?php if (!empty($item['item_photo'])): ?>
                        <p><img src="../<?php echo htmlspecialchars($item['item_photo']); ?>" alt="Photo" width="150" style="border-radius:4px; border: 1px solid #ccc;"></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #666; font-style: italic;">No accepted or resolved items have been recorded yet.</p>
    <?php endif; ?>
</div>

<div style="margin-top: 25px;">
    <a href="../index.php" style="color: #004080; font-weight: bold; text-decoration: none;">&larr; Back to Home</a>
</div>

<script>
function toggleAcceptedDetails(id) {
    var div = document.getElementById('accepted-details-' + id);
    div.style.display = (div.style.display === 'block') ? 'none' : 'block';
}
</script>

<?php include '../includes/footer.php'; ?>