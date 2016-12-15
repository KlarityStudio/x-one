<?php

/*-----------     The ajax WP_Query for the single post     -----------*/
	function ajax_press_release_modal( $id ) {

	    $id = $_POST['id'];

	    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	    $args = array(
	        'p'                       => $id,
	        'post_type' 				=> 'post',
	        'update_post_term_cache' 	=> false,
	        'posts_per_page' 			=> 1,
	        'pagination'				=> false,
	        'paged'					    => $paged,
	        );


		$modalPost = new WP_Query( $args );

	  if ( $modalPost->have_posts() ) : while ( $modalPost->have_posts() ) : $modalPost->the_post();
		  global $post;
		  $post = get_post($id);

		  $next_post = get_next_post();
		  $previous_post = get_previous_post();

		  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>

		<div class="modal-lockup" data-pre="<?php echo $previous_post->ID ?>" data-next="<?php echo $next_post->ID ?>" >
			<script type="text/javascript">

				var $paginationPost = $('#pagination').children('.icon'),
					$closeIcon = $('.modal-lockup').children('.icon-close');

				$closeIcon.on('click', function(){
					$('.modal-wrapper').removeClass('open');
					$('body').removeClass('modal-open');
					$('.modal-wrapper').fadeOut('slow');
				})

				$($paginationPost).on("click", function() {

					var id = $(this).data('post'),
						$ajaxUrl = $(this).attr('data-url'),
						$ajaxLoad = $('.loading-gif');

					$ajaxLoad.show();
					$.ajax({
						type: 'POST',
						url: $ajaxUrl,
						context: this,
						data: {'action': 'post_modal', id: id },
						success: function(response) {
							$ajaxLoad.hide();
							$('.modal-wrapper').html(response);
							$('.modal-wrapper').addClass('open');
							$('body').addClass('modal-open');
							return false;
						}
					});
				});
			</script>
			<script type="text/javascript">

				var $socialContainer = $('.social-wrapper'),
					$socialIcons = $('.social-container');

				$socialContainer
					.mouseover(function() {
						$(this).children($socialIcons).find('a').each(function(i){
							var $li = $(this);
							setTimeout(function() {
							  $li.addClass('show');
						  }, i*200);

						});
					})
					.mouseout(function() {
						$(this).children($socialIcons).find('a').each(function(i){
							var $li = $(this);
							setTimeout(function() {
							  $li.removeClass('show');
						  }, i*200);

						});
					});

			</script>
			<script type="text/javascript">

				$(".post-like").children('a').on('click',function(e){
					e.preventDefault();

				var $heart = $(this),
					// Retrieve post ID from data attribute
					$post_id = $heart.data("post_id");

					//Ajax call
					$.ajax({
						type: "post",
						url: "http://xone.staging/wp-admin/admin-ajax.php",
						data: "action=post-like&post_like=&post_id="+$post_id,
						success: function(count){
							// If vote successful
							if(count != "already")
							{
							   $heart.addClass("voted");
							   $heart.siblings(".count").text(count);
							}
						}
					});
					return false;
				});
			</script>
			<div class="icon icon-close"><?php get_template_part( '_build/icons/icon', 'close'); ?></div>
		    <div class="modal-content">
				<script type="application/ld+json">
					{
					  "@context": "http://schema.org",
					  "@type": "NewsArticle",
					  "mainEntityOfPage": {
					    "@type": "WebPage",
					    "@id": "<?php echo the_permalink(); ?>"
					  },
					  "headline": "<?php the_title(); ?>",
					  "image": {
					    "@type": "ImageObject",
					    "url": "<?php the_post_thumbnail_url(); ?>",
					    "height": 800,
					    "width": 800
					  },
					  "datePublished": "<?php echo the_date(); ?>",
					  "dateModified": "<?php echo the_modified_date(); ?>",
					  "author": {
					    "@type": "Person",
					    "name": "<?php echo the_author(); ?>"
					  },
					   "publisher": {
					    "@type": "Organization",
					    "name": "X-One",
					    "logo": {
					      "@type": "ImageObject",
						  "url": "<?php echo get_site_url() . '/wp-content/uploads/2016/10/cropped-logo.png'?>",
					      "width": 600,
					      "height": 60
					    }
					  },
					  "description": "<?php echo the_excerpt(); ?>"
					}
					</script>
				<div class="pagination-icon-lockup" id="pagination">
					<?php if($previous_post) : ?>
						<div class="icon icon-left" data-url="<?php echo admin_url('admin-ajax.php'); ?>" data-post="<?php echo $previous_post->ID ?>"><?php get_template_part( '_build/icons/icon', 'right'); ?></div>
					<?php endif; ?>
					<?php if($next_post) : ?>
					<div class="icon icon-right" data-url="<?php echo admin_url('admin-ajax.php'); ?>" data-post="<?php echo $next_post->ID ?>" ><?php get_template_part( '_build/icons/icon', 'right'); ?></div>
					<?php endif; ?>
				</div>
		        <div class="featured-image" style="background-image:url(<?php echo $thumb[0]; ?>)">
					<div class="article-header">
			            <div class="title-box">
			                <h1><?php the_title(); ?></h1>
			                <?php $supportDesc =  get_post_meta( $id,'desc', true);
			                    if(!empty( $supportDesc ) ){
			                    ?>
			                    <h2><?php echo $supportDesc ?></h2>
			                <?php } ?>

			            </div>
						<div class="article-social">
							<?php echo getThePostLikeLink($id); ?>
							<span class="divider"></span>
							<div class="social-wrapper">
								<div class="social-container">
									<?php get_template_part('includes/modules/module', 'socialShare'); ?>
								</div>
								<div class="social-link">
									<a href="#"><?php get_template_part('_build/icons/icon', 'share'); ?> Share</a>
								</div>
							</div>
						</div>

					</div>
		        </div>

		        <div class="post-content">
					<div class="article-meta">

						<p><span><?php the_author() ?></span> / <?php echo get_the_date(); ?></p>
					</div>
		            <?php the_content(); ?>
		        </div>
		    </div>
		</div>
	  <?php endwhile; ?>
	  <?php endif;

	  die();
	}

	add_action('wp_ajax_post_modal', 'ajax_press_release_modal');
	add_action('wp_ajax_nopriv_post_modal', 'ajax_press_release_modal');



