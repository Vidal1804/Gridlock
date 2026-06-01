<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Error';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gridlock</title>
    <link rel="icon" href="../favicon.ico">
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

    <header class="top-nav">
        <span class="nav-user">Welcome, <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');?>!</span>
        <form method="post" action="/logout" style="margin: 0;">
            <input type="submit" value="Log out" class="nav-btn primary-btn">
        </form>
    </header>

    <main class="dashboard-container">
        
        <aside class="control-panel">
            <h2>Filter Incident Data</h2>
            <form id="filter-form" method="get" action="/api/accidents">
                
                
                <div class="form-group">
                    <label for="start-date">Start Date</label>
                    <input type="date" id="start-date" name="start_date" required>
                </div>
                <div class="form-group">
                    <label for="end-date">End Date</label>
                    <input type="date" id="end-date" name="end_date" required>
                </div>

                <hr>

                
                <h3>Multi-Criteria Search</h3>
                <div class="form-group">
                    <label for="search-state">State</label>
                    <input type="text" id="search-state" name="state" placeholder="e.g. CA, NY">
                </div>
                <div class="form-group">
                    <label for="search-severity">Severity Level</label>
                    <select id="search-severity" name="severity">
                        <option value="">All Severities</option>
                        <option value="1">1 (Low)</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4 (High)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="search-weather">Weather Condition</label>
                    <input type="text" id="search-weather" name="weather" placeholder="e.g. Rain, Clear">
                </div>

                <button type="submit" class="nav-btn primary-btn full-width">Apply Filters</button>
            </form>

            <hr>

            <h3>Export Options</h3>
            <div class="export-actions">
                <button type="button" id="export-csv" class="nav-btn full-width">Export CSV</button>
                <button type="button" id="export-webp" class="nav-btn full-width">Export WebP</button>
                <button type="button" id="export-svg" class="nav-btn full-width">Export SVG</button>
            </div>
        </aside>

        <section class="display-panel">
            <div class="visual-card map-card">
                <h3>Geographic Map Representation</h3>
                <div id="accident-map" class="placeholder-box">
                    <p class="info-subtitle">Interactive map rendering service loaded here</p>
                </div>
            </div>

            <div class="stats-grid">
                <div class="visual-card">
                    <h3>Format 1: Timeline Analysis</h3>
                    <div id="chart-timeline" class="placeholder-box">
                        <p class="info-subtitle">Chart visualization (e.g., SVG-based Bar Chart)</p>
                    </div>
                </div>
                <div class="visual-card">
                    <h3>Format 2: Distribution by State</h3>
                    <div id="chart-pie" class="placeholder-box">
                        <p class="info-subtitle">Chart visualization (e.g., Donut Chart)</p>
                    </div>
                </div>
                <div class="visual-card">
                    <h3>Format 3: Metric Matrix</h3>
                    <div id="chart-matrix" class="placeholder-box">
                        <p class="info-subtitle">Data visualization grid / Heatmap table</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

</body>
</html>