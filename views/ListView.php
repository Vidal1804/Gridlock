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

                
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                    <h3 style="margin: 0;">Multi-Criteria Search</h3>
                    <label class="switch">
                        <input type="checkbox" id="switch-mcs">
                        <span class="slider"></span>
                    </label>
                </div>
                <div id="advanced-form" class="hidden-box hide">
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
                        <option value="Clear">Clear</option>
                        <option value="Cloudy">Cloudy</option>
                        <option value="Rain">Rain</option>
                        <option value="Snow">Snow</option>
                        <option value="Fog">Fog</option>
                        <option value="Severe Storm">Severe Storm</option>
                    </select>
                </div>
                </div>
                <button type="submit" class="nav-btn primary-btn full-width">Apply Filters</button>
            </form>

            <hr>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                    <h3 style="margin: 0;">Export Options</h3>
                    <label class="switch">
                        <input type="checkbox" id="switch-export">
                        <span class="slider"></span>
                    </label>
                </div>
            <div id="export-container" class="hidden-box hide">
                <button style="margin-bottom: 10px" type="button" id="export-csv-btn" class="nav-btn primary-btn full-width">Export CSV</button>
                <button style="margin-bottom: 10px" type="button" id="save-query-btn" class="nav-btn primary-btn full-width">Save Query</button>
            </div>

        </aside>

        <section class="display-panel">
            <div class="visual-card map-card">
                <h3>List View of Accidents</h3>
                <div id="accident_list" class="scrollable-box">
                    <h1>Loading...</h1>
                </div>
            </div>
        </section>
    </div>
    <script src="/public/js/dashboard-toggle.js"></script>
    <script>
        const currentUserId = <?php echo json_encode($_SESSION['user_id'] ?? null); ?>;
    </script>
    <script src="/public/js/list.js"></script>
    <?php include 'Footer.php' ?>
</body>