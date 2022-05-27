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

-- 테이블 tongro.TB_CONTENTS 구조 내보내기
CREATE TABLE IF NOT EXISTS `TB_CONTENTS` (
  `SEQ_ID` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '고유ID',
  `CONTENTS_NAME` varchar(64) NOT NULL COMMENT '콘텐츠 이름',
  `THEME_ID` bigint unsigned NOT NULL COMMENT '테마 SEQ_ID / TB_THEME.SEQ_ID',
  `KEYWORD` varchar(256) NOT NULL COMMENT '키워드',
  `THUMB_SMALL_PATH` varchar(256) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL COMMENT '썸네일 이미지 경로 (작은 크기)',
  `THUMB_BIG_PATH` varchar(256) NOT NULL COMMENT '썸네일 이미지 경로 (큰 크기)',
  `CONTENTS_PATH` varchar(256) NOT NULL COMMENT '컨텐츠 파일 경로',
  `USE_TYPE` int NOT NULL COMMENT '컨텐츠 용도 / 1:웹용, 2:인쇄용',
  `SIZE_CATEGORY_ID` bigint NOT NULL COMMENT '작업크기 카테고리 ID / TB_SIZE_CATEGORY.SEQ_ID\n- 템플릿 컨텐츠인 경우만 해당',
  `SIZE_INFO_ID` bigint NOT NULL COMMENT '작업크기 정보 ID / TB_SIZE.SEQ_ID\n- 템플릿 컨텐츠인 경우만 해당',
  `PUBLIC_FLAG` int NOT NULL DEFAULT '0' COMMENT '사용 여부 / 0 : false, 1 : true',
  `DEL` int NOT NULL DEFAULT '0' COMMENT '삭제여부 0 : false, 1 : true',
  `A_ID` bigint unsigned NOT NULL COMMENT '생성자 ID',
  `U_ID` bigint unsigned NOT NULL COMMENT '수정자 ID',
  `D_ID` bigint unsigned DEFAULT NULL COMMENT '삭제자 ID',
  `A_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
  `U_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '수정일',
  `D_DATE` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`SEQ_ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='컨텐츠';

-- 내보낼 데이터가 선택되어 있지 않습니다.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
