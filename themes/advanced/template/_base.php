<?php
	template\start('header');
?>
<!DOCTYPE html>
	<html lang="it">
		<head>
			<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />			
			<link rel="shortcut icon" href="favicon.png" type="image/png" />
			<link rel="stylesheet" href="<?php echo csscrush_file('themes/' . $PARAMETERS['themes']['current_theme'] . '/css/source/gdrcd.css'); ?>" type="text/css" />
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
			<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="/includes/corefunctions.js"></script>			
<?php
    /** * Il controllo individua se l'header non è impiegato per il main */
    if( ! isset($check_for_update)) {
        ?>
        <link rel="stylesheet" href="layouts/<?php echo $PARAMETERS['themes']['kind_of_layout'], '_frames.php?css=true'; ?>" type="text/css" />
        <?php
    }
    ?>
    <title>
        <?php echo $PARAMETERS['info']['site_name']; ?>
    </title>
</head>
<body>
<?php
	template\end('header');	
	template\start('footer');
?>

<!--<script type="text/javascript" src="includes/gdrcdskills.js"></script>-->
<?php
/** * Abilitazione tooltip
 * @author Blancks
 */
if($PARAMETERS['mode']['map_tooltip'] == 'ON' || $PARAMETERS['mode']['user_online_state'] == 'ON') { ?>
    <script type="text/javascript">
        var tooltip_offsetX = <?php echo $PARAMETERS['settings']['map_tooltip']['offset_x']; ?>;
        var tooltip_offsetY = <?php echo $PARAMETERS['settings']['map_tooltip']['offset_y']; ?>;
    </script>
    <script type="text/javascript" src="/includes/tooltip.js"></script>
    <?php
}
/** * Caricamento script per il titolo "lampeggiante" per i nuovi pm
 * @author Blancks
 */
if($PARAMETERS['mode']['alert_pm_via_pagetitle'] == 'ON') {
    echo '<script type="text/javascript" src="/includes/changetitle.js"></script>';

}
/** * Caricamento script per la scelta popup nel login
 * @author Blancks
 */
if($PARAMETERS['mode']['popup_choise'] == 'ON') {
    echo '<script type="text/javascript" src="/includes/popupchoise.js"></script>';
}
?>
<script type="text/javascript">
    function modalWindow(name, title, url, width, height) {
        // per width ed height imposto dei valori di default così non occorre specificarli in ogni occasione
        width = typeof width === 'undefined' ? 800 : width;
        height = typeof height === 'undefined' ? 600 : height;

        // verifichiamo se nel body non esiste il sorgente per la dialog
        if ($('#dialog-' + name).length == 0) {

            // in questo caso lo creiamo:
            $('body').append('<div id="dialog-' + name + '" title="' + title + '" style="padding:0;"><iframe src="' + url + '" frameborder="no" style="position:absolute;width:100%;height:100%;" scrolling="yes"></div>');

        } else {

            // se il sorgente invece esiste già assegnamo la nuova url all´iframe:
            $('#dialog-' + name).attr('title', title);
            $('#dialog-' + name + ' iframe').attr('src', url);
        }

        // Ok, adesso siamo pronti per lanciare la modale!
        $('#dialog-' + name).dialog({width: width, height: height});
    }
</script>

</body>
</html>
<?php
	template\end('footer');