-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 05. Aug 2020 um 07:43
-- Server-Version: 8.0.20
-- PHP-Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `bugebo`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ex_accounts`
--

CREATE TABLE `ex_accounts` (
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `registrationTime` datetime NOT NULL,
  `lastActiv` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ex_accountToBankAccount`
--

CREATE TABLE `ex_accountToBankAccount` (
  `id` int UNSIGNED NOT NULL,
  `accountUUID` char(36) NOT NULL,
  `bankAccountID` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ex_bankAccount`
--

CREATE TABLE `ex_bankAccount` (
  `id` int UNSIGNED NOT NULL,
  `bankAccountTypID` int UNSIGNED NOT NULL,
  `bankInstitutID` int UNSIGNED DEFAULT NULL,
  `accountName` varchar(255) NOT NULL,
  `description` text,
  `openingDate` date NOT NULL,
  `lastModified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ex_bankAccountTyp`
--

CREATE TABLE `ex_bankAccountTyp` (
  `id` int UNSIGNED NOT NULL,
  `bankAccountTypName` varchar(255) NOT NULL,
  `description` varchar(10000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ex_bankCode`
--

CREATE TABLE `ex_bankCode` (
  `id` int UNSIGNED NOT NULL,
  `bankNameID` int UNSIGNED NOT NULL,
  `bankCode` varchar(255) NOT NULL,
  `bic` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ex_bankInstitut`
--

CREATE TABLE `ex_bankInstitut` (
  `id` int UNSIGNED NOT NULL,
  `bankCodeID` int UNSIGNED NOT NULL,
  `cityID` int UNSIGNED NOT NULL,
  `streetID` int UNSIGNED NOT NULL,
  `houseNumber` varchar(10) NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `fax` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ex_bankName`
--

CREATE TABLE `ex_bankName` (
  `id` int UNSIGNED NOT NULL,
  `bankName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ex_city`
--

CREATE TABLE `ex_city` (
  `id` int UNSIGNED NOT NULL,
  `cityName` varchar(255) NOT NULL,
  `zipCode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ex_streets`
--

CREATE TABLE `ex_streets` (
  `id` int UNSIGNED NOT NULL,
  `street` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `ex_accounts`
--
ALTER TABLE `ex_accounts`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indizes für die Tabelle `ex_accountToBankAccount`
--
ALTER TABLE `ex_accountToBankAccount`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ex_bankAccount`
--
ALTER TABLE `ex_bankAccount`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `ex_bankAccountTyp`
--
ALTER TABLE `ex_bankAccountTyp`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `bankAccountTypName` (`bankAccountTypName`) USING BTREE;

--
-- Indizes für die Tabelle `ex_bankCode`
--
ALTER TABLE `ex_bankCode`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `bankCode` (`bankCode`,`bic`) USING BTREE,
  ADD KEY `bankNameID` (`bankNameID`);

--
-- Indizes für die Tabelle `ex_bankInstitut`
--
ALTER TABLE `ex_bankInstitut`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indizes für die Tabelle `ex_bankName`
--
ALTER TABLE `ex_bankName`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `name` (`bankName`);

--
-- Indizes für die Tabelle `ex_city`
--
ALTER TABLE `ex_city`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `name` (`cityName`,`zipCode`);

--
-- Indizes für die Tabelle `ex_streets`
--
ALTER TABLE `ex_streets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `street` (`street`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `ex_bankAccount`
--
ALTER TABLE `ex_bankAccount`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `ex_bankAccountTyp`
--
ALTER TABLE `ex_bankAccountTyp`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `ex_bankCode`
--
ALTER TABLE `ex_bankCode`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `ex_bankInstitut`
--
ALTER TABLE `ex_bankInstitut`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `ex_bankName`
--
ALTER TABLE `ex_bankName`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `ex_city`
--
ALTER TABLE `ex_city`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `ex_streets`
--
ALTER TABLE `ex_streets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `ex_bankCode`
--
ALTER TABLE `ex_bankCode`
  ADD CONSTRAINT `ex_bankCode_ibfk_1` FOREIGN KEY (`bankNameID`) REFERENCES `ex_bankName` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
