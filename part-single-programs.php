<?php

/*  Template for displaying post type for the student-programs plugin. .
    https://github.com/BellevueCollege/student-programs
*/

if (have_posts()) : 
	while (have_posts()) : the_post();
		$program_name = get_post_meta( get_the_ID(), 'program_name', true );
		$program_description = get_post_meta( get_the_ID(), 'program_description', true );
		$program_contact_name = get_post_meta( get_the_ID(), 'program_contact_name', true );
		$program_contact_email = get_post_meta( get_the_ID(), 'program_contact_email', true );
		$program_contact_phone = get_post_meta( get_the_ID(), 'program_contact_phone', true );
		$Office_location = get_post_meta( get_the_ID(), 'Office_location', true );
		$office_hours = get_post_meta( get_the_ID(), 'office_hours', true );
		$prgoram_url = get_post_meta( get_the_ID(), 'prgoram_url', true );
		$budget_document_link = get_post_meta( get_the_ID(), 'budget_document_link', true );
		

		?>

		
		<div class="content-padding">

			

			<h1><?php the_title()?></h1>

			<ul>
				
				<?php  if( !empty( $program_contact_name ) ) : ?>
					<li>Program Contact Name: <strong><?php echo $program_contact_name; ?></strong></li>
				<?php endif; ?>

				<?php if( !empty( $program_contact_email ) ) : ?>
					<li>Program Contact Email: <strong><a href="mailto:<?php echo $program_contact_email; ?>"><?php echo $program_contact_email; ?></a></strong></li>
				<?php endif; ?>

				<?php if( !empty( $program_contact_phone ) ) : ?>
				<li>Program Contact Phone: <strong><?php echo $program_contact_phone; ?></strong></li>
				<?php endif; ?>

				<?php if(!empty($Office_location)) : ?>
					<li>Office Location: <strong><?php echo $Office_location; ?></strong></li>
				<?php endif; ?>

				<?php if( !empty( $office_hours ) ) : ?>
					<li>Office Hours: <strong><?php echo $office_hours; ?></strong></li>
				<?php endif; ?>

				<?php if( !empty( $prgoram_url ) ) : ?>
					<li>Program Website: <strong><a href="<?php echo $prgoram_url; ?>"> <?php echo $prgoram_url; ?> </a></strong></li>
				<?php endif; ?>
				
			</ul>
			
			<?php the_content(); ?>
			<? if( !empty( $budget_document_link ) && $is_chartered ) : ?>
				<p><a href="<?php echo $budget_document_link; ?>" target="_blank">View Current Budget Information (opens in new window)</a></p>
			<?php endif; ?>
		</div><!--.content-padding-->     

	<?php endwhile;
	wp_reset_query();
endif;