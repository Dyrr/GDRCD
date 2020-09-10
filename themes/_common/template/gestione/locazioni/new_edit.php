<?php
/**
 *  @file       themes/_common/template/gestione/locazioni/new_edit.php
 *  
 *  @brief      Template con il form di creazione e modifica delle locazioni
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */
    defined('GDRCD') OR exit('Non è permesso accesso diretto ai template');
	//alias per velocizzare la scrittura del codice
	$l = $TAG['page']['locazione'];

    $disabled = ($TAG['page']['op'] == 'delete') ? 'disabled' : '';
?>
<div class="pagina_gestione_locazioni">
	<h1>Gestione Locazioni</h1>
	<h2 class="tc"><?php out($TAG['page']['op'] == 'edit' ? 'Modifica' : 'Nuova'); ?></h2>
	<form>
		<div class="fields">
			<label>Nome</label>
			<input type="text" name="nome" value="<?php out($l['nome']); ?>" placeholder="Nome della locazione" <?php out($disabled); ?> />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Nome della locazione.
			</div>
			
			<label>Descrizione</label>
			<textarea name="descrizione" <?php out($disabled); ?> ><?php out($l['descrizione']); ?></textarea>
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Descrizione che deve comparire nella pagina di descrizione della 
			 locazione. In questa sezione è possibile abilitare l'utilizzo di codice HTML.
			</div>
			
			<label>HTML On</label>
			<div class="checkbox">
				<label class="switch">
					<input type="checkbox" name="dascrizione_html" value="1" <?php out(($l['dascrizione_html'] != 0) ? 'checked' : ''); ?> <?php out($disabled); ?> >
					<span class="slider round"></span>
				</label>
			</div>
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Disattivare se non si vuole permettere l'HTML nella descrizione 
			 della locazione.
			</div>			
			
			<label>Stato</label>
			<textarea name="stato" <?php out($disabled); ?> ><?php out($l['stato']); ?></textarea>			
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Sezione da utilizzare per l'inserimento di stati temporanei della 
			 locazione senza dover toccare la descrizione della chat. In questa sezione non è possibile utilizzare 
			 l'HTML puro senza intervenire sul file template/gestione/locazioni/new_edit.php.
			</div>
			
			<label>Chat</label>
			<div class="checkbox">
				<label class="switch">
					<input type="checkbox" name="chat" value="1" <?php out(($l['chat'] != 0) ? 'checked' : ''); ?> <?php out($disabled); ?> >
					<span class="slider round"></span>
				</label>
			</div>
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Spuntare se la stanza è adibita a chat, altrimenti specificare nel 
			 campo "pagina" il file da caricare nel riquadro principale
			</div>
			
			<label>Modulo</label>
			<input type="text" name="pagina" value="<?php out($l['pagina']); ?>" placeholder="Nome della locazione"  <?php out($disabled); ?> />	
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Modulo che deve essere caricato quando si clicca sulla locazione. 
			 Va indicato senza estensione.<br />
			 Esempio se si vuole che venga usato il modulo servizi_mercato.inc.php inserire semplicemente servizi_mercato
			</div>			
			
			<label>Sottomappa</label>
			<select name="id_mappa_collegata" <?php out($disabled); ?>>
				<option value="0">Nessuna</option>
<?php
				//CICLA L'ELENCO DELLE MAPPE DISPONIBILI
				foreach($TAG['page']['liste']['mappe'] as $v) {
?>
					<option value="<?php out($v['id']); ?>" 
					        <?php out(($l['id_mappa_collegata'] == $v['id']) ? 'selected' : ''); ?>>
						<?php out($v['nome']); ?>
					</option>
<?php
				}
?>
			</select>
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Mappa che deve essere caricata quando si clicca sulla locazione in 
			 modo da poter creare un sistema di sottomappe collegate.
			</div>
			
			<label>Immagine</label>
			<input type="text" name="immagine" value="<?php out($l['immagine']); ?>" placeholder="standard_luogo.pmg"  <?php out($disabled); ?> />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Immagine che deve apparire nel riquadro di info_luogo.inc.php.
			</div>			
<?php
			if($l['immagine'] != '') {
?>
				<div class="img_box">
					<img src="themes/advanced/imgs/locations/<?php out($l['immagine']); ?>" alt="<?php out($l['nome']); ?>" />
				</div>
<?php
			}
