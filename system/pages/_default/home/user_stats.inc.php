<?php /*HELP: */
/** * Raccolta statistiche sito */
$site_activity = gdrcd_query("SELECT MIN(data_iscrizione) AS date_of_activity FROM personaggio");
$registered_users = gdrcd_query("SELECT COUNT(nome) AS num FROM personaggio");
$banned_users = gdrcd_query("SELECT COUNT(nome) AS num FROM personaggio WHERE esilio > NOW()");
$master_users = gdrcd_query("SELECT COUNT(nome) AS num FROM personaggio WHERE permessi = ".GAMEMASTER);
$admin_users = gdrcd_query("SELECT COUNT(nome) AS num FROM personaggio WHERE permessi >= ".MODERATOR);
$weekly_posts = gdrcd_query("SELECT COUNT(id_messaggio) AS num FROM messaggioaraldo WHERE data_messaggio > DATE_SUB(NOW(), INTERVAL 7 DAY)");
$weekly_actions = gdrcd_query("SELECT COUNT(id) AS num FROM chat WHERE ora > DATE_SUB(NOW(), INTERVAL 7 DAY)");
$weekly_signup = gdrcd_query("SELECT COUNT(nome) AS num FROM personaggio WHERE data_iscrizione > DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $query = "SELECT 
                 COUNT(nome) AS online 
             FROM personaggio 
             WHERE 
                     ora_entrata > ora_uscita 
                 AND DATE_ADD(ultimo_refresh, INTERVAL 4 MINUTE) > NOW()";   
    $users = gdrcd_query($query);
	
	require \template\file('home/user_stats');