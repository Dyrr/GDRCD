-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Lug 15, 2020 alle 02:41
-- Versione del server: 5.6.20-log
-- Versione PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gdrcd56`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `abilita`
--

CREATE TABLE IF NOT EXISTS `abilita` (
  `id_abilita` int(4) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `car` tinyint(1) NOT NULL DEFAULT '0',
  `descrizione` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `id_razza` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_abilita`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `ambientazione`
--

CREATE TABLE IF NOT EXISTS `ambientazione` (
  `capitolo` int(2) NOT NULL,
  `testo` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `titolo` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `araldo`
--

CREATE TABLE IF NOT EXISTS `araldo` (
  `id_araldo` int(4) NOT NULL AUTO_INCREMENT,
  `tipo` int(2) NOT NULL DEFAULT '0',
  `nome` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `proprietari` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_araldo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `araldo_letto`
--

CREATE TABLE IF NOT EXISTS `araldo_letto` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `araldo_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nome` (`nome`,`thread_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `backmessaggi`
--

CREATE TABLE IF NOT EXISTS `backmessaggi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mittente` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `destinatario` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `spedito` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `letto` tinyint(1) DEFAULT '0',
  `testo` text COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `blacklist`
--

CREATE TABLE IF NOT EXISTS `blacklist` (
  `ip` char(15) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `nota` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `granted` tinyint(1) NOT NULL DEFAULT '0',
  `ora` datetime DEFAULT NULL,
  `host` char(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '-',
  PRIMARY KEY (`ip`),
  KEY `Ora` (`ora`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `stanza` int(4) NOT NULL DEFAULT '0',
  `imgs` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `mittente` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `destinatario` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `ora` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tipo` char(1) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `testo` text COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`id`),
  KEY `Stanza` (`stanza`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `clgpersonaggioabilita`
--

CREATE TABLE IF NOT EXISTS `clgpersonaggioabilita` (
  `nome` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `id_abilita` int(4) NOT NULL,
  `grado` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `clgpersonaggiomostrine`
--

CREATE TABLE IF NOT EXISTS `clgpersonaggiomostrine` (
  `nome` char(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `id_mostrina` char(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`nome`,`id_mostrina`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `clgpersonaggiooggetto`
--

CREATE TABLE IF NOT EXISTS `clgpersonaggiooggetto` (
  `nome` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `id_oggetto` int(4) NOT NULL DEFAULT '0',
  `numero` int(8) DEFAULT '1',
  `cariche` int(4) NOT NULL DEFAULT '-1',
  `commento` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `posizione` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nome`,`id_oggetto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `clgpersonaggioruolo`
--

CREATE TABLE IF NOT EXISTS `clgpersonaggioruolo` (
  `personaggio` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `id_ruolo` int(4) NOT NULL DEFAULT '0',
  `scadenza` date NOT NULL DEFAULT '2010-01-01'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `codmostrina`
--

CREATE TABLE IF NOT EXISTS `codmostrina` (
  `id_mostrina` int(4) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `img_url` char(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'grigia.gif',
  `descrizione` char(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'nessuna',
  PRIMARY KEY (`id_mostrina`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `codtipogilda`
--

CREATE TABLE IF NOT EXISTS `codtipogilda` (
  `descrizione` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `cod_tipo` int(2) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`cod_tipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=116 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `codtipooggetto`
--

CREATE TABLE IF NOT EXISTS `codtipooggetto` (
  `cod_tipo` int(2) NOT NULL AUTO_INCREMENT,
  `descrizione` char(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`cod_tipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `gilda`
--

CREATE TABLE IF NOT EXISTS `gilda` (
  `id_gilda` int(4) NOT NULL AUTO_INCREMENT,
  `nome` char(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `tipo` varchar(1) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  `immagine` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `url_sito` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `statuto` text COLLATE utf8mb4_unicode_520_ci,
  `visibile` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_gilda`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_interessato` char(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `autore` char(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `data_evento` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `codice_evento` char(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `descrizione_evento` char(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `mappa`
--

CREATE TABLE IF NOT EXISTS `mappa` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `descrizione` text COLLATE utf8mb4_unicode_520_ci,
  `stato` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `pagina` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT 'nulla.php',
  `chat` tinyint(1) NOT NULL DEFAULT '1',
  `immagine` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT 'standard_luogo.png',
  `stanza_apparente` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `id_mappa` int(4) DEFAULT '0',
  `link_immagine` varchar(256) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `link_immagine_hover` varchar(256) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `id_mappa_collegata` int(11) NOT NULL DEFAULT '0',
  `x_cord` int(4) DEFAULT '0',
  `y_cord` int(4) DEFAULT '0',
  `invitati` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `privata` tinyint(1) NOT NULL DEFAULT '0',
  `proprietario` char(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `ora_prenotazione` datetime DEFAULT NULL,
  `scadenza` datetime DEFAULT NULL,
  `costo` int(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `Invitati` (`invitati`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `mappa_click`
--

CREATE TABLE IF NOT EXISTS `mappa_click` (
  `id_click` int(1) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `immagine` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'standard_mappa.png',
  `posizione` int(2) NOT NULL DEFAULT '0',
  `mobile` tinyint(1) NOT NULL DEFAULT '0',
  `meteo` varchar(40) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '20°c - sereno',
  `larghezza` smallint(4) NOT NULL DEFAULT '500',
  `altezza` smallint(4) NOT NULL DEFAULT '330',
  PRIMARY KEY (`id_click`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `mercato`
--

CREATE TABLE IF NOT EXISTS `mercato` (
  `id_oggetto` int(4) NOT NULL,
  `numero` int(4) DEFAULT '0',
  PRIMARY KEY (`id_oggetto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggi`
--

CREATE TABLE IF NOT EXISTS `messaggi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mittente` varchar(40) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `destinatario` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Nessuno',
  `spedito` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `letto` tinyint(1) DEFAULT '0',
  `mittente_del` tinyint(1) DEFAULT '0',
  `destinatario_del` tinyint(1) DEFAULT '0',
  `testo` text COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`id`),
  KEY `destinatario` (`destinatario`),
  KEY `letto` (`letto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggioaraldo`
--

CREATE TABLE IF NOT EXISTS `messaggioaraldo` (
  `id_messaggio` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_messaggio_padre` bigint(20) NOT NULL DEFAULT '0',
  `id_araldo` int(4) DEFAULT NULL,
  `titolo` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `messaggio` text COLLATE utf8mb4_unicode_520_ci,
  `autore` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `data_messaggio` datetime DEFAULT NULL,
  `importante` binary(1) NOT NULL DEFAULT '0',
  `chiuso` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_messaggio`),
  KEY `id_araldo` (`id_araldo`),
  KEY `id_messaggio_padre` (`id_messaggio_padre`),
  KEY `data_messaggio` (`data_messaggio`),
  KEY `importante` (`importante`,`chiuso`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `oggetto`
--

CREATE TABLE IF NOT EXISTS `oggetto` (
  `id_oggetto` int(4) NOT NULL AUTO_INCREMENT,
  `tipo` int(2) NOT NULL DEFAULT '0',
  `nome` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Sconosciuto',
  `creatore` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'System Op',
  `data_inserimento` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `descrizione` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Nessuna',
  `ubicabile` int(2) NOT NULL DEFAULT '0',
  `costo` int(11) NOT NULL DEFAULT '0',
  `difesa` int(4) NOT NULL DEFAULT '0',
  `attacco` int(4) NOT NULL DEFAULT '0',
  `cariche` varchar(10) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  `bonus_car0` int(4) NOT NULL DEFAULT '0',
  `bonus_car1` int(4) NOT NULL DEFAULT '0',
  `bonus_car2` int(4) NOT NULL DEFAULT '0',
  `bonus_car3` int(4) NOT NULL DEFAULT '0',
  `bonus_car4` int(4) NOT NULL DEFAULT '0',
  `bonus_car5` int(4) NOT NULL DEFAULT '0',
  `urlimg` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id_oggetto`),
  KEY `Tipo` (`tipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `personaggio`
--

CREATE TABLE IF NOT EXISTS `personaggio` (
  `idpg` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `cognome` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '-',
  `pass` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `ultimo_cambiopass` datetime DEFAULT NULL,
  `data_iscrizione` datetime DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `permessi` tinyint(1) DEFAULT '0',
  `ultima_mappa` int(4) NOT NULL DEFAULT '1',
  `ultimo_luogo` int(4) NOT NULL DEFAULT '-1',
  `esilio` date NOT NULL DEFAULT '2009-07-01',
  `data_esilio` date NOT NULL DEFAULT '2009-07-01',
  `motivo_esilio` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `autore_esilio` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `sesso` char(1) COLLATE utf8mb4_unicode_520_ci DEFAULT 'm',
  `id_razza` int(4) DEFAULT '1000',
  `descrizione` text COLLATE utf8mb4_unicode_520_ci,
  `affetti` text COLLATE utf8mb4_unicode_520_ci,
  `stato` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT 'nessuna',
  `online_status` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `disponibile` tinyint(1) NOT NULL DEFAULT '1',
  `url_img` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT 'imgs/avatars/empty.png',
  `url_img_chat` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT ' ',
  `url_media` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `blocca_media` binary(1) NOT NULL DEFAULT '0',
  `esperienza` decimal(12,4) DEFAULT '0.0000',
  `car0` int(4) NOT NULL DEFAULT '5',
  `car1` int(4) NOT NULL DEFAULT '5',
  `car2` int(4) NOT NULL DEFAULT '5',
  `car3` int(4) NOT NULL DEFAULT '5',
  `car4` int(4) NOT NULL DEFAULT '5',
  `car5` int(4) NOT NULL DEFAULT '5',
  `salute` int(4) NOT NULL DEFAULT '100',
  `salute_max` int(4) NOT NULL DEFAULT '100',
  `data_ultima_gilda` datetime NOT NULL DEFAULT '2009-07-01 00:00:00',
  `soldi` int(11) DEFAULT '50',
  `banca` int(11) DEFAULT '0',
  `ultimo_stipendio` date NOT NULL DEFAULT '2009-07-01',
  `last_ip` varchar(16) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `is_invisible` tinyint(1) NOT NULL DEFAULT '0',
  `ultimo_refresh` datetime NOT NULL,
  `ora_entrata` datetime NOT NULL,
  `ora_uscita` datetime NOT NULL,
  `posizione` int(4) NOT NULL DEFAULT '1',
  `ultimo_messaggio` bigint(20) NOT NULL DEFAULT '0',
  `forma` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idpg`),
  UNIQUE KEY `nome` (`nome`),
  KEY `IDRazza` (`id_razza`),
  KEY `Esilio` (`esilio`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `razza`
--

CREATE TABLE IF NOT EXISTS `razza` (
  `id_razza` int(4) NOT NULL AUTO_INCREMENT,
  `nome_razza` char(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `sing_m` char(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `sing_f` char(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `descrizione` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `bonus_car0` int(4) NOT NULL DEFAULT '0',
  `bonus_car1` int(4) NOT NULL DEFAULT '0',
  `bonus_car2` int(4) NOT NULL DEFAULT '0',
  `bonus_car3` int(4) NOT NULL DEFAULT '0',
  `bonus_car4` int(4) NOT NULL DEFAULT '0',
  `bonus_car5` int(4) NOT NULL DEFAULT '0',
  `immagine` char(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'standard_razza.png',
  `icon` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'standard_razza.png',
  `url_site` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `iscrizione` tinyint(1) NOT NULL DEFAULT '1',
  `visibile` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_razza`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=1001 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `regolamento`
--

CREATE TABLE IF NOT EXISTS `regolamento` (
  `articolo` int(2) NOT NULL,
  `titolo` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `testo` text COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `ruolo`
--

CREATE TABLE IF NOT EXISTS `ruolo` (
  `id_ruolo` int(4) NOT NULL AUTO_INCREMENT,
  `gilda` int(4) NOT NULL DEFAULT '-1',
  `nome_ruolo` char(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `immagine` varchar(256) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `stipendio` int(4) NOT NULL DEFAULT '0',
  `capo` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_ruolo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=6 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
