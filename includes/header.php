<?php
// Automatically detect if we are in the root directory or inside /pages/
$in_pages = strpos($_SERVER['PHP_SELF'], '/pages/') !== false;
$root_path = $in_pages ? '../' : '';
$pages_path = $in_pages ? '' : 'pages/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniFind - Campus Property Recovery System</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            background: #f4f6f9; 
            color: #333; 
        }
        header { 
            background: #004080; 
            color: white; 
            padding: 40px 60px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            flex-wrap: wrap; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            /* REMOVED fixed height to allow proper spacing */
        }
        header h2 { 
            margin: 0; 
            font-size: 22px; 
            letter-spacing: 0.5px;
        }
        nav { 
            display: flex; 
            gap: 10px; 
            align-items: center; 
            flex-wrap: wrap; 
        }
        nav a { 
            background: #ff6600; /* Matching button style for all nav links */
            color: white; 
            padding: 8px 14px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 13px; 
            font-weight: bold; 
            transition: background 0.2s; 
        }
        nav a:hover { 
            background: #e65c00; /* Darker orange on hover */
        }
        /* Accent style for register buttons */
        .btn-register { 
            background: #ff6600 !important; 
        }
        .btn-register:hover { 
            background: #e65c00 !important; 
        }
        .container { 
            max-width: 900px; 
            margin: 30px auto; 
            background: #fff; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.08); 
        }
        footer { 
            background-color: #004080;
            text-align: center; 
            padding: 60px; 
            color: #ffffff; /* Changed to white so it's readable on dark blue */
            font-size: 13px; 
            margin-top: 40px; 
            border-top: 1px solid #ddd;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

    <header>
        <h2>UniFind</h2>
        <nav>
            <a href="<?php echo $root_path; ?>index.php">Home</a>
            <a href="<?php echo $pages_path; ?>lost_item.php">Lost Items</a>
            <a href="<?php echo $pages_path; ?>found_item.php">Found Items</a>
            <a href="<?php echo $pages_path; ?>register_lost.php" class="btn-register">Register Lost Item</a>
            <a href="<?php echo $pages_path; ?>register_found.php" class="btn-register">Register Found Item</a>
        </nav>
    </header>

    <div class="container">