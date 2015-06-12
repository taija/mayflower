<?php

/*  Template for displaying post type for the student-club plugin. .
    https://github.com/BellevueCollege/student-club
*/

if (have_posts()) : while (have_posts()) : the_post();
    
    $meeting_location = get_post_meta( get_the_ID(), 'club_meeting_location', true );
    $meeting_time =  get_post_meta( get_the_ID(), 'club_meeting_time', true );

    $url = get_post_meta( get_the_ID(), 'club_url', true );
    $budget_document_link = get_post_meta( get_the_ID(), 'budget_document_link', true );

    $advisor_name = get_post_meta( get_the_ID(), 'club_advisor_name', true );
    $advisor_phone = get_post_meta( get_the_ID(), 'club_advisor_phone', true );
    $advisor_email = get_post_meta( get_the_ID(), 'club_advisor_email', true );

    $club_contact_name = get_post_meta( get_the_ID(), 'club_contact_name', true );
    $club_email = get_post_meta( get_the_ID(), 'club_contact_email', true );
    
    $club_statuses = wp_get_post_terms($post->ID, 'status', array("fields" => "names"));

    //Chartered Status
    $is_chartered = false;
    if (!(in_array('Unchartered', $club_statuses))) {
        $is_chartered = true;
    }
?>
<div class="content-padding">

    <?php 
        /* Display 'Unchartered' notice if Unchartered is in array.
           WIll display as unchartered even if Chartered is *also* selected */
        if (!($is_chartered)) {
            ?>
            <div class="alert alert-danger text-center large">
                <strong>This Club Has Not Chartered for the Current Academic Year</strong>
            </div>
            <?php
        }
    ?>

    <h1><?php the_title()?></h1>

    <ul>
   <?php
        if(!empty($club_contact_name)) {
   ?>
            <li>Club Contact: <?php echo $club_contact_name; ?></li>
    <?php
        }

        if(!empty($club_email)) {
    ?>
            <li>Club Contact Email: <a href="mailto:<?php echo $club_email; ?>"><?php echo $club_email; ?></a></li>
 <?php
        }
         if(!empty($advisor_name)) {
        ?>
           <li>Advisor Email: <?php echo $advisor_name; ?></li>

       <?php
        }
         if(!empty($advisor_email)) {
        ?>
           <li>Advisor Email: <a href="mailto:<?php echo $advisor_email; ?>"><?php echo $advisor_email; ?></a></li>
       <?php
        }
        if(!empty($advisor_phone)) {
    ?>
            <li>Advisor Phone: <?php echo $advisor_phone; ?></li>
       <?php
        }

       if(!empty($meeting_location)) {
   ?>
            <li>Meeting Location: <?php echo $meeting_location; ?></li>
   
     <?php
        }

        if(!empty($meeting_time)) {
        ?>
            <li>Meeting Time: <?php echo $meeting_time; ?></li>
        <?php
        }
        

         if(!empty($url)) {
           ?>
                    <li>Club Website: <strong><a href="<?php echo $url; ?>"> <?php echo $url; ?> </a></strong></li>
          <?php
                }

    ?>
        </ul>
    <?php 
    the_content(); 
    if(!empty($budget_document_link) && $is_chartered) {
    ?>
    <p><a href="<?php echo $budget_document_link; ?>" target="_blank">View Current Budget Information (opens in new window)</a></p>
    <?php
    }

    ?>

</div>     <!--.content-padding-->     

<?php 
endwhile;
wp_reset_query();
endif;
