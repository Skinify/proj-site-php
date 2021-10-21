-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21-Out-2021 às 05:47
-- Versão do servidor: 10.4.20-MariaDB
-- versão do PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `manga_online`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `capitulo`
--

CREATE TABLE `capitulo` (
  `Id` int(11) NOT NULL,
  `IdManga` int(11) NOT NULL,
  `Titulo` varchar(50) DEFAULT NULL,
  `Desc` varchar(500) DEFAULT NULL,
  `Ordem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `favoritados`
--

CREATE TABLE `favoritados` (
  `UserId` int(11) NOT NULL,
  `MangaId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `genero`
--

CREATE TABLE `genero` (
  `Id` int(11) NOT NULL,
  `Genero` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `manga`
--

CREATE TABLE `manga` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Desc` varchar(500) NOT NULL,
  `Autor` varchar(50) NOT NULL,
  `IdGenero` int(11) NOT NULL,
  `Capa` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagina`
--

CREATE TABLE `pagina` (
  `Id` int(11) NOT NULL,
  `IdCapitulo` int(11) NOT NULL,
  `Imagem` mediumtext NOT NULL,
  `Ordem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `Id` int(11) NOT NULL,
  `Nickname` varchar(20) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `Admin` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `capitulo`
--
ALTER TABLE `capitulo`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Titulo` (`Titulo`);

--
-- Índices para tabela `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`Id`);

--
-- Índices para tabela `manga`
--
ALTER TABLE `manga`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nome` (`Nome`);

--
-- Índices para tabela `pagina`
--
ALTER TABLE `pagina`
  ADD PRIMARY KEY (`Id`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nickname` (`Nickname`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `capitulo`
--
ALTER TABLE `capitulo`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `genero`
--
ALTER TABLE `genero`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `manga`
--
ALTER TABLE `manga`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pagina`
--
ALTER TABLE `pagina`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
