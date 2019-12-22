<?php

add_action("admin_menu", "customer_list_table_menu");

function customer_list_table_menu() {

    add_menu_page("Customers", "Customers", "manage_options", "customer-list-table", "customer_list_table_fn", "dashicons-admin-users", 20);
    add_submenu_page( 'customer-list-table', 'add_customer', 'Add Customer',
    'manage_options', "add_customer", 'add_customer_fn');

    // mailchimp setup
    add_submenu_page( 'customer-list-table', 'customer_table_settings', 'Settings',
    'manage_options', 'mailchimp_settings', 'rmb_plugin_settings_page');
    // register options
	register_setting( 'rmb-plugin-settings-group', 'mailchimp_api' );
	register_setting( 'rmb-plugin-settings-group', 'mailchimp_list_id' );
}



function add_customer_fn() {
    include_once plugin_dir_path( __FILE__ ) . 'views/customer-new.php';
}

function customer_list_table_fn() {

    ob_start();
    if ( isset( $_GET['customer']) && $_GET['action'] == 'edit' ) {
        include_once plugin_dir_path( __FILE__ ) . 'views/user.php';
        die;
    }

    include_once plugin_dir_path(__FILE__) . 'views/customer-table-list.php';

    $template = ob_get_contents();
    
    ob_end_clean();
    
    echo $template;
}
