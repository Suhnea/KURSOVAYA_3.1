<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json; charset=utf-8');

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

$email    = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email и пароль обязательны']);
    exit;
}

$file = '../../data/users.json';
if (!file_exists($file)) {
    echo json_encode(['success' => false, 'message' => 'База пользователей не найдена']);
    exit;
}

$users = json_decode(file_get_contents($file), true) ?: [];

$user = null;
foreach ($users as $u) {
    if ($u['email'] === $email) {
        $user = $u;
        break;
    }
}

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name']    = $user['name'];
    $_SESSION['role']    = 'volunteer';

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Неверный email или пароль']);
}
?>