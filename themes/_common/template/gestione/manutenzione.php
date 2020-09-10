<?php
/**
 *  @file       themes/_common/template/gestione/manutenzione.php
 *  
 *  @brief      Template base della gestione manutenzione
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */
    defined('GDRCD') OR exit('Non è permesso accesso diretto ai template'); 
?>
<div class="pagina_gestione_manutenzione">
	<div class="page_title">
		<h1>Gestione Manutenzione</h1>
	</div>
	<div class="content">
		<h2>Eliminazione log vecchi</h2>
		<form action="main.php?page=gestione__manutenzione" method="post" 
			  data-target=".pagina_gestione_manutenzione .content">
			<div class="fields">
				<label>
					Numero mesi
				</label>
				<select name="mesi" ?>
<?php 
					for($i = 0; $i <= 12; $i++) {
?>
						<option value="<?php out($i); ?>"><?php out($i); ?> mesi</option>
<?php 
					}
?>
				</select>
				<div class="form_info">
					<i class="far fa-question-circle"></i> Il numero di mesi precedenti a cui si vuole cancellare i log
				</div>
			</div>
			<div class="submit">
				<input type="hidden" name="op" value="old_log">
				<input type="submit" value="Cancella" />
			</div>
		</form>

		<h2>Eliminazione chat vecchie</h2>
		<form action="main.php?page=gestione__manutenzione" method="post" 
			  data-target=".pagina_gestione_manutenzione .content">
			<div class="fields">
				<label>
					Numero mesi
				</label>
				<select name="mesi" ?>
<?php 
					for($i = 0; $i <= 12; $i++) {
?>
						<option value="<?php out($i); ?>"><?php out($i); ?> mesi</option>
<?php 
					}
?>
				</select>
				<div class="form_info">
					<i class="far fa-question-circle"></i> Il numero di mesi precedenti a cui si vogliono cancellare le chat
				</div>
			</div>
			<div class='submit'>
				<input type="hidden" name="op" value="old_chat">
				<input type="submit" value="Cancella" />
			</div>
		</form>

		<h2>Eliminazione messaggi vecchi</h2>
		<form action="main.php?page=gestione__manutenzione" method="post" 
			  data-target=".pagina_gestione_manutenzione .content">
			<div class="fields">
				<label>
					Numero mesi
				</label>
				<select name="mesi" ?>
<?php 
					for($i = 0; $i <= 12; $i++) {
?>
						<option value="<?php out($i); ?>"><?php out($i); ?> mesi</option>
<?php 
					}
?>
				</select>
				<div class="form_info">
					<i class="far fa-question-circle"></i> Il numero di mesi precedenti a cui si vogliono cancellare i messaggi
				</div>
			</div>
			<div class='submit'>
				<input type="hidden" name="op" value="old_messages">
				<input type="submit" value="Cancella" />
			</div>
		</form>

		<h2>Eliminazione personaggi disabilitati</h2>
		<form action="main.php?page=gestione__manutenzione" method="post" 
			  data-target=".pagina_gestione_manutenzione .content">
			<div class="fields">
				<div class="form_info">
					<i class="far fa-question-circle"></i> Elimina i personaggi il cui account è stato disabilitato
				</div>		
				<div class="form_info">
					<i class="fas fa-exclamation-triangle"></i> <b>ATTENZIONE! Non sarà più possibile ripristinarli.</b>
				</div>			
			</div>
			<div class='submit'>
				<input type="hidden" name="op" value="deleted">
				<input type="submit" value="Cancella" />
			</div>
		</form>

		<h2>Eliminazione personaggi inattivi</h2>
		<form action="main.php?page=gestione__manutenzione" method="post" 
			  data-target=".pagina_gestione_manutenzione .content">
			<div class="fields">
				<label>
					Numero mesi
				</label>
				<select name="mesi" ?>
<?php 
					for($i = 0; $i <= 12; $i++) {
?>
						<option value="<?php out($i); ?>"><?php out($i); ?> mesi</option>
<?php 
					}
?>
				</select>
				<div class="form_info">
					<i class="far fa-question-circle"></i> Il numero di mesi minimi da quando il personagigo non effettua 
					più il login
				</div>
			</div>
			<div class='submit'>
				<input type="hidden" name="op" value="missing">
				<input type="submit" value="Cancella" />
			</div>
		</form>

		<h2>Eliminazione IP nella blackllist</h2>
		<form action="main.php?page=gestione__manutenzione" method="post" 
			  data-target=".pagina_gestione_manutenzione .content">
			<div class="fields">
				<div class="form_info">
					<i class="far fa-question-circle"></i> Svuota la blackist degli IP
				</div>		
				<div class="form_info">
					<i class="fas fa-exclamation-triangle"></i> 
					<b>ATTENZIONE! il comando elimina <u>tutti</u> gli IP presenti nella blacklist</b>
				</div>			
			</div>
			<div class='submit'>
				<input type="hidden" name="op" value="blacklisted">
				<input type="submit" value="Cancella" />
			</div>
		</form>
	</div>
	<div class="tc">
		<div class="button">
			<a href="main.php?page=gestione">
				Torna alla gestione
			</a>		
		</div>
	</div>	
</div>