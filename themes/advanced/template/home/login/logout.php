<?php
/**
 *  @file       themes/_common/template/home/login/logout.php
 *  
 *  @brief      Template del logout del personaggio
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */     
    defined('GDRCD') OR exit('Non è permesso accesso diretto ai template');
?>
    <div class="logout_box">
        <span class="logout_text">
            <?php out($_SESSION['login'] . ' ' . $GLOBALS['MESSAGE']['logout']['confirmation']); ?>
        </span>
        <span class="logout_text">
            <?php out($GLOBALS['MESSAGE']['logout']['logbackin']); ?> 
            <a href="index.php">
                <?php out($GLOBALS['PARAMETERS']['info']['homepage_name']); ?>
            </a>
        </span>
        <span class="logout_text">
            <?php out($GLOBALS['MESSAGE']['logout']['greeting']); ?>
        </span>
    </div>