?>
			<hr />

			<label>Locazione apparente</label>
			<input type="text" name="stanza_apparente" value="<?php out($l['stanza_apparente']); ?>"  <?php out($disabled); ?> />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Nome della locazione che deve risultare nei presenti.
			</div>			

			<h2>Mappa e marcatore</h2>
			
			<label>Mappa</label>
			<select name="id_mappa" <?php out($disabled); ?> >
				<option value="0">Nessuna</option>
<?php
				//CICLA L'ELENCO DELLE MAPPE DISPONIBILI
				foreach($TAG['page']['liste']['mappe'] as $v) {
?>
					<option value="<?php out($v['id']); ?>" 
					        <?php out(($l['id_mappa'] == $v['id']) ? 'selected' : ''); ?>>
						<?php out($v['nome']); ?>
					</option>
<?php
				}
?>
			</select>
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Mappa in cui deve apparire la locazione.
			</div>

			<label>Posizione X</label>
			<input type="text" id="x_cord" name="x_cord" value="<?php out($l['x_cord']); ?>"  <?php out($disabled); ?> />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Posizione orizzontale del marcatore sulla mappa.
			</div>			

			<label>Posizione Y</label>
			<input type="text" id="y_cord" name="y_cord" value="<?php out($l['y_cord']); ?>"  <?php out($disabled); ?> />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Posizione verticale del marcatore sulla mappa.
			</div>			

			<label>Classe</label>
			<input type="text" name="class" value="<?php out($l['class']); ?>"  <?php out($disabled); ?> />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Classe/i aggiuntive da assegnare al marcatore per personalizzarlo.<br />
			 Le classi del marcatore vanno inserite nel file marker.css.
			</div>

			<label>Icona</label>
			<input type="text" name="icona" value="<?php out($l['icona']); ?>"  <?php out($disabled); ?> />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> L'icona che deve comparire dentro il marcatore. Lasciare vuoto se si 
			 vuole usare le icone di default.
			</div>			
		</div>
<?php 
        //SE SI STA MODIFICANDO UNA LOCAZIONE
        if($TAG['page']['op'] == 'edit') {
            //visualizza la mappa di appartenenza per posizionare il marcatore
?>
            <div class="img_wrapper_outer">
                <div class="imgwrapper" 
                     style="width:<?php out($l['larghezza']); ?>px;height:<?php out($l['altezza']); ?>px;background-image:url('themes/advanced/imgs/maps/<?php out($l['urlimgmappa']); ?>');">	
<?php
                    foreach($TAG['page']['mappa']['locazioni'] as $v1) {
?>
                        <div class="marker <?php out(($v1['id'] == $l['id']) ? 'actual' : ''); ?>" 
                             style="left:<?php out(($v1['x_cord'] * 100) / $l['larghezza']); ?>%;
                             top:<?php out(($v1['y_cord'] * 100) / $l['altezza']); ?>%;">
<?php
                            //SE LA LOCAIZONE È UNA MAPPA
                            if($v1['id_mappa_collegata'] != 0) {
                                //mostra il marcatore e il link per la sottomappa
?>
                                <div class="label"><?php out($v1['nome']); ?></div>
                                <div class="pin <?php out($v1['class']); ?>">
                                    <div class="circle">
                                        <i class="<?php out(($v1['icona'] != '') ? $v1['icona'] : 'fas fa-map'); ?>"></i>
                                    </div>
                                    <div class="triangle"></div>
                                </div>	
<?php
                            //SE LA LOCAIZONE È UNA CHAT
                            } else {
                                //mostra il marcatore e il link per la chat
?>
                                <div class="label"><?php out($v1['nome']); ?></div>
                                <div class="pin <?php out($v1['class']); ?>">
                                    <div class="circle">
                                        <i class="<?php out(($v1['icona'] != '') ? $v1['icona'] : 'fas fa-comments'); ?>"></i>
                                    </div>
                                    <div class="triangle"></div>
                                </div>								
<?php
                            }
?>

                        </div>
<?php
                    }
?>
                </div>
            </div>
            <div class="fields">
                <div class="form_info">
                 <i class="far fa-question-circle"></i> Cliccare sulla mappa per impostare la posizione del marcatore della 
                 locazione.
                </div>			
            </div>            
<?php
        }
