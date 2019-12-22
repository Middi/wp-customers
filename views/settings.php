<?php
function rmb_plugin_settings_page() { ?>

<div class="wrap">
    <h1>Mailchimp Settings</h1>

    <form method="post" action="options.php">
        <?php settings_fields( 'rmb-plugin-settings-group' ); ?>
        <?php do_settings_sections( 'rmb-plugin-settings-group' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">MailChimp API</th>
                <td><input type="text" class="regular-text" name="mailchimp_api"
                        value="<?php echo esc_attr( get_option('mailchimp_api') ); ?>" /></td>
            </tr>

            <tr valign="top">
                <th scope="row">Mailchimp List ID</th>
                <td><input type="text" class="regular-text" name="mailchimp_list_id"
                        value="<?php echo esc_attr( get_option('mailchimp_list_id') ); ?>" /></td>
            </tr>

        </table>

        <?php submit_button(); ?>

    </form>
</div>
<?php } 