<?php 
defined('ABSPATH') or die('No script kiddies please!');
require_once(__DIR__ . '/smtp-configuration.php'); ?>

<div class="wrap">
    <h1><?php _e('SMTP Settings', 'smtp-configuration') ?></h1>
    <p><?php _e('Configure your SMTP settings here. If you are unsure about the settings, please contact your hosting provider.', 'smtp-configuration') ?></p>
    <table class="form-table" role="presentation">
        <tr>
            <td style="vertical-align: top;">
                <h2><?php _e('Settings & Authentication', 'smtp-configuration') ?></h2>
                <form method="post" action="<?php menu_page_url('smtp-configuration', 'smtp-configuration'); ?>">
                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row"><?php _e('Host Name', 'smtp-configuration') ?></th>
                                <td>
                                    <input type="text" name="smtp_host" aria-describedby="smtp_host_description" class="regular-text code" value="<?php echo esc_attr(get_option('smtp-configuration-smtp-host', DEFAUT_SMTP_HOST)); ?>" placeholder="smtp.gmail.com" />
                                    <p class="description" id="smtp_host_description"><?php _e('Host Name', 'smtp-configuration') ?> (<i>eg. smtp.gmail.com</i>)</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Port', 'smtp-configuration') ?></th>
                                <td><input type="text" name="smtp_port" value="<?php echo esc_attr(get_option('smtp-configuration-smtp-port', DEFAUT_SMTP_PORT)); ?>" placeholder="25" /></td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Use SSL', 'smtp-configuration') ?>?</th>
                                <td><input type="checkbox" name="smtp_secure" id="smtp_secure" <?php impedro_smtpconfiguration_maybe_smtp_secure_checked(); ?> /></td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Use SMTP Authentication', 'smtp-configuration') ?>?</th>
                                <td><input type="checkbox" name="smtp_auth" id="smtp_auth" <?php impedro_smtpconfiguration_maybe_smtp_auth_checked(); ?> /></td>
                            </tr>
                        </tbody>
                    </table>

                    <div id="smtp_auth_parameters" style="display: <?php impedro_smtpconfiguration_maybe_hide_smtp_auth_parameters(); ?>">
                        <table class="form-table" role="presentation">
                            <tbody>
                                <tr>
                                    <th scope="row"><?php _e('Username', 'smtp-configuration') ?></th>
                                    <td>
                                        <input type="text" name="smtp_username" id="smtp_username" class="regular-text" value="<?php echo esc_attr(get_option('smtp-configuration-smtp-username', DEFAUT_SMTP_USER)); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e('Password', 'smtp-configuration') ?></th>
                                    <td><input type="password" name="smtp_password" id="smtp_password" value="<?php echo esc_attr(get_option('smtp-configuration-smtp-password', DEFAUT_SMTP_PASS)); ?>" /></td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>

                    <p class="submit">
                        <input id="btnSubmit" name="submit" type="submit" class="button button-primary" value="<?php _e('Update Settings', 'smtp-configuration') ?>" />
                        <input id="btnSendTest" name="sendTest" type="submit" class="button" value="<?php echo __('Send test email to', 'smtp-configuration') . ' ' . get_bloginfo('admin_email'); ?>" />
                    </p>
                    <?php wp_nonce_field('smtp-configuration'); ?>
                </form>
            </td>
            <td style="vertical-align: top;">
                <h2><?php _e('SMTP Configuration', 'smtp-configuration') ?></h2>
                <p>For <strong>Gmail</strong>, use the following settings:</p>
                <ul>
                    <li><?php _e('Host Name', 'smtp-configuration') ?>: smtp.gmail.com</li>
                    <li><?php _e('Port', 'smtp-configuration') ?>: 587</li>
                    <li><?php _e('Use SSL', 'smtp-configuration') ?>: <?php _e('Yes', 'smtp-configuration') ?></li>
                    <li><?php _e('Use SMTP Authentication', 'smtp-configuration') ?>: <?php _e('Yes', 'smtp-configuration') ?></li>
                    <li><?php _e('Username', 'smtp-configuration') ?>: <?php printf(__('Your %s email address', 'smtp-configuration'), 'Gmail') ?></li>
                    <li><?php _e('Password', 'smtp-configuration') ?>: <?php printf(__('Your %s app password', 'smtp-configuration'), 'Gmail') ?></li>
                </ul>
                <p>For <strong>Yahoo</strong>, use the following settings:</p>   
                <ul>
                    <li><?php _e('Host Name', 'smtp-configuration') ?>: smtp.mail.yahoo.com</li>
                    <li><?php _e('Port', 'smtp-configuration') ?>: 465</li>
                    <li><?php _e('Use SSL', 'smtp-configuration') ?>: <?php _e('Yes') ?></li>
                    <li><?php _e('Use SMTP Authentication', 'smtp-configuration') ?>: <?php _e('Yes', 'smtp-configuration') ?></li>
                    <li><?php _e('Username', 'smtp-configuration') ?>: <?php printf(__('Your %s email address', 'smtp-configuration'), 'Yahoo') ?></li>
                    <li><?php _e('Password', 'smtp-configuration') ?>: <?php printf(__('Your %s password', 'smtp-configuration'), 'Yahoo') ?></li>
                </ul>
                <p>For <strong>Office 365</strong>, use the following settings:</p>
                <ul>
                    <li><?php _e('Host Name', 'smtp-configuration') ?>: smtp.office365.com</li>
                    <li><?php _e('Port', 'smtp-configuration') ?>: 587</li>
                    <li><?php _e('Use SSL', 'smtp-configuration') ?>: <?php _e('Yes', 'smtp-configuration') ?></li>
                    <li><?php _e('Use SMTP Authentication') ?>: <?php _e('Yes') ?></li>
                    <li><?php _e('Username', 'smtp-configuration') ?>: <?php printf(__('Your %s email address', 'smtp-configuration'), 'Office 365') ?></li>
                    <li><?php _e('Password', 'smtp-configuration') ?>: <?php printf(__('Your %s password', 'smtp-configuration'), 'Office 365') ?></li>
                </ul>
                <p><?php _e('For other email providers, please contact your hosting provider.', 'smtp-configuration') ?></p>
                <p><?php _e('Please note that this plugin doesn\'t support sending emails from your local server. It sends emails using your hosting provider\'s SMTP settings.', 'smtp-configuration') ?></p>
            </td>
        </tr>
    </table>
</div>