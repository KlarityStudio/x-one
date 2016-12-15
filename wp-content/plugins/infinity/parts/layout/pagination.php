<?php

	$infinity_options = views();
	$id = views()->id;
	$show_pagination = $infinity_options->getOption( 'pagination-show-' . $id );

 ?>

<?php if( $show_pagination ) : ?>

<?php vb_pagination(); ?>

<?php endif; ?>
