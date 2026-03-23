<?php
header('Content-Type: application/json; charset=utf-8');
$data = json_decode(file_get_contents('php://input'), true);
$id = (int)$data['id'];
$newStatus = $data['status'];

$file = '../data/applications.json';
$apps = json_decode(file_get_contents($file), true) ?? [];
foreach ($apps as &$app) {
    if ($app['id'] === $id) {
        $app['status'] = $newStatus;
        break;
    }
}
file_put_contents($file, json_encode($apps, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo json_encode(['success' => true]);
?>