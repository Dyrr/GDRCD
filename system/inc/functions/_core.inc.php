<?php
/**
 * Funzioni di core di gdrcd
 * Il file contiene una revisione del core originario introdotto in GDRCD5
 * @version 5.4
 * @author Breaker
 */

/**
 * Funzionalità di dialogo col database
 * Set di funzioni da core che implementano il dialogo gestito col db
 */

/**
 * Connettore al database MySql
 */
 
	require 'core/modulo.inc.php';
	//carica il set di funzioni per l'interrogazione del database

	\functions\load('core/helpers');
	\functions\load('core/template');
	\functions\load('core/log');

	\functions\load('core/db/mysqli');
	\functions\load('core/security/password');
	\functions\load('core/security/defcon');
	\functions\load('core/security/crypt');
 
function gdrcd_connect() {
    static $db_link = false;

    if($db_link === false) {
        $db_user = $GLOBALS['PARAMETERS']['database']['username'];
        $db_pass = $GLOBALS['PARAMETERS']['database']['password'];
        $db_name = $GLOBALS['PARAMETERS']['database']['database_name'];
        $db_host = $GLOBALS['PARAMETERS']['database']['url'];
        $db_collation = $GLOBALS['PARAMETERS']['database']['collation'];
		$db_error = $GLOBALS['MESSAGE']['error']['db_not_found'];

        #$db = mysql_connect($db_host, $db_user, $db_pass)or die(gdrcd_mysql_error());
        #mysql_select_db($db_name)or die(gdrcd_mysql_error($db_error));

        $db_link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

        mysqli_set_charset($db_link, $db_collation);

        if(mysqli_connect_errno()) {
            gdrcd_mysql_error($db_error);
        }
    }
    return $db_link;
}

/**
 * Chiusura della connessione col db MySql
 * @param resource $db : una connessione mysqli
 */
function gdrcd_close_connection($db) {
    mysqli_close($db);
}

/**
 * Gestore delle query, offre una basilare astrazione del database per la maggior parte delle funzionalità del database più usate.
 * @param string|mysqli_result $sql : il codice SQL da inviare al database o una risorsa risultato di MySqli
 * @param string $mode : La modalità con cui eseguire la query. Default "query"
 * Modalità accettate:
 *  query: esegue la query e ritorna come risultato la prima riga del resultset
 *  result: esegue la query e ritorna la risorsa MySql associata al risultato
 *  num_rows: accetta come parametro una risorsa mysqli e ritorna il numero di righe nel resultset
 *  fetch: accetta come parametro una risorsa mysqli e ritorna il successivo risultato dal resultset come array
 *  object: uguale a fetch, eccetto che ritorna un oggetto al posto di un array
 *  free: libera la memoria occupata dalla risorsa mysqli passata in $sql
 *  last_id: ritorna l'id del record generato dall'ultima query, se non era una INSERT o UPDATE ritorna 0. In questo caso $sql non viene considerato
 *  affected: ritorna il numero di record toccati dall'ultima query (INSERT, UPDATE, DELETE o SELECT). In questo caso $sql non viene considerato
 * @return un booleano in caso di esecuzione di query non SELECT e modalità 'query'. Altrimenti ritorna come specificato nella descrizione di $mode
 */
function gdrcd_query($sql, $mode = 'query') {
    $db_link = gdrcd_connect();

    switch(strtolower(trim($mode))) {
        case 'query':
            switch(strtoupper(substr(trim($sql), 0, 6))) {
                case 'SELECT':
                    $result = mysqli_query($db_link, $sql) or die(gdrcd_mysql_error($sql));
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    mysqli_free_result($result);

                    return $row;
                    break;
                default:
                    return mysqli_query($db_link, $sql) or die(gdrcd_mysql_error($sql));
                    break;
            }

        case 'result':
            $result = mysqli_query($db_link, $sql) or die(gdrcd_mysql_error($sql));

            return $result;
            break;

        case 'num_rows':
            return (int) mysqli_num_rows($sql);
            break;

        case 'fetch':
            $row = mysqli_fetch_array($sql, MYSQLI_ASSOC);

            return $row;
            break;

        case 'object':
            $row = mysqli_fetch_object($sql);

            return $row;
            break;

        case 'free':
            return mysqli_free_result($sql);
            break;

        case 'last_id':
            return mysqli_insert_id($db_link);
            break;

        case 'affected':
            return (int) mysqli_affected_rows($db_link);
            break;
			
    }
}

