<?php 

add_action( 'network_admin_menu', 'myplugin_network_menu_settings');

function myplugin_network_menu_settings(){

     add_menu_page ('My Plugin Settings', 'My Plugin Settings', 'manage_network', 'myplugin-settings', 'myplugin_network_settings');

}

function myplugin_network_settings() {

    if (is_multisite() && current_user_can('manage_network'))  {

        ?>
    <div class="wrap">

    <h2>My Plugin Network Settings</h2>

    <?php 

    if (isset($_POST['action']) && $_POST['action'] == 'update_myplugin_settings') {

    check_admin_referer('save_network_settings', 'my-network-plugin');

    //sample code from Professional WordPress book

    //store option values in a variable
        $network_settings = $_POST['network_settings'];

        //use array map function to sanitize option values
        $network_settings = array_map( 'sanitize_text_field', $network_settings );

        //save option values
        update_site_option( 'myplugin_network_settings', $network_settings );

        //just assume it all went according to plan
        echo '<div id="message" class="updated fade"><p><strong>MyPlugin Network Settings Updated!</strong></p></div>';

}//if POST

?>

<form method="post">
<input type="hidden" name="action" value="update_myplugin_settings" />
<?php 
$network_settings = get_site_option( 'myplugin_network_settings' ); 
$holiday = $network_settings['holiday']; //holiday setting example from Professional WordPress

wp_nonce_field('save_network_settings', 'my-network-plugin');
?>
<table class="form-table">
                <tr valign="top"><th scope="row">Network Holiday</th>
                    <td>
                        <select name="network_settings[holiday]">
                            <option value="halloween" <?php selected( $holiday, 'halloween' ); ?> >Halloween</option>
                            <option value="christmas" <?php selected( $holiday, 'christmas' ); ?> >Christmas</option>
                            <option value="april_fools" <?php selected( $holiday, 'april_fools' ); ?> >April Fools</option>
                        </select>
                    </td>
                </tr>
            </table>

            <p class="submit">
        <input type="submit" class="button-primary" name="update_myplugin_settings" value="Save Settings" />

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
