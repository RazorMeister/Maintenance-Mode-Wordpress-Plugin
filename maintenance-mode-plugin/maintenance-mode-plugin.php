<?php
/**
* Plugin Name: Maintenance Mode Plugin
* Plugin URI: https://github.com/RazorMeister/Maintenance-Mode-Wordpress-Plugin
* Description: Wtyczka umożliwiająca ustawienie maintenence mode w wybrancyh godzinach oraz na wykluczające adresy IP.
* Version: BETA

* Author: Tymoteusz `RazorMeister` Bartnik & Przemysław `lavar3l` Dominikowski
* Author URI: http://razormeister.pl

* License: MIT
* License URI: https://github.com/RazorMeister/Maintenance-Mode-Wordpress-Plugin/blob/master/LICENSE
**/

namespace MaintenanceModePlugin;

use MaintenanceModePlugin\Inc as Inc;

if( !defined('ABSPATH') ) exit;

if (file_exists(dirname(__FILE__).'/inc/AutoLoader.php')) {
    require_once dirname(__FILE__).'/inc/AutoLoader.php';
    $autoLoader = new Inc\AutoLoader();
}

/* Register all needed services */
Inc\Init::registerServices();