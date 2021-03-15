<?php
global $listing_edit;
global $is_edit;
$current_user = wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;
$agent_id               =   get_the_author_meta('user_agent_id',$userID);
$user_custom_picture    =   get_theme_file_uri('/img/default_user.png');
$agent_first_name       = '';
$agent_last_name        = '';
$agent_skype            = '';
$agent_phone            = '';
$agent_mobile           = '';
$agent_custom_data      = '';
$agent_email            = '';
$agent_posit            = '';
$agent_custom_picture   = '';
$agent_facebook         = '';
$agent_twitter          = '';
$agent_linkedin         = '';
$agent_pinterest        = '';
$agent_instagram        = '';
$agent_description      = '';  
$agent_website          = '';
$agent_category_selected= '';
$agent_action_selected  = '';
$agent_city             = '';
$agent_area             = '';
$agent_county           = '';
$agent_member           = '';
$user_to_edit           = '';
        
  
$agent_thumb    =   get_theme_file_uri('/img/default_user.png');     
if($listing_edit!=0){
   
    $user_to_edit       =   get_post_meta($listing_edit, 'user_meda_id',true );
    $user_for_agent     =   get_user_by('ID',$user_to_edit);
    $agent_first_name   =   get_post_meta( $listing_edit, 'first_name', true ) ;
    $agent_last_name    =   get_post_meta( $listing_edit, 'last_name',  true) ;
    $agent_phone        =   get_post_meta($listing_edit, 'agent_phone', true);
    $agent_skype        =   get_post_meta($listing_edit, 'agent_skype', true);
    $agent_posit        =   get_post_meta($listing_edit, 'agent_position', true);    
    $agent_mobile       =   get_post_meta($listing_edit, 'agent_mobile', true);
    $agent_custom_data  =   get_post_meta($listing_edit, 'agent_custom_data', true);	
    $agent_email        =   get_post_meta($listing_edit, 'agent_email', true);
    $agent_facebook     =   get_post_meta( $listing_edit, 'agent_facebook' , true) ;
    $agent_twitter      =   get_post_meta( $listing_edit, 'agent_twitter' , true) ;
    $agent_linkedin     =   get_post_meta( $listing_edit, 'agent_linkedin' , true) ;
    $agent_pinterest    =   get_post_meta( $listing_edit, 'agent_pinterest' , true) ;
    $agent_instagram    =   get_post_meta( $listing_edit, 'agent_instagram' , true) ;
    $agent_description  =   get_post_field('post_content', $listing_edit);
    $agent_website      =   get_post_meta( $listing_edit, 'agent_website' , true) ;
    $agent_member       =   get_post_meta( $listing_edit, 'agent_member' , true) ;
    
    $agent_category_selected    =   '';
    $agent_category_array       =   get_the_terms($listing_edit, 'property_category_agent');
    if(isset($agent_category_array[0])){
      $agent_category_selected   =   $agent_category_array[0]->term_id;
    }
    
    $agent_action_selected      =   '';
    $agent_action_array         =   get_the_terms($listing_edit, 'property_action_category_agent');
    if(isset($agent_action_array[0])){
        $agent_action_selected   =   $agent_action_array[0]->term_id;
    }

    $agent_city='';
    $agent_city_array     =   get_the_terms($listing_edit, 'property_city_agent');
    if(isset($agent_city_array[0])){
        $agent_city         =   $agent_city_array[0]->name;
    }

     $agent_area='';
    $agent_area_array     =   get_the_terms($listing_edit, 'property_area_agent');
    if(isset($agent_area_array[0])){
        $agent_area          =   $agent_area_array[0]->name;
    }

    $agent_county='';
    $agent_county_array     =   get_the_terms($listing_edit, 'property_county_state_agent');
    if(isset($agent_county_array[0])){
        $agent_county          =   $agent_county_array[0]->name;
    }

    $agent_thumb        =  wp_get_attachment_image_src( get_post_thumbnail_id($listing_edit ),'property_listings' );  
    
    if(isset($agent_thumb[0])){
        $agent_thumb    =   $agent_thumb[0];
    }
 
    if($agent_thumb==''){
        $agent_thumb    =   get_theme_file_uri('/img/default_user.png');
    }    
}
$user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
?>

 
<div class="col-md-12 user_profile_div"> 
    <div id="profile_message"></div> 
    
    <?php
    if ( wp_is_mobile() ) {
        print '<div class="add-estate profile-page profile-onprofile">';

            if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='pending'  ){
                print '<div class="user_dashboard_app">'.esc_html__('Your account is pending approval. Please wait for admin to approve it. ','wpresidence').'</div>';
            }
            if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='disabled' ){
                print '<div class="user_dashboard_app">'.esc_html__('Your account is disabled.','wpresidence').'</div>';
            }
               
        print '</div>';

    }
    ?>
