<?php
require_once __DIR__ . '/../config/db.php'; 
require_once __DIR__ . '/../models/AccidentsModel.php';

header('Content-Type: application/json');

$model = new AccidentsModel($pdo);

$startDate = $_GET['start_date'] ?? '';
$endDate = $_GET['end_date'] ?? '';
$state = $_GET['state'] ?? '';
$severity = $_GET['severity'] ?? '';
$weather = $_GET['weather'] ?? '';

if (empty($state) && empty($severity) && empty($weather)) {
    $accidents = $model->SimpleAccidentQuery($startDate, $endDate);
} else {
    $accidents = $model->ComplexAccidentQuery($startDate, $endDate, $state, $severity, $weather);
}

echo json_encode($accidents);