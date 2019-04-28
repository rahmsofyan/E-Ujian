-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Apr 2019 pada 15.31
-- Versi server: 10.1.34-MariaDB
-- Versi PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance2`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Cek` ()  BEGIN
	
    DECLARE done INT DEFAULT FALSE;
  	DECLARE id INT(10);
  	DECLARE idUser VARCHAR(25);
  	DECLARE agenda VARCHAR(15);
  	DECLARE status VARCHAR(191);
  	DECLARE lattitude DECIMAL(10,8);
  	DECLARE longitude DECIMAL(11,8);
  	DECLARE nameFileFOTO VARCHAR(50);
  	DECLARE created_at TIMESTAMP;
  	DECLARE updated_at TIMESTAMP;
    
  	DECLARE ambil CURSOR FOR SELECT l.idLog, l.fk_idUser, l.fk_idAgenda, l.status, l.lattitudeHP, l.longitudeHP, l.namaFileFOTO, l.created_at, l.updated_at FROM log l WHERE l.flag = '0';
  	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  
  	OPEN ambil;
    
  	read_loop: LOOP
    	FETCH ambil INTO id, idUser, agenda, status, lattitude, longitude, nameFileFOTO, created_at, updated_at;
    	IF done THEN
        -- SELECT "Wrong";
      		LEAVE read_loop;
    	END IF;
        	
         -- SELECT id;
    	 CALL inData(NULL, idUser, agenda, status, lattitude, longitude, nameFileFOTO, created_at, updated_at);
         UPDATE log SET flag = '1' WHERE idLog = id;
     
  	END LOOP;
  	CLOSE ambil;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetData` (IN `id` VARCHAR(15))  BEGIN

	SET @max = (SELECT MAX(pertemuanKe) FROM absenKuliah WHERE fk_idAgenda = (SELECT idAgenda FROM agenda WHERE idAgenda = id));
    
	SET @fq = "SELECT @rownum:=@rownum+1 No, K.idUser, U.name";
	SET @bq = CONCAT("FROM (SELECT @rownum:=0) r, kehadiran K JOIN users U ON K.idUser = U.idUser WHERE idAgenda = (SELECT idAgenda FROM agenda WHERE idAgenda = '",id,"') AND K.idUser NOT IN (SELECT idPIC FROM pic)");
	
    SET @i = 1;
	WHILE @i <= @max DO
    	
        SET @tgl = (SELECT tglPertemuan FROM absenKuliah WHERE pertemuanKe = @i AND fk_idAgenda = id);
        
		SET @fq = CONCAT(@fq,", IF(K.p",@i," IS NULL, 'Tidak Hadir','Hadir')'",@tgl,"'");
    SET @i = @i + 1;
    END WHILE;
    
    SET @query = CONCAT(@fq,@bq);
    -- SELECT @query;
    PREPARE stmt FROM @query;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inData` (IN `id` INT(10), IN `idUser` VARCHAR(25), IN `agenda` VARCHAR(15), IN `status` VARCHAR(191), IN `lattitude` DECIMAL(10,8), IN `longitude` DECIMAL(11,8), IN `nameFileFOTO` VARCHAR(50), IN `created_at` TIMESTAMP, IN `updated_at` TIMESTAMP)  BEGIN
		
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
        
		SET @ada = (SELECT k.idUser FROM kehadiran k WHERE k.idUser = idUser AND k.idAgenda = agenda);
        
		SET @query = '';
		
		IF @ada IS NULL THEN
			SET @query = CONCAT("INSERT INTO kehadiran (id, idUser, idAgenda, p",@day,") VALUES(NULL,'",idUser,"','",agenda,"','1')");
		ELSE
			-- SET @query = CONCAT("UPDATE kehadiran SET p",@day," = '1' WHERE idUser = '",idUser,"'"); aslinya
            SET @query = CONCAT("UPDATE kehadiran SET p",@day," = '1' WHERE idUser = '",idUser,"' AND idAgenda = '",agenda,"'");
		END IF;
    	
        	-- SELECT @query;
		
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
	END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inDataInput` (`id` INT(10), `idUser` VARCHAR(25), `agenda` VARCHAR(15), `status` VARCHAR(191), `lattitude` DECIMAL(10,8), `longitude` DECIMAL(11,8), `nameFileFOTO` VARCHAR(50), `created_at` TIMESTAMP, `updated_at` TIMESTAMP)  BEGIN

		INSERT INTO log (idLog, fk_idUser, fk_idAgenda, status, lattitudeHP, longitudeHP, namaFileFOTO, created_at, updated_at) VALUES (id, idUser, agenda, status, lattitude, longitude, nameFileFOTO, created_at, updated_at);
		    
    	SET @mulai = (SELECT WaktuMulai FROM agenda WHERE idAgenda = agenda); 		SET @selesai = (SELECT WaktuSelesai FROM agenda WHERE idAgenda = agenda);         SET @tglagenda = (SELECT tanggal FROM agenda WHERE idAgenda = agenda);
    	SET @tglcreated = DATE(created_at);
    	SET @day = (SELECT pertemuanKe FROM absenKuliah WHERE fk_idAgenda = agenda AND tglPertemuan = @tglcreated);
    
	IF (TIME(created_at) BETWEEN @mulai AND @selesai) AND status LIKE 'ACCEPTED%' AND @day IS NOT NULL THEN
        
		SET @ada = (SELECT k.idUser FROM kehadiran k WHERE k.idUser = idUser AND k.idAgenda = agenda);
		
		SET @query = '';
		
		IF @ada IS NULL THEN
			SET @query = CONCAT("INSERT INTO kehadiran (id, idUser, idAgenda, p",@day,") VALUES(NULL,'",idUser,"','",agenda,"','1')");
		ELSE
			SET @query = CONCAT("UPDATE kehadiran SET p",@day," = '1' WHERE idUser = '",idUser,"'");
		END IF;
		
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
	END IF;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `absenkuliah`
--

CREATE TABLE `absenkuliah` (
  `id` int(10) UNSIGNED NOT NULL,
  `fk_idAgenda` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tglPertemuan` date NOT NULL,
  `waktuMulai` time NOT NULL,
  `waktuSelesai` time NOT NULL,
  `pertemuanKe` int(11) NOT NULL,
  `BeritaAcara` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `agenda`
