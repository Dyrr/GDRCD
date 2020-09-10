<?php
/**
 *  @file system\config\gdrcd.php
 *  
 *  @brief Parametri informativi della versione attuale del CMS.
 *  
 *  @version 1.0.0
 *  @date    17/07/2018
 *  
 *  @author  Davide 'Dyrr' Grandi
 *  
 *  @details Per la numerazione della versione attenersi al Versionamento semantico.
 *  
 *  @see http://semver.org/lang/it/
 *  @see https://github.com/dbrock/semver-howto
 */

 /**
 * \defgroup config Parametri di configurazione
 * @{
 */	 
 
   /**
   * \defgroup parameters_version Parametri informativi della versione attuale del CMS
   *
   *  @details Parametri che contengono tutte le informazioni sulla release attuale e che non dovrebbero essere modificati 
   *  se non nel caso di rilascio di una nuova versione dell'engine.
   * @{
   */
	
	/** @brief Nome del CMS */	
	$PARAMETERS['version']['name'] = 'GDRCD';	
	/** @brief nome della versione */		
	$PARAMETERS['version']['subname'] = 'Refactory';	
	/** @brief Numero della versione */		
	$PARAMETERS['version']['number'] = '5.6.0';	
	/** @brief Elenco autori */	
	$PARAMETERS['version']['date'] = 'dyrr/dyrr/dyrr';	
	/** @brief Elenco autori */	
	
	$PARAMETERS['version']['author']['5.0'][0]['name'] = "MrFaber";	
	$PARAMETERS['version']['author']['5.1'][0]['name'] = "Salvatore 'Blancks' Rotondo";	
	$PARAMETERS['version']['author']['5.2'][0]['name'] = "Breaker";	
	$PARAMETERS['version']['author']['5.3'][0]['name'] = "Breaker";	
	$PARAMETERS['version']['author']['5.4'][0]['name'] = "Breaker";	
	$PARAMETERS['version']['author']['5.5'][0]['name'] = "Breaker";	
	$PARAMETERS['version']['author']['5.6'][0]['name'] = "Davide 'Dyrr' Grandi";	
	$PARAMETERS['version']['author']['5.6'][0]['mail'] = "Dyrr73@gmail.com";	
	/** @brief Descrizione breve */	
	$PARAMETERS['version']['description'] = 'CMS per la creazione di Play by Chat o tavoli virtuali per Giochi di Ruolo';
	$PARAMETERS['version']['details']  = 'Versione con ampio refactory del codice per facilitarne la comprensione e lo '; 
	$PARAMETERS['version']['details'] .= 'sviluppo.[br]';
	$PARAMETERS['version']['details'] .= 'Incompatibile con le versioni precedenti.';
	
	$PARAMETERS['version']['changelog']['new'][]  = 'Inserito CSSCrush come preprocessore per i CSS.';	
	$PARAMETERS['version']['changelog']['new'][]  = 'Inserito un gestore dei template per separare logica di codice e HTML.';	
	$PARAMETERS['version']['changelog']['new'][]  = 'Inserito possibilità di selezionare l\'intervallo dello stipendio ' 
		. 'tra giornaliero, settimanale, mensile';	
	
	$PARAMETERS['version']['changelog']['changed'][] = 'Aggiornato il gestore delle password.';	
	$PARAMETERS['version']['changelog']['changed'][] = 'Aggiornato il modulo della mappa e della relativa gestione locazioni.';	
	
	$PARAMETERS['version']['changelog']['fixed'][] = 'Corretto il bug sul coockie di controllo doppi.';	
	$PARAMETERS['version']['changelog']['fixed'][] = 'Corretto il file gestione_manutenzione.inc.php.';	
  

  /**@}*/ 
 
	/**
	* \defgroup config_session Parametri di configurazione delle sessioni
	* @{
	*
	* @todo decidere se salvare altri parametri sulle impostazioni delle sessioni qui	 
	*/	
	
		/** 
		 *  @brief Driver del gestore delle sessioni
		 *  @details Possibili valori:
		 *  	- file (gestore di default delle sessioni di PHP)
		 *  	- db (salvataggio delle sessioni nel database)
		 */	
		$PARAMETERS['session']['driver'] = 'db';
	
	/**@}*/	

   
   
   /**
   * \defgroup parameters_requisiti Requisiti minimi del sistema
   * @{
   */	
 
	/**
	 *  @brief		Versione minima di PHP richiesta dal sistema
	 *  
	 *  @details	La versione di PHP utilizzata solitamente è impostabile dal pannello di controllo de sito fornito 
	 *  dall'host a cui ci si appoggia. Per le istruzioni su come modificare la versione di php utilizzata consultare le 
	 *  quide fornite dall'host specifico	 
	 */
	$PARAMETERS['requisiti']['php']['min_version'] = '7.0.0';
	
	/** 
	 *  @brief		Versione minima di MySQL richiesta dal sistema
	 *  
	 *  @details	La versione di MySQL utilizzata solitamente non è modificabile direttamente dall'utente. La versione 
	 *  minima di MySQL richiesta è molto vecchia per cui non si dovrebbero avere problemi sotto questo punto di vista. 
	 *  In caso l'host utilizzato ne utilizzasse una inferiore si consiglia di contattare il fornitore dei servizi.
	 */
	$PARAMETERS['requisiti']['mysql']['min_version'] = '5.6.0';
   
   /**@}*/

	/**
	 *  @brief		Estensioni di PHP necessarie
	 */	
	$PARAMETERS['requisiti']['extensions'] = array(
		'openssl',
		'pdo_mysql',
		'mysqli',
		'mysqlnd'	
	); 
	
	$CONFIG['status']['land'] = 'develop';
	
 /**@}*/