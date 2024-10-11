<?php
header('Content-Type: application/json');

$jsonFile = 'users.json';

if (!file_exists($jsonFile)) {
    echo json_encode(['success' => false, 'error' => '파일이 존재하지 않습니다.']);
    exit;
}

$data = json_decode(file_get_contents($jsonFile), true);
if ($data === null) {
    echo json_encode(['success' => false, 'error' => 'JSON 파싱 오류: ' . json_last_error_msg()]);
    exit;
}

$username = $_POST['username'];
$password = $_POST['password'];

// 로그인 검증
$authenticated = false;
foreach ($data as $user) {
    if ($user['username'] === $username && $user['password'] === $password) {
        $authenticated = true;
        break;
    }
}

if ($authenticated) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>

