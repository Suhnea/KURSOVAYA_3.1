<?php
header('Content-Type: application/json; charset=utf-8');
$file = '../data/applications.json';
$apps = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
echo json_encode($apps);
?>