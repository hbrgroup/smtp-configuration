<?php 
defined('ABSPATH') or die('No script kiddies please!');
require_once(__DIR__ . '/smtp-configuration.php'); ?>

<div class="wrap">
    <h1>SMTP Settings</h1>
    <form method="post" action="<?php menu_page_url('smtp-configuration'); ?>" >
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">Host Name</th>
                    <td>
                        <input type="text" name="smtp_host" aria-describedby="smtp_host_description" class="regular-text code" value="<?php echo esc_attr(get_option('smtp-configuration-smtp-host')); ?>" placeholder="smtp.gmail.com" />
                        <p class="description" id="smtp_host_description">Host Name (<i>eg. smtp.gmail.com</i>)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Port</th>
                    <td><input type="text" name="smtp_port" value="<?php echo esc_attr(get_option('smtp-configuration-smtp-port')); ?>" placeholder="25" /></td>
                </tr>
                <tr>
                    <th scope="row">Use SSL?</th>
                    <td><input type="checkbox" name="smtp_secure" id="smtp_secure" <?php impedro_smtpconfiguration_maybe_smtp_secure_checked(); ?> /></td>
                </tr>
                <tr>
                    <th scope="row">Use SMTP Authentication?</th>
                    <td><input type="checkbox" name="smtp_auth" id="smtp_auth" <?php impedro_smtpconfiguration_maybe_smtp_auth_checked(); ?> /></td>
                </tr>
            </tbody>
        </table>

        <div id="smtp_auth_parameters" style="display: <?php impedro_smtpconfiguration_maybe_hide_smtp_auth_parameters(); ?>">
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row">Username</th>
                        <td>
                            <input type="text" name="smtp_username" id="smtp_username" class="regular-text" value="<?php echo esc_attr(get_option('smtp-configuration-smtp-username')); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Password</th>
                        <td><input type="password" name="smtp_password" id="smtp_password" value="<?php echo esc_attr(get_option('smtp-configuration-smtp-password')); ?>" /></td>
                    </tr>
                   
                </tbody>
            </table>
        </div>

        <p class="submit">
            <input type="submit" class="button button-primary" value="Update Settings" />
        </p>
        <?php wp_nonce_field('smtp-configuration'); ?>
    </form>
</div>