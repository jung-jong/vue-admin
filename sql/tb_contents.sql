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

-- 테이블 admin.tb_contents 구조 내보내기
CREATE TABLE IF NOT EXISTS `tb_contents` (
  `SEQ_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `THUMB_IMG_PATH` varchar(256) NOT NULL,
  `NAME` varchar(64) NOT NULL,
  `TYPE` varchar(64) NOT NULL,
  `TAGS` varchar(256) NOT NULL,
  `PUBLIC_FLAG` int(11) NOT NULL DEFAULT 0,
  `DEL` int(11) NOT NULL DEFAULT 0,
  `A_ID` bigint(20) unsigned NOT NULL,
  `U_ID` bigint(20) unsigned NOT NULL,
  `D_ID` bigint(20) unsigned DEFAULT NULL,
  `A_DATE` datetime NOT NULL DEFAULT current_timestamp(),
  `U_DATE` datetime NOT NULL DEFAULT current_timestamp(),
  `D_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`SEQ_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- 테이블 데이터 admin.tb_contents:~0 rows (대략적) 내보내기
DELETE FROM `tb_contents`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
