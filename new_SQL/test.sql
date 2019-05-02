SELECT * FROM attendance.log order by log.idLog desc;

-- null, '132163671', 'ada', 'TTD ACCEPTED, 132163671  (Time Elapsed = 0.399136)\n', '-7.27958770', '112.79727500', 'SIGN_132163671/7_20181212124038.png', '2019-05-02 02:40:38', '2019-05-02 02:40:38', '0'
-- data masuk kehadiran syaratnya :>
-- data dibuat sesuai dengan tanggal di absen kuliah agenda tertentu ,ex : '2019-05-02 02:40:38' => 2019-05-02
-- diantara waktu mulai min 30 menit dan waktu selesai ,ex:'2019-05-02 02:40:38' => 02:40:38
-- memiliki 'TTD ACCEPTED' ,ex: 'TTD ACCEPTED, 132163671  (Time Elapsed = 0.399136)\n'

insert into log values(
null, '132163671', 'ada', 'TTD ACCEPTED, 132163671  (Time Elapsed = 0.399136)\n', '-7.27958770', '112.79727500', 'SIGN_132163671/7_20181212124038.png', '2019-05-02 02:40:38', '2019-05-02 02:40:38', '0'
);
-- kalau mau ngetes cek versi 1
CALL Cek();

-- kalau mau ngetes cek versi 2
CALL Cek();

-- Setelah dicek jika memenuhi persyaratan data akan masuk tabel kehadiran atau kehadiranv2