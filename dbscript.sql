CREATE DATABASE IF NOT EXISTS chamados_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE chamados_db;

CREATE TABLE IF NOT EXISTS chamados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    status TINYINT NOT NULL,
    tempo_inicio DATETIME NULL,
    tempo_fim DATETIME NULL,
    duracao INT NULL
);
