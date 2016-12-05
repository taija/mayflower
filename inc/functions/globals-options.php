<?php

/**
 *
 * Creates 'Globals Settings' panel in menu admin 
 * for defining globals paths and other globals options.
 * For use by multisite or single site installations.
 *
 * @since 1.0
 *
 */


/**
* Adds globals settings page for single site installs
**/
function globals_admin_menu_settings(){
	add_menu_page (
		'Globals Settings',
		'Globals Settings',
		'manage_options',
		'globals-settings',
		'globals_settings'
	);
}

/**
* Adds globals settings page for multisite installs
**/
function globals_network_menu_settings(){
	add_menu_page (
		'Globals Settings',
		'Globals Settings',
		'manage_network',
		'globals-settings',
		'globals_settings'
	);
}

/**
* Calls the correct action to include the settings page based on type of install
**/
if ( is_multisite() ) {
    add_action( 'network_admin_menu', 'globals_network_menu_settings');
} else {
    add_action( 'admin_menu', 'globals_admin_menu_settings');
}

/**
* Outputs settings page
**/
function globals_settings() {
	if ( (!is_multisite() && current_user_can('manage_options')) || (is_multisite() && current_user_can('manage_network')) ) {
		$globals_settings              = get_option( 'globals_network_settings' );
        if ( is_multisite() ) {
            $globals_settings          = get_site_option( 'globals_network_settings' );
        }
		$globals_path                  = $globals_settings['globals_path'];
		$globals_url                   = $globals_settings['globals_url'];
		$globals_version               = $globals_settings['globals_version'];
		$globals_google_analytics_code = $globals_settings['globals_google_analytics_code'];
		?>
		<div class="wrap">
			<h2>Globals Settings</h2>

			<?php if ( isset($_POST['action'] ) && $_POST['action'] == 'update_globals_settings' ) {
				check_admin_referer('save_globals_settings', 'save-settings');

				//sample code from Professional WordPress book
				//store option values in a variable
				$globals_settings = $_POST['globals_settings'];

				//use array map function to sanitize option values
				$globals_settings = array_map( 'sanitize_text_field', $globals_settings );

				//save option values
                if ( is_multisite() ) {
				    update_site_option( 'globals_network_settings', $globals_settings );
                } else {
                    update_option( 'globals_network_settings', $globals_settings );
                }

                //reset values so will be updated values will be shown in form after submission
                $globals_path                  = $globals_settings['globals_path'];
		        $globals_url                   = $globals_settings['globals_url'];
		        $globals_version               = $globals_settings['globals_version'];
		        $globals_google_analytics_code = $globals_settings['globals_google_analytics_code'];
                
				//just assume it all went according to plan
				echo '<div id="message" class="updated fade"><p><strong>Globals settings updated!</strong></p></div>';

			} ?>

			<form method="post">
				<input type="hidden" name="action" value="update_globals_settings" />
					<?php wp_nonce_field('save_globals_settings', 'save-settings'); ?>
					<table class="form-table">
						<tr valign="top">
							<th scope="row">
								<label for="globals_settings[globals_path]">
									Globals path
								</label>
							</th>
							<td>
								<input size="50" type="text" name="globals_settings[globals_path]" id="globals_settings[globals_path]"
									value="<?php
									if (empty($globals_path)) {
										echo $_SERVER['DOCUMENT_ROOT'] . "/g/3/";
									} else {
										echo $globals_path;
									}?>"/>
								<i class="fa fa-question-circle"></i>
								<br /><small><strong>Apache example:</strong> /var/www/g/3/</small>
								<br /><small><strong>Nginx example:</strong> /usr/share/nginx/www.bellevuecollege.edu/g/3/</small>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="globals_settings[globals_url]">
									Globals URL
								</label>
							</th>
							<td>
								<input size="50" type="text" name="globals_settings[globals_url]" id="globals_settings[globals_url]" value="<?php echo $globals_url; ?>"/>
								<br /><small><strong>Example:</strong> //s.bellevuecollege.edu/g/3/ </small>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="globals_settings[globals_version]">
									Globals version
								</label>
							</th>
							<td>
								<input size="50" type="text" name="globals_settings[globals_version]" id="globals_settings[globals_version]" value="<?php echo $globals_version; ?>"/>
								<br /><small>Used to invalidate browser-side caching</small>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="globals_settings[globals_google_analytics_code]">
									Google Analytics code
								</label>
							</th>
							<td>
								<input size="50"
									   type="text"
									   name="globals_settings[globals_google_analytics_code]"
									   id="globals_settings[globals_google_analytics_code]"
									   value="<?php echo $globals_google_analytics_code; ?>"/>
								<br /><small>Used across WordPress site</small>
							</td>
						</tr>
				</table>

				<p class="submit">
					<input type="submit" class="button-primary" name="update_globals_settings" value="Save settings" />
				</p>
			</form>
		</div>

	<?php } 
}