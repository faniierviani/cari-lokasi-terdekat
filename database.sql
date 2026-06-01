CREATE DATABASE lokasi_db;
USE lokasi_db;

CREATE TABLE lokasi (
id INT AUTO_INCREMENT PRIMARY KEY,
nama_lokasi VARCHAR(100),
alamat TEXT,
latitude DOUBLE,
longitude DOUBLE
);
INSERT INTO lokasi (nama_lokasi, alamat, latitude, longitude)
VALUES
('Alun-Alun Karawang','Karawang', -6.3054, 107.2960),
('Rengasdengklok','Karawang', -6.1596, 107.3008),
('Mall Karawang Central Plaza','Karawang', -6.3224, 107.2995),
('Universitas Singaperbangsa Karawang','Karawang', -6.3227, 107.3046);
