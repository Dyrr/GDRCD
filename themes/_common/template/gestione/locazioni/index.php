<?php
/**
 *  @file       themes/_common/template/gestione/locazioni/index.php
 *  
 *  @brief      Template di default per la gestione dei luoghi
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */
    defined('GDRCD') OR exit('Non è permesso accesso diretto ai template'); 
?>
<div class="pagina_gestione_locazioni">
	<div class="page_title">
		<h2>Gestione Locazioni</h2>
	</div>
	<?php \template\load('paginate',$TAG['page']['pagination']); ?>
	<div class="elenco_luoghi">
		<h2>Elenco luoghi</h2>
		<table>
			<tr>
				<th>Nome</th>
				<th>Mappa</th>
				<th>Operazioni</th>
			</tr>
<?php
			foreach($TAG['page']['locazioni'] as $v) {
?>
				<tr>
					<td><?php out($v['nome']); ?></td>
					<td><?php out($v['mappa_click']); ?></td>
					<td>
						<a href="main.php?page=gestione__locazioni&id=<?php out($v['id']); ?>&op=edit">
							<i class="fas fa-edit"></i> Modifica
						</a> 
						<a href="main.php?page=gestione__locazioni&id=<?php out($v['id']); ?>&op=delete">
							<i class="fas fa-trash-alt"></i> Elimina
						</a>						
					</td>
				<tr>
<?php
			}
?>
		</table>
	</div>
	<?php \template\load('paginate',$TAG['page']['pagination']); ?>
	<div class="tc">
		<div class="button">
			<a href="main.php?page=gestione__locazioni&op=new">
				Nuova locazione
			</a>
        </div>
	</div>    
</div>