-- --------------------------------------------------------
-- 호스트:                          127.0.0.1
-- 서버 버전:                        8.0.29-0ubuntu0.20.04.3 - (Ubuntu)
-- 서버 OS:                        Linux
-- HeidiSQL 버전:                  12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- 테이블 tongro.TB_FILE 구조 내보내기
CREATE TABLE IF NOT EXISTS `TB_FILE` (
  `SEQ_ID` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '고유ID',
  `FILE_NAME` varchar(255) NOT NULL COMMENT '파일이름(확장자 포함)',
  `FILE_DIR` text NOT NULL COMMENT '저장된 디렉토리 경로',
  `FILE_EXTENSION` varchar(255) NOT NULL COMMENT '파일 확장자(.제외)',
  `FILE_TYPE` int NOT NULL COMMENT '파일 타입(이미지, 동영상, 음악)',
  `STORAGE_FILE_NAME` varchar(255) NOT NULL DEFAULT '0' COMMENT '최종 저장된 파일명',
  `NAME` varchar(255) NOT NULL COMMENT '표시되는 이름',
  `DEL` int NOT NULL DEFAULT '0',
  `A_ID` bigint unsigned NOT NULL,
  `U_ID` bigint unsigned NOT NULL,
  `D_ID` bigint unsigned DEFAULT NULL,
  `A_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `U_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `D_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`SEQ_ID`),
  KEY `INDEX_FILE` (`FILE_TYPE`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;

-- 내보낼 데이터가 선택되어 있지 않습니다.

-- 테이블 tongro.TB_PROJECT 구조 내보내기
CREATE TABLE IF NOT EXISTS `TB_PROJECT` (
  `SEQ_ID` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '고유ID',
  `USER_ID` varchar(64) NOT NULL COMMENT '사용자 ID',
  `TITLE` varchar(256) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL COMMENT '제목',
  `JSON_PATH` varchar(256) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL COMMENT '모든 페이지에 대한 JSON 데이터',
  `MEMO` varchar(256) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL COMMENT '설명',
  `PAGE_WIDTH` int NOT NULL COMMENT '가로',
  `PAGE_HEIGHT` int NOT NULL COMMENT '세로',
  `SCALE_CD` int NOT NULL COMMENT '크기 단위 코드 px, mm, cm, in',
  `SHARE_URL` varchar(256) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL COMMENT '공유URL',
  `PUBLIC_FLAG` int NOT NULL DEFAULT '0' COMMENT '공개 여부 0 : false, 1 : true',
  `DEL` int NOT NULL DEFAULT '0' COMMENT '삭제여부 0 : false, 1 : true',
  `A_ID` bigint unsigned NOT NULL COMMENT '생성자 ID',
  `U_ID` bigint unsigned NOT NULL COMMENT '수정자 ID',
  `D_ID` bigint unsigned DEFAULT NULL COMMENT '삭제자 ID',
  `A_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
  `U_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '수정일',
  `D_DATE` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`SEQ_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb3;

-- 내보낼 데이터가 선택되어 있지 않습니다.

-- 프로시저 tongro.TB_PROJECT_DUMMY 구조 내보내기
DELIMITER //
CREATE PROCEDURE `TB_PROJECT_DUMMY`()
BEGIN

DECLARE i INT DEFAULT 1;
	DELETE FROM TB_PROJECT;

	WHILE (i <= 1000) DO 
	
		INSERT INTO TB_PROJECT (`USER_ID`, `TITLE`, `JSON_PATH`, `MEMO`, `PAGE_WIDTH`, `PAGE_HEIGHT`, `SCALE_CD`, `SHARE_URL`, `A_ID`, `U_ID`)
		VALUES (CONCAT('user',i), CONCAT('프로젝트',i), '/PATH', CONCAT('user',i,'의 메모입니다.'), FLOOR(RAND()*1000),FLOOR(RAND()*1000), FLOOR(1+RAND()*4), CONCAT('url',i), 0, 0);
		
		SET i = i + 1;
	
	END WHILE;

END//
DELIMITER ;

-- 테이블 tongro.TB_USER_STATUS 구조 내보내기
CREATE TABLE IF NOT EXISTS `TB_USER_STATUS` (
  `SEQ_ID` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '고유ID',
  `USER_ID` varchar(64) NOT NULL COMMENT '사용자 ID',
  `USER_LEVEL` int NOT NULL COMMENT '사용자 레벨 1:마스터, 2:작업자, 9:사용자',
  `LICENSE_TYPE` varchar(32) NOT NULL COMMENT '라이선스 타입 "유료", "무료"',
  `USER_STATUS` varchar(32) NOT NULL COMMENT '사용자 상태 "작업중", "생성중"',
  `STORAGE_USE` int NOT NULL COMMENT '스토리지 사용률 MB 단위',
  `STORAGE_QUOTA` int NOT NULL COMMENT '스토리지 촣 할당량 MB 단위',
  `LAST_WORK_TYPE` varchar(32) DEFAULT NULL COMMENT '최종 작업(생성) 파일 포맷 JPG, PNG, PPT, PDF',
  `LAST_WORK_DATE` datetime DEFAULT NULL COMMENT '최종 작업(생성) 일자/시간',
  `LAST_EDIT_DATE` datetime DEFAULT NULL COMMENT '최종 수정 일자/시간',
  `DEL` int NOT NULL DEFAULT '0' COMMENT '0 : false, 1 : true',
  `A_ID` bigint unsigned NOT NULL,
  `U_ID` bigint unsigned NOT NULL,
  `D_ID` bigint unsigned DEFAULT NULL,
  `A_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `U_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `D_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`SEQ_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb3;

-- 내보낼 데이터가 선택되어 있지 않습니다.

-- 프로시저 tongro.tb_user_status_dummy 구조 내보내기
DELIMITER //
CREATE PROCEDURE `tb_user_status_dummy`()
BEGIN

DECLARE i INT DEFAULT 1;
	DELETE FROM TB_USER_STATUS;

	WHILE (i <= 1000) DO 
	
		INSERT INTO TB_USER_STATUS (`USER_ID`, `USER_LEVEL`, `LICENSE_TYPE`, `USER_STATUS`, `STORAGE_USE`,
		 `STORAGE_QUOTA`, `LAST_WORK_TYPE`, `LAST_WORK_DATE`, `LAST_EDIT_DATE`, `A_ID`, `U_ID`)
		VALUES (CONCAT('user',i), 9, '유료', '작업중', FLOOR(1+RAND()*100), 100, 'JPG', '2022-05-16', '2022-05-17', '0', '0');
		
		SET i = i + 1;
	
	END WHILE;

END//
DELIMITER ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
