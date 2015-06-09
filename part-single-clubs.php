<?php

/*  Template for displaying post type for the student-club plugin. .
    https://github.com/BellevueCollege/student-club
*/

if (have_posts()) : while (have_posts()) : the_post();

    $if_charted = get_post_meta( get_the_ID(), 'charted', true );
    $name = get_post_meta( get_the_ID(), 'club_contact_name', true );
    $location = get_post_meta( get_the_ID(), 'club_meeting_location', true );
    $url = get_post_meta( get_the_ID(), 'club_url', true );
    $phone = get_post_meta( get_the_ID(), 'club_advisor_phone', true );
    $advisor_email = get_post_meta( get_the_ID(), 'club_advisor_email', true );
    $club_email = get_post_meta( get_the_ID(), 'club_contact_email', true );
    $club_meeting_time =  get_post_meta( get_the_ID(), 'club_meeting_time', true );
    $budget_document_link = get_post_meta( get_the_ID(), 'budget_document_link', true );
    $category = get_post_meta( get_the_ID(), 'charted', true );
    $content = get_the_content();   
?>   
<div class="content-padding">          

    <h1><?php the_title()?></h1>
   <?php
        if(!empty($name))
        {
   ?>
            <p>Advisor: <?php echo $name; ?>  </p>
    <?php
        }
       if(!empty($location))
        {
   ?>
            <p>Office Location: <?php echo $location; ?>  </p>
   
     <?php
        }
        if(!empty($url))
        {
   ?>
            <p>Website: <a href="<?php echo $url; ?>"> <?php echo $url; ?> </a>  </p>
  <?php
        }
        if(!empty($phone))
        {
    ?>
            <p>Contact Information: <?php echo $phone; ?>  </p>
       <?php
        }
        if(!empty($advisor_email))
        {
    ?>      
            <p>Advisor Email: <a href="mailto: <?php echo $advisor_email; ?>"><?php echo $advisor_email; ?></a>  </p>
    <?php
        }
        if(!empty($club_email))
        {
    ?>    
            <p>Club Email: <a href="mailto: <?php echo $club_email; ?> "><?php echo $club_email; ?></a>  </p>           
           
 <?php
        }   
        if(!empty($content)){    ?>
       
            <br/><p><b> Description: </b> <?php echo $content; ?> </p> 
    <?php  
        }                
    ?> 
    <p>Club Meeting: <?php echo $club_meeting_time; ?>  </p>
    <p><a href="<?php echo $budget_document_link ?>">Budget Report </a></p>    

</div>     <!--.content-padding-->     

<?php 
endwhile;
wp_reset_query();
endif;