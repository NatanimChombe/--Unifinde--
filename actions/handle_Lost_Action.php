<?php
session_start();

// Enable error reporting to catch any hidden issues instantly
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$action  = $_POST['action'] ?? '';
$id      = $_POST['id'] ?? '';

if (!empty($id) && !empty($action)) {
    // Verify that the logged-in user owns this specific lost item
    $stmt = $pdo->prepare("SELECT * FROM lost_items WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    $item = $stmt->fetch();

    if ($item) {
        if ($action === 'delete') {
            // Delete image file from server if it exists
            if (!empty($item['item_photo']) && file_exists('../' . $item['item_photo'])) {
                unlink('../' . $item['item_photo']);
            }

            // Delete from database
            $del = $pdo->prepare("DELETE FROM lost_items WHERE id = ?");
            $del->execute([$id]);
        } 
        elseif ($action === 'found') {
            // Migrate full data from lost_items to accepted_items
            $mig = $pdo->prepare("INSERT INTO accepted_items (original_lost_id, user_id, student_name, phone_number, item_name, special_sign, item_photo, date_lost, place_lost) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $mig->execute([
                $item['id'], 
                $item['user_id'], 
                $item['student_name'], 
                $item['phone_number'], 
                $item['item_name'], 
                $item['special_sign'], 
                $item['item_photo'], 
                $item['date_lost'], 
                $item['place_lost']
            ]);

            // Delete from active lost_items table
            $del = $pdo->prepare("DELETE FROM lost_items WHERE id = ?");
            $del->execute([$id]);
        }
    }
}

header("Location: ../pages/lost_item.php");
exit();
?>