<?php
/**
 *  @file       themes/advanced/template/scheda/oggetti.php
 *  
 *  @brief      Template della pagina oggetti della scheda
 *  
 *  @version    5.6.0
 *  @date       11/07/2020
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @see        pages/scheda/scheda.inc.php
 *  
 *  @note       ricordarsi che l'array $TAG per le variabili in uscita sia statoo filtrato prima di includere il 
 *  template tramite la funzione \template\filterOut() o usare la funzione out() per stampare a video la variabile 
 *  se usate entrambe non sussiste nessun problema, se non eccesso di paranoia
 */
 
?>
    <section class="scheda">
        <?php require \template\file('scheda/nav'); // include il template del menù di navigazione ?>
		<?php require \template\file('scheda/indossati'); //include il tmeplate con il manichino ?>
		<section class="oggetti">
<?php
			//CICLA L'ELENCO DELLE CATEGORIE DI OGGETTI
			foreach($TAG['page']['oggetti']['lista'] as $k => $categorie) {
?>
				<h2>
					<a href="#" data-function="item_toggle" data-target="#categoria_<?php out($k); ?>">
						<i class="fa fa-plus-square"></i> 
						<?php out($TAG['page']['oggetti']['categorie'][$k]); ?>  
					</a>
				</h2>
				<div id="categoria_<?php out($k); ?>" class="categoria">
<?php
					//CICLA I GRUPPI DEGLI OGGETTI
					foreach($categorie as $k => $item) {
?>
						<div>
							<a href="#" data-function="item_toggle" data-target="#gruppo_<?php out($k); ?>">
								<i class="fa fa-plus-square"></i> 
								<?php out($TAG['page']['oggetti']['oggetti'][$k]); ?>  
							</a>                            
						</div>
						<div id="gruppo_<?php out($k); ?>" class="gruppo">
<?php
							//CICLA L'ELENCO DEGLI OGGETTI SINGOLI
							foreach($item as $v) {
?>
								<div class="item">
									<a href="#" data-function="item_toggle" data-target="#details_<?php out($v['idpooggetto']); ?>">
										<i class="fa fa-plus-square"></i> 
										<?php out($v['nome']); ?>
									</a> 
<?php
									//SE L'OGGETTO È ANCHE INDOSSATO
									if($v['indossato'] === true) {
										//visualizza la locazione dove è indossato
?>
										<?php out($v['nome_posizione']); ?>
<?php
									}
?>
									<div id="details_<?php out($v['idpooggetto']); ?>" 
										 class="details_wrapper">
										<div class="item_details">
											<div class="img">
												<img src="themes/_common/imgs/items/<?php out($v['urlimg']); ?>" />
											</div>
											<div class="bonus">
												<h2>Bonus</h2>
												<div>Difesa:</div><div>1</div>
												<div>Attacco:</div><div>0</div>
<?php
												//CICLA L'ELENCO DELLE STATISTICHE PER VISUALIZZARE I BONUS
												//in questa maniera se vengono agigunte statistiche 
												//si aggiungono in automatico
												foreach($TAG['page']['stats'] as $k => $s) {
													//visualizza i bonus
?>                                                      
													<div><?php out($s); ?></div>
													<div><?php out($v['bonus_' . $k]); ?></div>
<?php
												}
?>
											</div>
											<div>
												<h2>Descrizione</h2>
												<?php out($v['descrizione']); ?>
											</div>
<?php
											//SE CI SONO NOTE ALL'OGGETTO
											if($v['commento'] != '') {
												//mostra il commento
?>
												<div>
													<h2>Note</h2>
													<?php out($v['commento']); ?>
												</div>
<?php
											}
?>
											<div class="operazioni">
<?php
												//SE SONO IL PROPRIETARIO DEL PG
												if($TAG['page']['pg']['mio'] === true) {
													//visualizza i comandi per le operazioni
?>
													<form action="main.php?page=scheda__scheda" method="post">
														<input type="hidden" name="idpooggetto" value="<?php out($v['idpooggetto']); ?>" />
														<input type="hidden" name="pg" value="<?php out($_REQUEST['pg']); ?>" />
<?php
														//SE SI STA VISUALIZZANDO L'AREA DELLE PROPRIETÀ
														if($TAG['page']['area'] == 'proprieta') {
															//visualizza l'operazione per indossare l'oggetto
?>															
															<input type="hidden" name="op" value="trasporta" />
															<div class="submit">
																<input type="submit" value="Trasporta" />
															</div>
<?php
														}
?>
<?php
														//SE SI STA VISUALIZZANDO L'AREA DELL'EQUIPAGGIAMENTO
														if($TAG['page']['area'] == 'equip') {
															//visualizza l'operazione per indossare depositare l'oggetto
?>															
															<input type="hidden" name="op" value="deposita" />
															<div class="submit">
																<input type="submit" value="Deposita" />
															</div>
<?php
														}
														//sono stati usati due if differenti anzichè un else per
														//rendere più facile aggiungere nuove aree se create
?>													
													</form>
<?php
													//SE L'OGGETTO È TRASPORTATO
													//ED È INDOSSABILE
													if(   $v['posizione'] >= 1
													   && $v['ubicabile'] >= 2) {
?>
														<form action="main.php?page=scheda__scheda" method="post">
															<input type="hidden" name="idpooggetto" value="<?php out($v['idpooggetto']); ?>" />
															<input type="hidden" name="pg" value="<?php out($_REQUEST['pg']); ?>" />
<?php
															//SE L'OGGETTO È INDOSSATO
															if($v['posizione'] >= 2) {
																//visualizza l'operazione per togliere l'oggetto
?>															
																<input type="hidden" name="op" value="Togli" />
																<div class="submit">
																	<input type="submit" value="togli" />
																</div>
<?php
															//SE NON È INDOSSATO
															} else {
																//visualizza l'operazione per indossare l'oggetto
?>															
																<input type="hidden" name="op" value="Indossa" />
																<div class="submit">
																	<input type="submit" value="indossa" />
																</div>
<?php
															}
?>													
														</form>
<?php
													}
?>
													<form action="main.php?page=scheda__scheda" method="post">
														<input type="hidden" name="idpooggetto" value="<?php out($v['idpooggetto']); ?>" />
														<input type="hidden" name="op" value="cedi" />
														<div class="submit">
															<input type="submit" value="Cedi" />
														</div>
													</form>                                             
													<form action="main.php?page=scheda__scheda" method="post">
														<input type="hidden" name="idpooggetto" value="<?php out($v['idpooggetto']); ?>" />
														<input type="hidden" name="op" value="elimina" />
														<div class="submit">
															<input type="submit" value="Elimina" />
														</div>
													</form>                                             
													<form action="main.php?page=scheda__scheda" method="post">
														<input type="hidden" name="idpooggetto" value="<?php out($v['idpooggetto']); ?>" />
														<input type="hidden" name="op" value="commenta" />
														<div class="submit">
															<input type="submit" value="Commenta" />
														</div>
													</form>
<?php
												}
?>
<?php
												//SE HO I PERMESSI DI MASTER O SUPERIORI
												if($_SESSION['permessi'] >= GAMEMASTER) {
													//visualizzo il comando per l'operazione
?>
													<form action="main.php?page=scheda__scheda" method="post">
														<input type="hidden" name="idpooggetto" value="<?php out($v['idpooggetto']); ?>" />
														<input type="hidden" name="op" value="prendi" />
														<div class="submit">
															<input type="submit" value="Prendi" />
														</div>
													</form>
<?php
												}
?>
											</div>
										</div>
									</div>
								</div>
<?php
							}
?>                              
						</div>
<?php
					}
?>                  
				</div>
<?php
			}
?>
		</section>
    </section>