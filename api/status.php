<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

$settingsFile = __DIR__ . '/../data/settings.json';
if (!file_exists($settingsFile)) {
    echo json_encode(['success' => false, 'message' => 'Settings not found']);
    exit;
}

$data = json_decode(file_get_contents($settingsFile), true);
echo json_encode([
    'success' => true,
    'data' => $data
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