--

CREATE TABLE `agenda` (
  `idAgenda` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namaAgenda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `singkatAgenda` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date DEFAULT NULL,
  `hari` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_idRuang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `WaktuMulai` time NOT NULL,
  `WaktuSelesai` time NOT NULL,
  `fk_idPIC` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notule` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `foto_statuses`
--

CREATE TABLE `foto_statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kehadiran`
--

CREATE TABLE `kehadiran` (
  `id` int(11) NOT NULL,
  `idUser` varchar(25) NOT NULL,
  `idAgenda` varchar(15) NOT NULL,
  `p1` int(11) DEFAULT NULL,
  `p2` int(11) DEFAULT NULL,
  `p3` int(11) DEFAULT NULL,
  `p4` int(11) DEFAULT NULL,
  `p5` int(11) DEFAULT NULL,
  `p6` int(11) DEFAULT NULL,
  `p7` int(11) DEFAULT NULL,
  `p8` int(11) DEFAULT NULL,
  `p9` int(11) DEFAULT NULL,
  `p10` int(11) DEFAULT NULL,
  `p11` int(11) DEFAULT NULL,
  `p12` int(11) DEFAULT NULL,
  `p13` int(11) DEFAULT NULL,
  `p14` int(11) DEFAULT NULL,
  `p15` int(11) DEFAULT NULL,
  `p16` int(11) DEFAULT NULL,
  `p17` int(11) DEFAULT NULL,
  `p18` int(11) DEFAULT NULL,
  `p19` int(11) DEFAULT NULL,
  `p20` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kunci`
--

CREATE TABLE `kunci` (
  `kunci` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log`
--

CREATE TABLE `log` (
  `idLog` int(10) UNSIGNED NOT NULL,
  `fk_idUser` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_idAgenda` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `lattitudeHP` decimal(10,8) NOT NULL,
  `longitudeHP` decimal(11,8) NOT NULL,
  `namaFileFOTO` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `flag` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_11_13_062416_create_pics_table', 1),
(4, '2018_11_13_062416_create_ruangs_table', 1),
(5, '2018_11_13_062417_create_agendas_table', 1),
(6, '2018_11_13_062456_create_logs_table', 1),
(7, '2018_11_14_055809_create_absen_kuliahs_table', 1),
(8, '2019_01_18_071501_create_ratings_table', 2),
(9, '2019_01_18_074854_create_versions_table', 3),
(10, '2019_01_18_084039_create_versions_table', 4),
(11, '2019_02_10_084118_create_foto_statuses_table', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id` int(11) NOT NULL,
  `idUser` varchar(25) NOT NULL,
  `idAgenda` varchar(25) NOT NULL,
  `p1` int(11) DEFAULT NULL,
  `p2` int(11) DEFAULT NULL,
  `p3` int(11) DEFAULT NULL,
  `p4` int(11) DEFAULT NULL,
  `p5` int(11) DEFAULT NULL,
  `p6` int(11) DEFAULT NULL,
  `p7` int(11) DEFAULT NULL,
  `p8` int(11) DEFAULT NULL,
  `p9` int(11) DEFAULT NULL,
  `p10` int(11) DEFAULT NULL,
  `p11` int(11) DEFAULT NULL,
  `p12` int(11) DEFAULT NULL,
  `p13` int(11) DEFAULT NULL,
  `p14` int(11) DEFAULT NULL,
  `p15` int(11) DEFAULT NULL,
  `p16` int(11) DEFAULT NULL,
  `p17` int(11) DEFAULT NULL,
  `p18` int(11) DEFAULT NULL,
  `p19` int(11) DEFAULT NULL,
  `p20` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pic`
--

CREATE TABLE `pic` (
  `idPIC` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namaPIC` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ratings`
--

CREATE TABLE `ratings` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `rateable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rateable_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruang`
--

CREATE TABLE `ruang` (
  `idRuang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namaRuang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lattitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `floor` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUser` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `versions`
--

CREATE TABLE `versions` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pembuat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelebihan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kekurangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_download` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_video` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absenkuliah`
--
ALTER TABLE `absenkuliah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_idAgenda` (`fk_idAgenda`,`pertemuanKe`),
  ADD KEY `absenkuliah_fk_idagenda_index` (`fk_idAgenda`);

--
-- Indeks untuk tabel `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`idAgenda`),
  ADD KEY `agenda_fk_idruang_index` (`fk_idRuang`),
  ADD KEY `agenda_fk_idpic_index` (`fk_idPIC`);

--
-- Indeks untuk tabel `foto_statuses`
--
ALTER TABLE `foto_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kunci`
--
ALTER TABLE `kunci`
  ADD PRIMARY KEY (`kunci`);

--
-- Indeks untuk tabel `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`idLog`),
  ADD KEY `log_fk_iduser_index` (`fk_idUser`),
  ADD KEY `log_fk_idagenda_index` (`fk_idAgenda`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(191));

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pic`
--
ALTER TABLE `pic`
  ADD PRIMARY KEY (`idPIC`);

--
-- Indeks untuk tabel `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_rateable_type_rateable_id_index` (`rateable_type`(191),`rateable_id`),
  ADD KEY `ratings_rateable_id_index` (`rateable_id`),
  ADD KEY `ratings_rateable_type_index` (`rateable_type`(191)),
  ADD KEY `ratings_user_id_index` (`user_id`);

--
-- Indeks untuk tabel `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`idRuang`);

--
-- Indeks untuk tabel `versions`
--
ALTER TABLE `versions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
