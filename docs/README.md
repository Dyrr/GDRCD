# Introduzione {#mainpage}

# Introduzione {#mainpage}

##1 Indice {#mainpage_1} #
1. [Indice] (#mainpage_1)
2. [Requisiti Minimi] (#mainpage_2) 
3. [Installazione] (#mainpage_3)
	1. [Caricamento dei file nello spazio web](#mainpage_3_1)
	2. [Installazione guidata](#mainpage_3_2)
		1. [Controllo requisiti] (#mainpage_3_2_1)
		2. [Operazioni sul database] (#mainpage_3_2_2)
		3. [Creazione dell'account di gestione] (#mainpage_3_2_3)
		4. [Completamento dell'installazione] (#mainpage_3_2_4)
	3. [Installazione manuale](#mainpage_3_3)	
		1. [Configuraizone della connesisone al database] (#mainpage_3_3_1)	
		2. [Installazione del database] (#mainpage_3_3_2)
99. [Altra documentazione](#mainpage99)
	1. [documentazione per gli sviluppatori](#mainpage99_1)

## 2 Requisiti Minimi {#mainpage_2} #
I requisiti minimi per poter utilizzare questa versione del GDRCD 7 sono:
- Uno spazio web su un host che  PHP 7.1 o superiore
- Un database con MySQL 5.1 ao superiore (MySQL 5.6 consigliato);
- Le seguenti estensioni di php abilitate :
	+ PDO o mysqli o mysqlind a scelta (PDO consigliata);
	+ openssl;
	+ gdlib.
	
## 3 Installazione {#mainpage_3} #	
	
### 3.1 Caricamento dei file nello spazio web {#mainpage_3_1} #
Per prima cosa bisogna estrarre i file dall'archivio compresso .zip scaricato dal repository o dal sito contenente il 
pacchetto in una cartella del vostro pc controllando che la struttura delle cartelle dello stesso sia stata mantenuta.
Una volta fatta questa verifica i file vanno caricati sullo spazio web che avete scelto. Per effettuare questa 
operazione avrete bisogno di un client FTP come programma per caricare i file sull'host e dei dati di accesso all'ftp 
del vostro spazio web.
Per il client ftp ci sono numerosi ottimi programmi freeware che fanno allo scopo, scegliete quello che vi attira di più.
Per i dati di accesso all'ftp, solitamente l'host li invia nella mail di iscrizione o comunque ha delle guide al riguardo 
per cui vi rimando alla documentaizone dell'host.
Una volta configurato il client ftp, basta caricare i file sull'host che è la stessa cosa di quando copiate dei file da 
una cartella all'altra del vostro pc e verificare per scrupolo che la sturttura delle directory sia rimasta la stessa.

#### 3.2 Installazione guidata {#mainpage_3_2} #
Una volta terminate tutte le operazioni del punto procedente possiamo prendere il nostro browser e digitare nella barra 
degli indirizzi quella del nostro sito web es: https://www.miosito.org e il CMS riconoscerà che si tratta di un primo 
accesso facendo partire una procedura di installazione guidata passo passo tramite una interfaccia utente.

#### 3.2.1 Controllo requisiti {#mainpage_3_2_1} #
La prima schermata a cui ci troviamo di fronte è una semplice schermata dove il CMS controlla che tutti i prerequisiti 
citati al punto 1 siano soddisfatti visualizzando eventualmente i problemi da risolvere prima di proseguire con 
l'installazione

![Fase 1](/system/_doc/img/installation1.png)

#### 3.2.2 Operazioni sul database {#mainpage_3_2_2} #
In questa fase vengono salvati i parametri di connesisone al database, fatti i controlli dei requisiti del server 
MySQL e della possibilità di importare il database. Se non ci sono problemi dopo questi controlli il database viene 
importato. 
Per i parametri di connessione al database anche qui consigliamo di leggere la documentazione fornita dal proprio host 
al riguardo solitamente anche queta fornita con la mail di registrazione o in apposite quide sul sito di supporto 
dell'host

![Fase 2](/system/_doc/img/installation2.png)

#### 3.2.3 Creazione dell'account di gestione {#mainpage_3_2_3} #
In questa fase verrà creato sia l'user che il pg per il personaggio di gestione. Si è scelto di legare i permessi di 
gestione al pg e non all'user per permettere diversi livelli di gestione qualora l'utenza di gestione volesse avere un 
pg come gestore e uno come master o altre situaizoni simili.
Durante questa fase si consiglia di segnarsi la password scelta per l'account di gestione in quanto questa non verrà 
inviata via mail, per cui in caso sia dimenticata dovrà essere resettata normalmente tramite il normale reset della 
password.

![Fase 3](/system/_doc/img/installation3.png)

#### 3.2.4 Completamento dell'installazione {#mainpage_3_2_4} #
Una volta arrivati a questo punto è possibile procedere in due modi:
- Concludere l'installazione;
- Configurare alcune opzioni avanzate prima di concludere l'installazione.

Se non si hanno perticolari esigenze si può procedere con il completamento dell'installazione e al caricamento della 
pagina principale altrimenti si può procedere alla configuraizone delle opzioni avanzate.
Nel caso si concluda laprocedura di installazione la pagina di installazione non potrà più essere richiamata a meno di 
modificare a mano il file [/system/config/install.php](/gdrcd7/system/_doc/html/system_2config_2install_8php_source.html) per maggiore sicurezza 
si consiglia però di eliminare tutta la cartella /gdrcd7/system/install 

### 3.3 Installazione manuale {#mainpage_3_3} #
Qualora sia necessario per qualsiasi motivo, installazione guidata bloccata o altro, è possibile installare il GDRCD 7 
anche manualmente, anche se questo tipo di installazione è consigliata solo in caso di necessità o nel caso di utenti 
esperti.

## 99 Altra documentazione {#mainpage_99}

### 99.1 Documentazione per gli sviluppatori {#mainpage_99_1}

 - [Linee guida per la creazione di documentazione](@ref Istruzioni_per_la_documentazione);
 - [Linee guida per la creazione di moduli e plugin](@ref creazione_moduli)





 
 

