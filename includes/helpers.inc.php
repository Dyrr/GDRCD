<?php
		function out($data)
		{

			//SELEZIONA LE AZIONI DA ESEGUIRE IN BASE AL TIPO DI VARIABILE
			switch(gettype($data)) {
				
				case 'boolean' :
				case 'integer' :
				break;
			
				default :
				
					$data = htmlentities($data, ENT_QUOTES|ENT_SUBSTITUTE, "UTF-8", false);				
				
				break;
			
			}
			
			echo $data;
		
		}
