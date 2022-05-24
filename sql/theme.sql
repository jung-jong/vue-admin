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

-- 테이블 test.tb_contents_category 구조 내보내기
CREATE TABLE IF NOT EXISTS `tb_contents_category` (
  `SEQ_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '고유ID',
  `CONTENTS_TYPE_NAME` varchar(32) NOT NULL COMMENT '템플릿, 사진, 일러스트, 3D, 아이콘, 논텍스트, 배경, 동영상, 모션그래픽, GIF, 사운드, 텍스트, 도형, 표, 차트, 스타일',
  `LIST_TYPE` int(11) NOT NULL COMMENT '테마 리스트 방식 1: API기준, 2:자체설정',
  `DEL` int(11) NOT NULL DEFAULT 0 COMMENT '삭제여부 0 : false, 1 : true',
  `A_ID` bigint(20) unsigned NOT NULL COMMENT '생성자 ID',
  `U_ID` bigint(20) unsigned NOT NULL COMMENT '수정자 ID',
  `D_ID` bigint(20) unsigned DEFAULT NULL COMMENT '삭제자 ID',
  `A_DATE` datetime NOT NULL DEFAULT current_timestamp() COMMENT '생성일',
  `U_DATE` datetime NOT NULL DEFAULT current_timestamp() COMMENT '수정일',
  `D_DATE` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`SEQ_ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='컨텐츠';

-- 테이블 데이터 test.tb_contents_category:~16 rows (대략적) 내보내기
/*!40000 ALTER TABLE `tb_contents_category` DISABLE KEYS */;
INSERT IGNORE INTO `tb_contents_category` (`SEQ_ID`, `CONTENTS_TYPE_NAME`, `LIST_TYPE`, `DEL`, `A_ID`, `U_ID`, `D_ID`, `A_DATE`, `U_DATE`, `D_DATE`) VALUES
	(1, '템플릿', 2, 0, 0, 0, NULL, '2022-05-24 15:05:24', '2022-05-24 15:05:24', NULL),
	(2, '사진', 2, 0, 0, 0, NULL, '2022-05-24 15:05:53', '2022-05-24 15:05:53', NULL),
	(3, '일러스트', 2, 0, 0, 0, NULL, '2022-05-24 15:06:01', '2022-05-24 15:06:01', NULL),
	(4, '3D', 2, 0, 0, 0, NULL, '2022-05-24 15:06:11', '2022-05-24 15:06:11', NULL),
	(5, '아이콘', 2, 0, 0, 0, NULL, '2022-05-24 15:06:15', '2022-05-24 15:06:15', NULL),
	(6, '논텍스트', 2, 0, 0, 0, NULL, '2022-05-24 15:06:20', '2022-05-24 15:06:20', NULL),
	(7, '배경', 2, 0, 0, 0, NULL, '2022-05-24 15:06:24', '2022-05-24 15:06:24', NULL),
	(8, '동영상', 2, 0, 0, 0, NULL, '2022-05-24 15:06:28', '2022-05-24 15:06:28', NULL),
	(9, '모션그래픽', 2, 0, 0, 0, NULL, '2022-05-24 15:06:42', '2022-05-24 15:06:42', NULL),
	(10, 'GIF', 2, 0, 0, 0, NULL, '2022-05-24 15:06:52', '2022-05-24 15:06:52', NULL),
	(11, '사운드', 2, 0, 0, 0, NULL, '2022-05-24 15:06:55', '2022-05-24 15:06:55', NULL),
	(12, '텍스트', 2, 0, 0, 0, NULL, '2022-05-24 15:07:01', '2022-05-24 15:07:01', NULL),
	(13, '도형', 2, 0, 0, 0, NULL, '2022-05-24 15:07:03', '2022-05-24 15:07:03', NULL),
	(14, '표', 2, 0, 0, 0, NULL, '2022-05-24 15:07:06', '2022-05-24 15:07:06', NULL),
	(15, '차트', 2, 0, 0, 0, NULL, '2022-05-24 15:07:09', '2022-05-24 15:07:09', NULL),
	(16, '스타일', 2, 0, 0, 0, NULL, '2022-05-24 15:07:12', '2022-05-24 15:07:12', NULL);
/*!40000 ALTER TABLE `tb_contents_category` ENABLE KEYS */;

-- 테이블 test.tb_theme 구조 내보내기
CREATE TABLE IF NOT EXISTS `tb_theme` (
  `SEQ_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '고유ID',
  `CONTENTS_CATEGORY_ID` bigint(20) unsigned NOT NULL COMMENT '컨텐츠 타입 TB_CONTENTS_CATEGORY.SEQ_ID',
  `THEME_NAME` varchar(256) NOT NULL COMMENT '테마 이름',
  `ORDER` int(11) NOT NULL COMMENT '정렬 순서',
  `DEL` int(11) NOT NULL DEFAULT 0 COMMENT '삭제여부 0 : false, 1 : true',
  `A_ID` bigint(20) unsigned NOT NULL COMMENT '생성자 ID',
  `U_ID` bigint(20) unsigned NOT NULL COMMENT '수정자 ID',
  `D_ID` bigint(20) unsigned DEFAULT NULL COMMENT '삭제자 ID',
  `A_DATE` datetime NOT NULL DEFAULT current_timestamp() COMMENT '생성일',
  `U_DATE` datetime NOT NULL DEFAULT current_timestamp() COMMENT '수정일',
  `D_DATE` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`SEQ_ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='테마';

-- 테이블 데이터 test.tb_theme:~0 rows (대략적) 내보내기
/*!40000 ALTER TABLE `tb_theme` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_theme` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
