<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/AccidentsModel.php';

header('Content-Type: application/json');

$model = new AccidentsModel($pdo);

$startDate = trim($_GET['start_date'] ?? '');
$endDate = trim($_GET['end_date'] ?? '');
$state = trim($_GET['state'] ?? '');
$severity = trim($_GET['severity'] ?? '');
$weather = trim($_GET['weather'] ?? '');

if (!$startDate || !$endDate) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Missing required parameters: start_date and end_date are required.'
    ]);
    exit();
}

$start = DateTime::createFromFormat('Y-m-d', $startDate);
$end = DateTime::createFromFormat('Y-m-d', $endDate);
if (!$start || !$end) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Invalid date format. Use YYYY-MM-DD for start_date and end_date.'
    ]);
    exit();
}

try {
    $stats = $model->AccidentStats($startDate, $endDate, $state, $severity, $weather);
    echo json_encode($stats);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Server error while computing accident statistics.'
    ]);
}
