<?php

/**
 * Plugin Name: Wordpress Advanced CRM
 * Plugin URI: https://richardmiddleton.me
 * Description: Advanced Wordpress CRM for building and maintaining customers.
 * Version: 1.0
 * Author: Richard Middleton
 */

if(!function_exists('add_action')){
    echo 'hi there im just a plugin, i cant be called directly';
    exit;
 }
 
include plugin_dir_path(__FILE__) . 'user-role.php';

include plugin_dir_path(__FILE__) . 'notice.php';

include plugin_dir_path(__FILE__) . 'modify-customer.php';

include plugin_dir_path(__FILE__) . 'customer-table.php';

include plugin_dir_path(__FILE__) . 'settings.php';

