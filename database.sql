CREATE DATABASE pbl_presma;
GO

USE pbl_presma;
GO

CREATE TABLE [admin] (
  [id] INT IDENTITY(1,1) PRIMARY KEY,  -- Menambahkan IDENTITY untuk auto increment
  [username] VARCHAR(50) NOT NULL,
  [password] VARCHAR(100) NOT NULL,
  [salt] VARCHAR(50) NOT NULL,
  [level] VARCHAR(10) NOT NULL DEFAULT 'admin' CHECK ([level] = 'admin'),
);
GO

DROP TABLE [admin];
EXEC sp_rename 'user', 'admin';

INSERT INTO [admin] ([id], [username], [password], [salt], [level]) VALUES
(2, 'guest', '289dff07669d7a23de0ef88d2f7129e7', '', 'user'),
(6, 'admin', '$2y$10$KVL24OkvYhklhtnB0BvXL.0SInfs2QcJ/LvzzR7IPhkGfS3GBeW0O', '8ad2e053c563c20a803cf4698d95bf9d', 'admin');

INSERT INTO [admin] ([id], [username], [password], [salt], [level]) VALUES
(7, 'mahasiswa', '$2y$10$KVL24OkvYhklhtnB0BvXL.0SInfs2QcJ/LvzzR7IPhkGfS3GBeW0O', '8ad2e053c563c20a803cf4698d95bf9d', 'user');
GO


SELECT * FROM [admin];

SELECT * FROM dbo.[admin];





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

CREATE TABLE [mahasiswa] (
  [NIM] VARCHAR(10) NOT NULL PRIMARY KEY,
  [nama] VARCHAR(100) NOT NULL,
  [password] VARCHAR(100) NOT NULL,
  [salt] VARCHAR(50) NOT NULL,
  [id_prodi] INT NOT NULL,
  [alamat] VARCHAR(200) NOT NULL,
  CONSTRAINT FK_mahasiswa_prodi FOREIGN KEY ([id_prodi])
    REFERENCES [prodi]([id])
    ON DELETE CASCADE
    ON UPDATE CASCADE
);


CREATE TABLE [prestasi] (
  [NIM] VARCHAR(10) NOT NULL,
  [nama_lomba] VARCHAR(50) NOT NULL,
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
    ON UPDATE CASCADE
);
