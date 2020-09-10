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
	<h2>Fase 3: Creazione utenza gestione</h2>
	<p>Inserire nei campi del form dati dell'uuser e del personaggio che verranno utilizzati come utenza di gestione.<br />
	Si consiglia di annotare da qualche parte o di ricordarsi i dati dell'user in quanto per la creazione di questa 
	particolar eutenza non verraà inviata nessuna mail di registrazione.
	</p>
	<?php \template\load('errors',$TAG); ?>
	<form action="index.php" data-function="main" method="post" style="max-width:360px;margin:auto;">
		<div class="fields">
			<label class="flex_item">Pg:</label>
			<input type="text" name="nome" value="Gestore" class="flex_item" />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Il nome dell'account di gestione da creare.
			</div>
		
			<label class="flex_item">Mail:</label>
			<input type="email" name="mail" placeholder="Mail per l'utenza" class="flex_item" />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> L'email associata all'account di gesitone.
			</div>
		
			<label class="flex_item">Pass:</label>
			<input type="password" name="pass" value="root" class="flex_item" />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> La password dell'account di gestione.
			</div>

			<label class="flex_item">Conferma pass:</label>
			<input type="password" name="pass1" value="root" class="flex_item" />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> La password dell'account di gestione.
			</div>
			
			<input type="hidden" name="op" value="fase_4" />
		</div>
		<div class="tc">
			<input type="submit" value="Completa" />
		</div>
	</form>
</section>