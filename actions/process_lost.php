<?php
session_start(); // <--- CRITICAL: Must be at the very top
require_once '../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php?error=access_denied");
    exit();
}

if (isset($_POST['submit_lost'])) {
    $user_id      = $_SESSION['user_id']; // <--- Captures the logged-in user's ID
    $student_name = $_POST['student_name'];
    $student_id   = $_POST['student_id'];
    $phone_number = $_POST['phone_number'];
    $item_name    = $_POST['item_name'];
    $special_sign = $_POST['special_sign'];
    $date_lost    = !empty($_POST['date_lost']) ? $_POST['date_lost'] : null;
    $place_lost   = !empty($_POST['place_lost']) ? $_POST['place_lost'] : null;

    $photo_path = null;
    if (isset($_FILES['item_photo']) && $_FILES['item_photo']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['item_photo']['tmp_name'];
        $file_name = time() . '_' . preg_replace("/[^a-zA-Z0-9._]/", "", $_FILES['item_photo']['name']);
        $upload_dir = '../asset/upload/';
        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $destination = $upload_dir . $file_name;
        if (move_uploaded_file($file_tmp, $destination)) {
            $photo_path = 'asset/upload/' . $file_name;
        }
    }

    try {
        $sql = "INSERT INTO lost_items (user_id, student_name, student_id, phone_number, item_name, special_sign, item_photo, date_lost, place_lost) 
                VALUES (:user_id, :student_name, :student_id, :phone_number, :item_name, :special_sign, :item_photo, :date_lost, :place_lost)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id'      => $user_id,
            ':student_name' => $student_name,
            ':student_id'   => $student_id,
            ':phone_number' => $phone_number,
            ':item_name'    => $item_name,
            ':special_sign' => $special_sign,
            ':item_photo'   => $photo_path,
            ':date_lost'    => $date_lost,
            ':place_lost'   => $place_lost
        ]);

        header("Location: ../pages/lost_item.php?success=1");
        exit();
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
}
?>