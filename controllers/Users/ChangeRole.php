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

if (!isset($_SESSION['role']) || $_SESSION['role'] === 'user') {
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
    $model = new AccountsModel($pdo);
    $user = $model->findUserByID($id);
    if($user['role'] === 'user'){
        $role = 'admin';
    }
    else $role = 'user';
    $model->changeUserRole($id, $role);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to change user\'s role.']);
}