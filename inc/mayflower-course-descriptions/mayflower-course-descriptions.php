<?php
#######################################################
## Add course description shortcode buttons and modals
#######################################################

/**************************************
* Aggregate functions and WP actions
**************************************/
//API URL
define("API_MULTICOURSE_URL", "//www.bellevuecollege.edu/apis/classes/v1/courses/multiple"); //multiple course URL

// Add shortcode media buttons for course-related shortcode creation
function add_shortcode_buttons() {
    echo '<a href="#TB_inline?width=480&inlineId=select_form" class="thickbox button" id="add_course" title="' . __("Add Course", 'mayflower') . '"><span class="dashicons dashicons-welcome-learn-more"></span> ' . __("Add Course", "mayflower") . '</a>';
    //echo '<a href="#TB_inline?width=400&height=500&inlineId=multicourse_select_form" class="thickbox button" id="add_multi_course" title="' . __("Add Multiple Courses", 'mayflower') . '"><span class="dashicons dashicons-plus" style="vertical-align: middle;"></span> ' . __("Add Multiple Courses", "mayflower") . '</a>'; //UNCOMMENT TO ENABLE MULTICOURSE
}

//Return form HTML
function add_coursedesc_code() {
    add_coursedesc_popup();
    //add_multicourse_popup(); //UNCOMMENT TO ENABLE MULTICOURSE
}

add_action('media_buttons', 'add_shortcode_buttons', 99);
add_action('admin_footer', 'add_coursedesc_code'); //add HTML form snippets to admin footer
add_shortcode('coursedescription', 'coursedescription_func' );  //declare single course shortcode function
add_shortcode('multicoursedescription', 'multi_coursedescription_func' ); //declare multi course shortcode function
add_action('wp_ajax_get_course', 'get_course_callback'); //ajax to get course

/*****************************
* Single course functions
*****************************/

//HTML form for single course intake
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
                            $json_subjects_url = "//www.bellevuecollege.edu/classes/Api/Subjects?format=json";
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

/*
 * Ajax call to get courses
 * */
function get_course_callback() {
    $subject = $_POST['subject'];
    $json_subjects_url = "//www.bellevuecollege.edu/classes/All/".$subject."?format=json";
    $json = wp_remote_get($json_subjects_url);

    if(!empty($json) && !empty($json['body']))
    {
        echo $json['body'];
    }
    die();
}

//function for rendering single course shortcode into HTML
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
        $url = "//www.bellevuecollege.edu/classes/All/".$subject."?format=json";
        $json = wp_remote_get($url);
        if(!empty($json) && !empty($json['body']))
        {
		    $html = decodejsonClassInfo($json['body'],$course_id,$description);
            return $html;
        }
    }
    return null;
}

//process json returned by API call
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

//process individual course for display
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

/*****************************
* Multiple courses functions
*****************************/

// HTML form code for entering courses
function add_multicourse_popup() {
    ?>
    <script>
        function MulticourseInsertShortcode(){

            var courses = jQuery("#multicourse_add_courses").val().replace(/^\s+|\s+$/g, ""); //trim newlines and whitespace at beg/end of string

            var isempty_courses = courses.replace(/\r\n|\r|\n/g,"");  //trim any newlines to test if empty
            if(isempty_courses == ""){
                alert("<?php _e("Enter courses to be displayed.", "mayflower") ?>");
                return;
            }

            var implode_courses = courses.replace(/\r\n|\r|\n/g, ",");   //implode to comma-delimited list for use in shortcode
            var display_course_description = jQuery("#display_course_description").is(":checked");
            var description_qs = !display_course_description ? " description=\"false\"" : " description=\"true\"";  //set description info
            
            window.send_to_editor("[multicoursedescription courses=\"" + implode_courses.toUpperCase() + "\"" + description_qs + "]"); //output shortcode text
        }
    </script>

    <div id="multicourse_select_form" style="display:none;">
        <div class="wrap">
            <div>
                <div style="padding:15px 15px 0 15px;">
                    <h3 style="color:#5A5A5A!important; font-family:Georgia,Times New Roman,Times,serif!important; font-size:1.8em!important; font-weight:normal!important;"><?php _e("Insert courses", "mayflower"); ?></h3>
                    <span>
                        <?php _e("Enter courses, one per line, to add to your post or page.", "mayflower"); ?>
                    </span>
                </div>
                <div style="padding:15px 15px 0 15px;">
                    <textarea id="multicourse_add_courses" name="add_courses" rows="10"></textarea>
                </div>
                <div style="padding:15px 15px 0 15px;">
                    <input type="checkbox" id="multicourse_display_course_description"  /> <label for="display_course_description"><?php _e("Display course descriptions?", "mayflower"); ?></label>
                </div>
                <div style="padding:15px;">
                    <input type="button" class="button-primary" value="<?php _e("Insert courses", "mayflower"); ?>" onclick="MulticourseInsertShortcode();"/>&nbsp;&nbsp;&nbsp;
                    <a class="button" style="color:#bbb;" href="#" onclick="tb_remove(); return false;"><?php _e("Cancel", "mayflower"); ?></a>
                </div>
            </div>
        </div>
    </div>

    <?php
}

