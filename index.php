<?php

/**
 * Plugin Name: Customer User Role
 * Plugin URI: https://richardmiddleton.me
 * Description: Adds a customer user role to users.
 * Version: 1.0
 * Author: Richard Middleton
 */

add_role('customer', __( 'Customer' ), array(
		'read'         => true,
		'edit_posts'   => false,
	)
);

include plugin_dir_path(__FILE__) . 'modify-customer.php';

include plugin_dir_path(__FILE__) . 'customer-table.php';

