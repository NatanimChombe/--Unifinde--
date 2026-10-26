<?php
require_once '../includes/db.php';

if (isset($_POST['submit_found'])) {
    $finder_name  = $_POST['finder_name'];
    $finder_id    = $_POST['finder_id'];
    $phone_number = $_POST['phone_number'];
    $item_name    = $_POST['item_name'];
    $description  = $_POST['description'];
    $date_found   = !empty($_POST['date_found']) ? $_POST['date_found'] : null;
    $place_found  = !empty($_POST['place_found']) ? $_POST['place_found'] : null;

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
        $sql = "INSERT INTO found_items (finder_name, finder_id, phone_number, item_name, description, item_photo, date_found, place_found) 
                VALUES (:finder_name, :finder_id, :phone_number, :item_name, :description, :item_photo, :date_found, :place_found)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':finder_name'  => $finder_name,
            ':finder_id'    => $finder_id,
            ':phone_number' => $phone_number,
            ':item_name'    => $item_name,
            ':description'  => $description,
            ':item_photo'   => $photo_path,
            ':date_found'   => $date_found,
            ':place_found'  => $place_found
        ]);

        header("Location: ../pages/found_item.php?success=1");
        exit();
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
}
?>