<?php
    namespace modulo;

    function file($modulo)
    {

        $modulo = ROOT . '/pages/' . $modulo . '.inc.php';
        $modulo = str_replace('\\','/',$modulo);
 
		if(file_exists($modulo) === false) {
			
			$modulo = 'error/non_trovato.inc.php';
		
		}
		
		return $modulo;
    }
