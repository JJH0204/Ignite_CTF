function executeQuery() {
    // 사용자가 입력한 SQL 쿼리 가져오기
    const sqlQuery = document.querySelector('.sql-editor').value;

    // 쿼리가 비어있지 않은지 확인
    if (!sqlQuery.trim()) {
        alert("SQL 쿼리를 입력해주세요.");
        return;
    }

    // PHP 파일로 SQL 쿼리 전송 (AJAX 사용)
    fetch('script/php/execute_query.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'sql': sqlQuery
        })
    })
    .then(response => response.json())
    .then(data => {
        // 쿼리 결과를 출력 영역에 표시
        const outputElement = document.getElementById('sqlOutput');
        outputElement.innerHTML = '';

        if (data.error) {
            // 오류 메시지 표시
            outputElement.innerHTML = `<p style="color: red;">${data.error}</p>`;
        } else if (data.message) {
            // 결과가 없을 때 메시지 표시
            outputElement.innerHTML = `<p>${data.message}</p>`;
        } else {
            // 결과가 있을 때 테이블로 표시
            let table = '<table class="table"><thead><tr>';
            const keys = Object.keys(data[0]);

            // 테이블 헤더 생성
            keys.forEach(key => {
                table += `<th>${key}</th>`;
            });
            table += '</tr></thead><tbody>';

            // 테이블 행 생성
            data.forEach(row => {
                table += '<tr>';
                keys.forEach(key => {
                    table += `<td>${row[key]}</td>`;
                });
                table += '</tr>';
            });
            table += '</tbody></table>';

            outputElement.innerHTML = table;
        }
    })
    .catch(error => {
        console.error("쿼리 실행 중 오류 발생:", error);
        document.getElementById('sqlOutput').innerHTML = `<p style="color: red;">쿼리 실행 중 오류가 발생했습니다.</p>`;
    });
}
