CREATE DATABASE pbl_presma;
GO

USE pbl_presma;
GO

CREATE TABLE [admin] (
  [id] INT IDENTITY(1,1) PRIMARY KEY,  -- Menambahkan IDENTITY untuk auto increment
  [username] VARCHAR(50) NOT NULL,
  [password] VARCHAR(100) NOT NULL,
  [salt] VARCHAR(50) NOT NULL,
);
GO

CREATE TABLE [prodi] (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [nama_prodi] VARCHAR(50) NOT NULL
);

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



CREATE TABLE [prestasi] (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [NIM] VARCHAR(12) NOT NULL,
  [nama_lomba] VARCHAR(50) NOT NULL,
  [nip_dosbim] VARCHAR(20),
  [jenis_lomba] VARCHAR(50) NOT NULL,
  [juara_lomba] VARCHAR(50) NOT NULL,
  [tingkat_lomba] VARCHAR(50) NOT NULL,
  [status_tim] VARCHAR(10) NOT NULL DEFAULT 'individu',
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


CREATE TABLE [dosen] (
  [nip] VARCHAR(20) NOT NULL PRIMARY KEY,
  [password] VARCHAR(100) NOT NULL,
  [salt] VARCHAR(50) NOT NULL,
  [nama] VARCHAR(100) NOT NULL,
  [jenis_kelamin] VARCHAR(10) NOT NULL,
  [no_tlp] VARCHAR(15),
  [email] VARCHAR(100),
  [file_foto_profile] VARBINARY(MAX),
);