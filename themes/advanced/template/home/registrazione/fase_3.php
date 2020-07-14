<section class="iscrizione">
	<h1><?php echo gdrcd_filter('out', $MESSAGE['register']['page_name']); ?></h1>
	<h2>Fase 4</h2>
<?php
            if ($PARAMETERS['mode']['emailconfirmation'] == 'ON') {
                echo '<div class="page_title"><h2>' . gdrcd_filter('out',
                        $MESSAGE['register']['welcome']['message']['ok']) . '</h2></div>';
                echo '<div class="panels_box"><div class="welcome_message">' . gdrcd_filter('out',
                        $MESSAGE['register']['welcome']['message'][0]) . ' <b>' . gdrcd_filter('out',
                        $PARAMETERS['info']['site_name']) . '</b> ' . gdrcd_filter('out',
                        $MESSAGE['register']['welcome']['message'][1]) . '</div><div class="welcome_message">&nbsp;</div><div class="username">' . gdrcd_filter('out',
                        $MESSAGE['register']['welcome']['message'][3]) . ' <b>' . gdrcd_filter('get',
                        $_POST['email']) . '</b></div>';


            } else {

                echo '<div class="page_title"><h2>' . gdrcd_filter('out',
                        $MESSAGE['register']['welcome']['message']['ok']) . '</h2></div>';
                echo '<div class="panels_box"><div class="welcome_message">' . gdrcd_filter('out',
                        $MESSAGE['register']['welcome']['message'][0]) . ' <b>' . gdrcd_filter('out',
                        $PARAMETERS['info']['site_name']) . '</b> ' . gdrcd_filter('out',
                        $MESSAGE['register']['welcome']['message'][1]) . '</div><div class="welcome_message">' . gdrcd_filter('out',
                        $MESSAGE['register']['welcome']['message'][2]) . '</div><div class="username">' . gdrcd_filter('out',
                        $MESSAGE['register']['welcome']['message']['user']) . ' <b>' . gdrcd_filter('get',
                        $_POST['nome']) . '</b></div><div class="username">' . gdrcd_filter('out',
                        $MESSAGE['register']['welcome']['message']['pass']) . ' <b>' . $pass . '</b></div></div>';

            }
?>	
</section>