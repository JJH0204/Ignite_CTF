<?php
session_start();
header('Content-Type: application/json');

// 세션에서 사용자 이름 가져오기
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// 사용자 정보를 JSON으로 반환
echo json_encode([
    'username' => $username
]);
?>
