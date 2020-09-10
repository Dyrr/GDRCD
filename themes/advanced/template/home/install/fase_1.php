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
	//var_dump($TAG['page']['requisiti']);
	//echo "</pre>";
?>
		<div class="page_install">
			<h1>Installazione</h1>
			<h2>Fase 1: Controllo requisiti</h2>
			<p>In questa fase viene controllato che tutti i prerequisiti per il funzionamento del GDRCD siano soddisfatti 
			prima di installarlo. L'unico prerequisito che non viene controllato in questa fase è la verifica della versione 
			minima del server MySQL necessaria per il GDRCD. Questo requisito verrà controllato nella fase 2 nel momento in 
			cui si andranno ad impostare i dati della connessione al database.</p>
			Versione di PHP installata:  
<?php
			//SE È UTILIZZATA LA VERSIONE MINIMA DI PHP RICHIESTA
			if($TAG['page']['requisiti']['PHP']['status'] === true) {
				//mostra il messaggio di ok
?>
				<span class="ok">
					<?php out($TAG['page']['requisiti']['PHP']['version']); ?> <i class="fas fa-check"></i>
				</span>
				<br />
<?php
			//SE NON È UTILIZZATA LA VERSIONE MINIMA DI PHP RICHIESTA			
			} else {
				//mostra il messaggio di errore
?>
				<span class="nook">
					<?php out($TAG['page']['requisiti']['PHP']['version']); ?> <i class="fas fa-times"></i>
				</span>
				<br />
				<section class="error">
					<div class="msg">
						Stai usando <?php out($TAG['page']['requisiti']['PHP']['version']); ?>. Il <?php echo $TAG['page']['version']['name']; ?> 
						<?php echo $TAG['page']['version']['number']; ?> <?php echo $TAG['page']['version']['subname']; ?> richiede 
						<?php out($TAG['page']['requisiti']['PHP']['min']); ?> o superiore per funzionare. Solitamente puoi modificare la versione di 
						PHP utilizzata dal pannello di gestione del sito. Consulta le guide specifiche del tuo host per come fare
					</div>
				</section>
<?php
			}
?>		
			Estensione openssl:  
<?php
			//SE L'ESTENSIONE OPENSSL È ATTIVA
			if($TAG['page']['requisiti']['estensioni']['openssl'] === true) {
				//mostra il messaggio di ok
?>
				<span class="ok">
					<?php echo OPENSSL_VERSION_TEXT; ?>	<i class="fas fa-check"></i>
				</span>
				<br />
<?php
			//SE L'ESTENSIONE OPENSSL NON È ATTIVA		
			} else {
				//mostra il messaggio di errore
?>
				<span class="nook">
					<?php echo OPENSSL_VERSION_TEXT; ?>	<i class="fas fa-times"></i>
				</span>
				<br />
				<section class="error">
					<div class="msg">
						L'estensione openssl di php è necessaria per far funzionare Il <?php echo $TAG['page']['version']['name']; ?> 
						<?php echo $TAG['page']['version']['number']; ?> <?php echo $TAG['page']['version']['subname']; ?>
					</div>
				</section>
<?php
			}
?>				
			Estensione PDO:  
<?php
			//SE L'ESTENSIONE PDO È ATTIVA
			if($TAG['page']['requisiti']['estensioni']['pdo_mysql'] === true) {
				//mostra il messaggio di ok
?>
				<span class="ok">
					<?php echo phpversion('pdo_mysql'); ?>	<i class="fas fa-check"></i>
				</span>
<?php
			//SE L'ESTENSIONE PDO NON È ATTIVA		
			} else {
				//mostra il messaggio di errore
?>
				<span class="nook">
					<?php echo phpversion('pdo_mysql'); ?>	<i class="fas fa-times"></i>
				</span>
<?php
			}
?>
			<br />
			Estensione MySQLi :  
<?php
			//SE L'ESTENSIONE MYSQLI È ATTIVA
			if($TAG['page']['requisiti']['estensioni']['mysqli'] === true) {
				//mostra il messaggio di ok
?>
				<span class="ok">
					<?php echo phpversion('mysqli'); ?>	<i class="fas fa-check"></i>
				</span>

<?php
			//SE L'ESTENSIONE MYSQLI NON È ATTIVA			
			} else {
				//mostra il messaggio di errore
?>
				<span class="nook">
					<?php echo phpversion('mysqli'); ?>	<i class="fas fa-times"></i>
				</span>
<?php
			}
?>
			<br />
			Estensione MySQLi native driver:  
<?php
			//SE L'ESTENSIONE MYSQLI NATIVE DRIVER È ATTIVA
			if($TAG['page']['requisiti']['estensioni']['mysqlnd'] === true) {
				//mostra il messaggio di ok
?>
				<span class="ok">
					<?php echo phpversion('mysqlnd'); ?>	<i class="fas fa-check"></i>
				</span>

<?php
			//SE L'ESTENSIONE MYSQLI NATIVE DRIVER NON È ATTIVA			
			} else {
				//mostra il messaggio di errore
?>
				<span class="nook">
					<?php echo phpversion('mysqlnd'); ?>	<i class="fas fa-times"></i>
				</span>
<?php
			}
?>
<?php
			//SE NEMMENO UNO DEI DRIVER DI CONNESSIONE AL DATABASE È DISPONIBILE
			if($TAG['page']['requisiti']['MySQL']['db_driver'] === false) {
				//mostra il messaggio di errore
?>
				<br />
				<section class="error">
					<div class="msg">
						Nessuno dei driver di connessione al database è disponibile.
					</div>
				</section>
<?php
			}
?>			
<?php
			//SE CI SONO TUTTI I REQUISITI PER PROSEGUIRE L'INSTALLAZIONE
			if($TAG['page']['requisiti']['all'] === true) {
				//visualizza il form per accedere alla fase 2
?>			
				<br />
				<br />
				<form action="index.php" data-function="main" method="post" style="max-width:360px;margin:auto;">
					<div class="tc">
						<input type="hidden" name="op" value="fase_2" />			
						<input type="submit" value="Fase 2" />
					</div>
				</form>
<?php
			//SE CI SONO TUTTI I REQUISITI PER PROSEGUIRE L'INSTALLAZIONE
			} else {
				//visualizza il messaggio di errore
?>
				<section class="error">
					<h3>Errore</h3>

					<div class="msg">
						Mancano uno o più requisiti fondamentali per proseguire l'installazione
					</div>
				</section>
<?php
			}
?>				
		</div>