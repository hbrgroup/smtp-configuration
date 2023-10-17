<?php
defined('ABSPATH') or die('No script kiddies please!');

# Write this to wp_config.php or functions.php in theme folder
# and comment it for easy plugin updates

if (!defined('DEFAUT_SMTP_HOST')) 
    define('DEFAUT_SMTP_HOST', 'localhost');

if (!defined('DEFAUT_SMTP_PORT')) 
    define('DEFAUT_SMTP_PORT', 465);

if (!defined('DEFAUT_SMTP_USER')) 
    define('DEFAUT_SMTP_USER', '');

if (!defined('DEFAUT_SMTP_PASS')) 
    define('DEFAUT_SMTP_PASS', '');

if (!defined('DEFAUT_SMTP_SECURE')) 
    define('DEFAUT_SMTP_SECURE', true);