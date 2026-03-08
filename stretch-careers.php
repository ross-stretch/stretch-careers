<?php
/**
 * Plugin Name: Stretch Careers
 * Plugin URI: https://stretchmedia.ca
 * Description: Manage and display career listings with a beautiful shortcode-powered front end.
 * Version: 1.0.0
 * Author: StretchMedia Group
 * Author URI: https://stretchmedia.ca
 * Text Domain: stretch-careers
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'STRETCH_CAREERS_VERSION', '1.0.0' );
define( 'STRETCH_CAREERS_PATH', plugin_dir_path( __FILE__ ) );
define( 'STRETCH_CAREERS_URL', plugin_dir_url( __FILE__ ) );

require_once STRETCH_CAREERS_PATH . 'includes/class-stretch-careers-post-type.php';
require_once STRETCH_CAREERS_PATH . 'includes/class-stretch-careers-meta-boxes.php';
require_once STRETCH_CAREERS_PATH . 'includes/class-stretch-careers-shortcode.php';
require_once STRETCH_CAREERS_PATH . 'includes/class-stretch-careers-assets.php';

final class Stretch_Careers {

    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ) );
    }

    public function init() {
        new Stretch_Careers_Post_Type();
        new Stretch_Careers_Meta_Boxes();
        new Stretch_Careers_Shortcode();
        new Stretch_Careers_Assets();
    }
}

new Stretch_Careers();

register_activation_hook( __FILE__, function() {
    $post_type = new Stretch_Careers_Post_Type();
    $post_type->register();
    flush_rewrite_rules();
} );

register_deactivation_hook( __FILE__, function() {
    flush_rewrite_rules();
} );