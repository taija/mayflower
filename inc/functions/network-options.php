<?php 
add_action( 'network_admin_menu', 'ravealert_network_menu_settings');

function ravealert_network_menu_settings(){

     add_menu_page ('Rave Alert', 'Rave Alert', 'manage_network', 'ravealert-settings', 'ravealert_network_settings');

}

function ravealert_network_settings() {

    if (is_multisite() && current_user_can('manage_network'))  {

        ?>
    <div class="wrap">

    <h2>Rave Alert Settings</h2>

    <?php 

    if (isset($_POST['action']) && $_POST['action'] == 'update_ravealert_settings') {

    check_admin_referer('save_network_settings', 'my-network-plugin');

    //sample code from Professional WordPress book

    //store option values in a variable
        $network_settings = $_POST['network_settings'];

        //use array map function to sanitize option values
        $network_settings = array_map( 'sanitize_text_field', $network_settings );

        //save option values
        update_site_option( 'ravealert_network_settings', $network_settings );

        //just assume it all went according to plan
        echo '<div id="message" class="updated fade"><p><strong>Rave Alert Network Settings Updated!</strong></p></div>';

}//if POST

?>

<form method="post">
<input type="hidden" name="action" value="update_ravealert_settings" />
<?php 
$network_settings = get_site_option( 'ravealert_network_settings' ); 
//$holiday = $network_settings['holiday']; //holiday setting example from Professional WordPress
$high_alert = $network_settings['high_alert']; 

$trueSelected = "";
$falseSelected = "";
if($high_alert == "true")
{
	$trueSelected = "checked";
}
else
{
	$falseSelected = "checked";
}
$ravealert_currentMsg = $network_settings['ravealert_currentMsg'];
$ravealert_clearCacheCommand = $network_settings['ravealert_clearCacheCommand'];
$ravealert_college_openmessage = $network_settings['ravealert_college_openmessage'];
error_log("clear Cache Command  :".$ravealert_clearCacheCommand);


wp_nonce_field('save_network_settings', 'my-network-plugin');
?>
<table class="form-table">
                <tr valign="top">  
                    <th scope="row">  
                        <label for="high_alert">  
                            High Alert
                        </label>   
                    </th>  
                    
                    <td>  
                        <input type="radio" name="network_settings[high_alert]" value="true" <?php echo $trueSelected; ?> /> True
						<input type="radio" name="network_settings[high_alert]" value="false" <? echo $falseSelected; ?>/>  False
                    </td>  
                </tr>  
				<tr valign="top">  
                    <th scope="row">  
                        <label for="ravealert_college_openmessage">  
                            College Open Message
                        </label>
									
                    </th>  
                    <td>  
                       <textarea name="network_settings[ravealert_college_openmessage]" ><?php echo $ravealert_college_openmessage; ?></textarea>  			
                    </td>  
                </tr> 
				<tr valign="top">  
                    <th scope="row">  
                        <label for="ravealert_clearCacheCommand">  
                            Clear Cache Commands
                        </label>
									
                    </th>  
                    <td>  
                       <input type="text" name="network_settings[ravealert_clearCacheCommand]" value="<?php echo $ravealert_clearCacheCommand; ?>"/>  			
                    </td>  
                </tr> 
				<tr valign="top">  
                    <th scope="row">  
                        <label for="ravealert_currentMsg">  
                            Current Message Displayed
                        </label>
									
                    </th>  
                    <td>  
                       <input type="text" name="network_settings[ravealert_currentMsg]" value="<?php echo $ravealert_currentMsg; ?>" readonly />  			
                    </td>  
                </tr> 
            </table>

            <p class="submit">
        <input type="submit" class="button-primary" name="update_ravealert_settings" value="Save Settings" />

</p>
</form>

    <?php

    } else {

     echo '<p>My Network plugin must be used with WP Multisite.  Please configure WP Multisite before using this plugin.  In addition, this page can only be accessed in the by a super admin.</p>';
     /*Note: if your plugin is meant to be used also by single wordpress installations you would configure the settings page here, perhaps by calling a function.*/

     }

?>
</div>
<?php

} //settings page function 


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
		$globals_cache_version = $network_globals_settings['globals_cache_version']; 
				
		
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
		                       <input size="50" type="text" name="network_globals_settings[globals_path]" value="<?php //if (isset $globals_path) { echo $globals_path; } else { } ?>"/>  			
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
		                    </td>		                    
		                </tr>  
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="globals_version">
		                            Globals Cache Version
		                        </label>
		                    </th>
		                    <td>
		                       <input size="50" type="text" name="network_globals_settings[globals_cache_version]" value="<?php echo $globals_cache_version; ?>"/>  			
		                    </td>		                    
		                </tr>  
		            </table>
		
		            <p class="submit">
		        <input type="submit" class="button-primary" name="update_globals_settings" value="Save Settings" />
		
		</p>
		</form>
		

		
		    <?php
		
		    } else {
		
		     echo '<p>My Network plugin must be used with WP Multisite.  Please configure WP Multisite before using this plugin.  In addition, this page can only be accessed in the by a super admin.</p>';
		     /*Note: if your plugin is meant to be used also by single wordpress installations you would configure the settings page here, perhaps by calling a function.*/
		
		     }
		
		?>
		</div>
		<?php
		
		} //settings page function 
?>
