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
		
		
		function rawout($data)
		{
			
			//SELEZIONA LE AZIONI DA ESEGUIRE IN BASE AL TIPO DI VARIABILE
			switch(gettype($data)) {				
				
				case 'boolean' :
				case 'integer' :
				break;
			
				default :
				
					$data = html_entity_decode ($data, ENT_QUOTES|ENT_HTML5, "UTF-8");				
				
				break;
			
			}
			
			echo $data;
			
		}