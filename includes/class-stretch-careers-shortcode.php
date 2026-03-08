<?php
                $type       = get_post_meta( $post_id, '_stretch_career_type', true );
                $salary     = get_post_meta( $post_id, '_stretch_career_salary', true );
                $status     = get_post_meta( $post_id, '_stretch_career_status', true );

                echo '<article class="stretch-career-card">';
                echo '<div class="stretch-career-card__top">';
                echo '<span class="stretch-career-badge">' . esc_html( $status ? $status : 'Open' ) . '</span>';
                echo '</div>';
                echo '<h3 class="stretch-career-card__title"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3>';
                echo '<div class="stretch-career-meta">';

                if ( $department ) {
                    echo '<span>' . esc_html( $department ) . '</span>';
                }

                if ( $location ) {
                    echo '<span>' . esc_html( $location ) . '</span>';
                }

                if ( $type ) {
                    echo '<span>' . esc_html( $type ) . '</span>';
                }

                echo '</div>';

                if ( has_excerpt() ) {
                    echo '<div class="stretch-career-card__excerpt">' . esc_html( get_the_excerpt() ) . '</div>';
                }

                if ( $salary ) {
                    echo '<div class="stretch-career-card__salary">' . esc_html__( 'Compensation:', 'stretch-careers' ) . ' ' . esc_html( $salary ) . '</div>';
                }

                echo '<div class="stretch-career-card__actions">';
                echo '<a class="stretch-career-button" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'View Role', 'stretch-careers' ) . '</a>';
                echo '</div>';
                echo '</article>';
            }
        } else {
            echo '<div class="stretch-careers-empty">' . esc_html__( 'No current opportunities available.', 'stretch-careers' ) . '</div>';
        }

        echo '</div>';

        wp_reset_postdata();

        return ob_get_clean();
    }

    public function append_single_career_meta( $content ) {
        if ( ! is_singular( 'stretch_career' ) || ! in_the_loop() || ! is_main_query() ) {
            return $content;
        }

        $post_id    = get_the_ID();
        $location   = get_post_meta( $post_id, '_stretch_career_location', true );
        $department = get_post_meta( $post_id, '_stretch_career_department', true );
        $type       = get_post_meta( $post_id, '_stretch_career_type', true );
        $salary     = get_post_meta( $post_id, '_stretch_career_salary', true );
        $status     = get_post_meta( $post_id, '_stretch_career_status', true );
        $apply_url  = get_post_meta( $post_id, '_stretch_career_apply_url', true );

        ob_start();
        ?>
        <div class="stretch-career-single-box">
            <div class="stretch-career-single-grid">
                <?php if ( $department ) : ?>
                    <div><strong><?php esc_html_e( 'Department', 'stretch-careers' ); ?>:</strong> <?php echo esc_html( $department ); ?></div>
                <?php endif; ?>

                <?php if ( $location ) : ?>
                    <div><strong><?php esc_html_e( 'Location', 'stretch-careers' ); ?>:</strong> <?php echo esc_html( $location ); ?></div>
                <?php endif; ?>

                <?php if ( $type ) : ?>
                    <div><strong><?php esc_html_e( 'Type', 'stretch-careers' ); ?>:</strong> <?php echo esc_html( $type ); ?></div>
                <?php endif; ?>

                <?php if ( $salary ) : ?>
                    <div><strong><?php esc_html_e( 'Compensation', 'stretch-careers' ); ?>:</strong> <?php echo esc_html( $salary ); ?></div>
                <?php endif; ?>

                <?php if ( $status ) : ?>
                    <div><strong><?php esc_html_e( 'Status', 'stretch-careers' ); ?>:</strong> <?php echo esc_html( $status ); ?></div>
                <?php endif; ?>
            </div>

            <?php if ( $apply_url ) : ?>
                <div class="stretch-career-single-actions">
                    <a class="stretch-career-button" href="<?php echo esc_url( $apply_url ); ?>" target="_blank" rel="noopener noreferrer">
                        <?php esc_html_e( 'Apply Now', 'stretch-careers' ); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <?php

        return $content . ob_get_clean();
    }
}