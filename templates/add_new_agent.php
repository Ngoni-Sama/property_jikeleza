<?php
$current_user           =   wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;
$agent_id               =   get_the_author_meta('user_agent_id',$userID);
$user_custom_picture    =   get_theme_file_uri('/img/default_user.png');
$user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
?>


<div class="col-md-12 user_profile_div"> 
    <div id="profile_message">
    </div> 
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
        <?php print '<img id="profile-image" src="'.esc_url($user_custom_picture).'" alt="'.esc_html__('user image','wpresidence').'" data-profileurl="'.esc_attr($user_custom_picture).'" data-smallprofileurl="" >';
        ?>

        <div id="upload-container">                 
            <div id="aaiu-upload-container">                 

                <button id="aaiu-uploader" class="wpresidence_button wpresidence_success"><?php esc_html_e('Upload  profile image.','wpresidence');?></button>
                <div id="aaiu-upload-imagelist">
                    <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
                </div>
            </div>  
        </div>
        <span class="upload_explain"><?php esc_html_e('*minimum 500px x 500px','wpresidence');?></span>                    
    </div>
</div>

<div class="add-estate profile-page profile-onprofile row"> 
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php esc_html_e('User Details','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('Add your contact information.','wpresidence')?></div>

    </div>
          
    <div class="col-md-4">
        <p>
            <label for="firstname"><?php esc_html_e('First Name','wpresidence');?></label>
            <input type="text" id="firstname" class="form-control" value="<?php echo esc_html($first_name);?>"  name="firstname">
        </p>

        <p>
            <label for="secondname"><?php esc_html_e('Last Name','wpresidence');?></label>
            <input type="text" id="secondname" class="form-control" value="<?php echo esc_html($last_name);?>"  name="firstname">
        </p>
        <p>
            <label for="useremail"><?php esc_html_e('Email','wpresidence');?></label>
            <input type="text" id="useremail"  class="form-control" value="<?php echo esc_html($user_email);?>"  name="useremail">
        </p>
    </div>  

    <div class="col-md-4">
        <p>
            <label for="userphone"><?php esc_html_e('Phone', 'wpresidence'); ?></label>
            <input type="text" id="userphone" class="form-control" value="<?php echo esc_html($user_phone); ?>"  name="userphone">
        </p>
        <p>
            <label for="usermobile"><?php esc_html_e('Mobile', 'wpresidence'); ?></label>
            <input type="text" id="usermobile" class="form-control" value="<?php echo esc_html($user_mobile); ?>"  name="usermobile">
        </p>

        <p>
            <label for="userskype"><?php esc_html_e('Skype', 'wpresidence'); ?></label>
            <input type="text" id="userskype" class="form-control" value="<?php echo esc_html($user_skype); ?>"  name="userskype">
        </p>
        <?php   wp_nonce_field( 'profile_ajax_nonce', 'security-profile' );   ?>
       
    </div>
</div>
                             
<div class="add-estate profile-page profile-onprofile row">       
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php esc_html_e('User Details','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('Add your social media information.','wpresidence')?></div>

    </div>
    <div class="col-md-4">
        <p>
            <label for="userfacebook"><?php esc_html_e('Facebook Url', 'wpresidence'); ?></label>
            <input type="text" id="userfacebook" class="form-control" value="<?php echo esc_html($facebook); ?>"  name="userfacebook">
        </p>

        <p>
            <label for="usertwitter"><?php esc_html_e('Twitter Url', 'wpresidence'); ?></label>
            <input type="text" id="usertwitter" class="form-control" value="<?php echo esc_html($twitter); ?>"  name="usertwitter">
        </p>

        <p>
            <label for="userlinkedin"><?php esc_html_e('Linkedin Url', 'wpresidence'); ?></label>
            <input type="text" id="userlinkedin" class="form-control"  value="<?php echo esc_html($linkedin); ?>"  name="userlinkedin">
        </p>
    </div>
    <div class="col-md-4">
        <p>
            <label for="userinstagram"><?php esc_html_e('Instagram Url','wpresidence');?></label>
            <input type="text" id="userinstagram" class="form-control" value="<?php echo esc_html($userinstagram);?>"  name="userinstagram">
        </p> 

        <p>
            <label for="userpinterest"><?php esc_html_e('Pinterest Url','wpresidence');?></label>
            <input type="text" id="userpinterest" class="form-control" value="<?php echo esc_html($pinterest);?>"  name="userpinterest">
        </p> 

        <p>
            <label for="website"><?php esc_html_e('Website Url (without http)','wpresidence');?></label>
            <input type="text" id="website" class="form-control" value="<?php echo esc_html($website);?>"  name="website">
        </p>
    </div> 
</div>

    
        
<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php esc_html_e('Agent Area/Categories','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('What kind of listings do you handle?','wpresidence')?></div>
    </div>
    
    <div class="col-md-4 ">
        <p>
            <label for="agent_city"><?php esc_html_e('Category','wpresidence');?></label>
       
        
        <?php 
            $agent_category_selected='';
            $agent_category_array            =   get_the_terms($agent_id, 'property_category_agent');
            if(isset($agent_category_array[0])){
                $agent_category_selected   =   $agent_category_array[0]->term_id;
            }
            $args=array(
                'class'       => 'select-submit2',
                'hide_empty'  => false,
                'selected'    => $agent_category_selected,
                'name'        => 'agent_category_submit',
                'id'          => 'agent_category_submit',
                'orderby'     => 'NAME',
                'order'       => 'ASC',
                'show_option_none'   => esc_html__('None','wpresidence'),
                'taxonomy'    => 'property_category_agent',
                'hierarchical'=> true
            );
            wp_dropdown_categories( $args ); ?>
            
        </p>
    </div>
    
    <div class="col-md-4 ">
          <p>
            <label for="agent_city"><?php esc_html_e('Action Category','wpresidence');?></label>
           <?php
           $agent_action_selected='';
            $agent_action_array            =   get_the_terms($agent_id, 'property_action_category_agent');
            if(isset($agent_action_array[0])){
                $agent_action_selected   =   $agent_action_array[0]->term_id;
            }
            
            $args=array(
                'class'       => 'select-submit2',
                'hide_empty'  => false,
                'selected'    => $agent_action_selected,
                'name'        => 'agent_action_submit',
                'id'          => 'agent_action_submit',
                'orderby'     => 'NAME',
                'order'       => 'ASC',
                'show_option_none'   => esc_html__('None','wpresidence'),
                'taxonomy'    => 'property_action_category_agent',
                'hierarchical'=> true
            );
            wp_dropdown_categories( $args ); ?>
           
        </p>
    </div>
    
</div>



<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php esc_html_e('Agent Custom Data','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('Any custom parameters for agent','wpresidence')?></div>
    </div>

	<div class="col-md-12">
		<input type="button" class="wpresidence_button" value="<?php esc_html_e('Add Custom Field','wpresidence');?>" />
	</div>
	
    <div class="col-md-4 ">
        <p>
            <label for="user_custom_param"><?php esc_html_e('User Param 1','wpresidence');?></label>
            <input type="text" id="agent_custom_data" class="form-control" value="<?php echo esc_html($agent_custom_data);?>"  name="agent_custom_data">
        </p>
    </div>
      
</div>


        
<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php esc_html_e('Location','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('In what area are your properties','wpresidence')?></div>
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="agent_city"><?php esc_html_e('City','wpresidence');?></label>
            <input type="text" id="agent_city" class="form-control" value="<?php echo esc_html($agent_city);?>"  name="agent_city">
        </p>
        <p>
            <label for="agent_area"><?php esc_html_e('Area','wpresidence');?></label>
            <input type="text" id="agent_area" class="form-control" value="<?php echo esc_html($agent_area);?>"  name="agent_area">
        </p>
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="agent_county"><?php esc_html_e('State/County','wpresidence');?></label>
            <input type="text" id="agent_county" class="form-control" value="<?php echo esc_html($agent_county);?>"  name="agent_county">
        </p>  
    </div>
</div>
    
<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php esc_html_e('User Details','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('Add some information about yourself.','wpresidence')?></div>
    </div>
    <div class="col-md-8">
         <p>
            <label for="usertitle"><?php esc_html_e('Title/Position','wpresidence');?></label>
            <input type="text" id="usertitle" class="form-control" value="<?php echo esc_html($user_title);?>"  name="usertitle">
        </p>

         <p>
            <label for="about_me"><?php esc_html_e('About Me','wpresidence');?></label>
            <textarea id="about_me" class="form-control" name="about_me"><?php echo esc_textarea($about_me);?></textarea>
        </p>
        <p class="fullp-button">
            <button class="wpresidence_button" id="update_profile"><?php esc_html_e('Update profile', 'wpresidence'); ?></button>
            <button class="wpresidence_button" id="delete_profile"><?php esc_html_e('Delete profile', 'wpresidence'); ?></button>
            <?php
            $ajax_nonce = wp_create_nonce( "wpestate_update_profile_nonce" );
            print'<input type="hidden" id="wpestate_update_profile_nonce" value="'.esc_html($ajax_nonce).'" />    ';
            
            ?>
        </p>
    </div>
    
            
</div>
      
<?php   include( locate_template('templates/change_pass_template.php ') ); ?>
</div>