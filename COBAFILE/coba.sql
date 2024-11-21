CREATE TABLE [images] (
    [id] INT IDENTITY(1,1) PRIMARY KEY,
    [file_name] VARCHAR(255) NOT NULL,
    [file_type] VARCHAR(50) NOT NULL,
    [file_data] VARBINARY(MAX) NOT NULL,
    [upload_date] DATETIME NOT NULL DEFAULT GETDATE()
);

SELECT * FROM images;



CREATE TABLE Dokumen2 (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    NamaFile VARCHAR(255),
    DataFile VARBINARY(MAX),
);

USE latihan_pbl;
SELECT * FROM Dokumen2;