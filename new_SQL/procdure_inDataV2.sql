CREATE DEFINER=`root`@`localhost` PROCEDURE `inDatav2`(IN `id` INT(10), IN `idUser` VARCHAR(25), IN `agenda` VARCHAR(15), IN `status` VARCHAR(191), IN `lattitude` DECIMAL(10,8), IN `longitude` DECIMAL(11,8), IN `nameFileFOTO` VARCHAR(550), IN `created_at` TIMESTAMP, IN `updated_at` TIMESTAMP)
BEGIN
		
       -- SELECT idUser;
    	SET @tglcreated = DATE(created_at);
    	SET @day = (SELECT pertemuanKe FROM absenKuliah WHERE fk_idAgenda = agenda AND tglPertemuan = @tglcreated);
        SET @tglagenda = (SELECT tglPertemuan FROM absenKuliah WHERE fk_idAgenda = agenda AND pertemuanKe = @day);
    	SET @mulai = (SELECT waktuMulai FROM absenKuliah WHERE pertemuanKe = @day AND fk_idAgenda = agenda );         SET @selesai = (SELECT waktuSelesai FROM absenKuliah WHERE pertemuanKe = @day AND fk_idAgenda = agenda );         

	     
        -- SELECT @day;
        -- SELECT IF (TIME(created_at) BETWEEN @mulai AND @selesai, "JAM Bener", "Jam Salah");
        -- SELECT IF(status LIKE 'ACCEPTED%', "Status Y", "Status N");
        -- SELECT IF(@day IS NOT NULL, "DAY y", "DAY N");
	        
	IF (TIME(created_at) BETWEEN SUBTIME(@mulai, '00:30') AND @selesai) AND status LIKE 'TTD ACCEPTED%' AND @day IS NOT NULL THEN
       -- IF 1 = 1 THEN 
		SET @ada = (SELECT k.idUser FROM kehadiran k WHERE k.idUser = idUser AND k.idAgenda = agenda);
        
		SET @query = '';
		
		IF @ada IS NULL THEN
			SET @query = CONCAT("INSERT INTO kehadiranv2 (id, idUser, idAgenda, p",@day,") VALUES(NULL,'",idUser,"','",agenda,"','",TIME(created_at),"')");
		ELSE
			-- SET @query = CONCAT("UPDATE kehadiran SET p",@day," = '1' WHERE idUser = '",idUser,"'"); aslinya
            SET @query = CONCAT("UPDATE kehadiranv2 SET p",@day," = '",TIME(created_at),"' WHERE idUser = '",idUser,"' AND idAgenda = '",agenda,"'");
		END IF;
    	
        	-- SELECT @query;
		
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
	END IF;

END