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
<body class="dashboard-page">

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
                    <select id="search-state" name="state">
                        <option value="">Any State</option>
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                    </select>
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
                    <select id="search-weather" name="weather">
                        <option value="">Any weather</option>
                        <option value="1">Clear</option>
                        <option value="2">Light Rain</option>
                        <option value="3">Heavy Rain</option>
                        <option value="4">Fog</option>
                        <option value="5">Thunderstorm</option>
                    </select>
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
                <h3>Geographic Map</h3>
                <div id="accident-map" class="placeholder-box">
                    <p class="info-subtitle">map work in progress</p>
                </div>
            </div>

            <div class="stats-grid">
                <div class="visual-card">
                    <h3>Timeline Analysis</h3>
                    <div id="chart-timeline" class="placeholder-box">
                        <p class="info-subtitle">chart 1 wip</p>
                    </div>
                </div>
                <div class="visual-card">
                    <h3>Distribution by State</h3>
                    <div id="chart-pie" class="placeholder-box">
                        <p class="info-subtitle">chart 2 wip</p>
                    </div>
                </div>
                <div class="visual-card">
                    <h3>Metric Matrix</h3>
                    <div id="chart-matrix" class="placeholder-box">
                        <p class="info-subtitle">chart 3 wip</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

</body>
</html>