<?php
define('GDRCD', 'GDRCD');

/*Livelli di accesso utente*/
define('DELETED', -1);
define('USER', 0);
define('SUPERUSER', 4);
define('MODERATOR', 3);
define('GAMEMASTER', 2);
define('GUILDMODERATOR', 1);


//categorie log
define('GENERIC', 0);
define('SYSTEM', 1);
define('SECURITY', 2);
define('PG', 3);
define('LOGIN', 4);
define('ONGAME', 5);
define('SOLDI', 6);



/*Codici di log*/
define('PG_NOT_EXISTS',10000);
define('WRONG_PASSWORD',10001);
define('LOGIN_OK', 10002);
define('DOPPIO_IP', 10003);
define('DOPPIO_COOCKIE', 10004);
define('ALREADY_LOGGED', 10005);
define('BLOCKED', 10006);
define('LOGGEDIN', 10007);
define('ACCOUNTMULTIPLO', 10008);
define('ERRORELOGIN', 10009);

define('STIPENDIO', 60001);
define('BONIFICO', 60002);
define('MERCATO_COMPRA', 60003);
define('MERCATO_VENDI', 60004);

define('UNAUTHORIZED',20001);
define('LACK_OF_PERMISSION',20002);


define('NUOVOLAVORO', 6);
define('DIMISSIONE', 7);
define('CHANGEDROLE', 8);
define('CHANGEDPASS', 9);
define('PX', 10);
define('DELETEPG', 11);
define('CHANGEDNAME', 12);

/*Stati di disponibilità*/
define('NONDISPONIBILE', 0);
define('DISPONIBILE', 1);
define('SOLOSUINVITO', 2);

/*Tipi di forum*/
define('INGIOCO', 0);
define('PERTUTTI', 1);
define('SOLORAZZA', 2);
define('SOLOGILDA', 3);
define('SOLOMASTERS', 4);
define('SOLOMODERATORS', 5);

/*Posizione degli oggetti*/
define('INVENTARIO', 0);
define('ZAINO', 1);
define('MANODX', 2);
define('MANOSX', 3);
define('TORSO', 4);
define('GAMBE', 5);
define('PIEDI', 6);
define('TESTA', 7);
define('ANELLO', 8);
define('COLLO', 9);

/*Stati della mappa*/
define('INVIAGGIO', -1);

/**
 * Livelli di filtro html
 */
define('HTML_FILTER_BASE', 0);
define('HTML_FILTER_HIGH', 1);

const ERROR = array(
				'pg' => array( 
					'generic' => 100001,
					'empty' => 100002,
					'not_found' => 100003
				)
			);

/*Vettori globali dei parametri*/
$PARAMETER = array();
$MESSAGES = array();
