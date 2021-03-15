<?php

$current_user           =   wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;
$agency_id              =   get_the_author_meta('user_agent_id',$userID);
$agency_title           =   get_the_title($agency_id);
$agency_description     =   get_post_field('post_content', $agency_id);
$agency_email           =   get_the_author_meta( 'user_email' , $userID );
$agency_phone           =   esc_html(get_post_meta($agency_id, 'agency_phone', true));
$agency_mobile          =   esc_html(get_post_meta($agency_id, 'agency_mobile', true));
$agency_skype           =   esc_html(get_post_meta($agency_id, 'agency_skype', true));
$agency_facebook        =   esc_html(get_post_meta($agency_id, 'agency_facebook', true));
$agency_twitter         =   esc_html(get_post_meta($agency_id, 'agency_twitter', true));
$agency_linkedin        =   esc_html(get_post_meta($agency_id, 'agency_linkedin', true));
$agency_pinterest       =   esc_html(get_post_meta($agency_id, 'agency_pinterest', true));
$agency_instagram       =   esc_html(get_post_meta($agency_id, 'agency_instagram', true));
$agency_address         =   esc_html(get_post_meta($agency_id, 'agency_address', true));
$agency_languages       =   esc_html(get_post_meta($agency_id, 'agency_languages', true));     
$agency_license         =   esc_html(get_post_meta($agency_id, 'agency_license', true));
$agency_taxes           =   esc_html(get_post_meta($agency_id, 'agency_taxes', true)); 
$agency_opening_hours   =   esc_html(get_post_meta($agency_id, 'agency_opening_hours', true)); 
$agency_lat             =   esc_html(get_post_meta($agency_id, 'agency_lat', true));    
$agency_long            =   esc_html(get_post_meta($agency_id, 'agency_long', true));
$agency_website         =   esc_html(get_post_meta($agency_id, 'agency_website', true));


$agency_city='';
$agency_city_array     =   get_the_terms($agency_id, 'city_agency');
if(isset($agency_city_array[0])){
    $agency_city         =   $agency_city_array[0]->name;
}

 $agency_area='';
$agency_area_array     =   get_the_terms($agency_id, 'area_agency');
if(isset($agency_area_array[0])){
    $agency_area          =   $agency_area_array[0]->name;
}

$agency_county='';
$agency_county_array     =   get_the_terms($agency_id, 'county_state_agency');
if(isset($agency_county_array[0])){
    $agency_county          =   $agency_county_array[0]->name;
}
          
$user_custom_picture    =   get_the_post_thumbnail_url($agency_id,'user_picture_profile');
$image_id               =   get_post_thumbnail_id($agency_id);

if($user_custom_picture==''){
    $user_custom_picture=get_theme_file_uri('/img/default_user.png');
}
$user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
?>

<div class="col-md-12 user_profile_div"> 
    <div id="profile_message"></div> 
    
    <?php
    if ( wp_is_mobile() ) {
        echo '<div class="add-estate profile-page profile-onprofile">';

            if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='pending'  ){
                echo '<div class="user_dashboard_app">'.esc_html__('Your account is pending approval. Please wait for admin to approve it. ','wpresidence').'</div>';
            }
            if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='disabled' ){
                echo '<div class="user_dashboard_app">'.esc_html__('Your account is disabled.','wpresidence').'</div>';
            }
               
        echo '</div>';

    }
    ?>
