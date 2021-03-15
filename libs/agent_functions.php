<?php

/**
*  return agent/user picture
*
* @since    
* @var 
*/



if( !function_exists('wpestate_theme_slider_contact') ):
function wpestate_agent_picture($propid){
    $agent_id       =   intval( get_post_meta($propid, 'property_agent', true) );
    $thumb_id       =   get_post_thumbnail_id($agent_id);
    $preview        =   wp_get_attachment_image_src($thumb_id, 'property_listings');
    return  $preview[0];
            
}
endif;


/**
*  return agent/user details
*
* param   $propid = proeprty id
* @var 
*/

if( !function_exists('wpestate_return_agent_details') ):
function wpestate_return_agent_details($propid,$singular_agent_id=''){
    
    if($singular_agent_id==''){
        $agent_id       =   intval( get_post_meta($propid, 'property_agent', true) );
    }else{
        $agent_id=$singular_agent_id;
    }
    $user_id        =   0;
    $counter        =   0;
    $agent_member   =   '';
    $agent_face_img =   '';
    
    if($agent_id!=0){
        $one_id         =    $agent_id;
        $thumb_id       =    get_post_thumbnail_id($agent_id);
        if($thumb_id==''){
            $preview_img    =   get_theme_file_uri('/img/default_user_agent.gif');
            $agent_face     =   get_theme_file_uri('/img/default-user_1.png');
        }else{
            $preview        =   wp_get_attachment_image_src($thumb_id, 'property_listings');  
            $preview_img    =   $preview[0];
            $agent_face     =   wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');
            $agent_face_img =   $agent_face[0];
        }
        $title  =   get_the_title($agent_id);
        $link   =   esc_url( get_permalink($agent_id) );
        $type   =   get_post_type($agent_id);
     
        if( $type=='estate_agent' ){
            $agent_mobile       = esc_html( get_post_meta($agent_id, 'agent_mobile', true) );
            $agent_email        = esc_html( get_post_meta($agent_id, 'agent_email', true) );
            $agent_skype        = esc_html( get_post_meta($agent_id, 'agent_skype', true) );
            $agent_phone        = esc_html( get_post_meta($agent_id, 'agent_phone', true) );
            $agent_pitch        = esc_html( get_post_meta($agent_id, 'agent_pitch', true) );
            $agent_facebook     = esc_html( get_post_meta($agent_id, 'agent_facebook', true) );
            $agent_twitter      = esc_html( get_post_meta($agent_id, 'agent_twitter', true) );
            $agent_linkedin     = esc_html( get_post_meta($agent_id, 'agent_linkedin', true) );
            $agent_pinterest    = esc_html( get_post_meta($agent_id, 'agent_pinterest', true) );
            $agent_instagram    = esc_html( get_post_meta($agent_id, 'agent_instagram', true) );
            $agent_urlc         = esc_html( get_post_meta($agent_id, 'agent_website', true) );
            $agent_member       = esc_html(  get_post_meta( $agent_id, 'agent_member' , true) );
        }else if( $type=='estate_agency' ){
            $agent_mobile       = esc_html( get_post_meta($agent_id, 'agency_mobile', true) );
            $agent_email        = esc_html( get_post_meta($agent_id, 'agency_email', true) );
            $agent_skype         = esc_html( get_post_meta($agent_id, 'agency_skype', true) );
            $agent_phone         = esc_html( get_post_meta($agent_id, 'agency_phone', true) );
            $agent_pitch         = esc_html( get_post_meta($agent_id, 'agency_pitch', true) );
            $agent_posit         = esc_html( get_post_meta($agent_id, 'agency_position', true) );
            $agent_facebook      = esc_html( get_post_meta($agent_id, 'agency_facebook', true) );
            $agent_twitter       = esc_html( get_post_meta($agent_id, 'agency_twitter', true) );
            $agent_linkedin      = esc_html( get_post_meta($agent_id, 'agency_linkedin', true) );
            $agent_pinterest     = esc_html( get_post_meta($agent_id, 'agency_pinterest', true) );
            $agent_instagram     = esc_html( get_post_meta($agent_id, 'agency_instagram', true) );
            $agent_urlc          = esc_html( get_post_meta($agent_id, 'agency_website', true) );
            $agent_member        = esc_html(  get_post_meta( $agent_id, 'agent_member' , true) );
         
        }else if($type=='estate_developer'){
            $agent_mobile       = esc_html( get_post_meta($agent_id, 'developer_mobile', true) );
            $agent_email        = esc_html( get_post_meta($agent_id, 'developer_email', true) );
            $agent_skype         = esc_html( get_post_meta($agent_id, 'developer_skype', true) );
            $agent_phone         = esc_html( get_post_meta($agent_id, 'developer_phone', true) );
            $agent_pitch         = esc_html( get_post_meta($agent_id, 'developer_pitch', true) );
            $agent_posit         = esc_html( get_post_meta($agent_id, 'developer_position', true) );
            $agent_facebook      = esc_html( get_post_meta($agent_id, 'developer_facebook', true) );
            $agent_twitter       = esc_html( get_post_meta($agent_id, 'developer_twitter', true) );
            $agent_linkedin      = esc_html( get_post_meta($agent_id, 'developer_linkedin', true) );
            $agent_pinterest     = esc_html( get_post_meta($agent_id, 'developer_pinterest', true) );
            $agent_instagram     = esc_html( get_post_meta($agent_id, 'developer_instagram', true) );
            $agent_urlc          = esc_html( get_post_meta($agent_id, 'developer_website', true) );
            $agent_member        = esc_html(  get_post_meta( $agent_id, 'agent_member' , true) );
            
        }
        $agent_posit        = esc_html( get_post_meta($agent_id, 'agent_position', true) );
    
        $user_for_id = intval(get_post_meta($agent_id,'user_meda_id',true));
        if($user_for_id!=0){
            $counter            =   count_user_posts($user_for_id,'estate_property',true);
        }

      
    }else{
        $user_id        =    get_post_field( 'post_author', $propid );
        $one_id         =    $user_id;
        $preview_img    =$agent_face_img=    get_the_author_meta( 'custom_picture',$user_id  );
        
        if($preview_img==''){
            $preview_img = $agent_face_img=get_theme_file_uri('/img/default-user.png');
        }
        
        $title               =  get_the_author_meta( 'first_name',$user_id ).' '.get_the_author_meta( 'last_name',$user_id);
        $link                =  '';
        $agent_posit         =  get_the_author_meta( 'title' ,$user_id );  
        $agent_mobile        =  get_the_author_meta( 'mobile'  ,$user_id);
        $agent_skype         =  get_the_author_meta( 'skype',$user_id  );
        $agent_phone         =  get_the_author_meta( 'phone',$user_id  );
        $counter             =  count_user_posts($user_id,'estate_property',true);
        $agent_email         =  get_the_author_meta( 'user_email',$user_id  );
        $agent_pitch         =  '';
        $agent_facebook      =  get_the_author_meta( 'facebook',$user_id  );
        $agent_twitter       =  get_the_author_meta( 'twitter',$user_id  );
        $agent_linkedin      =  get_the_author_meta( 'linkedin',$user_id  );
        $agent_pinterest     =  get_the_author_meta( 'pinterest',$user_id  );
        $agent_instagram     =  get_the_author_meta( 'instagram',$user_id  );
        $agent_urlc          =  get_the_author_meta( 'website',$user_id  );
    }
   
    
    
    $all_details=array();
    $all_details['one_id']              =   $one_id;
    $all_details['agent_id']            =   $agent_id;
    $all_details['user_id']             =   $user_id;
    $all_details['realtor_image']       =   $preview_img;  
    $all_details['agent_face_img']      =   $agent_face_img;
    $all_details['realtor_name']        =   $title;
    $all_details['link']                =   $link;
    $all_details['email']               =   $agent_email;
    $all_details['realtor_position']    =   $agent_posit;
    $all_details['realtor_mobile']      =   $agent_mobile; 
    $all_details['realtor_skype']       =   $agent_skype;
    $all_details['realtor_phone']       =   $agent_phone;
    $all_details['realtor_pitch']       =   $agent_pitch;
    $all_details['realtor_facebook']    =   $agent_facebook;
    $all_details['realtor_twitter']     =   $agent_twitter;
    $all_details['realtor_linkedin']    =   $agent_linkedin;
    $all_details['realtor_pinterest']   =   $agent_pinterest;
    $all_details['realtor_instagram']   =   $agent_instagram;
    $all_details['realtor_urlc']        =   $agent_urlc;
    $all_details['member_of']           =   $agent_member;
                
         
    $all_details['counter']         =   $counter;
    return $all_details;
}
endif;