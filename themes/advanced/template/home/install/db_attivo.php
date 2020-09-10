<?php
/**
 *  @file public\themes\_common\desktop\template\install\fase_1.php
 *  
 *  @brief Template della padina principale della home del CMS
 *  
 *  @version 1.0.0
 *  @date    19/07/2018
 *  
 *  @author  Davide 'Dyrr' Grandi
 */

//IMPORTANTE: CONTROLLO DA INSERIRE SEMPRE ALL'INIZIO DI OGNI TEMPLATE PER IMPEDIRE IL CARICAMENTO AUTONOMO DEL TEMPLATE;
//=======================================================================================================================
//tutto l'output è già automaticamente filtrato quando viene passatao alla funzione: Template::load();	
	defined('GDRCD') OR exit('Non è permesso accesso diretto ai template');
	//echo "<pre>";
	//print_r($TAG);
	//echo "</pre>";
?>
<section class="page install">
	<h3>Installazione</h3>
	<h4>Fase 1: connessione al database</h4>
	<br />
	La connessione al database è gia attiva vuoi:
	<ul>
		<li>
			<a href="index.php?op=fase_2" data-function="main">Installare il database</a>
		</li>
		<li>
			<a href="index.php?op=reset_conn" data-function="main">Modificare le impostazioni di connesisone</a>
		</li>
	</ul>
</section>