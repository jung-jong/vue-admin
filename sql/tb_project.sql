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
INSERT IGNORE INTO `tb_project` (`SEQ_ID`, `USER_ID`, `TITLE`, `PAGE_LIST`, `DESCRIPTION`, `SCALE_CD`, `WIDTH`, `HEIGHT`, `SHARE_URL`, `PUBLIC_FLAG`, `DEL`, `A_ID`, `U_ID`, `D_ID`, `A_DATE`, `U_DATE`, `D_DATE`) VALUES
	(132, 'user4', 'project4', NULL, NULL, 0, 0, 0, 'url4', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(133, 'user5', 'project5', NULL, NULL, 0, 0, 0, 'url5', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(134, 'user6', 'project6', NULL, NULL, 0, 0, 0, 'url6', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(135, 'user7', 'project7', NULL, NULL, 0, 0, 0, 'url7', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(136, 'user8', 'project8', NULL, NULL, 0, 0, 0, 'url8', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(137, 'user9', 'project9', NULL, NULL, 0, 0, 0, 'url9', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(138, 'user10', 'project10', NULL, NULL, 0, 0, 0, 'url10', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(139, 'user11', 'project11', NULL, NULL, 0, 0, 0, 'url11', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(140, 'user12', 'project12', NULL, NULL, 0, 0, 0, 'url12', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(141, 'user13', 'project13', NULL, NULL, 0, 0, 0, 'url13', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(142, 'user14', 'project14', NULL, NULL, 0, 0, 0, 'url14', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(143, 'user15', 'project15', NULL, NULL, 0, 0, 0, 'url15', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(144, 'user16', 'project16', NULL, NULL, 0, 0, 0, 'url16', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(145, 'user17', 'project17', NULL, NULL, 0, 0, 0, 'url17', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(146, 'user18', 'project18', NULL, NULL, 0, 0, 0, 'url18', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(147, 'user19', 'project19', NULL, NULL, 0, 0, 0, 'url19', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(148, 'user20', 'project20', NULL, NULL, 0, 0, 0, 'url20', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(149, 'user21', 'project21', NULL, NULL, 0, 0, 0, 'url21', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(150, 'user22', 'project22', NULL, NULL, 0, 0, 0, 'url22', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(151, 'user23', 'project23', NULL, NULL, 0, 0, 0, 'url23', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(152, 'user24', 'project24', NULL, NULL, 0, 0, 0, 'url24', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(153, 'user25', 'project25', NULL, NULL, 0, 0, 0, 'url25', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(154, 'user26', 'project26', NULL, NULL, 0, 0, 0, 'url26', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(155, 'user27', 'project27', NULL, NULL, 0, 0, 0, 'url27', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(156, 'user28', 'project28', NULL, NULL, 0, 0, 0, 'url28', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(157, 'user29', 'project29', NULL, NULL, 0, 0, 0, 'url29', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(158, 'user30', 'project30', NULL, NULL, 0, 0, 0, 'url30', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(159, 'user31', 'project31', NULL, NULL, 0, 0, 0, 'url31', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(160, 'user32', 'project32', NULL, NULL, 0, 0, 0, 'url32', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(161, 'user33', 'project33', NULL, NULL, 0, 0, 0, 'url33', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(162, 'user34', 'project34', NULL, NULL, 0, 0, 0, 'url34', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(163, 'user35', 'project35', NULL, NULL, 0, 0, 0, 'url35', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(164, 'user36', 'project36', NULL, NULL, 0, 0, 0, 'url36', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(165, 'user37', 'project37', NULL, NULL, 0, 0, 0, 'url37', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(166, 'user38', 'project38', NULL, NULL, 0, 0, 0, 'url38', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(167, 'user39', 'project39', NULL, NULL, 0, 0, 0, 'url39', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(168, 'user40', 'project40', NULL, NULL, 0, 0, 0, 'url40', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(169, 'user41', 'project41', NULL, NULL, 0, 0, 0, 'url41', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(170, 'user42', 'project42', NULL, NULL, 0, 0, 0, 'url42', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(171, 'user43', 'project43', NULL, NULL, 0, 0, 0, 'url43', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(172, 'user44', 'project44', NULL, NULL, 0, 0, 0, 'url44', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(173, 'user45', 'project45', NULL, NULL, 0, 0, 0, 'url45', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(174, 'user46', 'project46', NULL, NULL, 0, 0, 0, 'url46', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(175, 'user47', 'project47', NULL, NULL, 0, 0, 0, 'url47', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(176, 'user48', 'project48', NULL, NULL, 0, 0, 0, 'url48', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(177, 'user49', 'project49', NULL, NULL, 0, 0, 0, 'url49', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(178, 'user50', 'project50', NULL, NULL, 0, 0, 0, 'url50', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(179, 'user51', 'project51', NULL, NULL, 0, 0, 0, 'url51', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(180, 'user52', 'project52', NULL, NULL, 0, 0, 0, 'url52', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(181, 'user53', 'project53', NULL, NULL, 0, 0, 0, 'url53', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(182, 'user54', 'project54', NULL, NULL, 0, 0, 0, 'url54', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(183, 'user55', 'project55', NULL, NULL, 0, 0, 0, 'url55', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(184, 'user56', 'project56', NULL, NULL, 0, 0, 0, 'url56', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(185, 'user57', 'project57', NULL, NULL, 0, 0, 0, 'url57', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(186, 'user58', 'project58', NULL, NULL, 0, 0, 0, 'url58', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(187, 'user59', 'project59', NULL, NULL, 0, 0, 0, 'url59', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(188, 'user60', 'project60', NULL, NULL, 0, 0, 0, 'url60', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(189, 'user61', 'project61', NULL, NULL, 0, 0, 0, 'url61', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(190, 'user62', 'project62', NULL, NULL, 0, 0, 0, 'url62', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(191, 'user63', 'project63', NULL, NULL, 0, 0, 0, 'url63', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(192, 'user64', 'project64', NULL, NULL, 0, 0, 0, 'url64', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(193, 'user65', 'project65', NULL, NULL, 0, 0, 0, 'url65', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(194, 'user66', 'project66', NULL, NULL, 0, 0, 0, 'url66', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(195, 'user67', 'project67', NULL, NULL, 0, 0, 0, 'url67', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(196, 'user68', 'project68', NULL, NULL, 0, 0, 0, 'url68', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(197, 'user69', 'project69', NULL, NULL, 0, 0, 0, 'url69', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(198, 'user70', 'project70', NULL, NULL, 0, 0, 0, 'url70', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(199, 'user71', 'project71', NULL, NULL, 0, 0, 0, 'url71', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(200, 'user72', 'project72', NULL, NULL, 0, 0, 0, 'url72', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(201, 'user73', 'project73', NULL, NULL, 0, 0, 0, 'url73', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(202, 'user74', 'project74', NULL, NULL, 0, 0, 0, 'url74', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(203, 'user75', 'project75', NULL, NULL, 0, 0, 0, 'url75', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(204, 'user76', 'project76', NULL, NULL, 0, 0, 0, 'url76', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(205, 'user77', 'project77', NULL, NULL, 0, 0, 0, 'url77', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(206, 'user78', 'project78', NULL, NULL, 0, 0, 0, 'url78', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(207, 'user79', 'project79', NULL, NULL, 0, 0, 0, 'url79', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(208, 'user80', 'project80', NULL, NULL, 0, 0, 0, 'url80', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(209, 'user81', 'project81', NULL, NULL, 0, 0, 0, 'url81', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(210, 'user82', 'project82', NULL, NULL, 0, 0, 0, 'url82', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(211, 'user83', 'project83', NULL, NULL, 0, 0, 0, 'url83', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(212, 'user84', 'project84', NULL, NULL, 0, 0, 0, 'url84', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(213, 'user85', 'project85', NULL, NULL, 0, 0, 0, 'url85', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(214, 'user86', 'project86', NULL, NULL, 0, 0, 0, 'url86', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(215, 'user87', 'project87', NULL, NULL, 0, 0, 0, 'url87', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(216, 'user88', 'project88', NULL, NULL, 0, 0, 0, 'url88', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(217, 'user89', 'project89', NULL, NULL, 0, 0, 0, 'url89', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(218, 'user90', 'project90', NULL, NULL, 0, 0, 0, 'url90', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(219, 'user91', 'project91', NULL, NULL, 0, 0, 0, 'url91', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(220, 'user92', 'project92', NULL, NULL, 0, 0, 0, 'url92', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(221, 'user93', 'project93', NULL, NULL, 0, 0, 0, 'url93', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(222, 'user94', 'project94', NULL, NULL, 0, 0, 0, 'url94', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(223, 'user95', 'project95', NULL, NULL, 0, 0, 0, 'url95', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(224, 'user96', 'project96', NULL, NULL, 0, 0, 0, 'url96', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(225, 'user97', 'project97', NULL, NULL, 0, 0, 0, 'url97', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(226, 'user98', 'project98', NULL, NULL, 0, 0, 0, 'url98', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(227, 'user99', 'project99', NULL, NULL, 0, 0, 0, 'url99', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL),
	(228, 'user100', 'project100', NULL, NULL, 0, 0, 0, 'url100', 0, 0, 0, 0, NULL, '2022-04-16 13:54:27', '2022-04-16 13:54:27', NULL);
/*!40000 ALTER TABLE `tb_project` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
