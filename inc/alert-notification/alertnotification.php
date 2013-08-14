<?php

/*
	This is the function called by cron job every minute.
*/

 function myCronFunction()
{
	//error_log("############################CRON TAB is Running #######################");
	$network_settings = get_site_option( 'ravealert_network_settings' ); 
	$url = $network_settings['ravealert_xml_feedurl'];//;get_template_directory() . '/inc/alert-notification/channel1.xml';
	$new_data = getDisplayMessage($url);
	$getHtml = returnHtmlNClearCache($new_data);
}
/*
	Clears the cache based on conditions.
	Updates new message in the database
*/
function returnHtmlNClearCache($new_data)
{
	$html = "";
	$class = "";//Class for the display message
	
	if($new_data["description"] != "")
	{
		$class = $new_data["class"];
		$html = "<div id='alertmessage' class='".$new_data["class"]."'>".$new_data["description"]."</div>";
	}
	$network_settings = get_site_option( 'ravealert_network_settings' ); 
	//error_log("network_settings:".print_r($network_settings,true));
	$high_alert = $network_settings['high_alert']; 
	$currentMsg = get_site_option('ravealert_currentMsg');
	$classForMsg = get_site_option('ravealert_classCurrentMsg');
	if(!$currentMsg)
	{
		add_site_option( "ravealert_currentMsg", "" );
	}
	if(!$classForMsg)
	{
		add_site_option( "ravealert_classCurrentMsg", "" );
	}
	$clearCacheCommand = $network_settings['ravealert_clearCacheCommand'];//error_log("clear cache command:".$clearCacheCommand);"sudo find /var/run/nginx-cache-bc -type f -exec rm {} \;";
	$clearCacheCommand = base64_decode($clearCacheCommand);	
	$new_display_message = trim($new_data["description"]);
			
//Clear the cache if there is a new message 	

	if($currentMsg != $new_display_message)
	{
		if($clearCacheCommand)
		{
			$returnValue= returnContentsOfUrl($clearCacheCommand);
			//error_log("clearing cache return value :".$returnValue);
			//var_dump($returnValue);
			if($returnValue)
			{
				//var_dump("==============================Inside if conditions");
				$returnJsonDecodedString = json_decode($returnValue,true);
				//error_log("returnJsonDecodedString :".print_r($returnJsonDecodedString,true));
				//var_dump($returnJsonDecodedString);
				foreach($returnJsonDecodedString as $key=>$value)
				{
					//var_dump("inside for loop:".$value);
					//$key will be the server name
					if($value["return_value"] != 0)
					{
						error_log("\n"."Error: Server ".$key." returns ".$value["return_value"]." while running command ".$value["command_run"]."\n");
					}
					else
					{
						//error_log("\n"." Success: Server ".$key." returns ".$value["return_value"]." while running command ".$value["command_run"]."\n");
					}
				}
				
			}
		}
	}
	//Updated the new message and the class variable in the database
	update_site_option("ravealert_currentMsg", $new_display_message);
	update_site_option("ravealert_classCurrentMsg", $class);
	return $html;
}

function returnContentsOfUrl($url)
{
	$ch = curl_init();
	// set URL and other appropriate options
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// grab URL and pass it to the browser
	$output = curl_exec($ch);
	// close cURL resource, and free up system resources
	curl_close($ch);
	//error_log("output :".$output);
	return $output;
}

/*
	This function mainly replicates the code written in asp into php.
	The function checks the given url and retrieves the xml data.
	It returns new display message and class based on conditions.
*/
function getDisplayMessage($url)
{
	//$xml = file_get_contents($url);
	$xml = returnContentsOfUrl($url);
	//error_log("xml returned :".$xml);
	$network_settings = get_site_option( 'ravealert_network_settings' ); 
	$high_alert = $network_settings['high_alert'];
	$open_message = $network_settings['ravealert_college_openmessage'];
	$returnArray = array();
	//echo("the xml:".$xml);
	$html="";
	if($xml)
	{
		$data = simplexml_load_string($xml);
		//echo "\n<pre>"; print_r($data);
		if($data ->channel)
		{
			if($data ->channel->item)
			{
				if($data ->channel ->item->description)
				{
					$description = $data ->channel ->item->description;
					//echo "\n channel:".print_r($channel);
					$title = $data ->channel ->item->title;
					$dcDate = $data ->channel ->item->children('dc',true)->date;
					$dcDate = str_replace("T"," ",str_replace("Z","", $dcDate));
					//echo "description:".$description;
					//echo "dcdate :".$dcDate;
					if (DateTime::createFromFormat('Y-m-d G:i:s', $dcDate) !== FALSE) {
					  // it's a date
						//echo "\nvalid date";
						//$now = time();
						$now = current_time('timestamp',1);//get_gmt_from_date();//the_date('Y-m-d');
						//error_log("now in gmt :".$now);
						//$now = strtotime($now);
						$dcDate_time = strtotime($dcDate);
						//error_log("dc date time in gmt :".$dcDate_time);
						$datediff = $dcDate_time - $now;
						//error_log("date diff:".$datediff);
     					//echo floor($datediff/(60*60*24));
     					if($datediff > -1)
     					{
     						$html = "<div class='alert alert-error'>".$description."</div>";
							$returnArray["description"] = $description;
							$returnArray["class"] = "alert alert-error";
     					}
     					else
     					{
						//	error_log("inside alert :".$high_alert);
     						if($high_alert == "true")
     						{
								
     							if($open_message)
								{
     								$html = "<div class='alert alert-success'>".$open_message."</div>";
									$returnArray["description"] = $open_message;
									$returnArray["class"] = "alert alert-success";
								}
     							else
     							{
									$returnArray["description"] = "";
									$returnArray["class"] = "";
								}								
     						}
     					}	
					}
					else
					{
						$html = "<!-- alert did not supply a recognizeable date: -->";
					}
				}
				else
				{
					$html = "<!-- Missing description node -->";
				}
			}
			else
			{
				$html = "<!-- XML is not a valid RSS feed (missing 'item' node(s)) -->";
			}
		}
		else
		{
			$html = "<!-- RSS url did not return valid XML (" & xmlResponse.parseError.reason & ") -->";
				
		}	

	}
	else
	{
		error_log("failed to read content from url :".$url);
	}
	//error_log("return ".print_r($returnArray));
	return $returnArray;
}
?>