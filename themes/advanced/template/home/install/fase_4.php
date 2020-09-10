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
			<h1>Installazione</h1>
			<h2>Installazione Completata con successo</h2>
			<p>La procedura di installazione del GDRCD 5.6 è stata completata con successo<br />
			Da questo momento in poi non sarà più possibile accedere alle pagine con la procedura di installazione a meno di 
			non resettare il file di configurazione dell'installazione. Nel caso si volesse fare si prega di consultare la 
			documentazione al riguardo.</p>
			<form action="index.php" data-function="main" method="post" style="max-width:360px;margin:auto;">
				<div class="tc">
					<input type="submit" value="Torna alla home" />
				</div>
			</form>		
		</section>