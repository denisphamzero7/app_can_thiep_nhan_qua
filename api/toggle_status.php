<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

$settingsFile = __DIR__ . '/../data/settings.json';
$settings = file_exists($settingsFile) ? json_decode(file_get_contents($settingsFile), true) : [];

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['is_active'])) {
    $settings['is_active'] = (bool)$input['is_active'];
}
if (isset($input['interval_minutes'])) {
    $settings['interval_minutes'] = max(1, (int)$input['interval_minutes']);
}
if (isset($input['daily_limit_minutes'])) {
    $settings['daily_limit_minutes'] = max(10, (int)$input['daily_limit_minutes']);
}
if (isset($input['target_grade'])) {
    $settings['target_grade'] = (string)$input['target_grade'];
}
if (isset($input['questions_to_pass'])) {
    $settings['questions_to_pass'] = max(1, (int)$input['questions_to_pass']);
}

$settings['updated_at'] = date('Y-m-d H:i:s');
file_put_contents($settingsFile, json_encode($settings, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo json_encode([
    'success' => true,
    'message' => 'Cập nhật cấu hình thành công',
    'data' => $settings
], JSON_UNESCAPED_UNICODE);