<div class="add-estate profile-page profile-onprofile row"> 
    
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php esc_html_e('Photo','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('Upload your profile photo.','wpresidence')?></div>
    </div>

    <div class="profile_div col-md-4" id="profile-div">
        <?php print '<img id="profile-image" src="'.esc_url($agent_thumb).'" alt="'.esc_html__('user image','wpresidence').'" data-profileurl="'.esc_url($agent_thumb).'" data-smallprofileurl="" >';
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
        <div class="user_details_row"><?php esc_html_e('Agent Details','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('Add your contact information.','wpresidence')?></div>

    </div>
    
    <div class="col-md-8">
        <?php if( $is_edit !=1) { ?>
        <p>
            <label for="firstname"><?php esc_html_e('Agent Username','wpresidence');?></label>
            <input type="text" id="agent_username" class="form-control" value=""  name="agent_username">
        </p>
        <?php
        
        }else{
            print '<p style="height:50px;">'.esc_html__('Username:','wpresidence').' '.esc_html($user_for_agent->user_login).' '.esc_html__('is not editable','wpresidence').'</p>';
        } 
        ?>
    </div>
    
    
    <div class="col-md-4 col-md-push-4">
        <?php if( $is_edit !=1){ ?>
        <p>
            <label for="firstname"><?php esc_html_e('Agent Password','wpresidence');?></label>
            <input type="text" id="agent_password" class="form-control" value=""  name="agent_password">
        </p>
        <?php } ?>
        
        <?php
        if ( wp_is_mobile() ) {?>
            <p>
            <label for="firstname"><?php esc_html_e('Re-type Password','wpresidence');?></label>
            <input type="text" id="agent_repassword" class="form-control" value=""  name="agent_repassword">
        </p>
        <?php  }?>
        
        <p>
            <label for="firstname"><?php esc_html_e('First Name','wpresidence');?></label>
            <input type="text" id="firstname" class="form-control" value="<?php print esc_html($agent_first_name);?>"  name="firstname">
        </p>

        <p>
            <label for="secondname"><?php esc_html_e('Last Name','wpresidence');?></label>
            <input type="text" id="secondname" class="form-control" value="<?php print esc_html($agent_last_name);?>"  name="firstname">
        </p>
        
        <p>
            <label for="useremail"><?php esc_html_e('Email','wpresidence');?></label>
            <input type="text" id="useremail"  class="form-control" value="<?php print esc_html($agent_email);?>"  name="useremail">
        </p>
        
        <p>
            <label for="agent_member"><?php esc_html_e('Member of','wpresidence');?></label>
            <input type="text" id="agent_member"  class="form-control" value="<?php print esc_html($agent_member);?>"  name="agent_member">
        </p>
    </div>  

    <div class="col-md-4 col-md-push-4">
        <?php if( $is_edit !=1 && !wp_is_mobile()){ ?>
           <p>
                <label for="firstname"><?php esc_html_e('Re-type Password','wpresidence');?></label>
                <input type="text" id="agent_repassword" class="form-control" value=""  name="agent_repassword">
            </p>
        <?php } ?>
        
        <p>
            <label for="userphone"><?php esc_html_e('Phone', 'wpresidence'); ?></label>
            <input type="text" id="userphone" class="form-control" value="<?php print esc_html($agent_phone);?>"  name="userphone">
        </p>
      
        <p>
            <label for="usermobile"><?php esc_html_e('Mobile', 'wpresidence'); ?></label>
            <input type="text" id="usermobile" class="form-control" value="<?php print esc_html($agent_mobile);?>"  name="usermobile">
        </p>

        <p>
            <label for="userskype"><?php esc_html_e('Skype', 'wpresidence'); ?></label>
            <input type="text" id="userskype" class="form-control" value="<?php print esc_html($agent_skype);?>"  name="userskype">
        </p>
        <?php   wp_nonce_field( 'profile_ajax_nonce', 'security-profile' );   ?>
       
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
            <input type="text" id="userfacebook" class="form-control" value="<?php print esc_html($agent_facebook);?>"  name="userfacebook">
        </p>

        <p>
            <label for="usertwitter"><?php esc_html_e('Twitter Url', 'wpresidence'); ?></label>
            <input type="text" id="usertwitter" class="form-control" value="<?php print esc_html($agent_twitter);?>"  name="usertwitter">
        </p>

        <p>
            <label for="userlinkedin"><?php esc_html_e('Linkedin Url', 'wpresidence'); ?></label>
            <input type="text" id="userlinkedin" class="form-control"  value="<?php print esc_html($agent_linkedin);?>"  name="userlinkedin">
        </p>
    </div>
    <div class="col-md-4">
        <p>
            <label for="userinstagram"><?php esc_html_e('Instagram Url','wpresidence');?></label>
            <input type="text" id="userinstagram" class="form-control" value="<?php print esc_html($agent_instagram);?>"  name="userinstagram">
        </p> 

        <p>
            <label for="userpinterest"><?php esc_html_e('Pinterest Url','wpresidence');?></label>
            <input type="text" id="userpinterest" class="form-control" value="<?php print esc_html($agent_pinterest);?>"  name="userpinterest">
        </p> 

        <p>
            <label for="website"><?php esc_html_e('Website Url (without http)','wpresidence');?></label>
            <input type="text" id="website" class="form-control" value="<?php print esc_html($agent_website);?>"  name="website">
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
						<input type="text"  class="form-control agent_custom_value" value=""  name="agent_custom_value[]">
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
							<input type="text"  class="form-control agent_custom_label" value="<?php print esc_html($agent_custom_data[$i]['label']);?>"   >
						</p>
					</div>
					<div class="col-md-5">
						<p>
							<label for="agent_custom_value"><?php esc_html_e('Parameter Value','wpresidence');?></label>
							<input type="text"  class="form-control agent_custom_value" value="<?php print esc_html($agent_custom_data[$i]['value']);?>"  name="agent_custom_value[]">
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
        <div class="user_details_row"><?php esc_html_e('Location','wpresidence');?></div> 
        <div class="user_profile_explain"><?php esc_html_e('In what area are your properties','wpresidence')?></div>
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="agent_city"><?php esc_html_e('City','wpresidence');?></label>
            <input type="text" id="agent_city" class="form-control" value="<?php print esc_html($agent_city);?>"  name="agent_city">
        </p>
        <p>
            <label for="agent_area"><?php esc_html_e('Area','wpresidence');?></label>
            <input type="text" id="agent_area" class="form-control" value="<?php print esc_html($agent_area);?>"  name="agent_area">
        </p>
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="agent_county"><?php esc_html_e('State/County','wpresidence');?></label>
            <input type="text" id="agent_county" class="form-control" value="<?php print esc_html($agent_county);?>"  name="agent_county">
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
            <input type="text" id="usertitle" class="form-control" value="<?php print esc_html($agent_posit);?>"  name="usertitle">
        </p>

         <p>
            <label for="about_me"><?php esc_html_e('About Me','wpresidence');?></label>
            <textarea id="about_me" class="form-control" name="about_me"><?php print esc_html($agent_description);?></textarea>
        </p>
        <p class="fullp-button">
            <button class="wpresidence_button" id="register_agent">
                <?php 
                if($is_edit!=1){
                    esc_html_e('Add New Agent', 'wpresidence');
                }else{
                    esc_html_e('Edit Agent', 'wpresidence'); 
                }
                 $ajax_nonce = wp_create_nonce( "wpestate_register_agent_nonce" );
                print'<input type="hidden" id="wpestate_register_agent_nonce" value="'.esc_html($ajax_nonce).'" />    ';
                ?>
            </button>
            

            <input type="hidden" id="is_agent_edit" value="<?php print esc_html($is_edit);?>">
            <input type="hidden" id="user_id"       value="<?php print esc_html($user_to_edit);?>">
            <input type="hidden" id="agent_id"      value="<?php print esc_html($listing_edit);?>">

        </p>
    </div>
             
</div>

</div>