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
$currentPin = $settings['parent_pin'] ?? '1234';

$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? 'login';

if ($action === 'login') {
    $pin = $input['pin'] ?? '';
    if ($pin === $currentPin) {
        echo json_encode([
            'success' => true,
            'message' => 'Đăng nhập thành công',
            'token' => md5($currentPin . '_parent_token_' . date('Y-m-d'))
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Mã PIN không đúng (Mặc định: 1234)'
        ], 401);
    }
    exit;
}

if ($action === 'change_pin') {
    $oldPin = $input['old_pin'] ?? '';
    $newPin = $input['new_pin'] ?? '';
    
    if ($oldPin !== $currentPin) {
        echo json_encode(['success' => false, 'message' => 'Mã PIN cũ không chính xác'], 400);
        exit;
    }
    if (strlen($newPin) < 4) {
        echo json_encode(['success' => false, 'message' => 'Mã PIN mới phải có ít nhất 4 chữ số'], 400);
        exit;
    }
    
    $settings['parent_pin'] = $newPin;
    $settings['updated_at'] = date('Y-m-d H:i:s');
    file_put_contents($settingsFile, json_encode($settings, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    
    echo json_encode(['success' => true, 'message' => 'Đổi mã PIN thành công']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ']);
