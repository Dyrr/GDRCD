<?php
/**
 *  @file       themes/_common/template/menu.php
 *  
 *  @brief      template per un menu basilare verticale
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */
?> 
<?php
    foreach($TAG as $k => $v) {
?>          
        <div class="link_menu">
            <a href="<?php out($v['url']); ?>" data-function="<?php out($v['function']); ?>">
                <div class="manu_<?php out($k); ?>">
                    <?php rawout($v['text']); ?>
                </div>
            </a>
        </div>
<?php           
    }
?>