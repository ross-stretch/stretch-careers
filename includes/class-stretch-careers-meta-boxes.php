<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Stretch_Careers_Meta_Boxes {

    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
        add_action( 'save_post_stretch_career', array( $this, 'save_meta' ) );
    }

    public function register_meta_boxes() {
        add_meta_box(
            'stretch-career-details',
            __( 'Career Details', 'stretch-careers' ),
            array( $this, 'render_meta_box' ),
            'stretch_career',
            'normal',
            'high'
        );
    }

    public function render_meta_box( $post ) {
        wp_nonce_field( 'stretch_career_save_meta', 'stretch_career_meta_nonce' );

        $location   = get_post_meta( $post->ID, '_stretch_career_location', true );
        $type       = get_post_meta( $post->ID, '_stretch_career_type', true );
        $salary     = get_post_meta( $post->ID, '_stretch_career_salary', true );
        $status     = get_post_meta( $post->ID, '_stretch_career_status', true );
        $apply_url  = get_post_meta( $post->ID, '_stretch_career_apply_url', true );
        $department = get_post_meta( $post->ID, '_stretch_career_department', true );

        ?>
        <div class="stretch-careers-admin-grid">
            <p>
                <label for="stretch_career_location"><strong><?php esc_html_e( 'Location', 'stretch-careers' ); ?></strong></label><br>
                <input type="text" id="stretch_career_location" name="stretch_career_location" value="<?php echo esc_attr( $location ); ?>" class="widefat">
            </p>

            <p>
                <label for="stretch_career_department"><strong><?php esc_html_e( 'Department', 'stretch-careers' ); ?></strong></label><br>
                <input type="text" id="stretch_career_department" name="stretch_career_department" value="<?php echo esc_attr( $department ); ?>" class="widefat">
            </p>

            <p>
                <label for="stretch_career_type"><strong><?php esc_html_e( 'Employment Type', 'stretch-careers' ); ?></strong></label><br>
                <select id="stretch_career_type" name="stretch_career_type" class="widefat">
                    <option value="Full Time" <?php selected( $type, 'Full Time' ); ?>>Full Time</option>
                    <option value="Part Time" <?php selected( $type, 'Part Time' ); ?>>Part Time</option>
                    <option value="Contract" <?php selected( $type, 'Contract' ); ?>>Contract</option>
                    <option value="Freelance" <?php selected( $type, 'Freelance' ); ?>>Freelance</option>
                    <option value="Internship" <?php selected( $type, 'Internship' ); ?>>Internship</option>
                </select>
            </p>

            <p>
                <label for="stretch_career_salary"><strong><?php esc_html_e( 'Salary / Compensation', 'stretch-careers' ); ?></strong></label><br>
                <input type="text" id="stretch_career_salary" name="stretch_career_salary" value="<?php echo esc_attr( $salary ); ?>" class="widefat" placeholder="$55,000 - $70,000">
            </p>

            <p>
                <label for="stretch_career_status"><strong><?php esc_html_e( 'Status', 'stretch-careers' ); ?></strong></label><br>
                <select id="stretch_career_status" name="stretch_career_status" class="widefat">
                    <option value="Open" <?php selected( $status, 'Open' ); ?>>Open</option>
                    <option value="Closed" <?php selected( $status, 'Closed' ); ?>>Closed</option>
                    <option value="Hiring Soon" <?php selected( $status, 'Hiring Soon' ); ?>>Hiring Soon</option>
                </select>
            </p>

            <p>
                <label for="stretch_career_apply_url"><strong><?php esc_html_e( 'Apply URL', 'stretch-careers' ); ?></strong></label><br>
                <input type="url" id="stretch_career_apply_url" name="stretch_career_apply_url" value="<?php echo esc_attr( $apply_url ); ?>" class="widefat" placeholder="https://example.com/apply">
            </p>
        </div>
        <?php
    }

    public function save_meta( $post_id ) {
        if ( ! isset( $_POST['stretch_career_meta_nonce'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['stretch_career_meta_nonce'] ) ), 'stretch_career_save_meta' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $fields = array(
            'stretch_career_location'   => '_stretch_career_location',
            'stretch_career_department' => '_stretch_career_department',
            'stretch_career_type'       => '_stretch_career_type',
            'stretch_career_salary'     => '_stretch_career_salary',
            'stretch_career_status'     => '_stretch_career_status',
            'stretch_career_apply_url'  => '_stretch_career_apply_url',
        );

        foreach ( $fields as $form_key => $meta_key ) {
            if ( isset( $_POST[ $form_key ] ) ) {
                $value = wp_unslash( $_POST[ $form_key ] );

                if ( 'stretch_career_apply_url' === $form_key ) {
                    update_post_meta( $post_id, $meta_key, esc_url_raw( $value ) );
                } else {
                    update_post_meta( $post_id, $meta_key, sanitize_text_field( $value ) );
                }
            }
        }
    }
}