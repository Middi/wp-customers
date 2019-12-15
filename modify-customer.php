<?php

add_action('wp_ajax_create_customer', 'rmb_create_customer');

add_action('wp_ajax_nopriv_create_customer', 'rmb_create_customer');

function rmb_create_customer() {
    $user_id = username_exists( $_POST['user_name'] );
	if ( !$user_id and email_exists($_POST['user_email']) == false ) {
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];
		if ($pass1 != $pass2){
			echo "<span style='color:#FF0000'><strong>Error..</strong></span><br /><br />please use a passwords don't match.";
				exit();
        }

        $date = date_create();
        $username = $_POST['first_name'] . date_timestamp_get($date);
		$user_id = wp_create_user( $username, $pass1, $_POST['user_email'] );
		$user_id = wp_update_user( array( 'ID' => $user_id, 'role' => 'customer' ) );

		$metas = array( 
			'first_name' => $_POST['first_name'], 
			'last_name'  => $_POST['last_name'],
			'user_email'  => $_POST['user_email'],
			'telephone'  => $_POST['telephone'],
            'address_line_1'  => $_POST['address_line_1'],
            'address_line_2'  => $_POST['address_line_2'],
            'address_town'  => $_POST['address_town'],
            'address_postcode'  => $_POST['address_postcode'],
            'status'  => $_POST['status'],
		);

		foreach($metas as $key => $value) {
			update_user_meta( $user_id, $key, $value );
		}

		wp_new_user_notification($user_id, $random_password);
	}
	else {
		$random_password = __('User already exists.  Password inherited.');
	}
}

add_action('wp_ajax_update_customer', 'rmb_update_customer');

function rmb_update_customer() {

		$metas = array( 
			'first_name' => $_POST['first_name'], 
			'last_name'  => $_POST['last_name'],
			'user_email'  => $_POST['user_email'],
			'telephone'  => $_POST['telephone'],
            'address_line_1'  => $_POST['address_line_1'],
            'address_line_2'  => $_POST['address_line_2'],
            'address_town'  => $_POST['address_town'],
            'address_postcode'  => $_POST['address_postcode'],
            'status'  => $_POST['status'],
        );

		foreach($metas as $key => $value) {
			update_user_meta( $_POST['id'], $key, $value );
        }
        exit();
    }



