function executeQuery() {
    // 사용자가 입력한 SQL 쿼리 가져오기
    const sqlQuery = document.querySelector('.sql-editor').value;
    
    // 쿼리가 비어있지 않은지 확인
    if (!sqlQuery.trim()) {
        alert("SQL 쿼리를 입력해주세요.");
        return;
    }

    const username = sessionStorage.getItem('username');
    const encoded_username = btoa(username);
    const phpFile = '/script/php/execute_query.php';
    const phpFileWithParam = `${phpFile}?username=${encodeURIComponent(username)}`; 

    // PHP 파일로 SQL 쿼리 전송 (AJAX 사용)
    fetch(phpFileWithParam, {
        method: 'POST', // HTTP POST 요청을 사용하여 데이터를 전송함
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded', // 요청의 데이터 형식을 URL 인코딩 형식으로 설정
            'Requester': encoded_username, // 요청 헤더에 사용자 이름 추가
        },
        body: new URLSearchParams({
            'sql': sqlQuery // 전송할 데이터로 사용자가 입력한 SQL 쿼리를 설정함
        })
    })
    .then(response => response.json()) // 서버로부터 받은 응답을 JSON 형식으로 파싱
    .then(data => {
        // 쿼리 결과를 출력 영역에 표시
        const outputElement = document.getElementById('sqlOutput'); // 결과를 표시할 HTML 요소를 찾음
        outputElement.innerHTML = ''; // 이전에 출력된 내용을 초기화

        if (data.error) {
            // 오류 메시지 표시
            outputElement.innerHTML = `<p style="color: red;">${data.error}</p>`; // 오류가 발생한 경우 오류 메시지를 빨간색으로 출력
        } else if (data.message) {
            // 결과가 없을 때 메시지 표시
            outputElement.innerHTML = `<p>${data.message}</p>`; // 결과가 없을 경우 메시지를 출력
        } else {
            // 결과가 있을 때 테이블로 표시
            let table = '<table class="table"><thead><tr>'; // 결과를 표시할 테이블 HTML 생성
            const keys = Object.keys(data[0]); // 결과 객체의 첫 번째 요소에서 컬럼 이름들을 가져옴

            // 테이블 헤더 생성
            keys.forEach(key => {
                table += `<th>${key}</th>`; // 각 컬럼 이름을 테이블 헤더로 추가
            });
            table += '</tr></thead><tbody>';

            // 테이블 행 생성
            data.forEach(row => {
                table += '<tr>'; // 각 결과 행을 시작
                keys.forEach(key => {
                    table += `<td>${row[key]}</td>`; // 각 컬럼 값을 테이블 데이터로 추가
                });
                table += '</tr>'; // 결과 행 종료
            });
            table += '</tbody></table>';

            outputElement.innerHTML = table; // 최종 생성된 테이블을 출력 영역에 추가
        }
    })
    .catch(error => {
        console.error("쿼리 실행 중 오류 발생:", error); // 콘솔에 오류 내용을 출력
        document.getElementById('sqlOutput').innerHTML = `<p style="color: red;">쿼리 실행 중 오류가 발생했습니다.</p>`; // 사용자에게 오류 메시지를 표시
    });
}
