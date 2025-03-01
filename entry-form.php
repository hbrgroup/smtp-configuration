<?php 
defined('ABSPATH') or die('No script kiddies please!');
require_once(__DIR__ . '/smtp-configuration.php'); ?>

<div class="wrap">
    <h1>SMTP Settings</h1>
    <p>Configure your SMTP settings here. If you are unsure about the settings, please contact your hosting provider.</p>
    <table class="form-table" role="presentation">
        <tr>
            <td style="vertical-align: top;">
                <h2>Settings & Authentication</h2>
                <form method="post" action="<?php menu_page_url('smtp-configuration'); ?>">
                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row">Host Name</th>
                                <td>
                                    <input type="text" name="smtp_host" aria-describedby="smtp_host_description" class="regular-text code" value="<?php echo esc_attr(get_option('smtp-configuration-smtp-host', DEFAUT_SMTP_HOST)); ?>" placeholder="smtp.gmail.com" />
                                    <p class="description" id="smtp_host_description">Host Name (<i>eg. smtp.gmail.com</i>)</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Port</th>
                                <td><input type="text" name="smtp_port" value="<?php echo esc_attr(get_option('smtp-configuration-smtp-port', DEFAUT_SMTP_PORT)); ?>" placeholder="25" /></td>
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
                                        <input type="text" name="smtp_username" id="smtp_username" class="regular-text" value="<?php echo esc_attr(get_option('smtp-configuration-smtp-username', DEFAUT_SMTP_USER)); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Password</th>
                                    <td><input type="password" name="smtp_password" id="smtp_password" value="<?php echo esc_attr(get_option('smtp-configuration-smtp-password', DEFAUT_SMTP_PASS)); ?>" /></td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>

                    <p class="submit">
                        <input id="btnSubmit" name="submit" type="submit" class="button button-primary" value="Update Settings" />
                        <input id="btnSendTest" name="sendTest" type="submit" class="button" value="Send test email to <?php echo get_bloginfo('admin_email'); ?>" />
                    </p>
                    <?php wp_nonce_field('smtp-configuration'); ?>
                </form>
            </td>
            <td style="vertical-align: top;">
                <h2>SMTP Configuration</h2>
                <p>For <strong>Gmail</strong>, use the following settings:</p>
                <ul>
                    <li>Host Name: smtp.gmail.com</li>
                    <li>Port: 587</li>
                    <li>Use SSL: Yes</li>
                    <li>Use SMTP Authentication: Yes</li>
                    <li>Username: Your Gmail email address</li>
                    <li>Password: Your Gmail app password</li>
                </ul>
                <p>For <strong>Yahoo</strong>, use the following settings:</p>   
                <ul>
                    <li>Host Name: smtp.mail.yahoo.com</li>
                    <li>Port: 465</li>
                    <li>Use SSL: Yes</li>
                    <li>Use SMTP Authentication: Yes</li>
                    <li>Username: Your Yahoo email address</li>
                    <li>Password: Your Yahoo password</li>
                </ul>
                <p>For <strong>Office 365</strong>, use the following settings:</p>
                <ul>
                    <li>Host Name: smtp.office365.com</li>
                    <li>Port: 587</li>
                    <li>Use SSL: Yes</li>
                    <li>Use SMTP Authentication: Yes</li>
                    <li>Username: Your Office 365 email address</li>
                    <li>Password: Your Office 365 password</li>
                </ul>
                <p>For other email providers, please contact your hosting provider.</p>
                <p>Please note that this plugin doesn't support sending emails from your local server. It sends emails using your hosting provider's SMTP settings.</p>
            </td>
        </tr>
    </table>
</div>