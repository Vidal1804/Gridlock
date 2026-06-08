<?php
$username = isset($_SESSION['user_id']) ? $_SESSION['username'] : "Error";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gridlock</title>
    <link rel="icon" href="/public/resources/favicon.ico">
    <link rel="stylesheet" href="/public/css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body class="dashboard-page">
    <?php include 'Navigation.php' ?>
    <div class="dashboard-container">
        <div style="display:flex; flex-direction: column; align-items: center; width: 100%;">
            <img src="/public/resources/user.png" style="max-width: 100px; max-height: 100px;">
            <h1 style="margin-bottom: 5px;"><?php echo htmlspecialchars($username, ENT_QUOTES, "UTF-8"); ?></h1>
            <p style="margin: 0; margin-bottom: 10px;">View your saved queries here:</p>
            <div id="querylist" class="query-list" style="gap: 20px;">
                
            </div>
        </div>
    </div>
    <?php include 'Footer.php' ?>
    <script src="public/js/profile.js"></script>
</body>