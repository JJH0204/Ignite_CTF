<?php
header('Content-Type: application/json');

$jsonFile = '../../json/users.json';

if (!file_exists($jsonFile)) {
    echo json_encode(['success' => false, 'error' => '파일이 존재하지 않습니다.']);
    exit;
}

$data = json_decode(file_get_contents($jsonFile), true);
if ($data === null) {
    echo json_encode(['success' => false, 'error' => 'JSON 파싱 오류: ' . json_last_error_msg()]);
    exit;
}

$username = $_POST['username']; // username을 POST로부터 가져옵니다.
$password = $_POST['password']; // password를 POST로부터 가져옵니다.

// 로그인 검증
$authenticated = false;
foreach ($data as $user) {
    if ($user['username'] === $username && $user['password'] === $password) {
        $authenticated = true;
        break;
    }
}

if ($authenticated) {
    session_start(); // 세션 시작
    $_SESSION['username'] = $username; // 세션에 사용자 ID 저장
    $_SESSION['password'] = $password; // 세션에 사용자 PW 저장

    // JSON 응답에 사용자 이름 포함
    echo json_encode(['success' => true, 'username' => $username]);
} else {
    echo json_encode(['success' => false]);
}
?>
