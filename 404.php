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

		$errmsgs = "It's not you, it's me.
		I wasn't expecting this either.
		I hate to tell you this, but...
		I'm feeling lost too.
		Oops, something is broken
		The page went where?
		It's been a tough day on the Web.
		You weren't supposed to see this.
		Errors happen to the best of people.
		Don't tell my supervisor :)
		Errors make me blush.
		We call this a Web Transfer Failure.
		Which way is north?
		You found an error. W00t!";

		// Here we split it into lines
		$errmsgs = explode( "\n", $errmsgs );

		// And then randomly choose a line
		return wptexturize( $errmsgs[ mt_rand( 0, count( $errmsgs ) - 1 ) ] );
	}

	// This just echoes the chosen line, we'll position it later
	$chosen = mayflower_errormsgs(); ?>
	<div class="jumbotron">
		<div class="container text-center">
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