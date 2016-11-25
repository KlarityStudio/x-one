<?php
    $tax = 'post_tag';
    $terms = get_terms( $tax );
    $count = count( $terms );

    if ( $count > 0 ): ?>
        <div class="post-tags tag-nav">
            <p>Filter by tag: </p>
            <ul>
        <?php
        foreach ( $terms as $term ) {
            $term_link = get_term_link( $term, $tax );
            echo '<li><a href="' . $term_link . '" class="tax-filter" title="' . $term->slug . '">' . $term->name . '</a> </li>';
        } ?>
            </ul>
        </div>
    <?php endif;
