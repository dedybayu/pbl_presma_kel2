CREATE DATABASE pbl_presma;
GO

USE pbl_presma;
GO

-- CREATE TABLE [admin] (
--   [id] INT IDENTITY(1,1) PRIMARY KEY,  -- Menambahkan IDENTITY untuk auto increment
--   [username] VARCHAR(50) NOT NULL,
--   [password] VARCHAR(100) NOT NULL,
--   [salt] VARCHAR(50) NOT NULL,
--   [level_admin] VARCHAR(10) NOT NULL DEFAULT 'admin' CHECK ([level] = 'admin'),
-- );
-- GO

DROP TABLE [admin];
SELECT * FROM [admin];
EXEC sp_rename 'user', 'admin';

-- INSERT INTO [admin] ([id], [username], [password], [salt], [level]) VALUES
-- (2, 'guest', '289dff07669d7a23de0ef88d2f7129e7', '', 'user'),
-- (6, 'admin', '$2y$10$KVL24OkvYhklhtnB0BvXL.0SInfs2QcJ/LvzzR7IPhkGfS3GBeW0O', '8ad2e053c563c20a803cf4698d95bf9d', 'admin');

-- INSERT INTO [admin] ([id], [username], [password], [salt], [level]) VALUES
-- (7, 'mahasiswa', '$2y$10$KVL24OkvYhklhtnB0BvXL.0SInfs2QcJ/LvzzR7IPhkGfS3GBeW0O', '8ad2e053c563c20a803cf4698d95bf9d', 'user');
-- GO


-- SELECT * FROM dbo.[admin];


EXEC sp_rename 'admin.level', 'level_admin', 'COLUMN';
GO






CREATE TABLE [admin] (
  [id] INT IDENTITY(1,1) PRIMARY KEY,  -- Menambahkan IDENTITY untuk auto increment
  [username] VARCHAR(50) NOT NULL,
  [password] VARCHAR(100) NOT NULL,
  [salt] VARCHAR(50) NOT NULL,
);
GO

SELECT * FROM admin;


CREATE TABLE [jurusan] (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [nama_jurusan] VARCHAR(50) NOT NULL
);
DROP TABLE jurusan;