/*-----------     The ajax function for filtering posts by tags     -----------*/
	//
	// function ajax_filter_posts_scripts() {
	//   // Enqueue script
	//   wp_register_script('kommerce_afp_script', get_template_directory_uri() . '/_build/js/min/ajax-filter-min.js', array('jquery'),'1.0.0', true);
	//   wp_enqueue_script('kommerce_afp_script');
	//
	//   wp_localize_script( 'kommerce_afp_script', 'modal_vars', array(
	//         'modal_nonce' => wp_create_nonce( 'modal_nonce' ), // Create nonce which we later will use to verify AJAX request
	//         'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
	//       )
	//   );
	// }
	// add_action('wp_enqueue_scripts', 'ajax_filter_posts_scripts', 100);

	// Script for getting posts
	function ajax_filter_get_posts( $taxonomy ) {

		$taxonomy = $_POST['taxonomy'];

		// WP Query
		$args = array(
		'tag' => $taxonomy,
		'post_type' => 'post',
		'posts_per_page' => 10,
		);

		// If taxonomy is not set, remove key from array and get all posts
		if( !$taxonomy ) {
		unset( $args['tag'] );
		}

		$query = new WP_Query( $args ); ?>
			<div class="loading-gif">
				<center>
					<img class="loading-image" src="/wp-content/themes/kommerce/_build/icons/ajax-loader.gif" alt="loading..">
				</center>
			</div>
			<script type="text/javascript">
				if ($('body').hasClass('page-press-release')) {

					var $posts = $('article:not(.reveal)'),
						$i = 0 ;

					setInterval( function(){

						if( $i >= $posts.length ) {
							return false;
						}

						var $el = $posts[$i];
						$($el).addClass('reveal');
						$i++;

					}, 500 );
				}
			</script>
			<script type="text/javascript">
				var $socialContainer = $('.social-wrapper'),
					$socialIcons = $('.social-container');

				$socialContainer
					.mouseover(function() {
						$(this).children($socialIcons).find('a').each(function(i){
							var $li = $(this);
							setTimeout(function() {
							  $li.addClass('show');
						  }, i*200);

						});
					})
					.mouseout(function() {
						$(this).children($socialIcons).find('a').each(function(i){
							var $li = $(this);
							setTimeout(function() {
							  $li.removeClass('show');
						  }, i*200);

						});
					});
			</script>
			<div class="tag-filter" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
				<?php get_template_part('includes/modules/module', 'tagsList'); ?>
			</div>
			<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
				<article data-value="<?php echo $data; ?>" data-post="<?php echo $post->ID; ?>">
					<div class="featured-image">
						<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
						<div style="background-image:url(<?php echo $thumb[0]; ?>)">

						</div>
					</div>
					<div class="article-content">
						<div class="article-meta">
							<p><span><?php the_author() ?></span> / <?php echo get_the_date(); ?></p>
						</div>
						<?php the_title('<h1>', '</h1>'); ?>
						<div class="post-tags">
							<?php the_tags('<ul><li>', '</li><li>', '</li></ul>'); ?>
						</div>
						<p>
							<?php the_excerpt(); ?>
						</p>
						<div class="post-footer">
							<div class="read-more-button">
								<a id="read-more" href="#" data-post="<?php echo $post->ID; ?>" data-url="<?php echo admin_url('admin-ajax.php'); ?>">Read More</a>
							</div>
							<span class="divider"></span>
							<div class="social-wrapper">
								<div class="social-container">
									<?php get_template_part('includes/modules/module', 'socialShare'); ?>
								</div>
								<div class="social-link">
									<a href="#"><?php get_template_part('_build/icons/icon', 'share'); ?> Share</a>
								</div>
							</div>
							<!-- <div class="article-social">
								<?php get_template_part('includes/modules/module', 'postFooter'); ?>
								<?php echo getThePostLikeLink($post->ID); ?>
							</div> -->
						</div>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else: ?>
		<h2>No posts found</h2>
		<?php endif;

		die();
	}

	add_action('wp_ajax_filter_posts', 'ajax_filter_get_posts');
	add_action('wp_ajax_nopriv_filter_posts', 'ajax_filter_get_posts');






