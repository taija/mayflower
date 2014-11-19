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

    $referrer = $_SERVER['HTTP_REFERER'];
    $user = wp_get_current_user();
    $computer_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $missing_page_url = curPageURL();
    if(defined("BC404_MAIL_TO"))
         $to = BC404_MAIL_TO;//Getting from wp-config file
    else
        error_log(" BC404_MAIL_TO constant not set. ");

    $subject = "Broken Link Error Report";
    $message = "";
    $message .= "Date/Time: ".current_time("d/m/Y H:i:s",0);
    //$user_login = isset($user) && !empty($user->data) ? $user->data->user_login : "";
    if(isset($user) && !empty($user->data) && isset($user->data->user_login))
        $message .= "\n\nUser:  ".$user->data->user_login;
    $message .= "\n\nHostname:  ".$computer_name;
    $message .= "\n\nReferrer Page:  ".$referrer;
    $message .= "\n\nCurrent Page url:  ".$missing_page_url;
    $headers  = array(); // Create a single mail function that has headers defined once. 
    $headers[] = 'From:'.WPMS_MAIL_FROM;
    if(isset($to) && !empty($to) && !empty($referrer))
    {
        $mail_return_value = wp_mail($to,$subject,$message,$headers);



        if(!$mail_return_value)
        {
            error_log("404 page Email was not sent to:".$to);
        }
    }
    else
    {
        error_log("404 page email cannot be sent because 'to' or referrer field is empty.");
    }
}
function curPageURL() {
    $pageURL = 'http';
    if (isset( $_SERVER["HTTPS"] )  && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
//add_action('in_admin_footer', 'error_reporting_file_not_found');
?>