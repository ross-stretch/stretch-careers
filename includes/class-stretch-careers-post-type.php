<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Stretch_Careers_Post_Type {

    public function __construct() {
        add_action( 'init', array( $this, 'register' ) );
        add_filter( 'manage_stretch_career_posts_columns', array( $this, 'columns' ) );
        add_action( 'manage_stretch_career_posts_custom_column', array( $this, 'column_content' ), 10, 2 );
    }

    public function register() {
        $labels = array(
            'name'               => __( 'Careers', 'stretch-careers' ),
            'singular_name'      => __( 'Career', 'stretch-careers' ),
            'menu_name'          => __( 'Careers', 'stretch-careers' ),
            'name_admin_bar'     => __( 'Career', 'stretch-careers' ),
            'add_new'            => __( 'Add New', 'stretch-careers' ),
            'add_new_item'       => __( 'Add New Career', 'stretch-careers' ),
            'new_item'           => __( 'New Career', 'stretch-careers' ),
            'edit_item'          => __( 'Edit Career', 'stretch-careers' ),
            'view_item'          => __( 'View Career', 'stretch-careers' ),
            'all_items'          => __( 'All Careers', 'stretch-careers' ),
            'search_items'       => __( 'Search Careers', 'stretch-careers' ),
            'not_found'          => __( 'No careers found.', 'stretch-careers' ),
            'not_found_in_trash' => __( 'No careers found in Trash.', 'stretch-careers' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_position'      => 26,
            'menu_icon'          => 'dashicons-businessperson',
            'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
            'has_archive'        => true,
            'rewrite'            => array( 'slug' => 'careers' ),
            'show_in_rest'       => true,
            'publicly_queryable' => true,
            'capability_type'    => 'post',
        );

        register_post_type( 'stretch_career', $args );
    }

    public function columns( $columns ) {
        $new_columns = array();

        foreach ( $columns as $key => $label ) {
            $new_columns[ $key ] = $label;

            if ( 'title' === $key ) {
                $new_columns['career_location'] = __( 'Location', 'stretch-careers' );
                $new_columns['career_type']     = __( 'Type', 'stretch-careers' );
                $new_columns['career_status']   = __( 'Status', 'stretch-careers' );
            }
        }

        return $new_columns;
    }

    public function column_content( $column, $post_id ) {
        if ( 'career_location' === $column ) {
            echo esc_html( get_post_meta( $post_id, '_stretch_career_location', true ) );
        }

        if ( 'career_type' === $column ) {
            echo esc_html( get_post_meta( $post_id, '_stretch_career_type', true ) );
        }

        if ( 'career_status' === $column ) {
            $status = get_post_meta( $post_id, '_stretch_career_status', true );
            echo esc_html( $status ? $status : 'Open' );
        }
    }
}