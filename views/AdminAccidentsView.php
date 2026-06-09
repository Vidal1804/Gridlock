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
            <div style="margin-bottom: 30px; margin-top: 10px;">
                <a href="/admin/users"><button class="nav-btn">Users</button></a>
                <a href="/admin/accidents"><button class="primary-btn nav-btn">Accidents</button></a>
            </div>
            <div id="userlist" class="accident-admin-list" style="gap: 20px;">
                <h1 style="margin-bottom: 5px">Import accident data using a .csv file</h1>
                <hr style="width: 300px">
                <h3 style="margin: 0">The structure of the .csv file must be formatted as such:</h3>
                <p style="margin: 0">(id, severity, start_time, end_time, start_lat, start_lng, distance_mi, city, state, weather_condition)</p>
                <hr style="width: 300px">
                <form action="/admin/uploadacc" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px; align-items: center; border: solid 2px #2e2e2e; padding: 20px; border-radius: 30px;">
                    <h2 style="margin: 0">Select CSV File:</h2>
                    <div class="form-group" style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
                        <input type="file" id="csv_file" name="csv_file" accept=".csv" required style="display: none;" onchange="updateFileName(this)">
                        <label for="csv_file" class="nav-btn primary-btn" style="border: 1px solid var(--border-color); display: inline-block; cursor: pointer; text-align: center;">
                            Choose CSV File
                        </label>
                        <span id="file-name" style="color: var(--text-subtle); font-size: 0.9rem;">No file selected.</span>
                    </div>
                    
                    <button class="primary-btn nav-btn" type="submit" name="submit">Upload and Import</button>
                </form>
                <?php if(isset($_GET['reply'])) echo "<h3>" . htmlspecialchars($_GET['reply'], ENT_QUOTES, 'UTF-8') . "</h3>"; ?>
            </div>
            
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileNameSpan = document.getElementById('file-name');
            if (input.files && input.files.length > 0) {
                fileNameSpan.textContent = input.files[0].name;
                fileNameSpan.style.color = "var(--text-main)";
            } else {
                fileNameSpan.textContent = "No file selected.";
                fileNameSpan.style.color = "var(--text-subtle)";
            }
        }
    </script>
    <script src="/public/js/admin-accidents.js"></script>
    <?php include 'Footer.php' ?>
</body> 