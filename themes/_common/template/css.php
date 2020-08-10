<?php
/**
 *  @file       themes/advanced/template/css.php
 *  
 *  @brief      Template con l'elenco dei css utilizzati dal CMS
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */
    defined('GDRCD') OR exit('Non è permesso accesso diretto ai template'); 
?>		
	<link rel="stylesheet" 
		  href="<?php echo csscrush_file('themes/' . $PARAMETERS['themes']['current_theme'] . '/css/source/gdrcd.css'); ?>" 
		  type="text/css" />	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.1/css/all.css" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.9/mediaelementplayer.min.css" />
	