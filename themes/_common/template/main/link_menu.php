<?php
/**
 *  @file       themes/_common/template/main/link_menu.php
 *  
 *  @brief      Template per il menù principale della land
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */
    defined('GDRCD') OR exit('Non è permesso accesso diretto ai template'); 
?>
<div class="pagina_link_menu">
		<select id="gotomap" onchange="$('main .modulo.ajax').load(this.value);history.pushState({}, '', this.value);">
<?php
			//CICLA L'ELENCO DELLE MAPPE E LOCAIZONI
			foreach($TAG['page']['locazioni'] as $v) {
				//visualizzando le voci
?>
<?php
				if($v['mappa'] === true) {
?>
                    <option value="main.php?page=mappaclick&map_id=<?php out($v['id_click']); ?>" class="map">
						<?php out($v['nome']); ?>
					</option>		
<?php
				} else {
?>
                    <option value="main.php?dir=<?php out($v['id']); ?>&id_map=<?php out($v['id_click']); ?>">
						<?php out($v['nome_chat']); ?>
					</option>
<?php
				}
?>
<?php
			}
?>
		</select>
		<div class="page_title">
			<h2>Menù</h2>
		</div>
		<div class="page_body">
			<?php \template\load('menu',$PARAMETERS['menu']); //carica il template che genera il menù principale ?>			
		</div>
</div>