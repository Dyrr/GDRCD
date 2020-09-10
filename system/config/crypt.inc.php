<?php
/* POLITICA DI CRIPTAZIONE
 * E' stata rimossa la possibilita' di scegliere se salvare le password in chiaro.
 * Sono stati rimossi i metodi SHA-1 e MD5 non essendo piu' sicuri. Rimane solo la funzione BCRYPT
 */
$PARAMETERS['encritp']['algorithm'] = PASSWORD_DEFAULT;
$PARAMETERS['encritp']['options'] = null;
$PARAMETERS['encritp']['mode'] = 'AES-128-CBC';
$PARAMETERS['encritp']['key'] = 'D1f€nTer05igN0R€d1M0nTo';
$PARAMETERS['encritp']['iv'] = 'de5IdeR10dIc1tU-';
$PARAMETERS['encritp']['hash'] = 'sha512';
$PARAMETERS['encritp']['ip'] = 'none';
$PARAMETERS['encritp']['email'] = 'none';

