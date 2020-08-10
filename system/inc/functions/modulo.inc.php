<?php
	namespace functions {

		function file($file) {
			
			$file = ROOT . '/system/inc/functions/' . $file . '.inc.php';
			$file = str_replace('\\','/',$file);
				
			return $file;
			
		}
		
		function load($file) {
			
			$file = \functions\file($file);
			
			require_once($file);
			
		}		
		
		function personaggio()
		{
			require \functions\file('personaggio/personaggio');
			
			
		}
		
	}    
	
	namespace modulo {

		function file($modulo)
		{

			$modulo = ROOT . '/system/pages/' . $modulo . '.inc.php';
			$modulo = str_replace('\\','/',$modulo);
			//converte la combinaizone di caratteri __ nel separatore di directory
			$modulo = str_replace('__','/',$modulo);
	 
			
			if(file_exists($modulo) === false) {
				
				$modulo = 'error/non_trovato.inc.php';
			
			}
			
			return $modulo;
		}
		
	}
