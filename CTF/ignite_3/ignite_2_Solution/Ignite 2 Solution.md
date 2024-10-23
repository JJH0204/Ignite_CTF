## To do!
adminDB.linuxusers password 바꾸기
network auto 설정

---
DB
	admin - adminPAssWOrd
	JY - jyPAssWOrd
	MJ - mjPAssWOrd
	JH - jhPAssWOrd
	JiH - jihPAssWOrd
	public - public
Linux
	root - i0oH3aemxD7T71tPr1nK
	admin - publications
	JY - technology
	MJ - calendar
	JH - stories
	JiH - photos

# 1. 사전 탐색 (1 point)
`nmap victim ip`
![[Pasted image 20241022163146.png]]

`dirb http://victim-ip/`
	/html, /script, /script/javascript, /script/php

`http://victim-ip/html/~` : 직접 경로 입력시 로그인 후 접근 할 수 있다는 경고 메시지
`http://victim-ip/sciprt/~` : 직접 경로 입력 하더라도 접근가능한 메시지 없음

# 2. /html/admin_dashboard.html (1 point)
![[Pasted image 20241022164128.png]]
패스워드 재설정 시 해당 아이디의 비밀번호 재설정 가능

# 3-1. SQL Worksheet DB (1 point)
`select * from GameDB.dbusers;` -> username:admin / role:db_admin 계정 확인
`show databases;` : 일반유저(JY, MJ, JH, JiH)으로 실행 시
	![[Pasted image 20241022165007.png]]

# 3-2. Burpsuite (2 point)
`show databases;` : proxy intercept Request에 Requester 값 확인 -> 위에서 찾은 admin으로 변경 -> adminDB 발견
	![[Pasted image 20241022165509.png]] -> ![[Pasted image 20241022165522.png]]
	![[Pasted image 20241022165535.png]]

`select * from adminDB.linuxusers` : linux ID 및 PW 확인
	![[Pasted image 20241022171919.png]]

# 4. John the Ripper (2)
`vi password.txt`
	![[Pasted image 20241022173258.png]]
`john --wordlist=/usr/share/dirbuster/wordlists/directory-list-2.3-small.txt password.txt` : ignite 1 에서 사용한 wordlist
	![[Pasted image 20241022173053.png]]

# 5. admin/publications로 ssh 접속