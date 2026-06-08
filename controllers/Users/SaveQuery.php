<?php
require_once __DIR__ . "/../../config/db.php";
require_once __DIR__ . "/../../models/AccountsModel.php";

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$jsonRaw = file_get_contents('php://input');
$data = json_decode($jsonRaw, true);
$id = $data['id'] ?? null;
$queryString = $data['queryString'] ?? "";

if (!isset($_SESSION['role'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}

if (!$id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing user ID.']);
    exit();
}

try {
    if($queryString != ""){
        $model = new AccountsModel($pdo);
        $model->saveQuery($id, $queryString);
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save query.']);
}