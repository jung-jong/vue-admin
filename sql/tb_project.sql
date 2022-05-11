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

-- 테이블 test.tb_project 구조 내보내기
CREATE TABLE IF NOT EXISTS `tb_project` (
  `SEQ_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '고유ID',
  `USER_ID` varchar(64) NOT NULL COMMENT '사용자 ID',
  `TITLE` varchar(255) NOT NULL COMMENT '제목',
  `PAGE_LIST` text DEFAULT NULL COMMENT '모든 페이지에 대한 JSON 데이터',
  `DESCRIPTION` text DEFAULT NULL COMMENT '설명',
  `SCALE_CD` int(11) NOT NULL DEFAULT 0 COMMENT '크기 단위 코드 px, mm, cm, in',
  `WIDTH` int(11) NOT NULL DEFAULT 0 COMMENT '가로',
  `HEIGHT` int(11) NOT NULL DEFAULT 0 COMMENT '세로',
  `SHARE_URL` varchar(255) NOT NULL COMMENT '공유URL',
  `PUBLIC_FLAG` int(11) NOT NULL DEFAULT 0 COMMENT '공개 여부 0 : false, 1 : true',
  `DEL` int(11) NOT NULL DEFAULT 0 COMMENT '삭제여부 0 : false, 1 : true',
  `A_ID` bigint(20) unsigned NOT NULL COMMENT '생성자 ID',
  `U_ID` bigint(20) unsigned NOT NULL COMMENT '수정자 ID',
  `D_ID` bigint(20) unsigned DEFAULT NULL COMMENT '삭제자 ID',
  `A_DATE` datetime NOT NULL DEFAULT current_timestamp() COMMENT '생성일',
  `U_DATE` datetime NOT NULL DEFAULT current_timestamp() COMMENT '수정일',
  `D_DATE` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`SEQ_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8;

-- 테이블 데이터 test.tb_project:~97 rows (대략적) 내보내기
/*!40000 ALTER TABLE `tb_project` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_project` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
