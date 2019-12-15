<?php 
// display custom admin notice
function rmb_custom_admin_notice($message) {
	?>
	<div class="notice notice-success is-dismissible">
		<p><?php _e($message, 'retro-money-beef'); ?></p>
	</div>
	<?php
}