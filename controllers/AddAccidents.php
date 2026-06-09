<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/AccidentsModel.php";

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] === 'user') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}

if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing or invalid CSV file upload.']);
    exit();
}

try {
    $tmpName = $_FILES['csv_file']['tmp_name'];

    $model = new AccidentsModel($pdo);
    $success = $model->importCSV($tmpName);

    if ($success) {
        header("Location: /admin/accidents?reply=Success");
    } else {
        http_response_code(500);
        header("Location: /admin/accidents?reply=Failure");
    }
} catch (Exception $e) {
    http_response_code(500);
    $errorMessage = urlencode($e->getMessage());
    header("Location: /admin/accidents?reply=$errorMessage");
}