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
![](Pasted%20image%2020241022163146.png)  
  
`dirb http://victim-ip/`  
	/html, /script, /script/javascript, /script/php  
  
`http://victim-ip/html/~` : 직접 경로 입력시 로그인 후 접근 할 수 있다는 경고 메시지  
`http://victim-ip/sciprt/~` : 직접 경로 입력 하더라도 접근가능한 메시지 없음  
  
# 2. /html/admin_dashboard.html (1 point)  
![Pasted%20image%2020241022164128.png](Pasted%20image%2020241022164128.png)  
패스워드 재설정 시 해당 아이디의 비밀번호 재설정 가능  
  
# 3-1. SQL Worksheet DB (1 point)  
`select * from GameDB.dbusers;` -> username:admin / role:db_admin 계정 확인  
`show databases;` : 일반유저(JY, MJ, JH, JiH)으로 실행 시  
![Pasted%20image%2020241022165007.png](Pasted%20image%2020241022165007.png)  
  
# 3-2. Burpsuite (2 point)  
`show databases;` : proxy intercept Request에 Requester 값 확인 -> 위에서 찾은 admin으로 변경 -> adminDB 발견  
	![](Pasted%20image%2020241022165509.png) -> ![](Pasted%20image%2020241022165522.png)  
![](Pasted%20image%2020241022165535.png)  
  
`select * from adminDB.linuxusers` : linux ID 및 PW 확인  
![Pasted%20image%2020241022171919.png](Pasted%20image%2020241022171919.png)  
  
# 4. John the Ripper (2)  
`vi password.txt`  
![Pasted%20image%2020241022173258.png](Pasted%20image%2020241022173258.png)  
`john --wordlist=/usr/share/dirbuster/wordlists/directory-list-2.3-small.txt password.txt` : ignite 1 에서 사용한 wordlist  
![Pasted%20image%2020241022173053.png](Pasted%20image%2020241022173053.png)  
  
# 5. admin/publications로 ssh 접속
![alt text]({98050B68-FCB6-461F-BB75-F358558BAA7E}.png)

# 6. c 코드 작성
```c
#include <stdio.h>

unsigned char ___hidden_key[] = {
	0x42, ...
}
unsigned int ___hidden_len = 2948;

int main() {
	FILE *fp;
	
	fp = fopen("restored_file", "wb");

	if (fp == NULL) {
		// perror("File open Fail");
		return 1;
	} 

	size_t written = fwrite(___hidden, 1, ___hidden_len, fp);
	if (written != ___hidden_len) {
		// perror("File Write Fail");
		fclose(fp);
		return 1;
	}

	printf("File Restored Success\n");
	fclose(fp);

	return 0;
}
```

# 7. gcc 빌드 후 실행

![alt text]({53E79D9A-6589-4FB0-B94B-DD0C7455EDE1}.png)

![alt text]({FEBA1167-7947-43EC-801D-E1B264620246}.png)

# 8. bzip2 압축 해제

![alt text]({118B4F97-9237-4E36-B25D-1F525F1DBC20}.png)
![alt text]({9BC793AB-E984-4CF8-AE07-EC5910C14628}.png)

# 9. 아카이브 해제

![alt text]({EDE7CEF0-8EC7-438F-B1CA-8567B28489A7}.png)

# 10. root 원격 접속 시도

![alt text]({91A24747-7A85-427C-BBE0-F227DB6ED7BB}.png)
