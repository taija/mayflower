<?php

###############################
// Globals Settings
###############################

	add_action( 'network_admin_menu', 'globals_network_menu_settings');

	function globals_network_menu_settings(){

	     add_menu_page ('Globals Settings', 'Globals Settings', 'manage_network', 'globals-settings', 'globals_network_settings');

	}

	function globals_network_settings() {

	    if (is_multisite() && current_user_can('manage_network'))  {

	        ?>
	    <div class="wrap">

	    <h2>Globals Settings</h2>

	    <?php

	    if (isset($_POST['action']) && $_POST['action'] == 'update_globals_settings') {

	    check_admin_referer('save_network_globals_settings', 'my-network-plugin');

	    //sample code from Professional WordPress book

	    //store option values in a variable
	        $network_globals_settings = $_POST['network_globals_settings'];

	        //use array map function to sanitize option values
	        $network_globals_settings = array_map( 'sanitize_text_field', $network_globals_settings );

	        //save option values
	        update_site_option( 'globals_network_settings', $network_globals_settings );

	        //just assume it all went according to plan
	        echo '<div id="message" class="updated fade"><p><strong>Globals Settings Updated!</strong></p></div>';

	}//if POST

	?>

	<form method="post">
	<input type="hidden" name="action" value="update_globals_settings" />
	<?php
	$network_globals_settings = get_site_option( 'globals_network_settings' );
	$globals_path = $network_globals_settings['globals_path'];
	$globals_url = $network_globals_settings['globals_url'];
	$globals_version = $network_globals_settings['globals_version'];
	$globals_google_analytics_code = $network_globals_settings['globals_google_analytics_code'];

	wp_nonce_field('save_network_globals_settings', 'my-network-plugin');
	?>
	<table class="form-table">
	                <tr valign="top">
	                    <th scope="row">
	                        <label for="globals_path">
	                            Globals Path
	                        </label>
	                    </th>
	                    <td>
	                       <input size="50" type="text" name="network_globals_settings[globals_path]" value="<?php 	if (empty($globals_path)) {
		echo $_SERVER['DOCUMENT_ROOT'] . "/g/3/"; } else {
	echo $globals_path; }?>"/><i class="fa fa-question-circle"></i>
	                       <br /><small><strong>Apache example:</strong> /var/www/g/3/</small>
	                       <br /><small><strong>Nginx example:</strong> /usr/share/nginx/www.bellevuecollege.edu/g/3/</small>

	                    </td>
	                </tr>
	                <tr valign="top">
	                    <th scope="row">
	                        <label for="globals_path">
	                            Globals URL
	                        </label>
	                    </th>
	                    <td>
	                       <input size="50" type="text" name="network_globals_settings[globals_url]" value="<?php echo $globals_url; ?>"/>
	                       <br /><small><strong>Example:</strong> //s.bellevuecollege.edu/g/3/ </small>
	                    </td>
                    </tr>
	                <tr valign="top">
	                    <th scope="row">
	                        <label for="globals_version">
	                            Globals Version
	                        </label>
	                    </th>
	                    <td>
	                       <input size="50" type="text" name="network_globals_settings[globals_version]" value="<?php echo $globals_version; ?>"/>
							<br /><small>Used to invalidate browser-side caching </small>
	                    </td>
	                </tr>
			 <tr valign="top">
	                    <th scope="row">
	                        <label for="globals_google_analytics_code">
	                            Google Analytics Code
	                        </label>
	                    </th>
	                    <td>
	                       <input size="50" type="text" name="network_globals_settings[globals_google_analytics_code]" value="<?php echo $globals_google_analytics_code; ?>"/>
							<br /><small>Used across wordpress network </small>
	                    </td>
	                </tr>

	</table>

	            <p class="submit">
	        <input type="submit" class="button-primary" name="update_globals_settings" value="Save Settings" />

	</p>
	</form>

	    <?php

	    } else {

	     echo '<p>Please configure WP Multisite before using these settings.  In addition, this page can only be accessed by a super admin.</p>';
	     /*Note: if your plugin is meant to be used also by single wordpress installations you would configure the settings page here, perhaps by calling a function.*/	
	     }

	?>
	</div>
	<?php

	} //settings page function 

