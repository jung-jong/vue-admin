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

-- 프로시저 test.user_status 구조 내보내기
DELIMITER //
CREATE PROCEDURE `user_status`()
BEGIN

DECLARE i INT DEFAULT 1;
	DELETE FROM tb_user_status;

	WHILE (i <= 1000) DO 
	
		INSERT INTO tb_user_status (`USER_ID`, `USER_LEVEL`, `LICENSE_TYPE`, `USER_STATUS`, `STORAGE_USE`,
		 `STORAGE_QUOTA`, `LAST_WORK_TYPE`, `LAST_WORK_DATE`, `A_ID`, `U_ID`)
		VALUES (CONCAT('user',i), 2, '유료', '작업중', 10, 100, 'JPG', '2022-05-10', '0', '0');
		
		SET i = i + 1;
	
	END WHILE;

END//
DELIMITER ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
