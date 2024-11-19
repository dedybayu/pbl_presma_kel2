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
  [level_admin] VARCHAR(10) NOT NULL DEFAULT 'admin' CHECK ([level_admin] = 'admin'),
);
GO



CREATE TABLE [jurusan] (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [nama_jurusan] VARCHAR(50) NOT NULL
);

CREATE TABLE [prodi] (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [nama_prodi] VARCHAR(50) NOT NULL,
  [id_jurusan] INT NOT NULL,
  CONSTRAINT FK_prodi_jurusan FOREIGN KEY ([id_jurusan])
    REFERENCES [jurusan]([id])
    ON DELETE CASCADE
    ON UPDATE CASCADE
);


-- Menambahkan data ke tabel jurusan
INSERT INTO [jurusan] (nama_jurusan)
VALUES ('Teknologi Informasi');

SELECT * FROM jurusan;

-- Menambahkan data ke tabel prodi
-- Ambil ID jurusan yang sesuai dengan nama "Teknologi Informasi"
DECLARE @id_jurusan INT;
SET @id_jurusan = (SELECT id FROM [jurusan] WHERE nama_jurusan = 'Teknologi Informasi');

INSERT INTO [prodi] (nama_prodi, id_jurusan)
VALUES ('Teknik Informatika', @id_jurusan);

SELECT * FROM prodi;






CREATE TABLE [mahasiswa] (
  [NIM] VARCHAR(10) NOT NULL PRIMARY KEY,
  [nama] VARCHAR(100) NOT NULL,
  [password] VARCHAR(100) NOT NULL,
  [salt] VARCHAR(50) NOT NULL,
  [id_prodi] INT NOT NULL,
  [no_tlp] VARCHAR(15),
  [alamat] VARCHAR(500),
  CONSTRAINT FK_mahasiswa_prodi FOREIGN KEY ([id_prodi])
    REFERENCES [prodi]([id])
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

SELECT * FROM mahasiswa;
DELETE FROM mahasiswa WHERE nama = 'Ines Sandika';

SELECT NIM, salt, password AS hashed_password FROM [mahasiswa] WHERE NIM = '123456';

CREATE TABLE [message] (
    [NIM] VARCHAR(10) NOT NULL,
    [message] VARCHAR(500) NOT NULL,
    CONSTRAINT FK_message_mahasiswa FOREIGN KEY ([NIM])
    REFERENCES [mahasiswa]([NIM])
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE [prestasi] (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [NIM] VARCHAR(10) NOT NULL,
  [nama_lomba] VARCHAR(50) NOT NULL,
  [nip_dosbim] VARCHAR(20),
  [jenis_lomba] VARCHAR(50) NOT NULL,
  [juara_lomba] VARCHAR(50) NOT NULL,
  [tingkat_lomba] VARCHAR(50) NOT NULL,
  [waktu_pelaksanaan] DATE NOT NULL,
  [penyelenggara_lomba] VARCHAR(50) NOT NULL,
  [bukti_foto] VARCHAR(70) NOT NULL,
  [sertifikat] VARCHAR(70) NOT NULL,
  [surat_undangan] VARCHAR(70),
  [surat_tugas] VARCHAR(70),
  [proposal] VARCHAR(70),
  [poin] INT NOT NULL,
  [waktu_modifikasi] DATE NOT NULL,
  CONSTRAINT FK_prestasi_mahasiswa FOREIGN KEY ([NIM])
    REFERENCES [mahasiswa]([NIM])
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT FK_dosbim FOREIGN KEY ([nip_dosbim])
    REFERENCES [dosen]([nip])
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

DROP TABLE prestasi;


CREATE TABLE [dosen] (
  [nip] VARCHAR(20) NOT NULL PRIMARY KEY,
  [password] VARCHAR(100) NOT NULL,
  [salt] VARCHAR(50) NOT NULL,
  [nama] VARCHAR(100) NOT NULL,
  [jabatan] VARCHAR(50) NOT NULL,
  [no_tlp] VARCHAR(15),
  [alamat] VARCHAR(500),
);

DROP TABLE dosen;

DROP TABLE [dosen_pembimbing];


ALTER TABLE [prestasi]
ADD [dosen_pembimbing] VARCHAR(50) NOT NULL DEFAULT '';

DROP TABLE prestasi;