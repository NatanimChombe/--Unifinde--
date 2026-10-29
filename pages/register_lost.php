<?php
session_start();

// Check if user is logged in; if not, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=access_denied");
    exit();
}

$is_page = true;
include '../includes/header.php';
?>

<h2>Register a Lost Item</h2>
<form action="../actions/process_lost.php" method="POST" enctype="multipart/form-data" style="max-width: 600px;">
    <!-- Your form fields remain here -->
    <div style="margin-bottom: 15px;">
        <label>Student Name:</label><br>
        <input type="text" name="student_name" value="<?php echo htmlspecialchars($_SESSION['fullname'] ?? ''); ?>" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Student ID / Username:</label><br>
        <input type="text" name="student_id" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Phone Number:</label><br>
        <input type="text" name="phone_number" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Name of Lost Item:</label><br>
        <input type="text" name="item_name" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Special Sign / Distinctive Feature:</label><br>
        <textarea name="special_sign" rows="3" required style="width:100%; padding:8px;" placeholder="e.g. Scratches, stickers..."></textarea>
    </div>

    <div style="margin-bottom: 15px;">
        <label>Photo of Item (Optional):</label><br>
        <input type="file" name="item_photo" accept="image/*">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Date Lost (Optional):</label><br>
        <input type="date" name="date_lost" style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Place Lost (Optional):</label><br>
        <input type="text" name="place_lost" placeholder="e.g. Main Library" style="width:100%; padding:8px;">
    </div>

    <button type="submit" name="submit_lost" style="background: #004080; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Submit Lost Item</button>
</form>

<?php include '../includes/footer.php'; ?>