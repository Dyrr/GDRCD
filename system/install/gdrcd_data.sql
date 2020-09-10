-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Lug 15, 2020 alle 02:42
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

--
-- Dump dei dati per la tabella `abilita`
--

INSERT INTO `abilita` (`id_abilita`, `nome`, `car`, `descrizione`, `id_razza`) VALUES
(18, 'Resistenza', 1, 'Il personaggio è in grado di sopportare il dolore ed il disagio e sopporta minime dosi di agenti tossici nel proprio organismo. ', -1),
(17, 'Sopravvivenza', 4, 'Il personaggio è in grado di procurarsi cibo e riparo all''aperto, con mezzi minimi.', -1),
(4, 'Atletica', 2, 'Il personaggio è ben allenato ed è in grado di saltare efficacemente, arrampicarsi, nuotare, schivare e compiere, genericamente, movimenti fisicamente impegnativi.', -1),
(5, 'Cercare', 5, 'Il personaggio è rapido ed efficace nel perquisire un ambiente in cerca di qualcosa.', -1),
(6, 'Conoscenza', 3, 'Il personaggio ha accumulato cultura ed esperienze, e potrebbe avere maggiori informazioni sulla situazione in cui si trova. A fronte di una prova di conoscenza il master dovrebbe fornire informazioni al giocatore via sussurro.', -1),
(7, 'Percepire intenzioni', 4, 'Il personaggio è abile nel determinare, durante una conversazione o un interazione, se il suo interlocutore stia mentendo, sia ostile o sia ben disposto.', -1),
(8, 'Cavalcare', 2, 'Il personaggio è in grado di cavalcare animali addestrati a tale scopo.', -1),
(9, 'Addestrare animali', 4, 'Il personaggio comprende gli atteggiamenti e le reazioni degli animali ed è in grado di interagire con loro, addomesticarli ed addestrarli.', -1),
(10, 'Armi bianche', 0, 'Il personaggio è addestrato al combattimento con armi bianche, scudi e protezioni.', -1),
(11, 'Armi da tiro', 5, 'Il personaggio è addestrato all''uso di armi da diro o da lancio.', -1),
(12, 'Lotta', 0, 'Il personaggio è addestrato al combattimento senza armi.', -1),
(13, 'Competenze tecniche', 3, 'Il personaggio è in grado di realizzare e riparare strumenti tecnologici. Il tipo ed il numero di tecnologie in cui è competente dovrebbe essere specificato nel background e proporzionale al punteggio di intelligenza.', -1),
(14, 'Mezzi di trasporto', 5, 'Il personaggio è in grado di governare o pilotare specifici mezzi di trasporto. L''elenco dei mezzi dovrebbe essere riportato nel background e proporzionale al punteggio di intelligenza.', -1),
(15, 'Pronto soccorso', 3, 'Il personaggio è in grado di eseguire interventi d''emergenza su individui feriti o la cui salute sia in qualche modo minacciata.', -1),
(16, 'FurtivitÃ ', 2, 'Il personaggio è in grado di muoversi ed agire senza dare nell''occhio, e di scassinare serrature.', -1),
(19, 'VolontÃ ', 4, 'Il personaggio è fortemente determinato e difficilmente si lascia persuadere o dissuadere.', -1);

--
-- Dump dei dati per la tabella `araldo`
--

INSERT INTO `araldo` (`id_araldo`, `tipo`, `nome`, `proprietari`) VALUES
(1, 4, 'Resoconti quest', 0),
(2, 0, 'Notizie in gioco', 0),
(3, 2, 'Umani', 1000),
(4, 3, 'Ordini alla Guardia', 1),
(5, 5, 'moderazione', -1);

--
-- Dump dei dati per la tabella `clgpersonaggioruolo`
--

INSERT INTO `clgpersonaggioruolo` (`personaggio`, `id_ruolo`, `scadenza`) VALUES
('Super', 1, '2010-01-01'),
('Test', 3, '2010-01-01');

--
-- Dump dei dati per la tabella `codtipogilda`
--

INSERT INTO `codtipogilda` (`descrizione`, `cod_tipo`) VALUES
('Positivo', 1),
('Neutrale', 2),
('Negativo', 3),
('test', 115);

--
-- Dump dei dati per la tabella `codtipooggetto`
--

INSERT INTO `codtipooggetto` (`cod_tipo`, `descrizione`) VALUES
(1, 'Animale'),
(2, 'Vestito'),
(3, 'Fiore - Pianta'),
(4, 'Gioiello'),
(5, 'Arma'),
(6, 'Attrezzo'),
(0, 'Vario');

--
-- Dump dei dati per la tabella `gilda`
--

INSERT INTO `gilda` (`id_gilda`, `nome`, `tipo`, `immagine`, `url_sito`, `statuto`, `visibile`) VALUES
(1, 'Guardia cittadina', '1', 'standard_gilda.png', 'https://www.google.com', 'jjkjkjkjkjk', 1);

--
-- Dump dei dati per la tabella `mappa`
--

INSERT INTO `mappa` (`id`, `nome`, `descrizione`, `stato`, `pagina`, `chat`, `immagine`, `stanza_apparente`, `id_mappa`, `link_immagine`, `link_immagine_hover`, `id_mappa_collegata`, `x_cord`, `y_cord`, `invitati`, `privata`, `proprietario`, `ora_prenotazione`, `scadenza`, `costo`) VALUES
(1, 'Strada', 'Via che congiunge la periferia al centro.', 'Nella norma', '', 1, 'standard_luogo.png', '', 1, '', '', 0, 180, 150, '', 0, 'Nessuno', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'Piazza', 'Piccola piazza con panchine ed una fontana al centro.', 'Nella norma', '', 1, 'standard_luogo.png', 'Mappa principale', 1, '', '', 0, 80, 150, '', 0, 'Nessuno', '0000-00-00 00:00:00', '2019-01-01 00:00:00', 0);

