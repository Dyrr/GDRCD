<?php
	namespace functions {

		function file($file) {
			
			$file = ROOT . '/system/inc/functions/' . $file . '.inc.php';
			$file = str_replace('\\','/',$file);
				
			return $file;
			
		}
		
	}    
	
	namespace modulo {

		function file($modulo)
		{

			$modulo = ROOT . '/pages/' . $modulo . '.inc.php';
			$modulo = str_replace('\\','/',$modulo);
			$modulo = str_replace('__','/',$modulo);
	 
			
			if(file_exists($modulo) === false) {
				
				$modulo = 'error/non_trovato.inc.php';
			
			}
			
			return $modulo;
		}
		
	}
