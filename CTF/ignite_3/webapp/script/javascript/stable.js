// fetch 및 showTable 관련 JavaScript 코드 (변경 없음)
// IP 주소 가져오기 및 표시
fetch('../script/php/get_ip.php')
    .then(response => response.json()) // 응답 데이터를 JSON 형식으로 변환
    .then(data => {
        // IP 주소를 'user-ip' ID를 가진 요소에 표시
        document.getElementById('user-ip').textContent = data.ip;
    })
    .catch(error => {
        // IP를 가져오는 도중 에러 발생 시 콘솔에 에러 메시지 출력
        console.error('Error fetching IP:', error);
        // 'user-ip' ID를 가진 요소에 'IP 가져오기 실패' 메시지 표시
        document.getElementById('user-ip').textContent = 'IP 가져오기 실패';
    });

// 사이드바 토글 기능 구현
const toggleSidebarBtn = document.getElementById('toggleSidebarBtn'); // 사이드바 토글 버튼 요소
const sidebar = document.getElementById('sidebar'); // 사이드바 요소
const mainContent = document.getElementById('mainContent'); // 메인 콘텐츠 요소

// 페이지 로드 시 사이드바가 열린 상태로 설정
window.addEventListener('DOMContentLoaded', function() {
    sidebar.style.left = "0"; // 사이드바를 보이게 설정
    mainContent.classList.add('active'); // 메인 콘텐츠에 'active' 클래스 추가
});

// 토글 버튼 클릭 이벤트 리스너 추가
toggleSidebarBtn.addEventListener('click', function () {
    // 사이드바가 숨겨져 있는지 확인
    if (sidebar.style.left === "-200px") {
        // 숨겨져 있다면 사이드바를 보이게 설정
        sidebar.style.left = "0";
        mainContent.classList.add('active'); // mainContent에 'active' 클래스 추가
    } else {
        // 보이는 상태라면 사이드바를 숨김
        sidebar.style.left = "-200px";
        mainContent.classList.remove('active'); // mainContent에서 'active' 클래스 제거
    }
});

// 로그아웃 버튼 클릭 시 로그인 페이지로 이동
const logoutBtn = document.getElementById('logoutBtn'); // 로그아웃 버튼 요소
logoutBtn.addEventListener('click', function () {
    // 클릭 시 로그인 페이지로 이동
    window.location.href = 'login.html';
});

// 비밀번호 재설정 버튼 클릭 시 이벤트
document.querySelectorAll('.reset_btn').forEach(function(button) {
    button.addEventListener('click', function() {
        const username = this.closest('tr').querySelector('td:first-child').innerText; // 해당 아이디 가져오기
        const modal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
        modal.show();

        document.getElementById('confirmResetBtn').onclick = function() {
            const newPassword = document.getElementById('newPassword').value;\

            if (newPassword) {
                // 비밀번호 변경 요청
                fetch('../php/update_password.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ username, newPassword })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    modal.hide();
                    // 페이지 새로 고침 또는 사용자 리스트 갱신
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                alert('새 비밀번호를 입력해 주세요.');
            }
        };
    });
});


