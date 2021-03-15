<?php
$current_user = wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;
$agent_id               =   get_the_author_meta('user_agent_id',$userID);
$user_email             =   get_the_author_meta( 'user_email' , $userID );
$user_title             =   get_the_author_meta( 'title' , $userID );
$user_small_picture     =   get_the_author_meta( 'small_custom_picture' , $userID );
$image_id               =   get_the_author_meta( 'small_custom_picture',$userID); 
$user_custom_picture    =   get_the_post_thumbnail_url($agent_id,'user_picture_profile');
$agent_id              =   get_the_author_meta('user_agent_id',$userID);
$first_name            =   esc_html(get_post_meta($agent_id, 'first_name', true));
$last_name             =   esc_html(get_post_meta($agent_id, 'last_name', true));
$agent_title           =   get_the_title($agent_id);
$agent_description     =   get_post_field('post_content', $agent_id);
$agent_email           =   esc_html(get_post_meta($agent_id, 'agent_email', true));
$agent_phone           =   esc_html(get_post_meta($agent_id, 'agent_phone', true));
$agent_mobile          =   esc_html(get_post_meta($agent_id, 'agent_mobile', true));
$agent_skype           =   esc_html(get_post_meta($agent_id, 'agent_skype', true));
$agent_facebook        =   esc_html(get_post_meta($agent_id, 'agent_facebook', true));
$agent_twitter         =   esc_html(get_post_meta($agent_id, 'agent_twitter', true));
$agent_linkedin        =   esc_html(get_post_meta($agent_id, 'agent_linkedin', true));
$agent_pinterest       =   esc_html(get_post_meta($agent_id, 'agent_pinterest', true));
$agent_instagram       =   esc_html(get_post_meta($agent_id, 'agent_instagram', true));
$agent_address         =   esc_html(get_post_meta($agent_id, 'agent_address', true));
$agent_languages       =   esc_html(get_post_meta($agent_id, 'agent_languages', true));     
$agent_license         =   esc_html(get_post_meta($agent_id, 'agent_license', true));
$agent_taxes           =   esc_html(get_post_meta($agent_id, 'agent_taxes', true));    
$agent_lat             =   esc_html(get_post_meta($agent_id, 'agent_lat', true));    
$agent_long            =   esc_html(get_post_meta($agent_id, 'agent_long', true));
$agent_website         =   esc_html(get_post_meta($agent_id, 'agent_website', true));
$agent_member          =   esc_html(get_post_meta($agent_id, 'agent_member', true));
$agent_position        =   esc_html(get_post_meta($agent_id, 'agent_position', true));
 $agent_custom_data       =   get_post_meta($agent_id, 'agent_custom_data', true);

 
$agent_city='';
$agent_city_array     =   get_the_terms($agent_id, 'property_city_agent');
if(isset($agent_city_array[0])){
    $agent_city         =   $agent_city_array[0]->name;
}

$agent_area='';
$agent_area_array     =   get_the_terms($agent_id, 'property_area_agent');
if(isset($agent_area_array[0])){
    $agent_area          =   $agent_area_array[0]->name;
}

$agent_county='';
$agent_county_array     =   get_the_terms($agent_id, 'property_county_state_agent');
if(isset($agent_county_array[0])){
    $agent_county          =   $agent_county_array[0]->name;
}


if($user_custom_picture==''){
    $user_custom_picture=get_theme_file_uri('/img/default_user.png');
}
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
        <div class="user_details_row"><?php esc_html_e('Agent Details','wpresidence');?></div> 
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
        
        <p>
            <label for="agent_member"><?php esc_html_e('Member of','wpresidence');?></label>
            <input type="text" id="agent_member"  class="form-control" value="<?php echo esc_html($agent_member);?>"  name="agent_member">
        </p>
    </div>  

    <div class="col-md-4">
        <p>
            <label for="userphone"><?php esc_html_e('Phone', 'wpresidence'); ?></label>
            <input type="text" id="userphone" class="form-control" value="<?php echo esc_html($agent_phone); ?>"  name="userphone">
        </p>
        <p>
            <label for="usermobile"><?php esc_html_e('Mobile', 'wpresidence'); ?></label>
            <input type="text" id="usermobile" class="form-control" value="<?php echo esc_html($agent_mobile); ?>"  name="usermobile">
        </p>

        <p>
            <label for="userskype"><?php esc_html_e('Skype', 'wpresidence'); ?></label>
            <input type="text" id="userskype" class="form-control" value="<?php echo esc_html($agent_skype); ?>"  name="userskype">
        </p>
        <?php   wp_nonce_field( 'profile_ajax_nonce', 'security-profile' );   ?>
       
    </div>
</div>


