<?php
header('Content-Type: application/json; charset=utf-8');
$data = json_decode(file_get_contents('php://input'), true);
$id = (int)$data['id'];

$file = '../data/applications.json';
$apps = json_decode(file_get_contents($file), true) ?? [];
$apps = array_filter($apps, fn($a) => $a['id'] !== $id);
file_put_contents($file, json_encode(array_values($apps), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo json_encode(['success' => true]);
?>