<?php

$id = $_GET['customer'];
$meta = get_user_meta($id);
$user = get_userdata($id);

$display_name = $user->display_name;
$first_name = $meta->first_name;
$last_name = $meta->last_name;
$address = $meta['user_address'][0];
?>

<form id="user-form" enctype="multipart/form-data" method="POST" action="<?php echo admin_url('admin-ajax.php'); ?>">
<h3><?php echo $display_name; ?> </h3>
<h3><?php echo $address; ?> </h3>
    <input type="text" name="user_address" placeholder="Address" value="" />
    <input type="hidden" name="action" value="update_customer" />
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    
    <?php submit_button( __( 'Save', 'retro-money-beef' ), 'primary' ); ?>
</form>


<?php