/*-----------     The ajax function for post likes    -----------*/

	add_action('wp_ajax_nopriv_post-like', 'post_like');
	add_action('wp_ajax_post-like', 'post_like');

	wp_enqueue_script('like_post', get_template_directory_uri().'/_build/js/post-like.js', array('jquery'),'1.0.0', true);
	wp_localize_script('like_post', 'ajax_var', array(
	    'url' => admin_url('admin-ajax.php'),
	    'nonce' => wp_create_nonce('ajax-nonce')
	));

	function post_like(){
	    // Check for nonce security
	    $nonce = $_POST['nonce'];

	    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
	        die ( 'You have already liked this post');

	    if(isset($_POST['post_like'])){
	        // Retrieve user IP address
	        $ip = $_SERVER['REMOTE_ADDR'];
	        $post_id = $_POST['post_id'];

	        // Get voters'IPs for the current post
	        $meta_IP = get_post_meta($post_id, "voted_IP");
	        $voted_IP = $meta_IP[0];

	        if(!is_array($voted_IP))
	            $voted_IP = array();

	        // Get votes count for the current post
	        $meta_count = get_post_meta($post_id, "votes_count", true);

	        // Use has already voted ?
	        if(!hasAlreadyVoted($post_id))
	        {
	            $voted_IP[$ip] = time();

	            // Save IP and increase votes count
	            update_post_meta($post_id, "voted_IP", $voted_IP);
	            update_post_meta($post_id, "votes_count", ++$meta_count);

	            // Display count (ie jQuery return value)
	            echo $meta_count;
	        }
	        else
	            echo "already";
	    }
	    exit;
	}
	$timebeforerevote = 120; // = 2 hours

	function hasAlreadyVoted($post_id){

	    global $timebeforerevote;

	    // Retrieve post votes IPs
	    $meta_IP = get_post_meta($post_id, "voted_IP");
	    $voted_IP = $meta_IP[0];

	    if(!is_array($voted_IP))
	        $voted_IP = array();

	    // Retrieve current user IP
	    $ip = $_SERVER['REMOTE_ADDR'];

	    // If user has already voted
	    if(in_array($ip, array_keys($voted_IP))){
	        $time = $voted_IP[$ip];
	        $now = time();

	        // Compare between current time and vote time
	        if(round(($now - $time) / 60) > $timebeforerevote)
	            return false;

	        return true;
	    }

	    return false;
	}

	function getThePostLikeLink($post_id){
	    $themename = "kommerce";

	    $vote_count = get_post_meta($post_id, "votes_count", true);
		if ($vote_count <= 0) {
			$vote_count = '0';
		}else

	    $output = '<p class="post-like">';
	    if(hasAlreadyVoted($post_id))
	        $output .= ' <span title="'.__('I like this article', $themename).'" class="like alreadyvoted"></span>';
	    else
	        $output .= '<a href="#" data-post_id="'.$post_id.'">
	                    <span  title="'.__('I like this article', $themename).'"class="qtip like"></span>
	                </a>';
	    $output .= '<span class="count">'.$vote_count.'</span></p>';

	    return $output;
	}
