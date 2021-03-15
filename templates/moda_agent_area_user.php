<?php
global $prop_id ;
global $agent_email;
global $agent_urlc;
global $link;
global $agent_url;
global $agent_urlc;
global $link;
global $agent_facebook;
global $agent_posit;
global $agent_twitter; 
global $agent_linkedin; 
global $agent_instagram;
global $agent_pinterest; 
global $agent_member;



$post_author_id = get_post_field( 'post_author', $post_id );

if ( get_the_author_meta('user_level') !=10){

    $realtor_details = wpestate_return_agent_details($post_id);

    include( locate_template('templates/agentdetails.php'));
    include( locate_template('templates/agent_contact.php') );        

}

?>