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

add_action('wp_enqueue_scripts', 'enqueue_jquery_form');

function enqueue_jquery_form() {
	wp_enqueue_script('jquery-form');
}

add_action('wp_ajax_create_customer', 'rmb_create_customer');

add_action('wp_ajax_nopriv_create_customer', 'rmb_create_customer');

function rmb_create_customer() {
	$user_id = username_exists( $_POST['user_name'] );
	if ( !$user_id and email_exists($_POST['user_email']) == false ) {
		$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
		$user_id = wp_create_user( $_POST['user_name'], $random_password, $_POST['user_email'] );
		$user_id = wp_update_user( array( 'ID' => $user_id, 'role' => 'customer' ) );

		wp_new_user_notification($user_id, $random_password);
	}
	else {
		$random_password = __('User already exists.  Password inherited.');
	}
}

add_action('wp_ajax_update_customer', 'rmb_update_customer');

function rmb_update_customer() {
	update_user_meta( get_current_user_id(), 'user_address', $_POST['user_address'] );
}

