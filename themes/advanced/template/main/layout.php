<?php
    defined('GDRCD') OR exit('Non è permesso accesso diretto ai template');
    template\start('layout_top');
?>
    
		<div class="main layout">
<?php
            foreach ($PARAMETERS['section'] as $k => $v) {
?>            <aside id="sez_<?php echo gdrcd_filter_out($k); ?>">
                    <div class="item">
<?php
                        foreach ($v['box'] as $box) {
?>
                            <div class="modulo <?php echo gdrcd_filter_out($box['class']); ?>">
                                <?php gdrcd_load_modules('pages/' . $box['page'] . '.inc.php', $box); ?>
                            </div>
<?php               
                        }
?>
                    </div>
                </aside>
<?php
            }
?>
            <main>
				<div class="modulo">
<?php
    template\end('layout_top');
    template\start('layout_bottom');
?>
				</div>
		   </main>
        </div>
	 <script>

             
          $(document).ready(function(){
            var outerContent = $('.main.layout');

            outerContent.scrollLeft(((outerContent.width() / 10) * 9));
            //outerContent.scrollTop(((outerContent.height() / 10) * 9));

            });
	   

      </script>
<?php
    template\end('layout_bottom');