<?php

/**
 * Plugin Name: Wordpress Advanced CRM
 * Plugin URI: https://richardmiddleton.me
 * Description: Advanced Wordpress CRM for building and maintaining customers.
 * Version: 1.0
 * Author: Richard Middleton
 */

include plugin_dir_path(__FILE__) . 'user-role.php';

include plugin_dir_path(__FILE__) . 'modify-customer.php';

include plugin_dir_path(__FILE__) . 'customer-table.php';


// display custom admin notice
function rmb_custom_admin_notice($message) { ?>
	
	<div class="notice notice-success is-dismissible">
		<p><?php _e($message, 'retro-money-beef'); ?></p>
	</div>
	
<?php }
