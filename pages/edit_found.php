<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? 0;
$user_id = $_SESSION['user_id'];

// Verify ownership and fetch data
$stmt = $pdo->prepare("SELECT * FROM found_items WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);
$item = $stmt->fetch();

if (!$item) {
    header("Location: found_item.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $finder_name  = $_POST['finder_name'];
    $phone_number = $_POST['phone_number'];
    $item_name    = $_POST['item_name'];
    $description  = $_POST['description'];
    $date_found   = !empty($_POST['date_found']) ? $_POST['date_found'] : null;
    $place_found  = !empty($_POST['place_found']) ? $_POST['place_found'] : null;

    // Keep existing photo by default
    $photo_path = $item['item_photo'];

    // Check if a new photo was uploaded
    if (isset($_FILES['item_photo']) && $_FILES['item_photo']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['item_photo']['tmp_name'];
        $file_name = time() . '_' . preg_replace("/[^a-zA-Z0-9._]/", "", $_FILES['item_photo']['name']);
        $upload_dir = '../asset/upload/';
        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $destination = $upload_dir . $file_name;
        if (move_uploaded_file($file_tmp, $destination)) {
            if (!empty($item['item_photo']) && file_exists('../' . $item['item_photo'])) {
                unlink('../' . $item['item_photo']);
            }
            $photo_path = 'asset/upload/' . $file_name;
        }
    }

    $update = $pdo->prepare("UPDATE found_items SET finder_name=?, phone_number=?, item_name=?, description=?, item_photo=?, date_found=?, place_found=? WHERE id=? AND user_id=?");
    $update->execute([$finder_name, $phone_number, $item_name, $description, $photo_path, $date_found, $place_found, $id, $user_id]);

    header("Location: found_item.php?updated=1");
    exit();
}

$is_page = true;
include '../includes/header.php';
?>

<h2>Edit Found Item</h2>
<!-- Added enctype="multipart/form-data" for file uploads -->
<form method="POST" enctype="multipart/form-data" style="max-width: 600px;">
    <div style="margin-bottom: 15px;">
        <label>Finder Name:</label><br>
        <input type="text" name="finder_name" value="<?php echo htmlspecialchars($item['finder_name']); ?>" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Phone Number:</label><br>
        <input type="text" name="phone_number" value="<?php echo htmlspecialchars($item['phone_number']); ?>" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Name of Found Item:</label><br>
        <input type="text" name="item_name" value="<?php echo htmlspecialchars($item['item_name']); ?>" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Item Description:</label><br>
        <textarea name="description" rows="3" required style="width:100%; padding:8px;"><?php echo htmlspecialchars($item['description']); ?></textarea>
    </div>

    <!-- Photo Update Section -->
    <div style="margin-bottom: 15px;">
        <label>Item Photo:</label><br>
        <?php if (!empty($item['item_photo'])): ?>
            <p>Current Photo:<br><img src="../<?php echo htmlspecialchars($item['item_photo']); ?>" width="100" style="border-radius:4px; border:1px solid #ccc; margin-bottom:5px;"></p>
        <?php endif; ?>
        <input type="file" name="item_photo" accept="image/*">
        <small style="color: #666; display: block; margin-top: 3px;">Leave blank to keep the current photo.</small>
    </div>

    <div style="margin-bottom: 15px;">
        <label>Date Found:</label><br>
        <input type="date" name="date_found" value="<?php echo htmlspecialchars($item['date_found']); ?>" style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Place Found:</label><br>
        <input type="text" name="place_found" value="<?php echo htmlspecialchars($item['place_found']); ?>" style="width:100%; padding:8px;">
    </div>

    <button type="submit" style="background: #004080; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight:bold;">Update Found Item</button>
    <a href="found_item.php" style="margin-left: 10px; text-decoration: none; color: #555;">Cancel</a>
</form>

<?php include '../includes/footer.php'; ?>