?>
		<div class="fields">	
			<h2>Restrizioni locazione</h2>			
			
			<label>Limitata</label>
			<div class="checkbox">
				<label class="switch">
					<input type="checkbox" name="privata" value="1" <?php out(($l['privata'] != 0) ? 'checked' : ''); ?> <?php out($disabled); ?> >
					<span class="slider round"></span>
				</label>
			</div>
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Spuntare se la stanza è una stanza con restrizioni all'accesso.
			</div>

			<label>Proprietario</label>
			<select name="proprietario" <?php out($disabled); ?> >
				<option value="">Nessuno</option>
				 <optgroup label="Gilde">
<?php
					//CICLA L'ELENCO DELLE GILDE DISPONIBILI
					foreach($TAG['page']['liste']['gilde'] as $v) {
?>
						<option value="<?php out($v['value']); ?>" 
								<?php out(($l['proprietario'] == $v['value']) ? 'selected' : ''); ?>>
							<?php out($v['nome']); ?>
						</option>
<?php
					}
?>
				</optgroup>
				<optgroup label="Personaggi">
<?php
					//CICLA L'ELENCO DELLE GILDE DISPONIBILI
					foreach($TAG['page']['liste']['pg'] as $v) {
?>
						<option value="<?php out($v['value']); ?>" 
								<?php out(($l['proprietario'] == $v['value']) ? 'selected' : ''); ?>>
							<?php out($v['nome']); ?>
						</option>
<?php
					}
?>
				</optgroup>				
			</select>
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Proprietario della locazione.
			</div>

             <label>Ora prenotazione</label>                   
<?php 
			/* Processo la data di scadenza della stanza privata */
			$l['ora_prenotazione'] = str_replace(' ','T',$l['ora_prenotazione']);
?>
			<div class="checkbox">
				<input type="datetime-local" name="ora_prenotazione" value="<?php out($l['ora_prenotazione']); ?>" <?php out($disabled); ?> >
			</div>
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Data della prenotazione della locaizone.
			</div>
		
             <label>Scadenza</label>                   
<?php 
			/* Processo la data di scadenza della stanza privata */
			$l['scadenza'] = str_replace(' ','T',$l['scadenza']);
?>
			<div class="checkbox">
				<input type="datetime-local" name="scadenza" value="<?php out($l['scadenza']); ?>" <?php out($disabled); ?> >
			</div>
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Data della scadenza della prenotazione della locaizone.
			</div>

			<label>Costo</label>
			<input type="text" name="costo" value="<?php out($l['costo']); ?>"  <?php out($disabled); ?> />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Costo della locaizone.
			</div>			
			
			<label>Invitati</label>
			<input type="text" name="invitati" value="<?php out($l['invitati']); ?>" placeholder="Nome della locazione"  <?php out($disabled); ?> />
			<div class="form_info">
			 <i class="far fa-question-circle"></i> Elenco dei personaggi che possono accedere alla stanza nonostante le restrizioni.
			</div>
		</div>
		<div class="submit">
<?php
			//SE SI STA MODIFICANDO UNA LOCAIZONE ESISTENTE
			if($TAG['page']['op'] == 'edit') {
				//visualizza i comandi di modifica
?>
				<input type="hidden" name="id" value="<?php out($l['id']); ?>" />	
                <input type="hidden" name="op" value="edit_save" />			
				<input type="submit" value="Modifica" />
<?php
			//SE SI STA INSERENDO UNA NUOVA LOCAIZONE
			} else {
				//visualizza i comandi di inserimento
?>
				<input type="hidden" name="op" value="new_save" />			
				<input type="submit" value="Inserisci" />
<?php
			}
?>
		</div>		
	</form>
	<div class="tc">
		<div class="button">
			<a href="main.php?page=gestione__locazioni">
				Torna alla gestione locazioni
			</a>
			<div class="break"></div>
			<a href="main.php?page=gestione">
				Torna alla gestione
			</a>		
		</div>
	</div>
</div>
	<script>
		$(document).ready(function(){
			
			$('.imgwrapper').on('click',function(e) {
				

				var x = e.pageX - $('.imgwrapper').offset().left;
				var y = e.pageY - $('.imgwrapper').offset().top;
				
				$('#x_cord').val(x);
				$('#y_cord').val(y);
				
				$('.marker.actual').css('left',x + 'px');
				$('.marker.actual').css('top',y + 'px');
				
				
			
			});
			
		});
	</script>
<?php
	//var_dump($l);