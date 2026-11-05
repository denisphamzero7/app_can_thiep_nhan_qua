<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

$questionsFile = __DIR__ . '/../data/questions.json';
$questions = file_exists($questionsFile) ? json_decode(file_get_contents($questionsFile), true) : [];

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['action']) && $input['action'] === 'delete') {
    $id = (int)$input['id'];
    $questions = array_values(array_filter($questions, fn($q) => $q['id'] !== $id));
    file_put_contents($questionsFile, json_encode($questions, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo json_encode(['success' => true, 'message' => 'Đã xóa câu hỏi']);
    exit;
}

// Add new question
if (!empty($input['question_text'])) {
    $newId = empty($questions) ? 1 : (max(array_column($questions, 'id')) + 1);
    
    $newQuestion = [
        'id' => $newId,
        'grade' => $input['grade'] ?? 'mam_non',
        'category' => $input['category'] ?? 'nhan_biet',
        'question_text' => $input['question_text'],
        'speech_text' => $input['speech_text'] ?: $input['question_text'],
        'options' => $input['options'] ?? []
    ];
    
    $questions[] = $newQuestion;
    file_put_contents($questionsFile, json_encode($questions, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    
    echo json_encode([
        'success' => true,
        'message' => 'Đã thêm câu hỏi thành công',
        'data' => $newQuestion
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
