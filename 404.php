<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
get_header(); ?>

<div class="content-padding row-padding box-shadow" id="content">

	<?php function mayflower_errormsgs() {
		/** These are the error messages that are randomly displayed */

		$errmsgs = "It was here, we promise!
		We've lead you astray...
		Oh no!
		You've found a broken link!";

		// Here we split it into lines
		$errmsgs = explode( "\n", $errmsgs );

		// And then randomly choose a line
		return wptexturize( $errmsgs[ mt_rand( 0, count( $errmsgs ) - 1 ) ] );
	}

	// This just echoes the chosen line, we'll position it later
	$chosen = mayflower_errormsgs(); ?>
	<div class="jumbotron">
		<div class="text-center">
			<p><?php echo $chosen; ?></p>
		</div>
	</div>

	<h1>404: Page not Found</h1>
	<p class="lead">Below are a few things you can try to find it:</p>
	<ol id="youcandoit" class="count">
		<li class="one">If you typed the web address, double-check if you typed it correctly.</li>
		<li class="two">Try searching for it.<?php get_search_form(); ?></li>
		<li class="three">Browse our <a href="//www.bellevuecollege.edu/directories/az/">A-Z directory</a>.</li>
		<li class="four">Use some of the links on this page.</li>
		<li class="five">Click the <a href="javascript:history.go(-1)">Back</a> button and try another link.</li>
	</ol>

</div><!-- content-padding -->


<?php get_footer();
