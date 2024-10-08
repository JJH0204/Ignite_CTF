# CTF 시나리오: 웹 사이트 해킹 후 권한 상승을 통한 관리자 데이터 접근

## 시나리오 배경
- 공격자는 웹사이트 취약점을 악용하여 **PC의 일반 사용자 계정**에 접근할 수 있는 **아이디와 비밀번호**를 획득했다.
- 목표 데이터는 **관리자 권한**을 통해서만 접근할 수 있다.
- 공격자는 일반 사용자 계정으로 로그인한 후, 권한 상승을 통해 **관리자 권한**을 획득하고 시스템에 저장된 중요한 데이터를 찾아야 한다.

## CTF 구성 요소

### 공격자가 접근할 시스템 구성
- **운영체제**: Windows 10 (패치되지 않은 구버전)
- **사용자 계정**:
  - 일반 사용자 계정: **user1**
    - 사용자명: `user1`
    - 비밀번호: `password123` (공격자가 웹사이트 해킹으로 획득한 비밀번호)
  - 관리자 계정: **admin**
    - 사용자명: `admin`
    - 비밀번호는 공격자가 모름.
    - 관리자 계정의 데스크톱에 중요한 데이터가 있는 **flag.txt** 파일이 저장됨.

---

## 단계별 권한 상승 과정

### 1. 일반 사용자 계정으로 로그인

1. **로그인 정보**: 
   - 사용자명: `user1`
   - 비밀번호: `password123`

2. 공격자는 주어진 계정 정보로 Windows 시스템에 로그인한다.

### 2. 시스템 탐색 및 힌트 발견

1. 로그인 후, `C:\Users\user1\Documents\README.txt` 파일을 탐색하여 힌트를 확인한다.
   - **README.txt 내용**: "관리자 권한을 획득해야 데이터에 접근할 수 있습니다. 시스템에 설치된 취약한 프로그램을 확인하세요."

### 3. 취약한 프로그램 경로 하이재킹

1. 시스템 내 `C:\Program Files\VulnerableApp\run.bat` 파일을 탐색한다.
   - **run.bat** 내용:
     ```batch
     @echo off
     echo 실행 중입니다...
     call config.bat
     pause
     ```

2. 참가자는 `run.bat` 파일이 **config.bat** 파일을 찾으려 하지만 존재하지 않음을 확인한다.

3. **config.bat** 파일을 악성 파일로 작성한 후, 경로에 배치한다.
   - 작성할 **config.bat** 내용:
     ```batch
     @echo off
     net localgroup administrators user1 /add
     cmd.exe
     ```

4. **config.bat** 파일을 `C:\Program Files\VulnerableApp\` 경로에 저장한다.

### 4. 관리자 권한 획득

1. **run.bat** 파일을 실행하면 **config.bat** 파일이 실행된다.
2. `user1` 계정이 **관리자 그룹에 추가**되면서 관리자 권한을 획득한다.

### 5. 최종 Flag 파일 찾기

1. 권한 상승에 성공한 후, **관리자 계정**의 데스크톱에 있는 **flag.txt** 파일을 찾는다.
   - 파일 경로: `C:\Users\Administrator\Desktop\flag.txt`
   - **flag.txt 내용**:
     ```txt
     FLAG{Admin_Access_Granted}
     ```

---

## 기술적 설정 세부사항

### 사용자 계정 설정
1. **user1** 계정과 **admin** 계정을 Windows 시스템에 설정한다.
   - `user1`: 표준 사용자 계정.
   - `admin`: 관리자 권한을 가진 계정.

### 취약한 프로그램 설정
1. **run.bat** 프로그램을 다음과 같이 설정한다:
   ```batch
   @echo off
   echo 실행 중입니다...
   call config.bat
   pause
```

config.bat 파일이 없기 때문에, 참가자가 이를 경로에 배치하고 하이재킹할 수 있게 한다.
파일 및 폴더 권한 설정
admin 계정의 데스크톱 폴더(C:\Users\Administrator\Desktop)는 일반 사용자 계정이 접근할 수 없도록 설정한다.
flag.txt 파일은 관리자 권한을 가진 사용자만 읽을 수 있도록 설정한다.
최종 목표
참가자는 일반 사용자 계정으로 PC에 접근한 후, 권한 상승을 통해 관리자 권한을 획득하고 최종적으로 flag.txt 파일을 찾아 제출하는 것이 목표입니다.

