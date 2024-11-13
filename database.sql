CREATE DATABASE pbl_presma;
GO

USE pbl_presma;
GO

CREATE TABLE [user] (
  [id] INT PRIMARY KEY,
  [username] VARCHAR(50) NOT NULL,
  [password] VARCHAR(100) NOT NULL,
  [salt] VARCHAR(50) NOT NULL,
  [level] VARCHAR(5) NOT NULL DEFAULT 'user' CHECK ([level] IN ('admin', 'user'))
);
GO


INSERT INTO [user] ([id], [username], [password], [salt], [level]) VALUES
(2, 'guest', '289dff07669d7a23de0ef88d2f7129e7', '', 'user'),
(6, 'admin', '$2y$10$KVL24OkvYhklhtnB0BvXL.0SInfs2QcJ/LvzzR7IPhkGfS3GBeW0O', '8ad2e053c563c20a803cf4698d95bf9d', 'admin');

INSERT INTO [user] ([id], [username], [password], [salt], [level]) VALUES
(7, 'mahasiswa', '$2y$10$KVL24OkvYhklhtnB0BvXL.0SInfs2QcJ/LvzzR7IPhkGfS3GBeW0O', '8ad2e053c563c20a803cf4698d95bf9d', 'user');
GO