<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php esc_html_e('Agent Custom Data','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('Any custom parameters for agent','wpresidence')?></div>
    </div>
   
   
   <div class="col-md-8 add_custom_data_cont">
		<div class="row">
			<button type="button" class="wpresidence_button add_custom_parameter"  ><?php esc_html_e('Add Custom Field','wpresidence');?></button>
 
		</div>
		
		
		<div class="row single_parameter_row cliche_row">
				<div class="col-md-5">
					<p>
						<label for="agent_custom_label"><?php esc_html_e('Parameter Label','wpresidence');?></label>
						<input type="text"  class="form-control agent_custom_label" value=""  name="agent_custom_label[]">
					</p>
				</div>
				<div class="col-md-5">
					<p>
						<label for="agent_custom_value"><?php esc_html_e('Parameter Value','wpresidence');?></label>
						<input type="text"   class="form-control agent_custom_value" value=""  name="agent_custom_value[]">
					</p>
				</div>
				<div class="col-md-2">
					<p>
						<br/>
						<button type="button" class="wpresidence_button remove_parameter_button"  ><?php esc_html_e('Remove','wpresidence');?></button>
					</p>
				</div>
			
			</div>
		
		<?php
	 
		if( is_array( $agent_custom_data) && count( $agent_custom_data )  > 0   ){
			for( $i=0; $i<count( $agent_custom_data ); $i++ ){
				?>
				
				<div class="row single_parameter_row ">
					<div class="col-md-5">
						<p>
							<label for="agent_custom_label"><?php esc_html_e('Parameter Label','wpresidence');?></label>
							<input type="text"   class="form-control agent_custom_label" value="<?php echo esc_html($agent_custom_data[$i]['label']);?>"   >
						</p>
					</div>
					<div class="col-md-5">
						<p>
							<label for="agent_custom_value"><?php esc_html_e('Parameter Value','wpresidence');?></label>
							<input type="text"   class="form-control agent_custom_value" value="<?php echo esc_html($agent_custom_data[$i]['value']);?>"  name="agent_custom_value[]">
						</p>
					</div>
					<div class="col-md-2">
						<p>
							<br/>
							<button type="button" class="wpresidence_button remove_parameter_button"  ><?php esc_html_e('Remove','wpresidence');?></button>
						</p>
					</div>
				
				</div>
				
				<?php
			}			
		} 
		?>

   </div> 
</div>
                             
<div class="add-estate profile-page profile-onprofile row">       
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php esc_html_e('Agent Details','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('Add your social media information.','wpresidence')?></div>

    </div>
    <div class="col-md-4">
        <p>
            <label for="userfacebook"><?php esc_html_e('Facebook Url', 'wpresidence'); ?></label>
            <input type="text" id="userfacebook" class="form-control" value="<?php echo esc_html($agent_facebook); ?>"  name="userfacebook">
        </p>

        <p>
            <label for="usertwitter"><?php esc_html_e('Twitter Url', 'wpresidence'); ?></label>
            <input type="text" id="usertwitter" class="form-control" value="<?php echo esc_html($agent_twitter); ?>"  name="usertwitter">
        </p>

        <p>
            <label for="userlinkedin"><?php esc_html_e('Linkedin Url', 'wpresidence'); ?></label>
            <input type="text" id="userlinkedin" class="form-control"  value="<?php echo esc_html($agent_linkedin); ?>"  name="userlinkedin">
        </p>
    </div>
    <div class="col-md-4">
        <p>
            <label for="userinstagram"><?php esc_html_e('Instagram Url','wpresidence');?></label>
            <input type="text" id="userinstagram" class="form-control" value="<?php echo esc_html($agent_instagram);?>"  name="userinstagram">
        </p> 

        <p>
            <label for="userpinterest"><?php esc_html_e('Pinterest Url','wpresidence');?></label>
            <input type="text" id="userpinterest" class="form-control" value="<?php echo esc_html($agent_pinterest);?>"  name="userpinterest">
        </p> 

        <p>
            <label for="website"><?php esc_html_e('Website Url (without http)','wpresidence');?></label>
            <input type="text" id="website" class="form-control" value="<?php echo esc_html($agent_website);?>"  name="website">
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
        <div class="user_details_row"><?php esc_html_e('Agent Details','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('Add some information about yourself.','wpresidence')?></div>
    </div>
    <div class="col-md-8">
         <p>
            <label for="usertitle"><?php esc_html_e('Title/Position','wpresidence');?></label>
            <input type="text" id="usertitle" class="form-control" value="<?php echo esc_html($agent_position);?>"  name="usertitle">
        </p>

         <p>
            <label for="about_me"><?php esc_html_e('About Me','wpresidence');?></label>
            <textarea id="about_me" class="form-control" name="about_me"><?php echo esc_textarea($agent_description);?></textarea>
        </p>
        <p class="fullp-button">
            <button class="wpresidence_button" id="update_profile"><?php esc_html_e('Update profile', 'wpresidence'); ?></button>

            <?php
            $ajax_nonce = wp_create_nonce( "wpestate_update_profile_nonce" );
            print'<input type="hidden" id="wpestate_update_profile_nonce" value="'.esc_html($ajax_nonce).'" />    ';
            
            $user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
            if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='publish'  ){
                print'<a href='. esc_url ( get_permalink($user_agent_id) ).' class="wpresidence_button view_public_profile">'.esc_html__('View public profile', 'wpresidence').'</a>';
            }
            ?>
            
            <button class="wpresidence_button" id="delete_profile"><?php esc_html_e('Delete profile', 'wpresidence'); ?></button>
        </p>
        
    </div>
    
            
</div>
      
<?php   get_template_part('templates/change_pass_template'); ?>
</div>