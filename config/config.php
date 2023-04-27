<?php

// base de données

//db micke
// define("DB_HOST", 'db.3wa.io');
// define("DB_NAME", 'argon71hotmailfr_mysociety');
// define("DB_USER", 'argon71hotmailfr');
// define("DB_PASS", '1b6d9c41e962f51b032b2fbc3a06cba1');

//db local
define('DB_HOST', '127.0.0.1');
define('DB_DATABASE', 'projet-rattrapage');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

//db ide
// define('DB_HOST', 'db.3wa.io');
// define('DB_DATABASE', 'lauredominguez_import');
// define('DB_USERNAME', 'lauredominguez');
// define('DB_PASSWORD', 'a0f980b4fdda9a703fe56e7ea61b8c49');


// cookie panier
    define('COOKIE_NAME', 'panier');
    define('COOKIE_EXPIRE', time() + 86400);

global $panier;

if (isset($_COOKIE[COOKIE_NAME])) {
    $panier = json_decode($_COOKIE[COOKIE_NAME], true);
} else {
    $panier = array();
}


// serveur mail