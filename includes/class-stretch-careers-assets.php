<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Stretch_Careers_Assets {

    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'front_assets' ) );
    }

    public function admin_assets( $hook ) {
        global $post_type;

        if ( 'stretch_career' !== $post_type ) {
            return;
        }

        wp_enqueue_style(
            'stretch-careers-admin',
            STRETCH_CAREERS_URL . 'assets/css/admin.css',
            array(),
            STRETCH_CAREERS_VERSION
        );

        wp_enqueue_script(
            'stretch-careers-admin',
            STRETCH_CAREERS_URL . 'assets/js/admin.js',
            array( 'jquery' ),
            STRETCH_CAREERS_VERSION,
            true
        );
    }

    public function front_assets() {
        wp_enqueue_style(
            'stretch-careers-front',
            STRETCH_CAREERS_URL . 'assets/css/front.css',
            array(),
            STRETCH_CAREERS_VERSION
        );
    }
}