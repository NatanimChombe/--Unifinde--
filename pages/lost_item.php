<?php
$is_page = true;
require_once '../includes/db.php';
include '../includes/header.php';

$stmt = $pdo->query("SELECT * FROM lost_items ORDER BY id DESC");
$lost_items = $stmt->fetchAll();
?>

<h2>Lost Items Registry</h2>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green; font-weight: bold;">Lost item registered successfully!</p>
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
                <p><strong>Student ID:</strong> <?php echo htmlspecialchars($item['student_id']); ?></p>
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($item['phone_number']); ?></p>
                <p><strong>Special Sign / Feature:</strong> <?php echo htmlspecialchars($item['special_sign']); ?></p>
                <p><strong>Date Lost:</strong> <?php echo htmlspecialchars($item['date_lost']); ?></p>
                <p><strong>Place Lost:</strong> <?php echo htmlspecialchars($item['place_lost']); ?></p>

                <?php if (!empty($item['item_photo'])): ?>
                    <p><img src="../<?php echo htmlspecialchars($item['item_photo']); ?>" alt="Item Photo" width="150" style="border-radius:4px;"></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div style="margin-top: 25px;">
    <a href="register_lost.php" class="btn" style="background: #ff6600; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">+ Register New Lost Item</a>
</div>

<script>
function toggleDetails(id) {
    var div = document.getElementById('details-' + id);
    div.style.display = (div.style.display === 'block') ? 'none' : 'block';
}
</script>

<?php include '../includes/footer.php'; ?>