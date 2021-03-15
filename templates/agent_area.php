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



if(isset($is_modal)){
    $prop_id=$post_id;
    $agent_id=$modal_agent_id;
   
}else{
    $agent_id       =   intval( get_post_meta($post->ID, 'property_agent', true) );
    $prop_id        =   $post->ID;
}


$realtor_details    =   wpestate_return_agent_details($prop_id);
$author_email       =   get_the_author_meta( 'user_email'  );
$agent_user_id      =   get_post_meta($agent_id,'user_agent_id',true);
if ($agent_id!=0){                        

      
        include( locate_template('templates/agentdetails.php'));
        include( locate_template('templates/agent_contact.php'));    
 
      
}   // end if !=0
else{  

        if ( get_the_author_meta('user_level') !=10){
        
            include( locate_template('templates/agentdetails.php'));
            include( locate_template('templates/agent_contact.php') );        
  
        }
}
?>