<h1>Brands</h1>


<?php

/*---------     Phone Makes Custom WP_Query loop function    ----------*/

    $terms = get_terms( 'pa_phone-makes' );

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){

        echo '<ul>';

            foreach ( $terms as $term ) {

                echo '<li>' . $term->name . '</li>';
            }

        echo '</ul>';

    }
