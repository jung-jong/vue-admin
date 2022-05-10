-- --------------------------------------------------------
-- 호스트:                          127.0.0.1
-- 서버 버전:                        10.4.24-MariaDB - mariadb.org binary distribution
-- 서버 OS:                        Win64
-- HeidiSQL 버전:                  11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- 테이블 test.tb_user_status 구조 내보내기
CREATE TABLE IF NOT EXISTS `tb_user_status` (
  `SEQ_ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '고유ID',
  `USER_ID` varchar(64) NOT NULL COMMENT '사용자 ID',
  `USER_LEVEL` int(11) NOT NULL COMMENT '1:마스터, 2:작업자',
  `LICENSE_TYPE` varchar(32) NOT NULL COMMENT '"유료", "무료"',
  `USER_STATUS` varchar(32) NOT NULL COMMENT '"작업중", "생성중"',
  `STORAGE_USE` int(11) NOT NULL COMMENT 'MB 단위',
  `STORAGE_QUOTA` int(11) NOT NULL COMMENT 'MB 단위',
  `LAST_WORK_TYPE` varchar(32) DEFAULT NULL COMMENT 'JPG, PNG, PPT, PDF',
  `LAST_WORK_DATE` datetime DEFAULT NULL,
  `DEL` int(11) NOT NULL DEFAULT 0 COMMENT '0 : false, 1 : true',
  `A_ID` bigint(20) NOT NULL,
  `U_ID` bigint(20) NOT NULL,
  `D_ID` bigint(20) DEFAULT NULL,
  `A_DATE` datetime NOT NULL DEFAULT current_timestamp(),
  `U_DATE` datetime NOT NULL DEFAULT current_timestamp(),
  `D_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`SEQ_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 테이블 데이터 test.tb_user_status:~0 rows (대략적) 내보내기
/*!40000 ALTER TABLE `tb_user_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_user_status` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
