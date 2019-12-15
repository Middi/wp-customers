<?php

?>

<div class="wrap">
    <h1 class="wp-heading-inline">Add Customer</h1>
    <!-- <div class="div" style="height: 30px; padding: 10px;">
        <div class="notice notice-success is-dismissible" style="display: none; margin: 0;"><p>User Updated!</p></div>
    </div> -->
    <form id="user-form" enctype="multipart/form-data" method="POST" action="<?php echo admin_url('admin-ajax.php'); ?>">
    <table class="form-table" role="presentation">
    <tbody>
        <tr>
            <th><label for="first_name"><?php _e( 'First Name' ); ?></label></th>
            <td><input class="regular-text" id="first_name" type="text" name="first_name" placeholder="First Name" value="<?php echo esc_attr($first_name); ?>" /></td>
        
            <th><label for="last_name"><?php _e( 'Last Name' ); ?></label></th>
            <td><input class="regular-text" id="last_name" type="text" name="last_name" placeholder="First Name" value="<?php echo esc_attr($last_name); ?>" /></td>
        </tr>

        <tr>
            <th><label for="telephone"><?php _e( 'Telephone' ); ?></label></th>
            <td><input class="regular-text" id="telephone" type="text" name="telephone" placeholder="Telephone" value="<?php echo esc_attr($telephone); ?>" /></td>
            <th><label for="email"><?php _e( 'Email' ); ?></label></th>
            <td><input class="regular-text" id="email" type="text" name="user_email" placeholder="Email" value="<?php echo esc_attr($user_email); ?>" /></td>
        </tr>
        <tr>
            <th><label for="address_line_1"><?php _e( 'Address Line 1' ); ?></label></th>
            <td><input class="regular-text" id="address_line_1" type="text" name="address_line_1" placeholder="Address Line 1" value="<?php echo esc_attr($address_line_1); ?>" /></td>
        </tr>

        <tr>
            <th><label for="address_line_2"><?php _e( 'Address Line 2' ); ?></label></th>
            <td><input class="regular-text" id="address_line_2" type="text" name="address_line_2" placeholder="Address Line 2" value="<?php echo esc_attr($address_line_2); ?>" /></td>
        </tr>

        <tr>
            <th><label for="address_town"><?php _e( 'Town/City' ); ?></label></th>
            <td><input class="regular-text" id="address_town" type="text" name="address_town" placeholder="Town/City" value="<?php echo esc_attr($address_town); ?>" /></td>
        </tr>

        <tr>
            <th><label for="address_postcode"><?php _e( 'Postcode' ); ?></label></th>
            <td><input class="regular-text" id="address_postcode" type="text" name="address_postcode" placeholder="Postcode" value="<?php echo esc_attr($address_postcode); ?>" /></td>
        </tr>
        </tbody>
    </table>
        <input type="hidden" name="action" value="create_customer" />
        
        <?php submit_button( __( 'Save', 'retro-money-beef' ), 'primary' ); ?>
    </form>
</div>


<?php
