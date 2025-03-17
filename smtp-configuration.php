<?php
/*
 * Plugin Name: SMTP Configuration
 * Description: Allows send authenticated emails through SMTP connection
 * Version: 2.0.1
 * Author: Pedro Fernandes
 * Author URI: http://impedro.com
 * Plugin URI: http://impedro.com
 * Text Domain: smtp-configuration
 * Domain Path: /languages
*/

defined('ABSPATH') or die('No script kiddies please!');
require_once(__DIR__ . '/default_settings.php'); 


function impedro_load_textdomain() {
	load_plugin_textdomain('smtp-configuration', false, dirname(plugin_basename(__FILE__)) . '/languages'); 
}

add_action('init', 'impedro_load_textdomain');

/**
 * Init phpmailer with saved configurations and support 
 * for username and password authentication
 * 
 * @return void
 */
function impedro_smtpconfiguration_phpmailer_init($phpmailer) {
    $phpmailer->Host = get_option('smtp-configuration-smtp-host', DEFAUT_SMTP_HOST);
    $phpmailer->Port = get_option('smtp-configuration-smtp-port', DEFAUT_SMTP_PORT);
    $phpmailer->Username = get_option('smtp-configuration-smtp-username', DEFAUT_SMTP_USER);
    $phpmailer->Password = get_option('smtp-configuration-smtp-password', DEFAUT_SMTP_PASS);

    if (get_option('smtp-configuration-smtp-auth', impedro_smtpconfiguration_is_authenticated()) == true) {
        $phpmailer->SMTPAuth = get_option('smtp-configuration-smtp-auth', impedro_smtpconfiguration_is_authenticated());
    }

    if (get_option('smtp-configuration-smtp-secure', DEFAUT_SMTP_SECURE) == true) {
        switch ($phpmailer->Port) {
            case 465:
                $phpmailer->SMTPSecure = 'ssl';
                break;

            case 587:
                $phpmailer->SMTPSecure = 'tls';
                break;                
            
            default:
                break;
        }
    }

    $phpmailer->IsSMTP();
}

add_action('phpmailer_init', 'impedro_smtpconfiguration_phpmailer_init');

/**
 * Set the from email address for the wp_mail function
 * 
 * @return string
 */
add_filter('wp_mail_from', function($from) {
    return get_bloginfo('admin_email');
});

/**
 * Set the from name for the wp_mail function
 * 
 * @return string
 */
add_filter('wp_mail_from_name', function($from_name) {
    return get_bloginfo('name');
});

function impedro_smtpconfiguration_wp_mail_failed($error) {
    $_SESSION['wp_mail_error'] = $error;
}

add_action('wp_mail_failed', 'impedro_smtpconfiguration_wp_mail_failed');

/**
 * Create admin smtp configuration menu in options panel
 * 
 * @return void
 */
function impedro_smtpconfiguration_create_settings_menu() {
    add_options_page(__('SMTP Settings', 'smtp-configuration'), __('SMTP Settings', 'smtp-configuration'), 'manage_options', 'smtp-configuration', 'impedro_smtpconfiguration_create_settings_page');
}

add_action('admin_menu', 'impedro_smtpconfiguration_create_settings_menu');

/**
 * Callback for create admin page and save settings
 * 
 * @return void
 */
function impedro_smtpconfiguration_create_settings_page() {
    if (!empty($_POST)) {
        if (isset($_POST['submit'])) {
            impedro_smtpconfiguration_process_form_input();
        }
    } 
    
    impedro_smtpconfiguration_generate_settings_form();
}

/**
 * Enqueue scripts for plugin
 * 
 * @return void
 */
function impedro_smtpconfiguration_enqueue_scripts() {
    wp_enqueue_script('smtp-settings-js', plugins_url('/js/global.js', __FILE__));
}

add_action('admin_enqueue_scripts', 'impedro_smtpconfiguration_enqueue_scripts');

/**
 * Show admin notice when settings are saved
 * 
 * @return void
 */
function impedro_smtpconfiguration_admin_notice() {
    if (isset($_POST['submit'])) {
        echo '<div class="notice notice-success is-dismissible">
            <p>' . __('Settings saved successfully.', 'smtp-configuration') . ' </p>
        </div>'; 
    } else if (isset($_POST['sendTest'])) {
        
        $sent = wp_mail(get_bloginfo('admin_email'), 'Test email', 'This is a test email sent from your WordPress site.');

        if ($sent == TRUE) {
            echo '<div class="notice notice-success is-dismissible">
                <p>' . __('Test email sent successfully.', 'smtp-configuration') . '</p>
            </div>'; 
        } else {
            echo '<div class="notice notice-error is-dismissible">            
                <p>' . __('Failed to send test email. Please check your SMTP settings.', 'smtp-configuration') . '</p>
            ';

            echo '  <ul>';

            foreach ($_SESSION['wp_mail_error']->errors['wp_mail_failed'] as $error) {
                echo '<li> - ' . $error . '</li>';
            }

            echo '  <ul>';
            echo '</div>';
        }
        
    }
}

add_action('admin_notices', 'impedro_smtpconfiguration_admin_notice');

/**
 * Create and show admin page in options menu
 * 
 * @return void
 */
function impedro_smtpconfiguration_generate_settings_form() {
?>
    <style><?php include('css/page.css'); ?></style>
    <?php include('entry-form.php'); ?>           
  <?php
}

/**
 * Save form data in wordpress
 * 
 * @return void
 */
function impedro_smtpconfiguration_process_form_input() {
    check_admin_referer('smtp-configuration');

    $smtp_host = !empty($_POST['smtp_host']) ? sanitize_text_field($_POST['smtp_host']) : '';
    $smtp_port = !empty($_POST['smtp_port']) ? absint($_POST['smtp_port']) : '';
    $smtp_auth = !empty($_POST['smtp_auth']) ? true : false;
    $smtp_username = !empty($_POST['smtp_username']) ? sanitize_text_field($_POST['smtp_username']) : '';
    $smtp_password = !empty($_POST['smtp_password']) ? sanitize_text_field($_POST['smtp_password']) : '';
    $smtp_secure = !empty($_POST['smtp_secure']) ? true : false;

    update_option('smtp-configuration-smtp-host', $smtp_host);
    update_option('smtp-configuration-smtp-port', $smtp_port);
    update_option('smtp-configuration-smtp-auth', $smtp_auth);
    update_option('smtp-configuration-smtp-username', $smtp_username);
    update_option('smtp-configuration-smtp-password', $smtp_password);
    update_option('smtp-configuration-smtp-secure', $smtp_secure);
}

function impedro_smtpconfiguration_maybe_smtp_secure_checked() {
    if (get_option('smtp-configuration-smtp-secure', DEFAUT_SMTP_SECURE) == true) echo 'checked="checked"';
}

function impedro_smtpconfiguration_maybe_smtp_auth_checked() {
    if (get_option('smtp-configuration-smtp-auth') == true) echo 'checked="checked"';
}

function impedro_smtpconfiguration_maybe_hide_smtp_auth_parameters() {
    if (get_option('smtp-configuration-smtp-auth', impedro_smtpconfiguration_is_authenticated()) == true) echo 'block';
    else echo 'none';
}

function impedro_smtpconfiguration_is_authenticated(): bool {
    if (DEFAUT_SMTP_USER === '' || DEFAUT_SMTP_PASS === '') {
        return false;
    } 

    return true;
}