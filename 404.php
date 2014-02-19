<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header();

error_reporting_file_not_found();


?>
	
		<div class="content-padding row-padding box-shadow" id="content">



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
						//return wptexturize( $errmsgs[ mt_rand( 0, count( $errmsgs ) - 1 ) ] );
					}

					// This just echoes the chosen line, we'll position it later
						$chosen = mayflower_errormsgs();
						echo "<h1 class='entry-title'>$chosen</h1>";
				?>
					<h1>Page not Found</h1>
                    <p class=""><strong>Below are a few things you can try to find it:</strong></p>
					
					
					<ol id="youcandoit" class="count">
						<li class="one">If you typed the web address, double-check if you typed it correctly.</li>
						<li class="two">Try searching for it.<?php get_search_form(); ?></li>
						<li class="three">Browse our <a href="//bellevuecollege.edu/directories/az/">A-Z directory</a>.</li>
						<li class="four">Use some of the links on this page.</li>
						<li class="five">Click the <a href="javascript:history.go(-1)">Back</a> button and try another link.</li>
					</ol>

		</div><!-- content-padding -->



<?php get_footer();
/*
 * Emails the error to the specified user.
 * The to and from is set in the wp-config.php file.
 */
function error_reporting_file_not_found()
{

    $referer = $_SERVER['HTTP_REFERER'];
    $url = $_SERVER['PHP_SELF'];
    $user = wp_get_current_user();
    $computer_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    error_log($user->data->user_login);
    error_log("computer name :".$computer_name);
    error_log("referre parse :".$referer);
    $to = WPMS_MAIL_TO;//Getting from wp-config file
    $subject = "Broken Link Error Report";
    $message = "";
    $message .= "User:  ".$user->data->user_login;
    $message .= "\n\n Hostname:  ".$computer_name;
    $message .= "\n\n Referer Page:  ".$referer;
    $message .= "\n\n Current Page:  ".$url;
    $headers  = array();
    //$headers[]  = 'MIME-Version: 1.0' ;
    $headers[] = 'From:'.WPMS_MAIL_FROM;
    // $headers[] = 'Reply-To: webmaster@example.com' ;
    //$headers[] = 'X-Mailer: PHP/' . phpversion();
    if(isset($to) && !empty($to))
    {
        $mail_return_value = wp_mail($to,$subject,$message,$headers);
        error_log("mail return value :".$mail_return_value);
        if($mail_return_value)
        {
            error_log("Email sent successfully");
        }
    }
    else
    {
        error_log("The 'to' field is empty.");
    }
}
//add_action('in_admin_footer', 'error_reporting_file_not_found');
?>