<?php
include_once plugin_dir_path( __FILE__ ) . 'views/settings.php';
// create custom plugin settings menu
add_action('admin_menu', 'rmb_create_menu');

function rmb_create_menu() {
	//call register settings function
	add_action( 'admin_init', 'register_rmb_plugin_settings' );
}

function register_rmb_plugin_settings() {
	//register our settings
	register_setting( 'rmb-plugin-settings-group', 'mailchimp_api' );
	register_setting( 'rmb-plugin-settings-group', 'mailchimp_list_id' );
}