/*
    * Prepared Statements
    * @param string $sql: il codice SQL da inviare al database
    * @param array $binds: array dei parametri associati alla query
    *
    * E' obbligatorio specificare nell'indice zero dell'array binds i tipi delle variabili che si stanno immettendo nella query
    * Tali tipi sono i seguenti:
    * i      corrispondente ai valori integer
    * d     corrispondente ai valori float/double
    * s     corrispondente alle stringhe
    * b     corrispondende a valori di tipo blob
    *
    * @return mysqli_result
*/
function gdrcd_stmt($sql, $binds = array())
{
    $db_link = gdrcd_connect();

    if ($stmt = mysqli_prepare($db_link, $sql)) {

        if (!empty($binds)) {
            
            #> E' necessario referenziare ogni parametro da passare alla query
            #> MySqli è suscettibile in proposito.
            $ref = array();
            
            foreach ($binds as $k => $v) {
                if ($k > 0) {
                    $ref[$k] = &$binds[$k];
                }else{
                    $ref[$k] = $v;
                }
            }
            
            array_unshift($ref, $stmt);
            call_user_func_array('mysqli_stmt_bind_param', $ref);
        }
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $stmtError = mysqli_stmt_error($stmt);
        
        if (!empty($stmtError))
            die(gdrcd_mysql_error($stmtError));
        
        mysqli_stmt_close($stmt);
        
        return $result;
        
    }else
    {
        die(gdrcd_mysql_error('Failed when creating the statement.'));
    }
}

/**
 * Funzione di recupero delle colonne e della loro dichiarazione della tabella specificata.
 * Si usa per la verifica dell'aggiornamento db da vecchie versioni di gdrcd5
 * @param string $table : il nome della tabella da controllare
 * @return un oggetto contenente la descrizione della tabella negli attributi
 */
function gdrcd_check_tables($table) {
    $result = gdrcd_query("SELECT * FROM $table LIMIT 1", 'result');
    $describe = gdrcd_query("SHOW COLUMNS FROM $table", 'result');

    $i = 0;
    $output = [];

    while($field = gdrcd_query($describe, 'object')) {
        $defInfo = mysqli_fetch_field_direct($result, $i);

        $field->auto_increment = (strpos($field->Extra, 'auto_increment') === false ? 0 : 1);
        $field->definition = $field->Type;

        if($field->Null == 'NO' && $field->Key != 'PRI') {
            $field->definition .= ' NOT NULL';
        }

        if($field->Default) {
            $field->definition .= " DEFAULT '".mysqli_real_escape_string(gdrcd_connect(), $field->Default)."'";
        }

        if($field->auto_increment) {
            $field->definition .= ' AUTO_INCREMENT';
        }

        switch($field->Key) {
            case 'PRI':
                $field->definition .= ' PRIMARY KEY';
                break;
            case 'UNI':
                $field->definition .= ' UNIQUE KEY';
                break;
            case 'MUL':
                $field->definition .= ' KEY';
                break;
        }

        $field->len = $defInfo->length;
        $output[$field->Field] = $field;
        ++$i;

        unset($defInfo);
    }
    gdrcd_query($describe, 'free');

    return $output;
}

/**
 * Gestione degli errori tornati dalle query
 * @param string $details : una descrizione dell'errore avvenuto
 * @return una stringa HTML che descrive l'errore riscontrato
 */
function gdrcd_mysql_error($details = false) {
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 50);

    $error_msg = '<strong>GDRCD MySQLi Error</strong> [File: '.basename($backtrace[1]['file']).'; Line: '.$backtrace[1]['line'].']<br>'.'<strong>Error Code</strong>: '.mysqli_errno(gdrcd_connect()).'<br>'.'<strong>Error String</strong>: '.mysqli_error(gdrcd_connect());

    if($details !== false) {
        $error_msg .= '<br><br><strong>Error Detail</strong>: '.$details;
    }

    return $error_msg;
}








/**
 * Funzione di filtraggio di codici malevoli negli input utente
 * @param string $what : modalità da utilizzare per controllare la stringa. Sono opzioni valide: in o get, num, out, addslashes, email, includes
 * @param string $str : la stringa da controllare
 * @return una versione filtrata di $str
 */
