<?php

	$comments_num = get_comments_number();
	if( comments_open() ){
		if ( $comments_num == 0 ) {
			$comments = 0;
		}elseif ( $comments_num > 1) {
			$comments = $comments_num . __('');
		}else{
			$comments = $comments_num . __('');
		}
		$comments = '<a href="' . get_comments_link() . '">' . $comments .'</a>';
	}else{
		$comments = __('Comments are Closed');
	}
	echo '<div class="post-stats"><div class="likes"><div class="icon icon-likes"></div></div><div class="comments"><div class="icon icon-comment"> </div><div>' . $comments . '</div></div></div><span></span>';
