<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Неверный метод запроса']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$name = trim(htmlspecialchars($data['name'] ?? ''));
$email = trim(htmlspecialchars($data['email'] ?? ''));
$password = $data['password'] ?? '';

if (strlen($name) < 3 || strlen($email) < 5 || strlen($password) < 6) {
    echo json_encode(['success' => false, 'message' => 'Заполните все поля корректно (пароль минимум 6 символов)']);
    exit;
}

$file = '../../data/users.json';
$users = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

if (array_filter($users, fn($u) => $u['email'] === $email)) {
    echo json_encode(['success' => false, 'message' => 'Этот email уже зарегистрирован']);
    exit;
}

$newUser = [
    'id'       => time(),
    'name'     => $name,
    'email'    => $email,
    'password' => password_hash($password, PASSWORD_DEFAULT),
    'role'     => 'volunteer'
];

$users[] = $newUser;
file_put_contents($file, json_encode($users, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo json_encode(['success' => true, 'message' => 'Регистрация прошла успешно! Теперь вы можете войти.']);
?>