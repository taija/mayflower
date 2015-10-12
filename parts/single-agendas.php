<?php
/**
 * Template for displaying post type for the Trustees Agendas plugin.
 * https://github.com/BellevueCollege/trustees-agenda
 */

if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="content-padding">

		<h1><?php the_title();

			$value = get_post_meta( get_the_ID(), 'meeting_date', true );

			if( !empty( $value ) ) {
				$display_date = date('F j, Y', strtotime($value));

			?>
		<br /><?php echo $display_date; ?></h1>
			<?php } ?>
		</h1>
		<?php
		$content = the_content();
		if ( $content=="" ) {
		/* Don't display empty the_content or surround divs */
		} else {
			echo $content;
		} ?>
	</div> <!--.content-padding-->

<?php
endwhile;
wp_reset_query();
endif;
