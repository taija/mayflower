<div class="content-padding">
	<?php foreach(posts_by_year() as $year => $posts) : ?>
		<h2><?php echo $year; ?></h2>
		<ul>
			<?php foreach($posts as $post) : setup_postdata($post); ?>
				<li>
					<a href="<?php the_permalink(); ?>">
						<?php $value = get_post_meta( get_the_ID(), 'meeting_date', true );
						if( !empty( $value ) ) {
							$display_date = date('F j, Y', strtotime($value));
							echo $display_date;
						} ?>
					</a>
					<?php $special_meeting = get_post_meta( get_the_ID(), 'special_meeting', true );
					$special = "";
					if( $special_meeting ) {
						$special = "&nbsp;(Special Meeting)";
						echo $special;
					} ?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endforeach; ?>
</div>

<?php
function posts_by_year() {
// array to use for results
$years = array();

// get posts from WP
$posts = get_posts(array(
	'numberposts' => -1,
	'meta_key'  => 'meeting_date',
	'orderby' => 'meta_value',
	'order' => 'DESC',
	'post_type' => 'agendas',
	'post_status' => 'publish'
));

// loop through posts, populating $years arrays
foreach($posts as $post) {
	if(isset($post->meeting_date) && !empty($post->meeting_date))
		$years[date('Y', strtotime($post->meeting_date))][] = $post;
	}

	// reverse sort by year
	krsort($years);
	return $years;
}
