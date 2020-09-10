<?php
  $CREDITS = gdrcd_filter_out('Basato su "GDRCD '.$GLOBALS['PARAMETERS']['info']['GDRCD'].'". CMS Open Source sviluppato da Breaker e distribuito gratuitamente.');
$LICENCE = '<a href="licenza.txt">' . gdrcd_filter('out', 'Licenza d\'uso e riproduzione') . '</a>.';   
    
    $RP_response = '';

    if ( ! empty($_POST['email'])) {

        $result = gdrcd_query("SELECT nome, email FROM personaggio", 'result');
        $success = false;
        while($row = gdrcd_query($result, 'fetch')) {
            if (\security\password\verify($_POST['email'], $row['email'])) {
                gdrcd_query($result, 'free');
                $pass = \security\password\generate();
                gdrcd_query("UPDATE personaggio SET pass = '" . \security\password\hash($pass) . "' WHERE nome = '" .$row['nome']. "' LIMIT 1");

                $subject = gdrcd_filter('out',$MESSAGE['register']['forms']['mail']['sub'] . ' ' . $PARAMETERS['info']['site_name']);
                $text = gdrcd_filter('out', $MESSAGE['register']['forms']['mail']['text'] . ': ' . $pass);

                mail($_POST['email'], $subject, $text, 'From: ' . $PARAMETERS['info']['webmaster_email']);

                $RP_response = gdrcd_filter('out', $MESSAGE['warning']['modified']);

                $success = true;
            }
        }
        if ($success === false) {
            $RP_response = gdrcd_filter('out', $MESSAGE['warning']['cant_do']);
        }

    }

    $content = ( ! empty($_GET['content'])) ? gdrcd_filter('include', $_GET['content']) : 'home';   
    
    
    require template\file('home/' . $page);
    

    
    template\start('content');
    require modulo\file('home/' . $content);
    template\end('content');