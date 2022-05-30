-- --------------------------------------------------------
-- 호스트:                          127.0.0.1
-- 서버 버전:                        8.0.29-0ubuntu0.20.04.3 - (Ubuntu)
-- 서버 OS:                        Linux
-- HeidiSQL 버전:                  11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- 테이블 tongro.TB_CONTENTS 구조 내보내기
CREATE TABLE IF NOT EXISTS `TB_CONTENTS` (
  `SEQ_ID` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '고유ID',
  `CONTENTS_NAME` varchar(64) NOT NULL COMMENT '콘텐츠 이름',
  `THEME_ID` bigint unsigned NOT NULL COMMENT '테마 SEQ_ID / TB_THEME.SEQ_ID',
  `KEYWORD` varchar(256) NOT NULL COMMENT '키워드',
  `THUMB_PATH` varchar(256) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL COMMENT '썸네일 이미지 경로 (작은 크기)\r\n컨텐츠 타입별 아래의 경로에 업로드\r\n- 템플릿 컨텐츠\r\n  ./contents/template/thumb/SEQ_ID.png \r\n- 텍스트 컨텐츠\r\n  ./contents/text/thumb/SEQ_ID.png\r\n- 도형 컨텐츠\r\n  ./contents/shape/thumb/SEQ_ID.png\r\n- 표 컨텐츠\r\n  ./contents/table/thumb/SEQ_ID.png\r\n- 차트 컨텐츠\r\n  ./contents/chart/thumb/SEQ_ID.png\r\n- 스타일 컨텐츠\r\n  ./contents/style/thumb/SEQ_ID.png\r\n',
  `CONTENTS_PATH` varchar(256) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL COMMENT '컨텐츠 파일 경로\r\n컨텐츠 타입에 따라 아래의 경로에 업로드\r\n- 디자인 템플릿\r\n  ./contents/template/\r\n- 텍스트 컨텐츠\r\n  ./contents/text/ \r\n- 도형 컨텐츠\r\n  ./contents/shape/\r\n- 표 컨텐츠\r\n  ./contents/table/ \r\n- 차트 컨텐츠\r\n  ./contents/chart/\r\n- 스타일 컨텐츠\r\n  ./contents/style/\r\n',
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

-- 테이블 데이터 tongro.TB_CONTENTS:~0 rows (대략적) 내보내기
/*!40000 ALTER TABLE `TB_CONTENTS` DISABLE KEYS */;
/*!40000 ALTER TABLE `TB_CONTENTS` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
