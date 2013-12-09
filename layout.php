<?php 
global $mayflower_brand; 
?>

<div id="content" <?php if( $mayflower_brand == 'branded' )  {?> class="box-shadow"<?php }?>>
	<?php 
		get_template_part('part-featured-full'); 
	?>
<?php wp_reset_query(); ?>
	<?php
	if(is_blog() ) {
		get_template_part('part-blog-page'); 

	} //END IF HOME OR SINGLE 
	else {
		get_template_part('part-static-page'); 
	} 
	?>

</div><!-- #content-->