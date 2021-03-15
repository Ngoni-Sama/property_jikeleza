<?php 
global $agent_email;
global $propid;
global $agent_wid;
$realtor_details =  wpestate_return_agent_details($post->ID);
?>


    
<?php
    wp_reset_query();
    $agent_wid=$realtor_details['agent_id'];
    if ( get_the_author_meta('user_level',$agent_wid) !=10){ ?>
        <div class="agent_contanct_form_sidebar widget-container">
            <?php
            include( locate_template('templates/agent_unit_widget_sidebar.php' ) ); 
            include( locate_template('templates/agent_contact.php') );
            ?>
        </div>
    <?php }
?>
