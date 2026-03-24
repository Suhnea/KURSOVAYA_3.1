<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);

$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Заполните все поля']);
    exit;
}

$file = '../../data/users.json';
$users = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

$user = array_filter($users, fn($u) => $u['email'] === $email);
$user = reset($user);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name']    = $user['name'];
    $_SESSION['role']    = 'volunteer';

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Неверный email или пароль']);
}
?>