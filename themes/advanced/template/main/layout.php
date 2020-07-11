<?php
    defined('GDRCD') OR exit('Non è permesso accesso diretto ai template');
    template\start('layout_top');
?>  
        <div class="main layout">
<?php
            foreach ($PARAMETERS['section'] as $k => $v) {
?>
                <aside id="sez_<?php echo gdrcd_filter_out($k); ?>">
<?php
                    foreach ($v['box'] as $box) {
?>
                        <div class="<?php gdrcd_filter_out($box['class']); ?>">
                            <?php gdrcd_load_modules('pages/' . $box['page'] . '.inc.php', $box); ?>
                        </div>
<?php               
                    }
?>
                </aside>
<?php
            }
?>
            <main id="maincontent">
                <div class="output">
<?php
    template\end('layout_top');
    template\start('layout_bottom');            
?>              
                </div>
            </main>
        </div>
<?php
    template\end('layout_bottom');