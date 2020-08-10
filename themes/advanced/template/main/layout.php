<?php
    defined('GDRCD') OR exit('Non è permesso accesso diretto ai template');
    template\start('layout_top');
?>
        <div class="main layout">
<?php
            //CICLA LE VARIE SEZONI DEL LAYOUT
            foreach ($PARAMETERS['section'] as $k => $v) {
                //creando una elemento aside per ogni seizone
?>              <aside id="sez_<?php out($k); ?>">
                    <div class="item">
<?php
                        //CICLA OGNI ELEMENTO DELLA SEZIONE
                        foreach ($v['box'] as $box) {
                            //creando un div per ogni elemento
?>
                            <div class="modulo <?php out($box['class']); ?>">
                                <?php gdrcd_load_modules(\modulo\file($box['page']), $box); //carica la pagina richiesta?>
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
                <div class="modulo ajax">
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