<?php

$id = $_GET['customer'];
$meta = get_user_meta($id);
$user = get_userdata($id);

$display_name = $user->display_name;
$user_email = $user->user_email;
$first_name = $meta['first_name'][0];
$last_name = $meta['last_name'][0];
$address_line_1 = $meta['address_line_1'][0];
$address_line_2 = $meta['address_line_2'][0];
$address_postcode = $meta['address_postcode'][0];
$address_town = $meta['address_town'][0];
$telephone = $meta['telephone'][0];
$status = $meta['status'][0];
?>

<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo $display_name; ?></h1>
    <div class="div" style="height: 30px; padding: 10px;">
        <div class="notice notice-success is-dismissible" style="display: none; margin: 0;"><p>User Updated!</p></div>
    </div>
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
        
            <th><label for="address_line_2"><?php _e( 'Address Line 2' ); ?></label></th>
            <td><input class="regular-text" id="address_line_2" type="text" name="address_line_2" placeholder="Address Line 2" value="<?php echo esc_attr($address_line_2); ?>" /></td>
        </tr>

        <tr>
            <th><label for="address_town"><?php _e( 'Town/City' ); ?></label></th>
            <td><input class="regular-text" id="address_town" type="text" name="address_town" placeholder="Town/City" value="<?php echo esc_attr($address_town); ?>" /></td>
        
            <th><label for="address_postcode"><?php _e( 'Postcode' ); ?></label></th>
            <td><input class="regular-text" id="address_postcode" type="text" name="address_postcode" placeholder="Postcode" value="<?php echo esc_attr($address_postcode); ?>" /></td>
        </tr>

        <tr>
            <select name="status" id="status" class="widefat">
                <option value="pack_sent" <?php selected( $status, 'pack_sent'); ?>>Pack Sent</option>
                <option value="pack_received" <?php selected( $status, 'pack_received'); ?>>Pack Received</option>
                <option value="box_sent" <?php selected( $status, 'box_sent'); ?>>Box Sent</option>
                <option value="box_received" <?php selected( $status, 'box_received'); ?>>Box Received</option>
            </select>
        </tr>

        </tbody>
    </table>
        <input type="hidden" name="action" value="update_customer" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        
        <?php submit_button( __( 'Save', 'retro-money-beef' ), 'primary' ); ?>
    </form>
</div>


<?php