CREATE TABLE [prodi] (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [nama_prodi] VARCHAR(50) NOT NULL,
  [id_jurusan] INT NOT NULL,
  CONSTRAINT FK_prodi_jurusan FOREIGN KEY ([id_jurusan])
    REFERENCES [jurusan]([id])
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- Hapus foreign key constraint
ALTER TABLE [prodi] DROP CONSTRAINT FK_prodi_jurusan;

-- Hapus kolom id_jurusan
ALTER TABLE [prodi] DROP COLUMN [id_jurusan];

-- Menambahkan data ke tabel jurusan
INSERT INTO [jurusan] (nama_jurusan)
VALUES ('Teknologi Informasi');

SELECT * FROM prodi;

-- Menambahkan data ke tabel prodi
-- Ambil ID jurusan yang sesuai dengan nama "Teknologi Informasi"
DECLARE @id_jurusan INT;
SET @id_jurusan = (SELECT id FROM [jurusan] WHERE nama_jurusan = 'Teknologi Informasi');

INSERT INTO [prodi] (nama_prodi, id_jurusan)
VALUES ('Teknik Informatika', @id_jurusan);

SELECT * FROM prodi;






CREATE TABLE [mahasiswa] (
  [NIM] VARCHAR(12) NOT NULL PRIMARY KEY,
  [nama] VARCHAR(100) NOT NULL,
  [password] VARCHAR(100) NOT NULL,
  [salt] VARCHAR(50) NOT NULL,
  [id_prodi] INT NOT NULL,
  [jenis_kelamin] VARCHAR(10) NOT NULL,
  [no_tlp] VARCHAR(15),
  [email] VARCHAR(100),
  [file_foto_profile] VARBINARY(MAX),
  CONSTRAINT FK_mahasiswa_prodi FOREIGN KEY ([id_prodi])
    REFERENCES [prodi]([id])
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

SELECT c.name AS ColumnName,
       t.name AS DataType,
       c.max_length AS MaxLength,
       c.is_nullable AS IsNullable
FROM sys.columns c
JOIN sys.types t ON c.user_type_id = t.user_type_id
WHERE c.object_id = OBJECT_ID('prestasi');


EXEC sp_help 'mahasiswa';


ALTER TABLE [mahasiswa] 
ALTER COLUMN [NIM] VARCHAR(12);

ALTER TABLE [mahasiswa]
ALTER COLUMN [NIM] VARCHAR(12);

ALTER TABLE [mahasiswa]
ALTER COLUMN [NIM] VARCHAR(12);


ALTER TABLE [mahasiswa] DROP COLUMN [jenis_kelamin];


ALTER TABLE [mahasiswa]
ADD [email] VARCHAR(100);

DROP TABLE mahasiswa;
SELECT * FROM mahasiswa;
DELETE FROM mahasiswa WHERE nama = 'Ines Sandika';

SELECT NIM, salt, password AS hashed_password FROM [mahasiswa] WHERE NIM = '1111111111';

CREATE TABLE [message] (
    [NIM] VARCHAR(12) NOT NULL,
    [message] VARCHAR(500) NOT NULL,
    CONSTRAINT FK_message_mahasiswa FOREIGN KEY ([NIM])
    REFERENCES [mahasiswa]([NIM])
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

ALTER TABLE [prestasi] DROP CONSTRAINT FK_prestasi_mahasiswa;


DROP TABLE message;



CREATE TABLE [prestasi] (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [NIM] VARCHAR(12) NOT NULL,
  [nama_lomba] VARCHAR(50) NOT NULL,
  [nip_dosbim] VARCHAR(20),
  [jenis_lomba] VARCHAR(50) NOT NULL,
  [juara_lomba] VARCHAR(50) NOT NULL,
  [tingkat_lomba] VARCHAR(50) NOT NULL,
  [waktu_pelaksanaan] DATE NOT NULL,
  [tempat_pelaksanaan] VARCHAR(100) NOT NULL,
  [penyelenggara_lomba] VARCHAR(50) NOT NULL,
  [file_bukti_foto] VARBINARY(MAX) NOT NULL,
  [file_sertifikat] VARBINARY(MAX) NOT NULL,
  [file_surat_undangan] VARBINARY(MAX),
  [file_surat_tugas] VARBINARY(MAX),
  [file_proposal] VARBINARY(MAX),
  [poin] INT NOT NULL,
  [status_verifikasi] VARCHAR(10) NOT NULL DEFAULT 'waiting', -- Kolom dengan nilai default 'waiting'
  [message] VARCHAR(255) NULL,
  [upload_date] DATETIME NOT NULL,
  CONSTRAINT FK_prestasi_mahasiswa FOREIGN KEY ([NIM])
    REFERENCES [mahasiswa]([NIM])
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT FK_dosbim FOREIGN KEY ([nip_dosbim])
    REFERENCES [dosen]([nip])
    ON DELETE CASCADE
    ON UPDATE CASCADE
);



ALTER TABLE [prestasi] DROP CONSTRAINT FK_prestasi_mahasiswa;

ALTER TABLE [prestasi]
ADD CONSTRAINT FK_prestasi_mahasiswa FOREIGN KEY ([NIM])
REFERENCES [mahasiswa]([NIM])
ON DELETE CASCADE
ON UPDATE CASCADE;


ALTER TABLE [prestasi]
ALTER COLUMN [upload_date] DATETIME NOT NULL;


ALTER TABLE [prestasi]
ADD 
    [status_tim] VARCHAR(10) NOT NULL DEFAULT 'individu';

SELECT * FROM prestasi;


ALTER TABLE [prestasi] DROP COLUMN [nama_file_bukti_foto];
ALTER TABLE [prestasi] DROP COLUMN [nama_file_sertifikat];
ALTER TABLE [prestasi] DROP COLUMN [nama_file_surat_undangan];
ALTER TABLE [prestasi] DROP COLUMN [nama_file_surat_tugas];
ALTER TABLE [prestasi] DROP COLUMN [nama_file_proposal];



CREATE TABLE [tim] (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [nama_tim] VARCHAR(50) NOT NULL,
);

CREATE TABLE [anggota_tim] (
  [id_tim] INT,
  [nim_mhs] VARCHAR(10)
)




SELECT COLUMN_NAME, DATA_TYPE
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = 'prestasi' AND COLUMN_NAME = 'waktu_pelaksanaan';



DROP TABLE prestasi;
SELECT * FROM prestasi;

CREATE TABLE [dosen] (
  [nip] VARCHAR(20) NOT NULL PRIMARY KEY,
  [password] VARCHAR(100) NOT NULL,
  [salt] VARCHAR(50) NOT NULL,
  [nama] VARCHAR(100) NOT NULL,
  [jabatan] VARCHAR(50) NOT NULL,
  [jenis_kelamin] VARCHAR(10) NOT NULL,
  [no_tlp] VARCHAR(15),
  [email] VARCHAR(100),
  [file_foto_profile] VARBINARY(MAX),
);

ALTER TABLE [dosen] DROP COLUMN [alamat];
ALTER TABLE [prestasi] ADD [status_tim] VARCHAR(10) NOT NULL DEFAULT 'individu';


SELECT * FROM dosen;
DROP TABLE dosen;

DROP TABLE [dosen_pembimbing];

ALTER TABLE [dosen]
ADD [email] VARCHAR(100);

ALTER TABLE [prestasi]
ADD [dosen_pembimbing] VARCHAR(50) NOT NULL DEFAULT '';

DROP TABLE prestasi;



CREATE TABLE [tanggal] (
  [tanggal] date NOT NULL,
);

INSERT INTO [tanggal] VALUES ('2024-11-21');
SELECT * FROM tanggal
DROP TABLE tanggal;

