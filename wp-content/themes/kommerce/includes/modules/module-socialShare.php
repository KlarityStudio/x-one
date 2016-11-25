<div class="social">
    <?php
    // Get current page URL
    $socialURL = get_permalink();
    // Get current page title
    $socialTitle = str_replace( ' ', '%20', get_the_title());
    $twitterURL = 'https://twitter.com/intent/tweet?text='.$socialTitle.'&amp;url='.$socialURL.'&amp;via=XONE_ZA';
    $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$socialURL;

    ?>
    <a href="<?php echo $facebookURL ?>" target="_blank"><div class="blog_facebook" title="Share on Facebook"><?php get_template_part( '/_build/icons/icon', 'facebook' ); ?></div></a>
    <a href="<?php echo $twitterURL ?>" target="_blank" title="Share On Twitter"><div class="blog_twitter"><?php get_template_part( '/_build/icons/icon', 'twitter' ); ?></div></a>
    <a href="mailto:?subject=I wanted you to see this post&amp;body=View it at <?php echo get_permalink( $post->ID ); ?>" title="Share by Email"><div class="blog_email"><?php get_template_part( '/_build/icons/icon', 'mail' ); ?></div></a>
</div>
