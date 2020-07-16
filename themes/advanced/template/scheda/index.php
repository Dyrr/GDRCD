<?php
/**
 *  @file       themes/advanced/template/scheda/index.php
 *  
 *  @brief      Template della padina principale della scheda
 *  
 *  @version    5.6.0
 *  @date       11/07/2020
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @details i tag che possono essere in bbcode o html puro in base alle impostazioni sono gia filtrati nella pagina 
 *  della logica della scheda non è un errore se qui non sono filtrati prima di essere stampati non rifiltrateli 
 *  
 *  @see        pages/scheda/scheda.inc.php
 *  
 *  @warning    l'audio restarta ad ogni cambio pagina della scheda se questa viene caricata in maniera tradizionale 
 *  per evitarlo bisogna far ricaricare la pagina della scheda tramite ajax
 *  
 *  @todo       effettuare i cambi pagina tramite ajax
 */     
?>
    <section class="scheda">
        <?php require \template\file('scheda/nav'); // include il template del menù di navigazione ?>
        <div class="ajax">
            <div class="outer_container">
                <div class="avatar_wrapper">
                    <div class="avatar" 
                         style="background-image:url(<?php echo gdrcd_filter_out($TAG['page']['pg']['url_img']); ?>);"></div>
                    <div class="sign">
                        <a href="main.php?page=messages_center&op=create&reply_dest=<?php echo gdrcd_filter_url($TAG['page']['pg']['nome']); ?>" 
                           class="link_invia_messaggio" data-function="msg">
                            <i class="fas fa-envelope"></i>
                        </a> 
                        <?php echo gdrcd_filter_out($TAG['page']['pg']['nome_completo']); ?>
                    </div>
                </div>
            </div>
            <h2>Descrizione</h2>
            <?php echo $TAG['page']['pg']['descrizione']; ?>
            <h2>Abbigliamento</h2>
            <?php echo $TAG['page']['pg']['abbigliamento']; ?>          
        </div>
<?php
        //SE LE COMPONENTI AUDIO SONO STATE ABILITATE
        if($TAG['page']['audio'] === true) {
?>
<?php
            //SE C'È UN URL VALIDO PER L'AUDIO
            if($TAG['page']['pg']['url_media'] != '') {
                    //visualizzo il lettore audio
?>
                        
                        <audio id="audio_scheda"  autoplay loop preload="none" width="100%" controls style="background-color:rgba(0,0,0,0);">
                            <source src="<?php echo $TAG['page']['pg']['url_media']; ?>">
                        </audio>
                        
                        <script>

            $('audio').mediaelementplayer();                                                            
                        </script>               
<?php
            }
?>
<?php
        }
?>      
    </section>