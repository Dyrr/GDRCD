<?php
    namespace template;

    function file($template)
    {

        $template = ROOT . '/themes/' . $GLOBALS['PARAMETERS']['themes']['current_theme'] . '/template/' . $template . '.php';
        $template = str_replace('\\','/',$template);
        
		return $template;
    }

    function start($template)
    {
	
        ob_start();
	
    }

    function end($template)
    {
			
        $GLOBALS['OUT'][$template] = ob_get_clean();
			
    }