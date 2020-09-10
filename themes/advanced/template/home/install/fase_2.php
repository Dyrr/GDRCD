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
<div class="page install">
	<h1>Installazione</h1>
	<h2>Fase 2: Operazioni sul database</h2>
	<p>In questa fase vengono definiti i parametri e il metodo di connessione al database e una volta creata una 
	connessione valida viene verificata la versione del server MySQL. Se la procedura non presenta nessun tipo di errore 
	e se il database selezionato è vuoto viene importato il database.
	</p>
	<?php \template\load('errors',$TAG); ?>
	<form action="index.php" data-function="main" style="max-width:360px;margin:auto;">
		<div class="fields">
			<label class="flex_item">Host:</label>
			<input type="text" name="host" value="localhost" class="flex_item" />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> L'host del database a cui si vuole avere accesso.
			</div>
			
			<label class="flex_item">User:</label>
			<input type="text" name="user" value="root" class="flex_item" />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> L'username con cui si effettua l'accesso al database.
			</div>
			
			<label class="flex_item">Pass:</label>
			<input type="text" name="pass" value="root" class="flex_item" />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> La password di accesso al database.
			</div>
			
			<label class="flex_item">Database:</label>
			<input type="text" name="database" value="gdrcd" class="flex_item" />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Il nome del database a cui collegarsi.
			</div>	
			
			<input type="hidden" name="op" value="fase_3" />
		</div>
		<div class="tc submit">
			<input type="submit" value="Fase 3" />
		</div>
	</form>
</div>