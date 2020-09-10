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

		function file($file)
		{

			$modulo_default = ROOT . '/system/pages/_default/' . $file . '.inc.php';
			$modulo_default = str_replace('\\','/',$modulo_default);
			//converte la combinaizone di caratteri __ nel separatore di directory
			$modulo_default = str_replace('__','/',$modulo_default);
	 
			$modulo_ge =   ROOT . '/system/pages/game_engine/' . $PARAMETERS['game_engine']['engine'] 
						 . '/' . $file . '.inc.php';
			$modulo_ge = str_replace('\\','/',$modulo_ge);
			//converte la combinaizone di caratteri __ nel separatore di directory
			$modulo_ge = str_replace('__','/',$modulo_ge);			
			
			$modulo_land = ROOT . '/system/pages/land/' . $file . '.inc.php';
			$modulo_land = str_replace('\\','/',$modulo_land);
			//converte la combinaizone di caratteri __ nel separatore di directory
			$modulo_land = str_replace('__','/',$modulo_land);				
			
            //imposta come modulo il modulo specifico per la land
            $modulo = $modulo_land;
            
            //SE NON ESISTE IL MODULO SPEFICICO PER LA LAND
            if(file_exists($modulo) === false) {			
			
                //imposta come modulo specifico quello per l'engine di gioco
                $modulo = $modulo_ge;          
            
                //SE NON ESISTE IL MODULO SPECIFICO PER L'ENGINE DI GIOCO
                if(file_exists($modulo) === false) {
                    
                    //imposta come modulo quello generico
                    $modulo = $modulo_default;   

                    //SE NON ESISTE IL MODULO GENERICO
                    if(file_exists($modulo) === false) {
                        
                        //imposta il modulo di errore
                        $modulo = '/system/pages/_default/error/non_trovato.inc.php';
                    
                    }                    
                    
                }
            
            }
			
			return $modulo;
		
        }
		
		function addon($modulo)
		{

			$modulo = ROOT . '/system/pages/' . $modulo . '.addon.php';
			$modulo = str_replace('\\','/',$modulo);
			//converte la combinaizone di caratteri __ nel separatore di directory
			$modulo = str_replace('__','/',$modulo);
	 
			
			if(file_exists($modulo) === false) {
				
				$modulo = 'error/non_trovato.inc.php';
			
			}
			
			return $modulo;
		}		
		
		
		function load(
			$file, 
			$params = null,
			$submodulo = false)
		{
			
			
			global $MESSAGE;
			global $PARAMETERS;

			if(file_exists($path)) {
				include($path);
			} else {
				echo $MESSAGE['interface']['layout_not_found'];
			}
		}		
		
	}
