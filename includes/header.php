<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniFind - Campus Property Recovery System</title>
    <link rel="stylesheet" href="<?php echo isset($is_page) ? '../asset/css/style.css' : 'asset/css/style.css'; ?>">
    <script src="<?php echo isset($is_page) ? '../asset/js/main.js' : 'asset/js/main.js'; ?>" defer></script>
</head>
<body>
    <header>
        <div class="logo">
            <h2>UniFind</h2>
        </div>
        <nav>
            <a href="<?php echo isset($is_page) ? '../index.php' : 'index.php'; ?>">Home</a>
            <a href="<?php echo isset($is_page) ? 'lost_item.php' : 'pages/lost_item.php'; ?>">Lost Items</a>
            <a href="<?php echo isset($is_page) ? 'found_item.php' : 'pages/found_item.php'; ?>">Found Items</a>
            <a href="<?php echo isset($is_page) ? 'register_lost.php' : 'pages/register_lost.php'; ?>" class="btn-nav">Register Lost Item</a>
            <a href="<?php echo isset($is_page) ? 'register_found.php' : 'pages/register_found.php'; ?>" class="btn-nav">Register Found Items</a>
        </nav>
    </header>
    <main class="container">