<?php
    // 사용자의 IP 주소 가져오기
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // IP 주소를 반환하기 위해서 간단히 JSON으로 출력
    echo json_encode(['ip' => htmlspecialchars($user_ip)]);
?>