<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');          // для локальной разработки
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
    exit;
}

// обязательные поля
$required = ['name', 'email', 'phone', 'vacancy'];
foreach ($required as $field) {
    if (empty(trim($data[$field] ?? ''))) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => "Поле $field обязательно"]);
        exit;
    }
}

$name    = htmlspecialchars(trim($data['name']),    ENT_QUOTES, 'UTF-8');
$email   = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
$phone   = htmlspecialchars(trim($data['phone']),   ENT_QUOTES, 'UTF-8');
$vacancy = htmlspecialchars(trim($data['vacancy']), ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars(trim($data['message'] ?? ''), ENT_QUOTES, 'UTF-8');

if (!$email) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Некорректный email']);
    exit;
}

$file = __DIR__ . '/../../data/applications.json';

$applications = [];
if (file_exists($file)) {
    $json = file_get_contents($file);
    $applications = json_decode($json, true) ?: [];
}

$newApplication = [
    'id'      => time() . rand(100,999),   // простой уникальный id
    'name'    => $name,
    'email'   => $email,
    'phone'   => $phone,
    'vacancy' => $vacancy,
    'message' => $message,
    'date'    => date('Y-m-d H:i:s'),
    'status'  => 'new'
];

$applications[] = $newApplication;

$options = JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES;
$success = file_put_contents($file, json_encode($applications, $options));

if ($success === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Не удалось сохранить файл']);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Заявка успешно отправлена'
]);