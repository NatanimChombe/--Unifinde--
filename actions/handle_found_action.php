<?php
session_start();
require_once '../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$action  = $_POST['action'] ?? '';
$id      = $_POST['id'] ?? '';

if ($id) {
    // Verify that the logged-in user owns this specific found item
    $stmt = $pdo->prepare("SELECT * FROM found_items WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    $item = $stmt->fetch();

    if ($item) {
        if ($action === 'delete') {
            // Optional: Delete the image file from server
            if (!empty($item['item_photo']) && file_exists('../' . $item['item_photo'])) {
                unlink('../' . $item['item_photo']);
            }

            // Delete from database
            $del = $pdo->prepare("DELETE FROM found_items WHERE id = ?");
            $del->execute([$id]);
        }
    }
}

// Redirect back to the found items registry
header("Location: ../pages/found_item.php");
exit();
?>