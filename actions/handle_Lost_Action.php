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
            $del = $pdo->prepare("DELETE FROM lost_items WHERE id = ?");
            $del->execute([$id]);
        } elseif ($action === 'found') {
            // 1. Migrate data to resolved_items table
            $mig = $pdo->prepare("INSERT INTO resolved_items (original_lost_id, user_id, student_name, phone_number, item_name, special_sign, item_photo, date_lost, place_lost) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $mig->execute([
                $item['id'], $item['user_id'], $item['student_name'], $item['phone_number'], 
                $item['item_name'], $item['special_sign'], $item['item_photo'], $item['date_lost'], $item['place_lost']
            ]);

            // 2. Delete from active lost_items table
            $del = $pdo->prepare("DELETE FROM lost_items WHERE id = ?");
            $del->execute([$id]);
        }
    }
}
header("Location: ../pages/lost_item.php");
exit();
?>