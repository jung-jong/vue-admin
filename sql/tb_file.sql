-- --------------------------------------------------------
-- 호스트:                          127.0.0.1
-- 서버 버전:                        10.7.3-MariaDB - mariadb.org binary distribution
-- 서버 OS:                        Win64
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

-- 테이블 admin.tb_file 구조 내보내기
CREATE TABLE IF NOT EXISTS `tb_file` (
  `SEQ_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '고유ID',
  `FILE_NAME` varchar(255) NOT NULL COMMENT '파일이름(확장자 포함)',
  `FILE_DIR` text NOT NULL COMMENT '저장된 디렉토리 경로',
  `FILE_EXTENSION` varchar(255) NOT NULL COMMENT '파일 확장자(.제외)',
  `FILE_TYPE` int(11) NOT NULL COMMENT '파일 타입(이미지, 동영상, 음악)',
  `STORAGE_FILE_NAME` varchar(255) NOT NULL DEFAULT '0' COMMENT '최종 저장된 파일명',
  `NAME` varchar(255) NOT NULL COMMENT '표시되는 이름',
  `DEL` int(11) NOT NULL DEFAULT 0,
  `A_ID` bigint(20) unsigned NOT NULL,
  `U_ID` bigint(20) unsigned NOT NULL,
  `D_ID` bigint(20) unsigned DEFAULT NULL,
  `A_DATE` datetime NOT NULL DEFAULT current_timestamp(),
  `U_DATE` datetime NOT NULL DEFAULT current_timestamp(),
  `D_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`SEQ_ID`),
  KEY `INDEX_FILE` (`FILE_TYPE`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

-- 테이블 데이터 admin.tb_file:~4 rows (대략적) 내보내기
INSERT INTO `tb_file` (`SEQ_ID`, `FILE_NAME`, `FILE_DIR`, `FILE_EXTENSION`, `FILE_TYPE`, `STORAGE_FILE_NAME`, `NAME`, `DEL`, `A_ID`, `U_ID`, `D_ID`, `A_DATE`, `U_DATE`, `D_DATE`) VALUES
	(1, 'image.png', 'user1', 'png', 0, 'image', '이름', 0, 0, 0, NULL, '2022-04-18 14:42:33', '2022-04-18 14:42:33', NULL),
	(4, '다운로드.jpg', 'user1', 'jpg', 0, '다운로드.jpg', '이름', 0, 0, 0, NULL, '2022-04-21 10:37:57', '2022-04-21 10:37:58', NULL),
	(8, '한글파일.jpg', 'user2', 'jpg', 0, '다운로드.jpg', '이름', 0, 0, 0, NULL, '2022-04-21 10:37:57', '2022-04-21 10:37:58', NULL),
	(9, 'img2.gif', 'user1', 'gif', 0, 'image', '이름', 0, 0, 0, NULL, '2022-04-18 14:42:33', '2022-04-18 14:42:33', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
