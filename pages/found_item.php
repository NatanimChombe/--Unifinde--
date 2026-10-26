<?php
$is_page = true;
require_once '../includes/db.php';
include '../includes/header.php';

$stmt = $pdo->query("SELECT * FROM found_items ORDER BY id DESC");
$found_items = $stmt->fetchAll();
?>

<h2>Found Items Registry</h2>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green; font-weight: bold;">Found item registered successfully!</p>
<?php endif; ?>

<div class="registry-list">
    <?php foreach ($found_items as $item): ?>
        <div class="item-card" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #fff;">
            <div class="item-title" onclick="toggleFoundDetails(<?php echo $item['id']; ?>)" style="cursor: pointer; color: #ff6600; font-weight: bold;">
                🔑 <?php echo htmlspecialchars($item['item_name']); ?> 
                <span style="font-size: 0.8em; color: #666;">(Click for details ▼)</span>
            </div>

            <div id="found-details-<?php echo $item['id']; ?>" class="item-details" style="display: none; margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee;">
                <p><strong>Finder Name:</strong> <?php echo htmlspecialchars($item['finder_name']); ?></p>
                <p><strong>Finder ID:</strong> <?php echo htmlspecialchars($item['finder_id']); ?></p>
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($item['phone_number']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($item['description']); ?></p>
                <p><strong>Date Found:</strong> <?php echo htmlspecialchars($item['date_found']); ?></p>
                <p><strong>Place Found:</strong> <?php echo htmlspecialchars($item['place_found']); ?></p>

                <?php if (!empty($item['item_photo'])): ?>
                    <p><img src="../<?php echo htmlspecialchars($item['item_photo']); ?>" alt="Item Photo" width="150" style="border-radius:4px;"></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div style="margin-top: 25px;">
    <a href="register_found.php" class="btn" style="background: #004080; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">+ Register New Found Item</a>
</div>

<script>
function toggleFoundDetails(id) {
    var div = document.getElementById('found-details-' + id);
    div.style.display = (div.style.display === 'block') ? 'none' : 'block';
}
</script>

<?php include '../includes/footer.php'; ?>