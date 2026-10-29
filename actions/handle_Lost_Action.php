<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$action  = $_POST['action'] ?? '';
$id      = $_POST['id'] ?? '';

if ($id) {
    // Verify ownership
    $stmt = $pdo->prepare("SELECT * FROM lost_items WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    $item = $stmt->fetch();

    if ($item) {
        if ($action === 'delete') {
            // Optional: Delete the image file from server to save storage space
            if (!empty($item['item_photo']) && file_exists('../' . $item['item_photo'])) {
                unlink('../' . $item['item_photo']);
            }

            // Delete from database
            $del = $pdo->prepare("DELETE FROM lost_items WHERE id = ?");
            $del->execute([$id]);
        } 
        elseif ($action === 'found') {
            // Migrate to resolved_items table
            $mig = $pdo->prepare("INSERT INTO resolved_items (original_lost_id, user_id, student_name, phone_number, item_name, special_sign, item_photo, date_lost, place_lost) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $mig->execute([
                $item['id'], $item['user_id'], $item['student_name'], $item['phone_number'], 
                $item['item_name'], $item['special_sign'], $item['item_photo'], $item['date_lost'], $item['place_lost']
            ]);

            // Delete from active lost items
            $del = $pdo->prepare("DELETE FROM lost_items WHERE id = ?");
            $del->execute([$id]);
        }
    }
}
header("Location: ../pages/lost_item.php");
exit();
?>