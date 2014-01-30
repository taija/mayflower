<?php 
global $mayflower_brand; 
?>

<div id="content" <?php if( $mayflower_brand == 'branded' )  {?> class="box-shadow"<?php }?>>

	<?php
	if(mayflower_is_blog() ) {
		get_template_part('part-blog-page');

	} //END IF HOME OR SINGLE
	else {
		get_template_part('part-static-page');
	}
	?>

</div><!-- #content-->