--
-- Dump dei dati per la tabella `mappa_click`
--

INSERT INTO `mappa_click` (`id_click`, `nome`, `immagine`, `posizione`, `mobile`, `meteo`, `larghezza`, `altezza`) VALUES
(1, 'Mappa principale', 'map.png', 2, 0, '20°c - sereno', 800, 463),
(2, 'Mappa secondaria', 'spacer.gif', 2, 0, '18°c - nuvoloso', 500, 330);

--
-- Dump dei dati per la tabella `oggetto`
--

INSERT INTO `oggetto` (`id_oggetto`, `tipo`, `nome`, `creatore`, `data_inserimento`, `descrizione`, `ubicabile`, `costo`, `difesa`, `attacco`, `cariche`, `bonus_car0`, `bonus_car1`, `bonus_car2`, `bonus_car3`, `bonus_car4`, `bonus_car5`, `urlimg`) VALUES
(1, 6, 'Scopa', 'Super', '2009-12-20 14:29:33', 'Una comune scopa di saggina.', 2, 10, 0, 0, '3', 1, 0, 0, 0, 0, 0, 'standard_oggetto.png');

--
-- Dump dei dati per la tabella `personaggio`
--

INSERT INTO `personaggio` (`idpg`, `nome`, `cognome`, `pass`, `ultimo_cambiopass`, `data_iscrizione`, `email`, `permessi`, `ultima_mappa`, `ultimo_luogo`, `esilio`, `data_esilio`, `motivo_esilio`, `autore_esilio`, `sesso`, `id_razza`, `descrizione`, `affetti`, `stato`, `online_status`, `disponibile`, `url_img`, `url_img_chat`, `url_media`, `blocca_media`, `esperienza`, `car0`, `car1`, `car2`, `car3`, `car4`, `car5`, `salute`, `salute_max`, `data_ultima_gilda`, `soldi`, `banca`, `ultimo_stipendio`, `last_ip`, `is_invisible`, `ultimo_refresh`, `ora_entrata`, `ora_uscita`, `posizione`, `ultimo_messaggio`, `forma`) VALUES
(1, 'Super', 'User', '$P$BJE001D5rCOyecNLf2m7eZV.UhUB/G1', NULL, '2011-06-04 00:47:48', 'email@domain.ext', 4, 1, -1, '2015-06-26', '2015-06-26', '', 'Super', 'm', 1000, 'test', 'test', 'test', '', 1, 'https://i.pinimg.com/736x/fb/d1/b0/fbd1b0dfc7a155f201f6581035d5d4bc--cyberpunk--cyberpunk-art.jpg', ' ', 'http://finaldistance.net/mp3/Initial%20D%20D%20Selection/Dave%20Rodgers%20-%20Space%20Boy.mp3', '0', '1000.2090', 7, 8, 6, 5, 6, 5, 100, 100, '0000-00-00 00:00:00', 300, 50600, '2020-07-14', '192.168.1.101', 0, '2020-07-15 02:42:08', '2020-07-14 22:42:07', '2020-07-14 22:31:23', 1, 1, 0),
(2, 'Test', 'Di Funzionalià ', '$P$BDbMuQu8/x4NVfin/nsTGtzwoWixwK1', NULL, '2011-06-04 00:47:48', 'test@domain.ext', 0, 1, -1, '0000-00-00', '0000-00-00', '', '', 'm', 1000, '', '', 'Nella norma', '', 1, 'imgs/avatars/empty.png', ' ', '', '0', '1000.0000', 7, 8, 6, 5, 6, 5, 100, 100, '0000-00-00 00:00:00', 50, 90, '2020-07-11', '192.168.1.101', 0, '2020-07-11 18:01:49', '2020-07-11 12:18:19', '2020-06-20 02:52:20', 1, 4, 0);

--
-- Dump dei dati per la tabella `razza`
--

INSERT INTO `razza` (`id_razza`, `nome_razza`, `sing_m`, `sing_f`, `descrizione`, `bonus_car0`, `bonus_car1`, `bonus_car2`, `bonus_car3`, `bonus_car4`, `bonus_car5`, `immagine`, `icon`, `url_site`, `iscrizione`, `visibile`) VALUES
(1000, 'Umani', 'Umano', 'Umana', '', 0, 0, 0, 0, 0, 0, 'standard_razza.png', 'standard_razza.png', '', 1, 1);

--
-- Dump dei dati per la tabella `ruolo`
--

INSERT INTO `ruolo` (`id_ruolo`, `gilda`, `nome_ruolo`, `immagine`, `stipendio`, `capo`) VALUES
(1, 1, 'Capitano della guardia', 'standard_gilda.png', 100, 1),
(2, 1, 'Ufficiale della guardia', 'standard_gilda.png', 70, 0),
(5, -1, 'Lavoratore', 'standard_gilda.png', 5, 0),
(3, 1, 'Soldato della guardia', 'standard_gilda.png', 40, 0),
(4, 1, 'Recluta della guardia', 'standard_gilda.png', 15, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
