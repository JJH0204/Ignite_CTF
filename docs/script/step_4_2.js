document.addEventListener('DOMContentLoaded', function () {
    var outputBox = document.getElementById('markdown-content');
    var submitButton = document.getElementById('submit-button');
    var userInput = document.getElementById('user-input');
    var resultMessage = document.getElementById('result-message');


      // 개발자가 설정한 정답 (암호)
    var correctAnswer = 'aWduaXRlIHN0ZXAyIHJvb3QgZmxhZw=='; // 여기에 암호(정답)를 설정

    // 마크다운 파일 경로 (개발자가 지정)
    var filePath = '../markdown/Step_4_2.md'; // 마크다운 파일의 경로

    // 마크다운 파일 불러오기 (로컬에서 fetch를 사용할 경우 서버가 필요함)
    fetch(filePath)
        .then(response => {
            if (!response.ok) {
                throw new Error('파일을 불러오는 데 실패했습니다.');
            }
            return response.text();
        })
        .then(markdownText => {
            // 마크다운 파일 내용을 HTML로 변환하여 출력
            outputBox.innerHTML = marked.parse(markdownText);
        })
        .catch(error => {
            outputBox.textContent = error.message;
        });

    // 확인 버튼 클릭 이벤트
    submitButton.addEventListener('click', function () {
        var userAnswer = userInput.value.trim();

        if (!correctAnswer) {
            resultMessage.textContent = '퀴즈 정답이 없습니다.';
            resultMessage.style.color = 'red';
            return;
        }

        if (userAnswer === correctAnswer) {
            resultMessage.textContent = '정답입니다!';
            resultMessage.style.color = 'green';

            window.location.href = '../html/step_5.html';
        } else {
            resultMessage.textContent = '오답입니다. 다시 시도하세요.';
            resultMessage.style.color = 'red';
        }
    });
});
