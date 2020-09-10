<?php
/**
 *  @file system\config\install.php
 *  
 *  @brief Parametri dello stato di installazione del CMS
 *  
 *  @version 5.6.0
 *  @date    dyrr/dyrr/dyrr
 *  
 *  @author  Davide 'Dyrr' Grandi
 *  
 *  @details Il file contiene i parametri di configurazione dello stato di installazione del CMS, i parametri servono 
 *  principalmente per impedire che si possa rieseguire la procedura di installazione del CMS una volta fatta la prima 
 *  volta senza che i parametri vengano resettati
 *  
 *  @note Sebbene questo dovrebbe prevenire qualsiasi tentativo di malintenzionati di rieseguire la procedure di 
 *  setup del CMS, si consiglia comunque una volta effettuato il setup di cancellare il contenuto della cartella 
 *  system/install *  
 */

 /**
 * \defgroup config Parametri di configurazione
 * @{
 */	
	
   /**
   * \defgroup config_install Stato di installazione del CMS
   * @{
   */	
	
	/** @brief stato della configurazione dei parametri di connessione **/	
	$PARAMETERS['install']['conn'] = true;
	/** @brief stato dell'installazione del database **/	
	$PARAMETERS['install']['db'] = true;
	/** @brief stato di installazione del cms **/	
	$PARAMETERS['install']['complete'] = true; 
	
   /**@}*/
 /**@}*/