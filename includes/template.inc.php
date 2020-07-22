<?php
/**
 *  @file       includes/template.inc.php
 *  
 *  @brief      Set di funzioni per la gestione dei template
 *  
 *  @version    5.6.0
 *  @date       11/07/2020
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @details    Set di piccole funzioni per l'utilizzo di un sistema di template base, separato dal file principale 
 *  delle funzioni per avere un po' più di ordine
 *  
 *  @todo       commentare le funzioni
 *  
 */     
    
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
    
    /**
     *  @brief      stampa della struttura della pagina
     *  
     *  @details    La funzione stampa a video la struttura della pagina ricostruita riordinatamente in base al tipo 
     *  di richiesta 
     *       
     *  @snippet    system\lib\dlight\core\template\Template.php is_ajax_example
     */      
    function render($template) {
        
        //SE LA PAGINA È STATA RICHIESTA TRAMITE CHIAMATA AJAX
        if(\template\is_ajax() === true) { 
        
            //stampa solo il contenuto del modulo
            echo $template['content'];          
        
        //SE LA PAGINA È STATA RICHIESTA NORMALMENTE
        } else {
            
            //stampa tutta la pagina HTML
            echo $template['header'];   
            echo $template['layout_top'];   
            echo $template['content'];  
            echo $template['layout_bottom'];        
            echo $template['footer'];
        
        }       
    
    }
    
    /**
     *  @brief      Identifica  la modalirà di richiesta della pagina
     *  
     *  @return     $ajax <b>(bool)</b> true se la pagine è stata richiesta tramite ajax false in caso contrario
     *  
     *  @details    Il metodo identifica se la pagina è stata richiesta tramite chiamata ajax o meno, restituendo 
     *  1 nel primo caso e 0 nel secondo.
     *  
     *  @snippet    system\lib\dlight\core\template\Template.php is_ajax_example
     */     
    function is_ajax()
    {
        
        $ajax = (
                    isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
                 && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') 
            ? true 
            : false;
        
        return $ajax;
    
    }

		/**
		 *  @brief 			Filtra automaticamente l'output
		 *  
		 *  @param [in] 	$item <b>array</b> reference all'array contenente i dati dell'output
		 *  
		 *  @details 		Il metodo passa tutti gli elementi dell'array $var attraverso la funzione htmlentities()
		 *  per assicurarsi che tutti i dati passati per l'output del template siano sicuri.
		 *  Le funzione è anche impostata come paramtri per evitare che le entità html non siano codificate più di una 
		 *  volta.
		*/		
		function __autoFilter(&$item, $key)
		{

			//SELEZIONA LE AZIONI DA ESEGUIRE IN BASE AL TIPO DI VARIABILE
			switch(gettype($item)) {
				
				case 'boolean' :
				case 'integer' :
				break;
			
				default :
				
					//$item = $this->replace_n($item);
					$item = htmlentities($item, ENT_QUOTES|ENT_SUBSTITUTE, "UTF-8", false);				
				
				break;
			
			}
		
		}

		function filterOut($TAG)
		{
			
			array_walk_recursive($TAG,'\template\__autofilter');
			
			return $TAG;
		
		}