<div class="add-estate profile-page profile-onprofile row"> 
    
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php esc_html_e('Photo','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('Upload your profile photo.','wpresidence')?></div>
    </div>

    <div class="profile_div col-md-4" id="profile-div">
        <?php print '<img id="profile-image" src="'.esc_url($user_custom_picture).'" alt="'.esc_html__('user image','wpresidence').'" data-profileurl="'.esc_attr($user_custom_picture).'" data-smallprofileurl="'.esc_attr($image_id).'" >';?>

        <div id="upload-container">                 
            <div id="aaiu-upload-container">                 

                <button id="aaiu-uploader" class="wpresidence_button wpresidence_success"><?php esc_html_e('Upload  profile image.','wpresidence');?></button>
                <div id="aaiu-upload-imagelist">
                    <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
                </div>
            </div>  
        </div>
        <div id="imagelist-profile"></div>
        <span class="upload_explain"><?php esc_html_e('*minimum 500px x 500px','wpresidence');?></span>                    
    </div>
</div>


    
<div class="add-estate profile-page profile-onprofile row"> 
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php esc_html_e('Agency Details','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('Add your contact information.','wpresidence')?></div>
    </div>
          
    <div class="col-md-4">
        <p>
            <label for="agency_title"><?php esc_html_e('Agency Name','wpresidence');?></label>
            <input type="text" id="agency_title" class="form-control" value="<?php echo esc_html(stripslashes($agency_title));?>"  name="agency_title">
        </p>

      
        <p>
            <label for="useremail"><?php esc_html_e('Email','wpresidence');?></label>
            <input type="text" id="useremail"  class="form-control" value="<?php echo esc_html($agency_email);?>"  name="useremail">
        </p>
        
        <p>
            <label for="userskype"><?php esc_html_e('Skype', 'wpresidence'); ?></label>
            <input type="text" id="userskype" class="form-control" value="<?php echo esc_html($agency_skype); ?>"  name="userskype">
        </p>
        
        <p>
            <label for="website"><?php esc_html_e('Taxes','wpresidence');?></label>
            <input type="text" id="agency_taxes" name="agency_taxes" class="form-control" value="<?php echo esc_html($agency_taxes);?>"  name="website">
        </p>
        
        <p>
            <label for="website"><?php esc_html_e('Opening Hours','wpresidence');?></label>
            <input type="text" id="agency_opening_hours" name="agency_opening_hours" class="form-control" value="<?php echo esc_html($agency_opening_hours);?>"  name="website">
        </p>
    </div>  

    <div class="col-md-4">
        <p>
            <label for="userphone"><?php esc_html_e('Phone', 'wpresidence'); ?></label>
            <input type="text" id="userphone" class="form-control" value="<?php echo esc_html($agency_phone); ?>"  name="userphone">
        </p>
        
        <p>
            <label for="usermobile"><?php esc_html_e('Mobile', 'wpresidence'); ?></label>
            <input type="text" id="usermobile" class="form-control" value="<?php echo esc_html($agency_mobile); ?>"  name="usermobile">
        </p>
        
        <p>
            <label for="website"><?php esc_html_e('Languages','wpresidence');?></label>
            <input type="text" id="agency_languages" name="agency_languages" class="form-control" value="<?php echo esc_html($agency_languages);?>"  name="website">
        </p>
        
         <p>
            <label for="website"><?php esc_html_e('License ','wpresidence');?></label>
            <input type="text" id="agency_license" name="agency_license" class="form-control" value="<?php echo esc_html($agency_license);?>"  name="website">
        </p>

        <?php   wp_nonce_field( 'profile_ajax_nonce', 'security-profile' );   ?>
       
    </div>
</div>
                             
<div class="add-estate profile-page profile-onprofile row">       
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php esc_html_e('Agency Details','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('Add your social media information.','wpresidence')?></div>

    </div>
    <div class="col-md-4">
        <p>
            <label for="userfacebook"><?php esc_html_e('Facebook Url', 'wpresidence'); ?></label>
            <input type="text" id="userfacebook" class="form-control" value="<?php echo esc_html($agency_facebook); ?>"  name="userfacebook">
        </p>

        <p>
            <label for="usertwitter"><?php esc_html_e('Twitter Url', 'wpresidence'); ?></label>
            <input type="text" id="usertwitter" class="form-control" value="<?php echo esc_html($agency_twitter); ?>"  name="usertwitter">
        </p>

        <p>
            <label for="userlinkedin"><?php esc_html_e('Linkedin Url', 'wpresidence'); ?></label>
            <input type="text" id="userlinkedin" class="form-control"  value="<?php echo esc_html($agency_linkedin); ?>"  name="userlinkedin">
        </p>    
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="userinstagram"><?php esc_html_e('Instagram Url','wpresidence');?></label>
            <input type="text" id="userinstagram" class="form-control" value="<?php echo esc_html($agency_instagram);?>"  name="userinstagram">
        </p> 

        <p>
            <label for="userpinterest"><?php esc_html_e('Pinterest Url','wpresidence');?></label>
            <input type="text" id="userpinterest" class="form-control" value="<?php echo esc_html($agency_pinterest);?>"  name="userpinterest">
        </p> 

        <p>
            <label for="website"><?php esc_html_e('Website Url (without http)','wpresidence');?></label>
            <input type="text" id="agency_website" class="form-control" value="<?php echo esc_html($agency_website);?>"  name="website">
        </p>
                
    </div> 
</div>
    
    
<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php esc_html_e('Agency Area/Categories','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('What kind of listings do you handle?','wpresidence')?></div>
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="agency_city"><?php esc_html_e('Category','wpresidence');?></label>
       
        
        <?php 
            $agency_category_selected='';
            $agency_category_array            =   get_the_terms($agency_id, 'category_agency');
            if(isset($agency_category_array[0])){
                $agency_category_selected   =   $agency_category_array[0]->term_id;
            }
            $args=array(
                'class'       => 'select-submit2',
                'hide_empty'  => false,
                'selected'    => $agency_category_selected,
                'name'        => 'agency_category',
                'id'          => 'agency_category_submit',
                'orderby'     => 'NAME',
                'order'       => 'ASC',
                'show_option_none'   => esc_html__('None','wpresidence'),
                'taxonomy'    => 'category_agency',
                'hierarchical'=> true
            );
            wp_dropdown_categories( $args ); ?>
            
        </p>
    </div>
    
    <div class="col-md-4">
          <p>
            <label for="agency_city"><?php esc_html_e('Action Category','wpresidence');?></label>
           <?php
           $agency_action_selected='';
            $agency_action_array            =   get_the_terms($agency_id, 'action_category_agency');
            if(isset($agency_action_array[0])){
                $agency_action_selected   =   $agency_action_array[0]->term_id;
            }
            
            $args=array(
                'class'       => 'select-submit2',
                'hide_empty'  => false,
                'selected'    => $agency_action_selected,
                'name'        => 'agency_action',
                'id'          => 'agency_action_submit',
                'orderby'     => 'NAME',
                'order'       => 'ASC',
                'show_option_none'   => esc_html__('None','wpresidence'),
                'taxonomy'    => 'action_category_agency',
                'hierarchical'=> true
            );
            wp_dropdown_categories( $args ); ?>
           
        </p>
    </div>  
</div>

    
    
<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php esc_html_e('Agency Location','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('Add some information about your agency.','wpresidence')?></div>
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="agency_city"><?php esc_html_e('City','wpresidence');?></label>
            <input type="text" id="agency_city" class="form-control" value="<?php echo esc_html($agency_city);?>"  name="agency_city">
        </p>
        <p>
            <label for="agency_area"><?php esc_html_e('Area','wpresidence');?></label>
            <input type="text" id="agency_area" class="form-control" value="<?php echo esc_html($agency_area);?>"  name="agency_area">
        </p>
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="agency_county"><?php esc_html_e('State/County','wpresidence');?></label>
            <input type="text" id="agency_county" class="form-control" value="<?php echo esc_html($agency_county);?>"  name="agency_county">
        </p>  
    </div>
    
    
 

    <div class="col-md-8 col-md-push-4">
        
        <p>
            <label for="adress"><?php esc_html_e('Address','wpresidence');?></label>
            <input type="text" id="agency_address" class="form-control" value="<?php echo esc_html($agency_address);?>"  name="website">
        </p>
        
        <p>
            <label for="usertitle"><?php esc_html_e('Location','wpresidence');?></label>
            <div id="googleMapsubmit" ></div>   
            <input type="hidden" name="agency_lat" id="agency_lat"      value="<?php echo esc_html($agency_lat);?>">
            <input type="hidden" name="agency_long" id="agency_long"    value="<?php echo esc_html($agency_long);?>">
        </p>  
        
        <p class="fullp-button">
            <button id="google_agency_location"  class="wpresidence_button wpresidence_success"><?php esc_html_e('Place Pin with Agency Address','wpresidence');?></button>
        </p>
        
        <p>
            <label for="about_me"><?php esc_html_e('About Us','wpresidence');?></label>
            <textarea id="about_me" class="form-control" name="about_me"><?php echo esc_textarea($agency_description);?></textarea>
        </p>
        <p class="fullp-button">
            <button class="wpresidence_button" id="update_profile_agency"><?php esc_html_e('Update profile', 'wpresidence'); ?></button>
 
            <?php
            $ajax_nonce = wp_create_nonce( "wpestate_update_profile_nonce" );
            print'<input type="hidden" id="wpestate_update_profile_nonce" value="'.esc_html($ajax_nonce).'" />    ';
            
            $user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
            if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='publish'  ){
                print'<a href='.esc_url( get_permalink($user_agent_id)).' class="wpresidence_button view_public_profile">'.esc_html__('View public profile', 'wpresidence').'</a>';
            }
            ?>
            <button class="wpresidence_button" id="delete_profile"><?php esc_html_e('Delete profile', 'wpresidence'); ?></button>
        </p>
  
    </div>
    
            
</div>
      
<?php   get_template_part('templates/change_pass_template'); ?>
</div>