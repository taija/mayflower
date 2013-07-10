<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<div class="row">
	<div class="span12">
		<div class="content-padding">



				<?php function mayflower_errormsgs() {
						/** These are the error messages that are randomly displayed */

						$errmsgs = "It's not you, it's me.
						I wasn't expecting this either.
						I hate to tell you this, but…
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
						$chosen = mayflower_errormsgs();
						echo "<h1 class='entry-title'>$chosen</h1>";
				?>
					<h2>We couldn’t find the information you were looking for but there are a few things you can do.</h2>
					<br />
					<h2>Find what you were looking for</h2>
					<ol id="youcandoit" class="count">
						<li class="one">If you typed the web ad...you typed it correctly.</li>
						<li class="two">Try searching for it.<?php get_search_form(); ?></li>
						<li class="three"> Browse our <a href="//bellevuecollege.edu/directories/">web directories</a>.</li>
						<li class="four">Use some of the links on this page.</li>
						<li class="five">Click the <a href="javascript:history.go(-1)">Back</a> button and try another link.</li>
					</ol>

		</div><!-- content-padding -->

	</div><!-- span12 -->
</div><!-- row -->


<?php get_footer(); ?>