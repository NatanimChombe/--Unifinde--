<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? 0;
$user_id = $_SESSION['user_id'];

// Fetch the item ensuring the logged-in user owns it
$stmt = $pdo->prepare("SELECT * FROM lost_items WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);
$item = $stmt->fetch();

if (!$item) {
    header("Location: lost_item.php");
    exit();
}

// Handle form submission when updated
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = $_POST['student_name'];
    $student_id   = $_POST['student_id'];
    $phone_number = $_POST['phone_number'];
    $item_name    = $_POST['item_name'];
    $special_sign = $_POST['special_sign'];
    $date_lost    = !empty($_POST['date_lost']) ? $_POST['date_lost'] : null;
    $place_lost   = !empty($_POST['place_lost']) ? $_POST['place_lost'] : null;

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
            // Optional: delete the old photo file from server to save space
            if (!empty($item['item_photo']) && file_exists('../' . $item['item_photo'])) {
                unlink('../' . $item['item_photo']);
            }
            $photo_path = 'asset/upload/' . $file_name;
        }
    }

    $update = $pdo->prepare("UPDATE lost_items SET student_name=?, student_id=?, phone_number=?, item_name=?, special_sign=?, item_photo=?, date_lost=?, place_lost=? WHERE id=? AND user_id=?");
    $update->execute([$student_name, $student_id, $phone_number, $item_name, $special_sign, $photo_path, $date_lost, $place_lost, $id, $user_id]);

    header("Location: lost_item.php?updated=1");
    exit();
}

$is_page = true;
include '../includes/header.php';
?>

<h2>Edit Lost Item</h2>
<!-- Added enctype="multipart/form-data" for file uploads -->
<form method="POST" enctype="multipart/form-data" style="max-width: 600px;">
    <div style="margin-bottom: 15px;">
        <label>Student Name:</label><br>
        <input type="text" name="student_name" value="<?php echo htmlspecialchars($item['student_name']); ?>" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Student ID:</label><br>
        <input type="text" name="student_id" value="<?php echo htmlspecialchars($item['student_id']); ?>" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Phone Number:</label><br>
        <input type="text" name="phone_number" value="<?php echo htmlspecialchars($item['phone_number']); ?>" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Name of Lost Item:</label><br>
        <input type="text" name="item_name" value="<?php echo htmlspecialchars($item['item_name']); ?>" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Special Sign / Distinctive Feature:</label><br>
        <textarea name="special_sign" rows="3" required style="width:100%; padding:8px;"><?php echo htmlspecialchars($item['special_sign']); ?></textarea>
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
        <label>Date Lost:</label><br>
        <input type="date" name="date_lost" value="<?php echo htmlspecialchars($item['date_lost']); ?>" style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Place Lost:</label><br>
        <input type="text" name="place_lost" value="<?php echo htmlspecialchars($item['place_lost']); ?>" style="width:100%; padding:8px;">
    </div>

    <button type="submit" style="background: #004080; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight:bold;">Update Lost Item</button>
    <a href="lost_item.php" style="margin-left: 10px; text-decoration: none; color: #555;">Cancel</a>
</form>

<?php include '../includes/footer.php'; ?>