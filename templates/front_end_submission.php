<?php 
global $submit_title;
global $submit_description;
global $prop_category;
global $prop_action_category;       
global $property_city;      
global $property_area;
global $property_address;
global $property_county;
global $property_zip;
global $property_state;
global $country_selected; 
global $property_status; 
global $property_price; 
global $property_label; 
global $property_label_before; 
global $property_size; 
global $property_lot_size; 
global $property_year;
global $property_rooms;    
global $property_bedrooms;      
global $property_bathrooms; 
global $option_video; 
global $embed_video_id; 
global $virtual_tour;
global $property_latitude; 
global $property_longitude;
global $google_view_check; 
global $prop_featured_check;
global $google_camera_angle;  
global $action;
global $edit_id;
global $wpestate_show_err;
global $feature_list_array;
global $prop_category_selected;
global $prop_action_category_selected;
global $userID;
global $user_pack;
global $prop_featured;                
global $current_user;
global $custom_fields_array;
global $option_slider;
global $property_has_subunits;
global $property_subunits_list;
global $all_submission_fields;
global $wpestate_submission_page_fields;
//kul
$parent_userID          =   wpestate_check_for_agency($userID);


$images_to_show     =   '';
$remaining_listings =   wpestate_get_remain_listing_user($parent_userID,$user_pack);

if($remaining_listings  === -1){
   $remaining_listings=11;
}
$paid_submission_status= esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );

    

if( !isset( $_GET['listing_edit'] ) && $paid_submission_status == 'membership' && $remaining_listings != -1 && $remaining_listings < 1 ) {
    print '<div class="user_profile_div"><h4>'.esc_html__('Your current package doesn\'t let you publish more properties! You need to upgrade your membership.','wpresidence' ).'</h4></div>';
}else{
      
    $mandatory_fields           =   ( wpresidence_get_option('wp_estate_mandatory_page_fields','') );
    if(is_array($mandatory_fields)){
        $mandatory_fields           =   array_map("wpestate_strip_array",$mandatory_fields);
    }
    if(is_array($mandatory_fields) && !empty($mandatory_fields) ){
        $all_mandatory_fields   =   wpestate_return_all_fields(1);
        
       
        print '<div class="submit_mandatory col-md-9">';
        esc_html_e('These fields are mandatory: Title','wpresidence');
            foreach ($mandatory_fields as  $key=>$value){
                print ', '.$all_mandatory_fields[$value];
            }
        print '</div>';
    }
             
                
?>


<form id="new_post" name="new_post" method="post" action="" enctype="multipart/form-data" class="add-estate">
       <?php wp_nonce_field( 'dashboard_property_front_action', 'dashboard_property_front_nonce'); ?>
       <?php
       
       if( esc_html ( wpresidence_get_option('wp_estate_paid_submission','') ) == 'yes' ){
         print '<br>'.esc_html__('This is a paid submission.The listing will be live after payment is received.','wpresidence');  
       }
        
       ?>
        </span> 
        
<div class="col-md-12 row_dasboard-prop-listing">
       <?php
       if($wpestate_show_err){
           print '<div class="alert alert-danger">'.$wpestate_show_err.'</div>';
       }
       ?>
</div>

    
    <div class="profile-page row">
             <?php
              if ( wp_is_mobile() ) { 
                     include( locate_template('templates/submit_templates/user_memebership_form.php') );
                     include( locate_template('templates/submit_templates/property_featured.php') );
                     include( locate_template('templates/submit_templates/property_description.php') );
                     include( locate_template('templates/submit_templates/property_categories.php') ); 
                     include( locate_template('templates/submit_templates/property_images.php') ); 
                     include( locate_template('templates/submit_templates/property_location.php' ) );
                     include( locate_template('templates/submit_templates/property_energy_effective.php' ));  
                     include( locate_template('templates/submit_templates/property_details.php') ); 
                     include( locate_template('templates/submit_templates/property_status.php') );  
                     include( locate_template('templates/submit_templates/property_amenities.php') );  
                     include( locate_template('templates/submit_templates/property_video.php' ) );
                     include( locate_template('templates/submit_templates/video_tour.php') );
                     include( locate_template('templates/submit_templates/property_subunits.php' ) );
            }else{
                    print '<div class="col-md-9 user_dashboard">';
                     include( locate_template('templates/submit_templates/property_description.php') ); 
                     include( locate_template('templates/submit_templates/property_categories.php') );
                     include( locate_template('templates/submit_templates/property_images.php') ); 
                     include( locate_template('templates/submit_templates/property_location.php') );
                     include( locate_template('templates/submit_templates/property_energy_effective.php') );
                     include( locate_template('templates/submit_templates/property_details.php') );
                     include( locate_template('templates/submit_templates/property_status.php') );  
                     include( locate_template('templates/submit_templates/property_amenities.php') );  
                     include( locate_template('templates/submit_templates/property_video.php') );
                     include( locate_template('templates/submit_templates/video_tour.php') );
                     include( locate_template('templates/submit_templates/property_subunits.php') );
                    print '</div>';

                    print '<div class="col-md-3 user_dashboard">';
                     include( locate_template('templates/submit_templates/user_memebership_form.php') ); 
                     include( locate_template('templates/submit_templates/property_featured.php') ); 
                    print '</div>';
                             
            }
            ?>
   

   <div class="col-md-12">
       <div class="col-md-3"></div>
       <div class="col-md-9">
            <input type="hidden" name="action" value="<?php print esc_html($action);?>">
            <div class="submit_form_row">
                <?php
                if($action=='edit'){ ?>
                    <input type="submit" class="wpresidence_button" id="form_submit_1" value="<?php esc_html_e('Save Changes', 'wpresidence') ?>" />
                <?php    
                }else{
                ?>
                   <input type="submit" class="wpresidence_button" id="form_submit_1" value="<?php esc_html_e('Add Property', 'wpresidence') ?>" />
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</div>
    
    
    </div><!-- end row--> 
       
    <input type="hidden" name="edit_id" value="<?php print intval($edit_id);?>">
    <input type="hidden" name="images_todelete" id="images_todelete" value="">
    <?php wp_nonce_field('submit_new_estate','new_estate'); ?>
</form>
<?php } // end check pack rights ?>