//function for rendering multicourse shortcode into HTML
function multi_coursedescription_func($atts)
{
    $courses = $atts["courses"];    //provided course ids
    //var_dump($courses);
    $description = $atts["description"]; //whether to include descriptions
    if( !empty($courses) )
    {
        //error_log("course :".$course);
        $course_split = explode(",", $courses);
        $url = API_MULTICOURSE_URL;

        //build query string for URL
        $qs = "";
        foreach ( $course_split as $course ){
            if ( !empty($qs) ) $qs .= "&";
            $qs .= "courses[]=" . urlencode(html_entity_decode(strtoupper($course)));
        }
        $url .= "?" . $qs;

        $json = wp_remote_get($url);    //make API call

        if(!empty($json) && !empty($json['body']))
        {
		    $html = process_multicourse_json($json['body'], $description); //process returned json
            return $html;
        }
    }
    return null;
}

//process json returned by API call
function process_multicourse_json($json_string, $description = null )
{
    $json = json_decode($json_string,true);
    //var_dump($json);
    $html = "";
    $courses = $json["courses"];
    $html .= "<div class='classDescriptions'>";
    //loop through any returned courses and output each
    if(count($courses)>0)
    {
        foreach($courses as $course)
        {
            $html .= get_course_html($course, $description);
        }
    }
    $html .= "</div>"; //classDescriptions

    return $html;
}

//process individual course for display
function get_course_html($course, $description = null)
{
    $html = "";
    $html .= "<div class='class-info'>";
    $html .= "<h5 class='class-heading'>";

    $course_id = $course["subject"] . " " . $course["courseNumber"];

    $course_url = CLASSESURL.$course["subject"];
    /*if($course["isCommonCourse"])
    {
        $course_url .= "&";
    }*/
    $course_url .= "/".$course["courseNumber"];

    $html .= "<a href='".$course_url."''>";
    $html .= "<span class='course-id'>".$course_id."</span>";
    $html .= " <span class='course-title'>".$course["title"]."</span>";
    $html .= "<span class='course-credits'> &#8226; ";

    if($course["isVariableCredits"])
    {
        $html .= "V1-".$course["credits"]." <abbr title='variable credit'>Cr.</abbr>";
    }
    else
    {
        $html .= $course["credits"]." <abbr title='credit(s)'>Cr.</abbr>";
    }
    $html .= "</span>";
    $html .= "</a>";
    $html .= "</h5>"; //classHeading
    if($description=="true" && !empty($course["description"]))
    {
        //error_log("Not here");
        $html .= "<p class='class-description'>" . $course["description"] . "</p>";
        $html .= "<p class='class-details-link'>";
        $html .= "<a href='".$course_url."'>View details for ".$course["subject"]." ".$course["courseNumber"]."</a>";
        $html .= "</p>";
    }
        $html .= "</div>"; //classInfo
        return $html;
}
