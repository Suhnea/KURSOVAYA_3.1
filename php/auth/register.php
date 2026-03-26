<?php
// Включаем отображение ошибок для отладки (убери потом!)
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Метод запроса должен быть POST']);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Неверный JSON: ' . json_last_error_msg()]);
    exit;
}

$name     = trim(htmlspecialchars($data['name'] ?? ''));
$email    = trim(htmlspecialchars($data['email'] ?? ''));
$password = $data['password'] ?? '';

if (empty($name) || empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Все поля обязательны']);
    exit;
}

if (strlen($password) < 6) {
    echo json_encode(['success' => false, 'message' => 'Пароль должен быть не менее 6 символов']);
    exit;
}

$file = '../../data/users.json';

if (!is_dir('../../data')) {
    mkdir('../../data', 0777, true);
}

$users = [];
if (file_exists($file)) {
    $json = file_get_contents($file);
    $users = json_decode($json, true) ?: [];
}

// Проверка на существующий email
foreach ($users as $u) {
    if ($u['email'] === $email) {
        echo json_encode(['success' => false, 'message' => 'Этот email уже зарегистрирован']);
        exit;
    }
}

$newUser = [
    'id'       => time(),
    'name'     => $name,
    'email'    => $email,
    'password' => password_hash($password, PASSWORD_DEFAULT),
    'role'     => 'volunteer'
];

$users[] = $newUser;

if (file_put_contents($file, json_encode($users, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'message' => 'Регистрация прошла успешно! Теперь войдите в кабинет.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Не удалось сохранить данные. Проверьте права на папку data/']);
}
?>