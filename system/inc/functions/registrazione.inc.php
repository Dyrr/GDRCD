<?php
/**
 *  @file       system/inc/functions/registrazione.inc.php
 *  
 *  @brief      Set di funzioni la registrazione del personaggio
 *  
 *  @version    5.6.0
 *  @date       11/07/2020
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @todo       commentare le funzioni
 *  @todo       creare un set di costanti per i codici degli errori
 *  @todo       rendere più sicuri i contorlli sul nome
 *  
 */     
    
    namespace registrazione;
    
    function controlloMail($mail)
    {
        
        //controllo esistenza mail
        $query = "SELECT 
                     email 
                 FROM personaggio 
                 WHERE 
                     email= '" . gdrcd_filter_in($mail) . "' 
                 LIMIT 1";
        
        $result = gdrcd_query($query, 'result');

        if (gdrcd_query($result, 'num_rows') > 0) {

            //restituisce esito negativo del controllo
            $data['ok'] = false;            
            //restituisce i dati dell'errore
            $data['errors'][] = array(
                'code' => 111,
                'testo' => $GLOBALS['MESSAGE']['register']['error']['email_taken']
            );          
            
        }

        gdrcd_query($result, 'free');                
                
        /** @todo verificare la mail in maniera più accurata con una regex **/
        //SE LA MAIL NON HA UN FORMATO VALIDO
        if (   mail == '' 
            || strpos($mail,'@') === false 
            || strpos($mail, '.') === false){
                    
            //restituisce esito negativo del controllo
            $data['ok'] = false;            
            //restituisce i dati dell'errore
            $data['errors'][] = array(
                'code' => 112,
                'testo' => $GLOBALS['MESSAGE']['register']['error']['email_needed']
            );              
            
        }

        if(isset($data) === false) {
            
            $data = false;
            
        }

        return $data;
        
    }
    
    function controlloNome($nome)
    {
        
        $query = "SELECT 
                     nome 
                 FROM personaggio 
                 WHERE 
                     nome = '" . gdrcd_capital_letter(gdrcd_filter_in($nome)) . "' 
                 LIMIT 1";
        $result = gdrcd_query($query, 'result');

    
        //SE IL NOME ESISTE GIA
        if (gdrcd_query($result, 'num_rows') > 0){
                   
            //restituisce esito negativo del controllo
            $data['ok'] = false;            
            //restituisce i dati dell'errore
            $data['errors'][] = array(
                'code' => 121,
                'testo' => $GLOBALS['MESSAGE']['register']['error']['name_taken']
            );

        //SE LA SOMMA È CORRETTA
        } else {
            
            //imposta i dati degli errori a false
            $data = false;
            
        }   
        
        gdrcd_query($result, 'free');
        
        return $data;
    
    }
    
    function controlloPunti()
    {
        
        //recupera l'elenco delle statistiche usato dal sistema di gioco eliminando la salute
        $stats = $GLOBALS['PARAMETERS']['names']['stats'];
        array_pop($stats);        
        
        //imposta il valore iniziale della somma dei punteggi delle statistiche
        $sum = 0;
        
        //CICLA L'ELENCO DELLE STATISTICE
        foreach($stats as $k => $v) {
            
            //esegue la somma dei valori delle statistiche
            $sum = $sum + $_REQUEST[$k];
            
        }
        
        //SE LA SOMMA DEI PUNTI DELLE STATISTICHE È DIVERSA DA QUELLA DEFINITA NELLE IMPOSTAIZONI DI GIOCO
        if ($sum != $GLOBALS['PARAMETERS']['settings']['cars_sum']){
                   
            //restituisce esito negativo del controllo
            $data['ok'] = false;            
            //restituisce i dati dell'errore
            $data['errors'][] = array(
                'code' => 131,
                'testo' => $GLOBALS['MESSAGE']['register']['fields']['stats_info'] . ' ' 
                . $GLOBALS['PARAMETERS']['settings']['cars_sum']
            );

        //SE LA SOMMA È CORRETTA
        } else {
            
            //imposta i dati degli errori a false
            $data = false;
            
        }

        //restituisce i dati
        return $data;
        
    }   