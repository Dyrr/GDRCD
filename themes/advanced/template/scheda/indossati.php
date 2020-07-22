<?php
/**
 *  @file       themes/advanced/template/scheda/indossati.php
 *
 *  @brief      Template della pagina dello schema degli oggetti indossati
 *
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *
 *  @author     Davide 'Dyrr' Grandi
 *
 *  @see        pages/scheda/scheda.inc.php
 *
 *  @note       ricordarsi che l'array $TAG per le variabili in uscita sia statoo filtrato prima di includere il 
 *  template tramite la funzione \template\filterOut() o usare la funzione out() per stampare a video la variabile 
 *  se usate entrambe non sussiste nessun problema, se non eccesso di paranoia
 *
 *  @todo       vedere se oltre al nome sul manichino far visualizzare altro dell'oggetto indossato
 */
    //definisce l'indice base delle locazioni
    $i = 2;
?>
        <section class="equipped">
            <h2>Equipaggiamento indossato</h2>
            <div class="siluette">
<?php
                    //CICLA L'ELENCO DELLE LOCAZIONI IN CUI GLI OGGETTI POSSONO ESSERE INDOSSATI
                    //in questo modo se vengono aggiunte locazioni non occorre modificare il codice
                    foreach($TAG['page']['equipped'] as $k => $v) {
?>
                        <div class="location equipped_<?php out($k); ?>">
<?php
                            //SE C'È UN OGGETTI INDOSSATO IN QUELLA LOCAZIONE
                            if(isset($TAG['page']['siluette'][$i])) {
                                //visualizza il nome dell'oggetto
?>
                                <?php out($TAG['page']['siluette'][$i]['nome']); ?>
<?php
                            //SE NON C'È UN OGGETTI INDOSSATO IN QUELLA LOCAZIONE
                            } else {
                                //visualizza il nome della locazione
?>
                                <?php out($v); ?>
<?php
                            }
?>
                        </div>
<?php
                        //incrementa l'indice delle locazioni
                        ++$i;
                    }
?>                  
                <div class="sesso_<?php out($TAG['page']['pg']['sesso']); ?>">
                </div>
            </div>
        </section>