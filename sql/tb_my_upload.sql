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

-- 테이블 test.tb_my_upload 구조 내보내기
CREATE TABLE IF NOT EXISTS `tb_my_upload` (
  `SEQ_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '고유ID',
  `FILE_NAME` varchar(64) NOT NULL COMMENT '파일이름(확장자 포함)',
  `FILE_DIR` varchar(64) NOT NULL COMMENT '저장된 디렉토리 경로 ./user/{사용자ID}/upload/',
  `FILE_EXTENSION` varchar(16) NOT NULL COMMENT '파일 확장자(.제외)',
  `FILE_TYPE` int(11) NOT NULL COMMENT '파일 타입 1:이미지, 2:동영상, 3:오디오',
  `STORAGE_FILE_NAME` varchar(255) NOT NULL COMMENT '최종 저장된 파일명 ./user/{사용자ID}/upload/ TB_UPLOAD_FILE.FILE_NAME',
  `THUMB_PATH` varchar(255) NOT NULL COMMENT '썸네일 이미지 경로',
  `DEL` int(11) NOT NULL DEFAULT 0,
  `A_ID` bigint(20) unsigned NOT NULL,
  `U_ID` bigint(20) unsigned NOT NULL,
  `D_ID` bigint(20) unsigned DEFAULT NULL,
  `A_DATE` datetime NOT NULL DEFAULT current_timestamp(),
  `U_DATE` datetime NOT NULL DEFAULT current_timestamp(),
  `D_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`SEQ_ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='파일관리';

-- 테이블 데이터 test.tb_my_upload:~4 rows (대략적) 내보내기
/*!40000 ALTER TABLE `tb_my_upload` DISABLE KEYS */;
INSERT IGNORE INTO `tb_my_upload` (`SEQ_ID`, `FILE_NAME`, `FILE_DIR`, `FILE_EXTENSION`, `FILE_TYPE`, `STORAGE_FILE_NAME`, `THUMB_PATH`, `DEL`, `A_ID`, `U_ID`, `D_ID`, `A_DATE`, `U_DATE`, `D_DATE`) VALUES
	(1, 'image.png', 'user1', 'png', 1, 'image', '', 0, 0, 0, NULL, '2022-05-17 16:41:15', '2022-05-17 16:41:15', NULL),
	(2, '고용량.gif', 'user1', 'gif', 1, '고용량', '', 0, 0, 0, NULL, '2022-05-17 16:41:15', '2022-05-17 16:41:15', NULL),
	(3, '다운로드.jpg', 'user1', 'jpg', 1, '다운로드', '', 0, 0, 0, NULL, '2022-05-17 16:45:33', '2022-05-17 16:45:33', NULL),
	(4, '한글파일.jpg', 'user2', 'jpg', 1, '한글파일', '', 0, 0, 0, NULL, '2022-05-17 16:47:49', '2022-05-17 16:47:49', NULL);
/*!40000 ALTER TABLE `tb_my_upload` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
