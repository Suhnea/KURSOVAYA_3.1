<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);
$name = trim(htmlspecialchars($data['name']));
$email = trim(htmlspecialchars($data['email']));
$pass = $data['password'];

$file = '../../data/users.json';
$users = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

if (array_filter($users, fn($u) => $u['email'] === $email)) {
    echo json_encode(['success' => false, 'message' => 'Email уже занят']);
    exit;
}

$newUser = [
    'id' => time(),
    'name' => $name,
    'email' => $email,
    'password' => password_hash($pass, PASSWORD_DEFAULT),
    'role' => 'volunteer'
];

$users[] = $newUser;
file_put_contents($file, json_encode($users, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo json_encode(['success' => true, 'message' => 'Регистрация прошла успешно!']);
?>