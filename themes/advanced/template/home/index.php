<?php
    defined('GDRCD') OR exit('Non è permesso accesso diretto ai template');
    template\start('layout_top');
?>
        <div class="home layout">
            <header>
				<h1><a href="index.php"><?php echo $MESSAGE['homepage']['main_content']['site_title']; ?></a></h1>
				<h2><?php echo $MESSAGE['homepage']['main_content']['site_subtitle']; ?></h2>
            </header>
			<nav>
                <ul>
                     <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="index.php?page=index&content=iscrizione">Registrazione</a>
                    </li>
                    <li>
                        <a href="index.php?page=index&content=user_regolamento">Guida</a>
                    </li>
                    <li>
                        <a href="index.php?page=index&content=iscrizione">?</a>
                    </li>
				</ul>
            </nav> 			
<?php
            foreach ($PARAMETERS['home']['section'] as $k => $v) {
?>            <aside id="sez_<?php echo gdrcd_filter_out($k); ?>">
                    <div class="item">
<?php
                        foreach ($v['box'] as $box) {
?>
                            <div class="modulo <?php echo gdrcd_filter_out($box['class']); ?>">
                                <?php gdrcd_load_modules(\modulo\file('home/' . $box['page']), $box); ?>
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
<?php
    template\end('layout_top');
    //IL CONTENUTO DELLA PAGINA FINIRÀ QUI IN MEZZO
    template\start('layout_bottom');
?>                      

            </main>
            <nav class="bottom">
                <ul>
                     <li>
                        <a href="index.php">Legal</a>
                    </li>
                    <li>
                        <a href="index.php?page=index&content=iscrizione">FaQ</a>
                    </li>
                    <li>
                        <a href="index.php?page=index&content=user_regolamento">Contatti</a>
                    </li>
				</ul>			
			</nav>
			<footer>
                <div>
                    <?php echo gdrcd_filter('out', $PARAMETERS['info']['site_name']), ' - ', gdrcd_filter('out', $MESSAGE['homepage']['info']['webm']), ': ', gdrcd_filter('out', $PARAMETERS['info']['webmaster_name']), ' - ', gdrcd_filter('out', $MESSAGE['homepage']['info']['dbadmin']), ': ', gdrcd_filter('out', $PARAMETERS['info']['dbadmin_name']), ' - ', gdrcd_filter('out', $MESSAGE['homepage']['info']['email']), ': <a href="mailto:', gdrcd_filter('out', $PARAMETERS['info']['webmaster_email']), '">', gdrcd_filter('out', $PARAMETERS['info']['webmaster_email']), '</a>.'; ?>
				</div>
                <div>    
					<?php echo $CREDITS, ' ', $LICENCE ?>
                </div>
            </footer>
        </div>
<?php
    template\end('layout_bottom');