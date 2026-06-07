<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Gridlock</title>
    <link rel="icon" href="/public/resources/favicon.ico">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body class="dashboard-page">
    <?php include 'Navigation.php' ?>
    <div class="dashboard-container">
        <div style="display:flex; flex-direction: column; align-items: center; width: 100%">
            <h1>User list</h1>
            <div id="userlist" class="user-list" style="gap: 20px;">
                
            </div>
        </div>
    </div>
    <script>
        const currentUserId = <?php echo json_encode($_SESSION['user_id'] ?? null); ?>;
    </script>
    <script src="/public/js/admin.js"></script>
    <?php include 'Footer.php' ?>
</body> 