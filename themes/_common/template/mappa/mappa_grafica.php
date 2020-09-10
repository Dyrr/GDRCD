<?php
/**
 *  @file       themes/_common/template/mappa/mappa_grafica.php
 *  
 *  @brief      Template la mappa grafica della land
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @see css/source/pages/mappa.css
 */
    defined('GDRCD') OR exit('Non è permesso accesso diretto ai template'); 
	//var_dump($TAG['page']['mappa']['locazioni']);
?>
	<div class="mappa_grafica">
		<div class="page_title">
			<h2 style="white-space:nowrap;"><?php out($TAG['page']['mappa']['dati']['nome']); ?></h2>
		</div>
		<div class="map_container">
<?php
	$w = $TAG['page']['mappa']['dati']['larghezza'];
	$h = $TAG['page']['mappa']['dati']['altezza'];
	$w1 = '90';
	$h1 = (($h / $w) * 100) * 0.9;
?>			
			<div class="map" 
			     style="width:0px;
				        height:0px;
						background-image:url('themes/_common/imgs/maps/<?php out($TAG['page']['mappa']['dati']['img_map']); ?>');">
				<div class="linear_grid1">
			
<?php
					//CICLA L'ELENCO DELLE LOCAIZONI
					foreach($TAG['page']['mappa']['locazioni'] as $v) {
?>
<?php
						//SE LA LOCAZIONE È RAPPRESENTATA DA UNA IMMAGINE
						if($v['link_immagine'] != '') {
							//visualizza il marcatore dell'immagine
							//imarcatori con le immagini possono essere personalizzati nel file css/source/pages/mappa.css
?>
<?php
							//SE LA LOCAIZONE È UNA MAPPA
							if($v['id_mappa_collegata'] != 0) {
								//mostra il marcatore e il link per la sottomappa
?>
								<a href="main.php?page=mappa&map_id=<?php out($v['id_mappa_collegata']); ?>" 
								   class="marker_mappa mappa_<?php out($v['id_mappa_collegata']); ?>" 
								   style="left:<?php out(($v['x_cord'] * 100) / $TAG['page']['mappa']['dati']['larghezza']); ?>%;
								   top:<?php out(($v['y_cord'] * 100) / $TAG['page']['mappa']['dati']['altezza']); ?>%;"
								   data-function="main">								
								</a>
<?php
							//SE LA LOCAIZONE È UNA CHAT
							} else {
								//mostra il marcatore e il link per la chat
?>
								<a href="main.php?dir=<?php out($v['id']); ?>" 
								   class="marker_locazione  locazione_<?php out($v['id']); ?>" 							   
								   style="left:<?php out(($v['x_cord'] * 100) / $TAG['page']['mappa']['dati']['larghezza']); ?>%;
								   top:<?php out(($v['y_cord'] * 100) / $TAG['page']['mappa']['dati']['altezza']); ?>%;"							   
								   data-function="main">
								</a>
<?php
							}
?>
<?php
						//SE LA LOCAZIONE È RAPPRESENTATA DA UNA IMMAGINE					
						} else {
							//visualizza i marcatori creati graficamente
?>
							<div class="marker" 
							     style="left:<?php out(($v['x_cord'] * 100) / $TAG['page']['mappa']['dati']['larghezza']); ?>%;
								 top:<?php out(($v['y_cord'] * 100) / $TAG['page']['mappa']['dati']['altezza']); ?>%;">
<?php
								//SE LA LOCAIZONE È UNA MAPPA
								if($v['id_mappa_collegata'] != 0) {
									//mostra il marcatore e il link per la sottomappa
?>
									<div class="label"><?php out($v['nome']); ?></div>
									<a href="main.php?page=mappa&map_id=<?php out($v['id_mappa_collegata']); ?>" 
									   data-function="main">
										<div class="pin">
											<i class="fas fa-map"></i>
										</div>	
									</a>
<?php
								//SE LA LOCAIZONE È UNA CHAT
								} else {
									//mostra il marcatore e il link per la chat
?>
									<div class="label"><?php out($v['nome']); ?></div>
									<a href="main.php?dir=<?php out($v['id']); ?>" data-function="main">
										<div class="pin">										
											<i class="fas fa-comments"></i>
										</div>
									</a>
<?php
								}
?>

							</div>
<?php
						}
?>
<?php
					}
?>
				</div>
			</div>
		</div>
	</div>
	<script>
		function map()
		{
			
			$('.mappa_grafica .map').width(0);
			$('.mappa_grafica .map').height(0);	
			
			var width = $(window).width();

			var height = $(window).height();
			var cw = $('.mappa_grafica .map_container').width() - 10;
			var ch = $('.mappa_grafica .map_container').height() - 10;
			var w = <?php out($w); ?>;
			var h = <?php out($h); ?>;
			
			if(width > height) {
			
				var scale = ch / h;
				
			} else {
				
				var scale =  ch / h;
				
			
			}
				
			var new_w = w * scale;
			var new_h = h * scale;
			
			$('.mappa_grafica .map').width(new_w);
			$('.mappa_grafica .map').height(new_h);			
			
			console.log(cw + ' - ' + ch);
			console.log(new_w + ' - ' + new_h);		
		
		}
		
		$(document).ready(function(){
			
			map();
			

			
			
		});
	
		window.addEventListener("resize", function() {
			
			map();

		}, false);
	
	</script>