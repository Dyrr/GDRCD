<?php
/* SCELTA DEL TEMA */
$PARAMETERS['themes']['current_theme'] = 'advanced'; //tema in uso
//$PARAMETERS['themes']['current_theme'] = 'medieval';
/**
 * SCELTA DEL TIPO DI LAYOUT
 * Tutti i layout sono cross-browser, compatibili cioè con tutti i browser.
 * Il css di ogni singolo layout è disponibile nel file del layout nella cartella "layouts"
 * se avete intenzione di editarli fatelo con cura
 * @author Blancks
 **** Descrizione dei tipi di frames_layout selezionabili:
 * left-right: [ LAYOUT DI DEFAULT ] layout a frames con colonne fisse a destra e sinistra
 * * Questo layout consente di abilitare e di usare left_column e right_column per decidere quali moduli caricare e
 *     dove
 * left-top: Layout a frames con colonna fissa a sinistra e riga fissa in alto, contenuti in basso adattabili
 * * Questo layout consente di abilitare e di usare left_column e top_column per decidere quali moduli caricare e dove
 * left-bottom: Layout a frames con colonna fissa a sinistra e riga fissa in basso, contenuti in alto adattabili
 * * Questo layout consente di abilitare e di usare left_column e bottom_column per decidere quali moduli caricare e
 *     dove top-bottom: Layout a frames con riga fissa in alto e riga fissa in basso, contenuti al centro
 * * Questo layout consente di abilitare e di usare top_column e bottom_column per decidere quali moduli caricare e
 *     dove
 *
 * * AVVERTENZA: ricordare di ordinare il css dei moduli di modo che sostino bene, su di una riga, altrimenti è normale
 * * avere problemi di visualizzazione
 * left-top-right: Layout a frames con colonna fissa a sinistra e a destra e riga fissa in alto, contenuti in basso al
 *     centro adattabili
 * * Questo layout consente di abilitare e di usare left_column, top_column e right_column per decidere quali moduli
 *     caricare e dove
 *
 * * AVVERTENZA: ricordare di ordinare il css dei moduli di modo che sostino bene sulla riga superiore, altrimenti è
 *     normale
 * * avere problemi di visualizzazione
 * left-right-bottom: Layout a frames con colonna fissa a sinistra e a destra e riga fissa in basso, contenuti in alto
 *     al centro adattabili
 * * Questo layout consente di abilitare e di usare left_column, bottom_column e right_column per decidere quali moduli
 *     caricare e dove
 *
 * * AVVERTENZA: ricordare di ordinare il css dei moduli di modo che sostino bene sulla riga superiore, altrimenti è
 *     normale
 * * avere problemi di visualizzazione
 * left-top-bottom: Layout a frames con colonna fissa a sinistra e riga fissa in basso e in alto, contenuti al centro
 *     adattabili
 * * Questo layout consente di abilitare e di usare left_column, bottom_column e top_column per decidere quali moduli
 *     caricare e dove
 *
 * * AVVERTENZA: ricordare di ordinare il css dei moduli di modo che sostino bene sulla riga superiore, altrimenti è
 *     normale
 * * avere problemi di visualizzazione
 * left-top-right-bottom: Layout a frames con colonna fissa a sinistra e a destra e riga fissa in basso e in alto,
 *     contenuti al centro adattabili
 * * Questo layout consente di abilitare e di usare left_column, bottom_column, top_column e right_column per decidere
 *     quali moduli caricare e dove
 *
 * * AVVERTENZA: ricordare di ordinare il css dei moduli di modo che sostino bene sulla riga superiore e inferiore,
 *     altrimenti è normale
 * * avere problemi di visualizzazione
 * left: layout a frames con una colonna di sinistra fissa e contenuti adattabili
 * * Questo layout consente di abilitare e di usare solo left_column per caricare i moduli (menu, messaggi, presenti
 *     etc) right: Layout a frames con una colonna di destra fissa e contenuto adattablile
 * * Questo layout consente di abilitare e di usare solo right_column per caricare i moduli
 * top: Layout a frames con una riga in alto e contenuti adattabili in basso
 * * Questo layout consente di abilitare e di usare solo top_column per caricare i moduli
 *
 * * AVVERTENZA: ricordare di ordinare il css dei moduli di modo che sostino bene, su di una riga, altrimenti è normale
 * * avere problemi di visualizzazione
 * bottom: Layout a frames con una riga in basso e contenuti adattabili in alto
 * * Questo layout consente di abilitare e di usare solo bottom_column per caricare i moduli
 *
 * * AVVERTENZA: ricordare di ordinare il css dei moduli di modo che sostino bene, su di una riga, altrimenti è normale
 * * avere problemi di visualizzazione
 *
 */
$PARAMETERS['themes']['kind_of_layout'] = 'left-right';

/*COLONNA SINISTRA */
$PARAMETERS['section']['left']['box']['info_location']['class'] = 'info';
$PARAMETERS['section']['left']['box']['info_location']['page'] = 'info_location'; //Meteo e informazioni sul luogo.
$PARAMETERS['section']['left']['box']['frame_messaggi']['class'] = 'msgs';
$PARAMETERS['section']['left']['box']['frame_messaggi']['page'] = 'frame_messaggi'; //Link ai messaggi ed al forum.
$PARAMETERS['section']['left']['box']['link_menu']['class'] = 'menu';
$PARAMETERS['section']['left']['box']['link_menu']['page'] = 'link_menu'; //Menu' del gioco.

/*COLONNA DESTRA*/
$PARAMETERS['section']['right']['box']['frame_presenti']['class'] = 'presenti';
$PARAMETERS['section']['right']['box']['frame_presenti']['page'] = 'frame_presenti'; //Presenti.