function gdrcd_filter($what, $str) {
    switch(strtolower($what)) {
        case 'in':
        case 'get':
            $str = addslashes(str_replace('\\', '', $str));
            break;

        case 'num':
            $str = (int) $str;
            break;

        case 'out':
            $str = html_entity_decode($str, ENT_HTML5, 'utf-8');
            break;

        case 'addslashes':
            $str = addslashes($str);
            break;

        case 'email':
            $str = (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,4}$#is", $str)) ? $str : false;
            break;

        case 'includes':
            $str = (preg_match("#[^:]#is")) ? htmlentities($str, ENT_QUOTES) : false;
            break;

        case 'url':
            $str = urlencode($str);
            break;

        case 'fullurl':
            $str = filter_var(str_replace(' ', '%20', $str), FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
            break;
    }

    return $str;
}

/**
 * Funzioni di alias per gdrcd_filter()
 */
function gdrcd_filter_in($str) {
    return gdrcd_filter('in', $str);
}

function gdrcd_filter_out($str) {
    return gdrcd_filter('out', $str);
}

function gdrcd_filter_get($str) {
    return gdrcd_filter('get', $str);
}

function gdrcd_filter_num($str) {
    return gdrcd_filter('num', $str);
}

function gdrcd_filter_addslashes($str) {
    return gdrcd_filter('addslashes', $str);
}

function gdrcd_filter_email($str) {
    return gdrcd_filter('email', $str);
}

function gdrcd_filter_includes($str) {
    return gdrcd_filter('includes', $str);
}

function gdrcd_filter_url($str) {
    return gdrcd_filter('url', $str);
}

/**
 * Funzione basilare di filtraggio degli elementi pericolosi in html
 * Serve a consentire l'uso di html e css in sicurezza nelle zone editabili della scheda
 * Il livello di filtraggio viene controllato da config: $PARAMETERS['settings']['html']
 * @param string $str : la stringa da filtrare
 * @return $str con gli elementi illegali sosituiti con una stringa di errore
 */
function gdrcd_html_filter($str) {
    $notAllowed = [
        "#(<script.*?>.*?(<\/script>)?)#is"      => "Script non consentiti",
        "#(<iframe.*?\/?>.*?(<\/iframe>)?)#is"   => "Frame non consentiti",
        "#(<object.*?>.*?(<\/object>)?)#is"      => "Contenuti multimediali non consentiti",
        "#(<embed.*?\/?>.*?(<\/embed>)?)#is"     => "Contenuti multimediali non consentiti",
        "#( on[a-zA-Z]+=\"?'?[^\s\"']+'?\"?)#is" => "",
        "#(javascript:[^\s\"']+)#is"             => ""
    ];

    if($GLOBALS['PARAMETERS']['settings']['html'] == HTML_FILTER_HIGH) {
        $notAllowed = array_merge($notAllowed, [
            "#(<img.*?\/?>)#is" => "Immagini non consentite",
            "#(url\(.*?\))#is"  => "none",
        ]);
    }

    return preg_replace(array_keys($notAllowed), array_values($notAllowed), $str);
}

/**
 * Controlli di routine di gdrcd sui personaggi
 * Set di funzione per semplificare controlli frequenti sui personaggi nell'engine
 */

/**
 * Check validità della sessione utente
 */
function gdrcd_controllo_sessione() {
    if(empty($_SESSION['login'])) {
        echo '<div class="error">', $GLOBALS['MESSAGE']['error']['session_expired'], '<br />', $GLOBALS['MESSAGE']['warning']['please_login_again'], '<a href="', $GLOBALS['PARAMETERS']['info']['site_url'], '">Homepage</a></div>';
        die();
    }
}

/**
 * Controlla se l'utente è esiliato o meno
 * @param string $pg : il nome del pg da ricercare
 * @return true se il pg è esiliato, false altrimenti
 */
function gdrcd_controllo_esilio($pg) {
    $exiled = gdrcd_query("SELECT autore_esilio, esilio, motivo_esilio FROM personaggio WHERE nome='".gdrcd_filter('in', $pg)."' LIMIT 1");

    if(strtotime($exiled['esilio']) > time()) {
        echo '<div class="error">', gdrcd_filter_out($pg), ' ', gdrcd_filter_out($GLOBALS['MESSAGE']['warning']['character_exiled']), ' ', gdrcd_format_date($exiled['esilio']), ' (', $exiled['motivo_esilio'], ' - ', $exiled['autore_esilio'], ')</div>';

        return true;
    }

    return false;
}

/**
 * Controlla se l'utente è loggato da pochi minuti. Utile per l'icona entra/esce
 * @param string $time : data in un formato leggibile da strtotime()
 * @return int
 */
function gdrcd_check_time($time) {
    $time_hours = date('H', strtotime($time));
    $time_minutes = date('i', strtotime($time));

    if($time_hours == date('H')) {
        return date('i') - $time_minutes;
    } elseif($time_hours == (date('H') - 1) || $time_hours == (strftime('H') + 11)) {
        return date('i') - $time_minutes + 60;
    }

    return 61;
}

/**
 * Utilità
 * Set di funzioni di utilità generica per l'engine
 */

/**
 * Provvede al caricamento degli elementi nell'interfaccia
 * E' approssimata ma funziona, se qualcuno vuol far di meglio si faccia avanti
 * @param string $path : il percorso filesystem del file da includere
 * @param array $params : un array di dati aggiuntivi passabili al modulo
 */
function gdrcd_load_modules($path, $params = []) {
    global $MESSAGE;
    global $PARAMETERS;

    if(file_exists($path)) {
        include($path);
    } else {
        echo $MESSAGE['interface']['layout_not_found'];
    }
}

/**
 * Funzione di formattazione per la data nel formato italiano
 * @param string $date_in : la data in un formato leggibile da strtotime()
 * @return la data nel formato dd/mm/yyyy
 */
function gdrcd_format_date($date_in) {
    return date('d/m/Y', strtotime($date_in));
}

/**
 * Funzione di formattazione del tempo nel formato italiano
 * @param string $time_in : la data-ora in un formato leggibile da strtotime()
 * @return l'ora nel formato hh:mm
 */
function gdrcd_format_time($time_in) {
    return date('H:i', strtotime($time_in));
}

/**
 * Funzione di formattazione data completa nel formato italiano
 * @param $datetime_in : la data e ora in formato leggibile da strtotime()
 * @return la data/ora nel formato DD/MM/YYYY hh:mm
 */
function gdrcd_format_datetime($datetime_in) {
    return date('d/m/Y H:i', strtotime($datetime_in));
}

/**
 * Funzione di formattazione data completa nel formato ita per nome file da catalogare
 * @param string $datetime_in : la data e ora in formato leggibile da strtotime()
 * @return data ora formattata nel formato YYYYMMDD_hhmm
 */
function gdrcd_format_datetime_cat($datetime_in) {
    return date('Ymd_Hi', strtotime($datetime_in));
}

/**
 * Trasforma la prima lettera della parola in maiuscolo
 * @param string $word : la parola da manipolare
 * @return $word con solo la prima lettera maiuscola
 */
function gdrcd_capital_letter($word) {
    return ucwords(strtolower($word));
}

/**
 * BBcode nativo di GDRCD
 * Secondo me, questo bbcode presenta non poche vulnerabilità.
 * TODO Andrebbe aggiornata per essere più sicura
 * @param string $str : la stringa con i bbcode da tradurre, dovrebbe già essere stata filtrata per l'output su pagina web
 * @return $str con i tag bbcode tradotti in html
 * @author Blancks
 */
function gdrcd_bbcoder($str) {
    global $MESSAGE;
    $str = gdrcd_close_tags('quote', $str);

    $search = [
        '#\n#',
        '#\[BR\]#is',
        '#\[B\](.+?)\[\/B\]#is',
        '#\[i\](.+?)\[\/i\]#is',
        '#\[U\](.+?)\[\/U\]#is',
        '#\[center\](.+?)\[\/center\]#is',
        '#\[img\](.+?)\[\/img\]#is',
        '#\[redirect\](.+?)\[\/redirect\]#is',
        '#\[url=(.+?)\](.+?)\[\/url\]#is',
        '#\[color=(.+?)\](.+?)\[\/color\]#is',
        '#\[quote(?::\w+)?\]#i',
        '#\[quote=(?:&quot;|"|\')?(.*?)["\']?(?:&quot;|"|\')?\]#i',
        '#\[/quote(?::\w+)?\]#si'
    ];
    $replace = [
        '<br />',
        '<br />',
        '<span style="font-weight: bold;">$1</span>',
        '<span style="font-style: italic;">$1</span>',
        '<span style="border-bottom: 1px solid;">$1</span>',
        '<div style="width:100%; text-align: center;">$1</div>',
        '<img src="$1">',
        '<meta http-equiv="Refresh" content="5;url=$1">',
        '<a href="$1">$2</a>',
        '<span style="color: $1;">$2</span>',
        '<div class="bb-quote">'.$MESSAGE['interface']['forums']['link']['quote'].':<blockquote class="bb-quote-body">',
        '<div class="bb-quote"><div class="bb-quote-name">$1 ha scritto:</div><blockquote class="bb-quote-body">',
        '</blockquote></div>'
    ];

    return preg_replace($search, $replace, $str);
}

/**
 * Aggiunge la chiusura dei tag BBCode per impedire agli utenti di rompere l'HTML del sito
 * @param array|string $tag : il tag da controllare, senza le parentesi quadre, può essere un array di tag
 * @param $body : il testo in cui controllare
 * @return Il testo corretto
 * TODO aggiunge correttamente i tag non chiusi, ma non fa nulla se ci sono troppi tag di chiusura
 */
function gdrcd_close_tags($tag, $body) {
    if(is_array($tag)) {
        foreach($tag as $value) {
            $body = gdrcd_close_tags($value, $body);
        }
    } else {
        $opentags = preg_match_all('/\['.$tag.'/i', $body);
        $closed = preg_match_all('/\[\/'.$tag.'\]/i', $body);
        $unclosed = $opentags - $closed;
        for($i = 0; $i < $unclosed; $i++) {
            $body .= '[/'.$tag.']';
        }
    }

    return $body;
}

/**
 * Fa il redirect della pagina, diretto ocon delay
 * @param $url : l'URL verso cui fare redirect
 * @param $tempo : il numero di secondi da attendere prima di fare redirect. Se non attendere impostare a 0 o false
 */
function gdrcd_redirect($url, $tempo = false) {
    if( ! headers_sent() && $tempo == false) {
        header('Location:'.$url);
    } elseif( ! headers_sent() && $tempo != false) {
        header('Refresh:'.$tempo.';'.$url);
    } else {
        if($tempo == false) {
            $tempo = 0;
        }
        echo "<meta http-equiv=\"refresh\" content=\"".$tempo.";".$url."\">";
    }
}

/**
 * Sostituisce eventuali parentesi angolari in coppia in una stringa con parentesi quadre
 * @param string $str : la stringa da controllare
 * @return $str con la coppie di parentesi angolari sostituite con parentesi quadre
 */
function gdrcd_angs($str) {
    $search = [
        '#\&lt;(.+?)\&gt;#is',
        '#\<(.+?)>#is',
    ];
    $replace = [
        '[$1]',
        '[$1]',
    ];

    return preg_replace($search, $replace, $str);
}

/**
 * Colora in HTML le parti di testo comprese tra parentesi angolari o parentesi quadre
 * Si usa in chat
 * @param string $str : la stringa da controllare
 * @return $str con la parti colorate
 */
function gdrcd_chatcolor($str) {
    $search = [
        '#\&lt;(.+?)\&gt;#is',
        '#\[(.+?)\]#is',
    ];
    $replace = [
        '<span class="color2">&lt;$1&gt;</span>',
        '<span class="color2">&lt;$1&gt;</span>',
    ];

    return preg_replace($search, $replace, $str);
}

/**
 * Sottolinea in HTML una stringa presente in un testo. Usata per sottolineare il proprio nome in chat
 * @param string $user : la stringa da sottolineare, in genere un nome utente
 * @param string $str : la stringa in cui cercare e sottolineare $user
 * @return $str con tutte le occorrenze di $user sottolineate
 */
function gdrcd_chatme($user, $str, $master = false) {
    $search = "|\\b".preg_quote($user, "|")."\\b|si";
    if( ! $master) {
        $replace = '<span class="chat_me">'.gdrcd_filter('out', $user).'</span>';
    } else {
        $replace = '<span class="chat_me_master">'.gdrcd_filter('out', $user).'</span>';
    }

    return preg_replace($search, $replace, $str);
}

/**
 * Crea un campo di autocompletamento HTML5 (<datalist>) per vari contenuti
 * @param string $str : specifica il soggetto di cui creare la lista. Attualmente è supportato solo 'personaggi', che crea una lista di tutti gli utenti del gdr
 * @return il tag html <datalist> già pronto per essere stampato sulla pagina
 */
function gdrcd_list($str) {
    switch(strtolower($str)) {
        case 'personaggi':
            $list = '<datalist id="personaggi">';
            $query = "SELECT nome FROM personaggio ORDER BY nome";
            $characters = gdrcd_query($query, 'result');

            while($option = gdrcd_query($characters, 'fetch')) {
                $list .= '<option value="'.$option['nome'].'" />';//TODO escape HTMl del nome!
            }
            gdrcd_query($characters, 'free');
            $list .= '</datalist>';
            break;
    }

    return $list;
}

