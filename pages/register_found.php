<?php
$is_page = true;
include '../includes/header.php';
?>

<h2>Register a Found Item</h2>
<form action="../actions/process_found.php" method="POST" enctype="multipart/form-data" style="max-width: 600px;">
    <div style="margin-bottom: 15px;">
        <label>Finder Name:</label><br>
        <input type="text" name="finder_name" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Finder ID:</label><br>
        <input type="text" name="finder_id" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Phone Number:</label><br>
        <input type="text" name="phone_number" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Name of Found Item:</label><br>
        <input type="text" name="item_name" required style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Item Description:</label><br>
        <textarea name="description" rows="3" required style="width:100%; padding:8px;" placeholder="Provide brief description..."></textarea>
    </div>

    <div style="margin-bottom: 15px;">
        <label>Photo of Item (Optional):</label><br>
        <input type="file" name="item_photo" accept="image/*">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Date Found (Optional):</label><br>
        <input type="date" name="date_found" style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Place Found (Optional):</label><br>
        <input type="text" name="place_found" placeholder="e.g. Cafeteria" style="width:100%; padding:8px;">
    </div>

    <button type="submit" name="submit_found" style="background: #ff6600; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Submit Found Item</button>
</form>

<?php include '../includes/footer.php'; ?>