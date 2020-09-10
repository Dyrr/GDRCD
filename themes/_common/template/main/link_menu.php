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
				//SE LA VOCE È UNA VOCE DI MAPPA
				if($v['mappa'] === true) {
?>
<?php
					//SE LA MAPPA NON È LA STESSA DI CUI SI STANNO VISUALIZZANDO LE LOCAZIONI					
					if($v['id_click'] != $v['id_mappa_collegata']) {
?>
						<option value="main.php?page=mappa&map_id=<?php out($v['id_click']); ?>" class="map">
							<?php out($v['nome_locazione']); ?>
						</option>
<?php
					}
?>
<?php
				//SE LA VOCE È UNA LOCAZIONE
				} else {
?>
<?php
					//SE LA LOCAIZONE PUNTA AD UNA CHAT
					if($v['id_mappa_collegata'] == 0) {
?>
						<option value="main.php?dir=<?php out($v['id']); ?>&id_map=<?php out($v['id_click']); ?>">
							<?php out($v['nome_locazione']); ?>
						</option>
<?php
					//SE LA LOCAIZONE PUNTA AD UNA SOTTOMAPPA
					} else {
?>
						<option value="main.php?page=mappa&map_id=<?php out($v['id_mappa_collegata']); ?>">
							<?php out($v['nome_locazione']); ?>
						</option>
<?php
					}
?>
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