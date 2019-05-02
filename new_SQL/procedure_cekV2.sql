CREATE DEFINER=`root`@`localhost` PROCEDURE `Cekv2`()
BEGIN
	
   DECLARE done INT DEFAULT FALSE;
  	DECLARE id INT(10);
  	DECLARE idUser VARCHAR(25);
  	DECLARE agenda VARCHAR(15);
  	DECLARE status VARCHAR(191);
  	DECLARE lattitude DECIMAL(10,8);
  	DECLARE longitude DECIMAL(11,8);
  	DECLARE nameFileFOTO VARCHAR(550);
  	DECLARE created_at TIMESTAMP;
  	DECLARE updated_at TIMESTAMP;
    
  	DECLARE ambil CURSOR FOR SELECT l.idLog, l.fk_idUser, l.fk_idAgenda, l.status, l.lattitudeHP, l.longitudeHP, l.namaFileFOTO, l.created_at, l.updated_at FROM log l WHERE l.flag = '0';
  	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  
  	OPEN ambil;
    
  	read_loop: LOOP
    	FETCH ambil INTO id, idUser, agenda, status, lattitude, longitude, nameFileFOTO, created_at, updated_at;
    	IF done THEN
              		LEAVE read_loop;
    	END IF;
        	
             	 CALL inDatav2(NULL, idUser, agenda, status, lattitude, longitude, nameFileFOTO, created_at, updated_at);
         UPDATE log SET flag = '1' WHERE idLog = id;
     
  	END LOOP;
  	CLOSE ambil;

END