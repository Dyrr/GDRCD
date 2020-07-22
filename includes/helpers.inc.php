<?php
    /**
     *  @brief Stampa una variabile filtrata in uscita
     *  
     *  @param [in] $data <b>(mixed)</b> la variabile in entrata da filtrare
     *  
     *  @return <b>(mixed)</b> la variaible filtrata in uscita
     *  
     *  @details La funzione stampa a video una variabile filtrandola nel caso si rilevi che questa sia una stringa
     *  
     *  @todo vedere se fare qualche filtragigo nel caso la variabile risulti diversa da questi tre tipi di variabile
     */     
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
    
    /**
     *  @brief Stampa una variabile rimuovendo il filtro html in uscita
     *  
     *  @param [in] $data <b>(mixed)</b> la variabile in entrata da cui togliere il filtro
     *  
     *  @return <b>(mixed)</b> la variaible a cui è stato tolto il filltro in uscita
     *  
     *  @details La funzione stampa a video una variabile togliendo la funzione htmlentities()
     */         
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