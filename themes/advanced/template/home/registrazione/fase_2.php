<?php
/**
 *  @file       themes/advanced/template/home/registrazione/fase_2.php
 *  
 *  @brief      Template per la fase 2 della registrazione del personaggio
 *  
 *  @version    5.6.0
 *  @date       14/07/2020
 *  
 *  @author     Davide 'Dyrr' Grandi
 */ 
   defined('GDRCD') OR exit('Non è permesso accesso diretto ai template');
?>
<section class="iscrizione">
	<h1><?php echo gdrcd_filter_out($MESSAGE['register']['page_name']); ?></h1>
	<h2>Fase 2</h2>
	<table>
		<caption><?php echo gdrcd_filter_out($MESSAGE['register']['summary']) ?></caption>
		<tr>
			<td>E-mail</td>
			<td><?php echo gdrcd_filter_out($_REQUEST['email']) ?></td>
		</tr>
		<tr>
			<td>Nome</td>
			<td><?php echo gdrcd_filter_out($_REQUEST['nome']) ?></td>
		</tr>
		<tr>
			<td>Cognome</td>
			<td><?php echo gdrcd_filter_out($_REQUEST['cognome']) ?></td>
		</tr>
		<tr>
			<td>Sesso</td>
			<td><?php echo gdrcd_filter_out($_REQUEST['genere']) ?></td>
		</tr>
		<tr>
			<td>Razza</td>
			<td><?php echo gdrcd_filter_out($razza['nome_razza']) . '&nbsp;' ?></td>
		</tr>
<?php
		//cicla le statistiche per creare le righe della tabella con i dati delle statistiche del pg
		//in questa maniera se vengono aggiunte statistiche al sistema di gioco non occorre modificare il template
		foreach($TAG['page']['pg_stat'] as $k => $v) {
?>
			<tr>
				<td><?php echo gdrcd_filter_out($v); ?></td>				
				<td><?php echo gdrcd_filter_num($_REQUEST[$k]); ?></td>
			</tr>
<?php
		}
?>
	</table>
	<form action="<?php echo $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING']; ?>" method="post">
		<div class="submit">
			<input type="hidden" name="fase" value="3"/>
<?php 
			//include il template con i dati del personagigo da passare tramite input hidden
			require \template\file('home/registrazione/dati_pg');
?>
			<input type="submit"
				   value="<?php echo gdrcd_filter_out($MESSAGE['register']['forms']['ok']); ?>"/>
		</div>
	</form>
	<form action="<?php echo $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING']; ?>" method="post">
		<div class="submit">
			<input type="hidden" name="fase" value="1"/>
<?php 
			//include il template con i dati del personagigo da passare tramite input hidden
			require \template\file('home/registrazione/dati_pg');
?>
			<input type="submit" value="<?php echo gdrcd_filter_out($MESSAGE['register']['forms']['back']); ?>"/>
		</div>
	</form>
</section>