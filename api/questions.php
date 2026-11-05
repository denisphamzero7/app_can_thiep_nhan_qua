<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

$questionsFile = __DIR__ . '/../data/questions.json';
$questions = file_exists($questionsFile) ? json_decode(file_get_contents($questionsFile), true) : [];

$grade = isset($_GET['grade']) ? trim($_GET['grade']) : 'all';

if ($grade !== 'all' && !empty($grade)) {
    $filtered = array_values(array_filter($questions, function($q) use ($grade) {
        return isset($q['grade']) && $q['grade'] === $grade;
    }));
} else {
    $filtered = $questions;
}

echo json_encode([
    'success' => true,
    'total' => count($filtered),
    'data' => $filtered
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
