<?php
####################################################
## Add Course Description Shortcode Button & Modal
####################################################

add_action('media_buttons', 'add_shortcode_button', 99);

function add_shortcode_button() {
            echo '<a href="#TB_inline?width=480&inlineId=select_form" class="thickbox button" id="add_course" title="' . __("Add Course", 'mayflower') . '"><span class="dashicons dashicons-welcome-learn-more"></span> ' . __("Add Course", "mayflower") . '</a>';
        }
function add_coursedesc_popup() {

        ?>
        <script>
            function InsertCourse(){
                var subject = jQuery("#add_subject").val();
                if(subject == ""){
                    alert("<?php _e("Please select a subject", "mayflower") ?>");
                    return;
                }
                var courseID = jQuery("#add_course_id").val();
                if(courseID == ""){
                    alert("<?php _e("Please select a course", "mayflower") ?>");
                    return;
                }

                var subject_select = jQuery("#add_subject option[value='" + subject + "']").text().replace(/[\[\]]/g, '');
                var display_course_description = jQuery("#display_course_description").is(":checked");
                var description_qs = !display_course_description ? " description=\"false\"" : " description=\"true\"";

                window.send_to_editor("[coursedescription subject=\"" + subject + "\" courseid=\"" + courseID + "\"" + description_qs + "]");
            }
            jQuery(document.body).on('change','#add_subject',function(){
                //alert('Change Happened');
                var selectedSubject = jQuery('#add_subject :selected').text();
                var selectedSubject = jQuery.trim(selectedSubject);
                var data = {
                                action: 'get_course',
                                subject: selectedSubject
                           };
                jQuery.post(ajaxurl,data,function(response){
                    //alert('Got this from the server: ' + response);
                    if(response)
                    {
                        try{
                            var json = JSON.parse(response);
                           // alert(json.Courses);
                            var courses = json.Courses;
                            var el = jQuery("#add_course_id");
                            if(courses.length>0)
                            {
                                el.empty();
                                jQuery("#add_course_id").append("<option value=''>Select Course</option>");
                            }

                            for(var i=0;i < courses.length;i++)
                            {
                                //alert(courses[i].CourseID);
                                jQuery("#add_course_id").append("<option value='"+courses[i].CourseID+"'>"+courses[i].CourseID+"</option>")
                            }
                        }catch(e){
                            alert("Error:",e);
                        }
                    }

                });
            });
		</script>

        <div id="select_form" style="display:none;">
            <div class="wrap">
                <div>
                    <div style="padding:15px 15px 0 15px;">
                        <h3 style="color:#5A5A5A!important; font-family:Georgia,Times New Roman,Times,serif!important; font-size:1.8em!important; font-weight:normal!important;"><?php _e("Insert a course", "mayflower"); ?></h3>
                        <span>
                            <?php _e("Select a subject to add it to your post or page.", "mayflower"); ?>
                        </span>
                    </div>
                    <div style="padding:15px 15px 0 15px;">

                        <select id="add_subject">
                            <option value="">  <?php _e("Select Subject", "mayflower"); ?>  </option>
								<?php
								$json_subjects_url = "http://www.bellevuecollege.edu/classes/Api/Subjects?format=json";
								//$json = file_get_contents($json_subjects_url,0,null,null);
                                $json = wp_remote_get($json_subjects_url);
                                if(!empty($json) && !empty($json['body']))
                                {
                                    $links = json_decode($json['body'], TRUE);
                                    ?>
                                    <?php
                                    //error_log("links :". $links);
                                        foreach($links as $key=>$val){
                                    ?>
                                        <option>
                                            <?php echo trim($val['Slug']); ?>
                                        </option>
                                <?php
                                        }
                                }
								?>
                        </select> <br/>
                        <select id="add_course_id">
                            <option value="">  <?php _e("Select Course", "mayflower"); ?>  </option>
                        </select>
                    </div>
                    <div style="padding:15px 15px 0 15px;">
                        <input type="checkbox" id="display_course_description"  /> <label for="display_course_description"><?php _e("Display course description", "mayflower"); ?></label>
                    </div>
                    <div style="padding:15px;">
                        <input type="button" class="button-primary" value="<?php _e("Insert course", "mayflower"); ?>" onclick="InsertCourse();"/>&nbsp;&nbsp;&nbsp;
                    <a class="button" style="color:#bbb;" href="#" onclick="tb_remove(); return false;"><?php _e("Cancel", "mayflower"); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }


add_action('admin_footer',  'add_coursedesc_popup');

/*
 * Ajax call to get courses
 * */
add_action('wp_ajax_get_course','get_course_callback');

function get_course_callback() {
    $subject = $_POST['subject'];
    $json_subjects_url = "http://www.bellevuecollege.edu/classes/All/".$subject."?format=json";
    $json = wp_remote_get($json_subjects_url);

    if(!empty($json) && !empty($json['body']))
    {
        echo $json['body'];
    }
    die();
}

add_shortcode('coursedescription', 'coursedescription_func' );

function coursedescription_func($atts)
{
      $subject = $atts["subject"];
      $course = $atts["courseid"];// Attribute name should always read in lower case.
    $description = $atts["description"];
    if(!empty($course) && !empty($subject))
    {
        //error_log("course :".$course);
        $course_split = explode(" ",$course);
        $course_letter = $course_split[0];
        $course_id = $course_split[1];
        $subject = trim(html_entity_decode  ($subject));
        $url = "http://www.bellevuecollege.edu/classes/All/".$subject."?format=json";
        $json = wp_remote_get($url);
        if(!empty($json) && !empty($json['body']))
        {
		    $html = decodejsonClassInfo($json['body'],$course_id,$description);
            return $html;
        }
    }
    return null;
}


	function decodejsonClassInfo($jsonString,$number = NULL,$description = NULL)
	{
		$decodeJson = json_decode($jsonString,true);
		$htmlString = "";
		$courses = $decodeJson["Courses"];
		$htmlString .= "<div class='classDescriptions'>";
        if(count($courses)>0)
        {
            foreach($courses as $sections)
            {
                if($number!=null)
                {
                    if($sections["Number"] == $number)
                    {
                        $htmlString .= getHtmlForCourse($sections,$description);
                    }
                }
                else
                {
                    $htmlString .= getHtmlForCourse($sections,$description);
                }
            }
        }
		$htmlString .= "</div>"; //classDescriptions

		return $htmlString;
	}


	function getHtmlForCourse($sections,$description = NULL)
	{
		$htmlString = "";
		$htmlString .= "<div class='class-info'>";
		$htmlString .= "<h5 class='class-heading'>";
			$courseUrl = CLASSESURL.$sections["Subject"];
			if($sections["IsCommonCourse"])
			{
				$courseUrl .= "&";
			}
			$courseUrl .= "/".$sections["Number"];

			$htmlString .= "<a href='".$courseUrl."''>";
			$htmlString .= "<span class='course-id'>".$sections["Descriptions"][0]["CourseID"]."</span>";
			$htmlString .= " <span class='course-title'>".$sections["Title"]."</span>";
			$htmlString .= "<span class='course-credits'> &#8226; ";

			if($sections["IsVariableCredits"])
			{
				$htmlString .= "V1-".$sections["Credits"]." <abbr title='variable credit'>Cr.</abbr>";
			}
			else
			{
				$htmlString .= $sections["Credits"]." <abbr title='credit(s)'>Cr.</abbr>";
			}
			$htmlString .= "</span>";
			$htmlString .= "</a>";
			$htmlString .= "</h5>";//classHeading
        if($description=="true" && !empty($sections["Descriptions"]))
        {
            //error_log("Not here");
			$htmlString .= "<p class='class-description'>" . $sections["Descriptions"][0]["Description"] . "</p>";
			$htmlString .= "<p class='class-details-link'>";
			$htmlString .= "<a href='".$courseUrl."'>View details for ".$sections["Descriptions"][0]["CourseID"]."</a>";
			$htmlString .= "</p>";
        }
			$htmlString .= "</div>"; //classInfo
			return $htmlString;
	}
    