<?php
// Template Name: User Dashboard Submit
// Wp Estate Pack
wpestate_dashboard_header_permissions();

$current_user           =   wp_get_current_user();
$userID                 =   $current_user->ID;
$user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
$status                 =   get_post_status($user_agent_id);

if( $status==='pending' || $status==='disabled' ){
    wp_redirect(  esc_url(home_url('/')));exit;
}

add_filter('wp_kses_allowed_html', 'wpestate_add_allowed_tags');

$user_pack                      =   get_the_author_meta( 'package_id' , $userID );
$allowed_html                   =   array();
$wpestate_submission_page_fields=   wpresidence_get_option('wp_estate_submission_page_fields','');
$all_submission_fields          =   wpestate_return_all_fields();
$agent_list                     =   (array)get_user_meta($userID,'current_agent_list',true);

global $wpestate_show_err;
global $wpestate_submission_page_fields;
global $all_submission_fields;

$property_features              =   get_terms( array(
                                    'taxonomy' => 'property_features',
                                    'hide_empty' => false,
                                ));
$property_status_array          =   get_terms( array(
                                    'taxonomy' => 'property_status',
                                    'hide_empty' => false,
                                ));
$errors=array();
    
    
$allowed_html_desc=array(
    'a' => array(
        'href' => array(),
        'title' => array()
    ),
    'br'        =>  array(),
    'em'        =>  array(),
    'strong'    =>  array(),
    'ul'        =>  array('li'),
    'li'        =>  array(),
    'code'      =>  array(),
    'ol'        =>  array('li'),
    'del'       =>  array(
                    'datetime'=>array()
                    ),
    'blockquote'=> array(),
    'ins'       =>  array(),
    
    
);

if( isset( $_GET['listing_edit'] ) && is_numeric( $_GET['listing_edit'] ) ){
    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// If we have edit load current values
    ///////////////////////////////////////////////////////////////////////////////////////////
    $edit_id                        =  intval ($_GET['listing_edit']);
  
    $the_post= get_post( $edit_id); 
    if( $current_user->ID != $the_post->post_author &&  !in_array($the_post->post_author , $agent_list)   ) {
        exit('You don\'t have the rights to edit this');
    }
    $wpestate_show_err              =   '';
    $action                         =   'edit';
    $submit_title                   =   get_the_title($edit_id);
    $submit_description             =   get_post_field('post_content', $edit_id);
    
   
  
    $prop_category_array            =   get_the_terms($edit_id, 'property_category');
    if(isset($prop_category_array[0])){
         $prop_category_selected   =   $prop_category_array[0]->term_id;
    }
    
    $prop_action_category_array     =   get_the_terms($edit_id, 'property_action_category');
    if(isset($prop_action_category_array[0])){
        $prop_action_category_selected           =   $prop_action_category_array[0]->term_id;
    }
   
    
    $property_city_array            =   get_the_terms($edit_id, 'property_city');
    if(isset($property_city_array [0])){
          $property_city                  =   $property_city_array [0]->name;
    }
    
    $property_area_array            =   get_the_terms($edit_id, 'property_area');
    if(isset($property_area_array [0])){
        $property_area                  =   $property_area_array [0]->name;
    }
    
    $property_county_state_array            =   get_the_terms($edit_id, 'property_county_state');
    if(isset($property_county_state_array [0])){
        $property_county_state                 =   $property_county_state_array [0]->name;
    }
  
    $property_address               =   esc_html( get_post_meta($edit_id, 'property_address', true) );
    $property_county                =   esc_html( get_post_meta($edit_id, 'property_county', true) );
    $property_zip                   =   esc_html( get_post_meta($edit_id, 'property_zip', true) );
    $country_selected               =   esc_html( get_post_meta($edit_id, 'property_country', true) );
 
    // energy effect
    $energy_class                      =   esc_html( get_post_meta($edit_id, 'energy_class', true) );
    $energy_index                      =   esc_html( get_post_meta($edit_id, 'energy_index', true) );
    // ee end
	
    $property_status                =   '';
    
    if(is_array($property_status_array)){
        foreach ($property_status_array as $key=>$term) {
            $property_status.='<option value="' . $term->name . '"';
            if( has_term( $term->name, 'property_status',$edit_id )){
                $property_status.='selected="selected"';
            }
            $property_status.='>' .stripslashes($term->name) . '</option>';
        }
    }

    $property_price                 =   floatval   ( get_post_meta($edit_id, 'property_price', true) );
    $property_label                 =   esc_html ( get_post_meta($edit_id, 'property_label', true) );  
    $property_label_before          =   esc_html ( get_post_meta($edit_id, 'property_label_before', true) );  
    $property_year_tax              =   floatval ( get_post_meta($edit_id, 'property_year_tax', true));
    $property_hoa                   =   floatval ( get_post_meta($edit_id, 'property_hoa', true));
    $property_size                  =   esc_html   ( get_post_meta($edit_id, 'property_size', true) ); 
    $owner_notes                    =   esc_html ( get_post_meta($edit_id, 'owner_notes', true) ); 
    $property_lot_size              =   esc_html   ( get_post_meta($edit_id, 'property_lot_size', true) );
    $property_rooms                 =   floatval   ( get_post_meta($edit_id, 'property_rooms', true) );
    $property_bedrooms              =   floatval   ( get_post_meta($edit_id, 'property_bedrooms', true) ); 
    $property_bathrooms             =   floatval   ( get_post_meta($edit_id, 'property_bathrooms', true) );
    $property_has_subunits          =   intval      (get_post_meta($edit_id, 'property_has_subunits', true)) ;
    $property_subunits_list         =   get_post_meta($edit_id, 'property_subunits_list', true); 
    $property_roofing               =   esc_html ( get_post_meta($edit_id, 'property_roofing', true) ); 
    $option_video                   =   '';
    $video_values                   =   array('vimeo', 'youtube');
    $video_type                     =   esc_html ( get_post_meta($edit_id, 'embed_video_type', true) ); 
    $google_camera_angle            =   intval   ( get_post_meta($edit_id, 'google_camera_angle', true) );
    
    $plan_title_array               =   get_post_meta($edit_id, 'plan_title', true);
    $plan_desc_array                =   get_post_meta($edit_id, 'plan_description', true) ;
    $plan_image_array               =   get_post_meta($edit_id, 'plan_image', true) ;
    $plan_size_array                =   get_post_meta($edit_id, 'plan_size', true) ;
    $plan_rooms_array               =   get_post_meta($edit_id, 'plan_rooms', true) ;
    $plan_bath_array                =   get_post_meta($edit_id, 'plan_bath', true);
    $plan_price_array               =   get_post_meta($edit_id, 'plan_price', true) ;
    
      
    

    foreach ($video_values as $value) {
        $option_video.='<option value="' . $value . '"';
        if ($value == $video_type) {
            $option_video.='selected="selected"';
        }
        $option_video.='>' . $value . '</option>';
    }
    
    $option_slider='';
    $slider_values = array('full top slider', 'small slider');
  
    $embed_video_id                 =   esc_html( get_post_meta($edit_id, 'embed_video_id', true) );
    $virtual_tour                   =   get_post_meta($edit_id, 'embed_virtual_tour', true);
    $property_latitude              =   floatval( get_post_meta($edit_id, 'property_latitude', true)); 
    $property_longitude             =   floatval( get_post_meta($edit_id, 'property_longitude', true));
    $google_view                    =   intval( get_post_meta($edit_id, 'property_google_view', true) );

    if($google_view==1){
        $google_view_check  =' checked="checked" ';
    }else{
         $google_view_check =' ';
    }
    
    
  
    
    $google_camera_angle            =   intval( get_post_meta($edit_id, 'google_camera_angle', true) );; 
   
    //  custom fields
    $custom_fields = wpresidence_get_option( 'wp_estate_custom_fields', '');  
    $custom_fields_array=array();
    $i=0;
    if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){
           $name    =   $custom_fields[$i][0];
           $type    =   $custom_fields[$i][2];
           $slug    =   wpestate_limit45(sanitize_title( $name ));
           $slug    =   sanitize_key($slug);
           $custom_fields_array[$slug]  =   esc_html(get_post_meta($edit_id, $slug, true));
           $i++;
        }
    }

            

}else{    
    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// If default view make vars blank 
    ///////////////////////////////////////////////////////////////////////////////////////////
    $action                         =   'view';
    $submit_title                   =   ''; 
    $submit_description             =   ''; 
    $prop_category                  =   ''; 
    $property_address               =   ''; 
    $property_county                =   ''; 
    $property_state                 =   ''; 
    $property_zip                   =   ''; 
    $country_selected               =   ''; 
    $prop_stat                      =   ''; 
    $property_status                =   '';
    $property_price                 =   ''; 
    $property_label                 =   '';   
    $property_label_before          =   '';  
    $property_year_tax              =   '';
    $property_hoa                   =   '';
    $property_size                  =   ''; 
    $owner_notes                    =   '';   
    $property_lot_size              =   ''; 
    $property_year                  =   ''; 
    $property_rooms                 =   ''; 
    $property_bedrooms              =   ''; 
    $property_bathrooms             =   ''; 
    $option_video                   =   '';
    $option_slider                  =   '';
    $video_type                     =   '';  
    $embed_video_id                 =   ''; 
    $virtual_tour                   =   '';
    $property_latitude              =   ''; 
    $property_longitude             =   '';  
    $google_view                    =   ''; 
    $google_camera_angle            =   ''; 
    $prop_category                  =   '';  
    $plan_title_array               =   '';
    $plan_desc_array                =   '';
    $plan_image_array               =   '';
    $plan_size_array                =   '';
    $plan_rooms_array               =   '';
    $plan_bath_array                =   '';
    $plan_price_array               =   '';
    $property_has_subunits          =   '';
    $property_subunits_list         =   '';
	
    // enegy effective
    $energy_class          =   '';
    $energy_index         =   '';
    //ee end
   
    $custom_fields = wpresidence_get_option( 'wp_estate_custom_fields', '');    
    $custom_fields_array=array();
    $i=0;
    if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){
           $name    =   $custom_fields[$i][0];
           $type    =   $custom_fields[$i][2];
           $slug    =   wpestate_limit45(sanitize_title( $name ));
           $slug    =   sanitize_key($slug);
           $custom_fields_array[$slug]='';
           $i++;
        }
    }
    
    if(is_array($property_status_array)){
        foreach ($property_status_array as $key=>$term) {
            $property_status.='<option value="'.$term->name.'" >'.stripslashes($term->name).'</option>';
        }
    }
    
   
    $video_values                   =   array('vimeo', 'youtube');
    foreach ($video_values as $value) {
      $option_video.='<option value="' . $value . '"';
      $option_video.='>' . $value . '</option>';
    }    

    $option_slider='';
    $slider_values = array('full top slider', 'small slider');
      
    foreach ($slider_values as $value) {
        $option_slider.='<option value="' . $value . '"';
        $option_slider.='>' . $value . '</option>';
    }
}


///////////////////////////////////////////////////////////////////////////////////////////
/////// Submit Code
///////////////////////////////////////////////////////////////////////////////////////////


if( isset($_POST) && isset($_POST['action'])  && $_POST['action']=='view' ) {
    if (    ! isset( $_POST['dashboard_property_front_nonce'] )  || ! wp_verify_nonce( $_POST['dashboard_property_front_nonce'], 'dashboard_property_front_action' ) ) {
        esc_html_e('Sorry, your nonce did not verify.','wpresidence');
        exit;
    }
    $parent_userID              =   wpestate_check_for_agency($userID);
    $paid_submission_status    =    esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
     
    if ( $paid_submission_status!='membership' || ( $paid_submission_status== 'membership' || wpestate_get_current_user_listings($parent_userID) > 0)  ){ // if user can submit
        
        if ( !isset($_POST['new_estate']) || !wp_verify_nonce($_POST['new_estate'],'submit_new_estate') ){
           exit('Sorry, your not submiting from site'); 
        }
   
        if( !isset($_POST['prop_category']) || $_POST['prop_category']==-1 ) {
            $prop_category=0;           
        }else{
            $prop_category  =   intval($_POST['prop_category']);
        }
  
        if( !isset($_POST['prop_action_category']) ) {
            $prop_action_category=0;           
        }else{
            $prop_action_category  =   wp_kses(esc_html($_POST['prop_action_category']),$allowed_html);
        }
        
        if( !isset($_POST['property_city']) ) {
            $property_city='';           
        }else{
            $property_city  =   wp_kses(esc_html($_POST['property_city']),$allowed_html);
        }
        
        if( !isset($_POST['property_area']) ) {
            $property_area='';           
        }else{
            $property_area  =   wp_kses(esc_html($_POST['property_area']),$allowed_html);
        }
       
        
        if( !isset($_POST['property_county']) ) {
            $property_county_state='';           
        }else{
            $property_county_state  =   wp_kses(esc_html($_POST['property_county']),$allowed_html);
        }
       
        
        
        
                
        $wpestate_show_err                       =   '';
        $post_id                        =   '';
        $submit_title                   =   '';
        if(isset($_POST['wpestate_title'])){
            $submit_title                   =   wp_kses( $_POST['wpestate_title'],$allowed_html ); 
        }
        $submit_description                   =   '';
        if(isset($_POST['wpestate_description'])){
            $submit_description             =   wp_kses( $_POST['wpestate_description'],$allowed_html_desc);     
        }
        
        $property_address                   =   '';
        if(isset($_POST['property_address'])){
            $property_address               =   wp_kses( $_POST['property_address'],$allowed_html);
        }
        
        $property_county                   =   '';
        if(isset($_POST['property_county'])){
            $property_county                =   wp_kses( $_POST['property_county'],$allowed_html);
        }
        
        $property_zip                   =   '';
        if(isset($_POST['property_zip'])){
            $property_zip                   =   wp_kses( $_POST['property_zip'],$allowed_html);
        }
		
		
        // energy effect
        $energy_class                   =   '';
        if(isset($_POST['energy_class'])){
            $energy_class                   =   wp_kses( $_POST['energy_class'],$allowed_html);
        }
        $energy_index                   =   '';
        if(isset($_POST['energy_index'])){
            $energy_index                   =   wp_kses( $_POST['energy_index'],$allowed_html);
        }
        // end
        
        $country_selected                   =   '';
        if(isset($_POST['property_country'])){
            $country_selected               =   wp_kses( $_POST['property_country'],$allowed_html);     
        }
        
        $prop_stat                   =   '';
        if(isset($_POST['property_status'])){
            $prop_stat                      =   wp_kses( $_POST['property_status'],$allowed_html);
        }
        
        
        $property_status                =   '';
        
        if(is_array($property_status_array)){
            foreach ($property_status_array as $key=>$term) {
                $property_status.='<option value="' . $term->name . '"';
                if ($term->name == $prop_stat) {
                    $property_status.='selected="selected"';
                }
                $property_status.='>' .stripslashes($term->name) . '</option>';
            }
        }
        
        
        $property_price                   =   '';
        if(isset($_POST['property_price'])){
            $property_price                 =   wp_kses( esc_html($_POST['property_price']),$allowed_html);
        }
        
        $property_label                   =   '';
        if(isset($_POST['property_label'])){
            $property_label                 =   wp_kses( esc_html($_POST['property_label']),$allowed_html);   
        }
        
        $property_label_before                   =   '';
        if(isset($_POST['property_label_before'])){
            $property_label_before          =   wp_kses( esc_html($_POST['property_label_before']),$allowed_html); 
        }
        
        $property_year_tax                   =   '';
        if(isset($_POST['property_year_tax'])){
            $property_year_tax          =   wp_kses( esc_html($_POST['property_year_tax']),$allowed_html); 
        }
        
        $property_hoa                   =   '';
        if(isset($_POST['property_year_tax'])){
            $property_hoa          =   wp_kses( esc_html($_POST['property_hoa']),$allowed_html); 
        }
        

        $property_size                   =   '';
        if(isset($_POST['property_size'])){
            $property_size                  =   wp_kses( esc_html($_POST['property_size']),$allowed_html);  
        }
        
        $owner_notes                   =   '';
        if(isset($_POST['owner_notes'])){
            $owner_notes                    =   wp_kses( esc_html($_POST['owner_notes']),$allowed_html);  
        }
        
        $property_lot_size                   =   '';
        if(isset($_POST['property_lot_size'])){
            $property_lot_size              =   wp_kses( esc_html($_POST['property_lot_size']),$allowed_html); 
        }
        
        $property_rooms                   =   '';
        if(isset($_POST['property_rooms'])){
            $property_rooms                 =   wp_kses( esc_html($_POST['property_rooms']),$allowed_html); 
        }
        
        $property_bedrooms                   =   '';
        if(isset($_POST['property_bedrooms'])){
            $property_bedrooms              =   wp_kses( esc_html($_POST['property_bedrooms']),$allowed_html); 
        }
        
        
        $property_bathrooms                   =   '';
        if(isset($_POST['property_bathrooms'])){
            $property_bathrooms             =   wp_kses( esc_html($_POST['property_bathrooms']),$allowed_html); 
        }
        
        
        $option_video                   =   '';
        $video_values                   =   array('vimeo', 'youtube');
        
        $video_type                   =   '';
        if(isset($_POST['embed_video_type'])){
            $video_type                     =   wp_kses( esc_html($_POST['embed_video_type']),$allowed_html); 
        }
        
        $google_camera_angle                   =   '';
        if(isset($_POST['google_camera_angle'])){
            $google_camera_angle            =   wp_kses( esc_html($_POST['google_camera_angle']),$allowed_html); 
        }
        
        $property_has_subunits                   =   '';
        if(isset($_POST['property_has_subunits'])){
            $property_has_subunits          =   wp_kses( esc_html($_POST['property_has_subunits']),$allowed_html); 
        }
        
        if(isset($_POST['property_subunits_list'])){
            $property_subunits_list         =   $_POST['property_subunits_list']; 
        }
        $has_errors                      =   false;
        $errors                         =   array();
      
        foreach ($video_values as $value) {
            $option_video.='<option value="' . $value . '"';
            if ($value == $video_type) {
                $option_video.='selected="selected"';
            }
            $option_video.='>' . $value . '</option>';
        }
        
        $option_slider='';
        $slider_values = array('full top slider', 'small slider'); 
        $iframe = array( 'iframe' => array(
                            'src' => array (),
                            'width' => array (),
                            'height' => array (),
                            'name'       => array(),
                            'frameborder' => array(),
                            'style' => array(),
                            'allowFullScreen' => array() ,
                            'allow'             => array(),
                            'scrolling'         => array(),// add any other attributes you wish to allow// add any other attributes you wish to allow
                          ) );
      
        
        
        $embed_video_id                   =   '';
        if(isset($_POST['embed_video_id'])){
            $embed_video_id                 =   wp_kses( esc_html($_POST['embed_video_id']),$allowed_html); 
        }
        
        $virtual_tour                   =   '';
        if(isset($_POST['embed_virtual_tour'])){
            $virtual_tour                   =   wp_kses (trim($_POST['embed_virtual_tour']),$iframe) ;
        }
        
        
        $property_latitude                   =   '';
        if(isset($_POST['property_latitude'])){
            $property_latitude              =   floatval( $_POST['property_latitude']); 
        }
        
        $property_longitude                   =   '';
        if(isset($_POST['property_longitude'])){
            $property_longitude             =   floatval( $_POST['property_longitude']); 
        }
        
        $google_view                   =   '';
        if(isset($_POST['property_google_view'])){
            $google_view                    =   wp_kses( esc_html( $_POST['property_google_view']),$allowed_html); 
        }
        
        
        if($google_view==1){
            $google_view_check=' checked="checked" ';
        }else{
            $google_view_check=' ';
        }
   
         
        $google_camera_angle                   =   '';
        if(isset($_POST['google_camera_angle'])){
            $google_camera_angle            =   intval( $_POST['google_camera_angle']); 
        }
        
        $prop_category                  =   get_term( $prop_category, 'property_category');
        if(isset($prop_category->term_id)){
            $prop_category_selected         =   $prop_category->term_id;
        }else{
           $prop_category = -1; 
        }
    
        $prop_action_category           =   get_term( $prop_action_category, 'property_action_category');  
        if(isset($prop_action_category->term_id)){
            $prop_action_category_selected  =   $prop_action_category->term_id;
        }else{
            $prop_action_category=-1;
        }
         
        $attchs =   array();
        if(isset($_POST['attachid'])){
            $attchs =   explode(',',$_POST['attachid']);
        }
            
        
        // save custom fields
     
        $i=0;
        if( !empty($custom_fields)){  
            while($i< count($custom_fields) ){
               $name    =   $custom_fields[$i][0];
               $type    =   $custom_fields[$i][1];
               $slug    =   str_replace(' ','_',$name);
               $slug    =   wpestate_limit45(sanitize_title( $name ));
               $slug    =   sanitize_key($slug);
               if(isset($_POST[$slug])){
                $custom_fields_array[$slug]= wp_kses( esc_html($_POST[$slug]),$allowed_html);
               }
               $i++;
            }
        }    
            
        if($submit_title==''){
            $has_errors=true;
            $errors[]=esc_html__('Please submit a title for your property','wpresidence');
        }
         
        $check_mandatory_field=wpestate_check_mandatory_fields($prop_category,$prop_action_category);
    
        if(!empty($check_mandatory_field)){
            $has_errors=true;
            $errors=array_merge($errors,$check_mandatory_field);
        }
       

        if($has_errors){
            foreach($errors as $key=>$value){
                $wpestate_show_err.=$value.'</br>';
            }            
        }else{
            $paid_submission_status = esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
            $new_status             = 'pending';
            
            $admin_submission_status= esc_html ( wpresidence_get_option('wp_estate_admin_submission','') );
            if($admin_submission_status=='no' && $paid_submission_status!='per listing'){
               $new_status='publish';  
            }
            
            
            $post = array(
                'post_title'	=> $submit_title,
                'post_content'	=> $submit_description,
                'post_status'	=> $new_status, 
                'post_type'     => 'estate_property' ,
                'post_author'   => $current_user->ID 
            );
            $post_id =  wp_insert_post($post );  
            
            if( $paid_submission_status == 'membership'){ // update pack status
                wpestate_update_listing_no($parent_userID);                
            }
       
        }
        
      

        
        
        if($post_id) {
            // uploaded images
            $order  =   0;
           
            $last_id='';
            foreach($attchs as $att_id){
                if( !is_numeric($att_id) ){
                 
                }else{
                    if($last_id==''){
                        $last_id=  $att_id;  
                    }
                    $order++;
                    wp_update_post( array(
                                'ID' => $att_id,
                                'post_parent' => $post_id,
                                'menu_order'=>$order
                            ));
                        
                    
                }
            }
            
            if( isset($_POST['attachthumb']) &&  is_numeric($_POST['attachthumb']) && $_POST['attachthumb']!=''  ){
                set_post_thumbnail( $post_id, wp_kses(esc_html($_POST['attachthumb']),$allowed_html )); 
            }else{
                set_post_thumbnail( $post_id, $last_id );                
            }
            //end uploaded images
            
            
            if( isset($prop_category->name) ){
                wp_set_object_terms($post_id,$prop_category->name,'property_category'); 
            }  
            if ( isset ($prop_action_category->name) ){
                wp_set_object_terms($post_id,$prop_action_category->name,'property_action_category'); 
            }  
            if( isset($property_city) && $property_city!='none' ){
                if($property_city == -1 ){
                    $property_city='';
                }
                
                wp_set_object_terms($post_id,$property_city,'property_city'); 
            }  
          
            if( isset($property_area) && $property_area!='none' ){
                wp_set_object_terms($post_id,$property_area,'property_area'); 
            }  
            
            if( isset($property_county_state) && $property_county_state!='none' ){
                if($property_county_state == -1){
                    $property_county_state='';
                }
                wp_set_object_terms($post_id,$property_county_state,'property_county_state'); 
            }  
            
            if($property_area!=''){
                $terms= get_term_by('name', $property_area, 'property_area');
                if($terms!=''){
                    $t_id=$terms->term_id;
                    $term_meta=array('cityparent'=>$property_city);
                    add_option( "taxonomy_$t_id", $term_meta ); 
                }
                
            }
	 
            if($property_city!=''){
                $terms= get_term_by('name', $property_city, 'property_city');
                if($terms!=''){
                    $t_id=$terms->term_id;
                    $term_meta=array('stateparent'=>$property_county_state);
                    add_option( "taxonomy_$t_id", $term_meta ); 
                }
                
            }
          
   
            update_post_meta($post_id, 'sidebar_agent_option', 'global');
            update_post_meta($post_id, 'local_pgpr_slider_type', 'global');
            update_post_meta($post_id, 'local_pgpr_content_type', 'global');
            update_post_meta($post_id, 'prop_featured', 0);
            update_post_meta($post_id, 'property_address', $property_address);
            update_post_meta($post_id, 'property_county', $property_county);
            update_post_meta($post_id, 'property_zip', $property_zip);
			
            // energy effect
            update_post_meta($post_id, 'energy_class', $energy_class);
            update_post_meta($post_id, 'energy_index', $energy_index);
            // ee end
			
            update_post_meta($post_id, 'property_country', $country_selected);
            update_post_meta($post_id, 'property_size', $property_size);
            update_post_meta($post_id, 'owner_notes', $owner_notes);
            update_post_meta($post_id, 'property_lot_size', $property_lot_size);  
            update_post_meta($post_id, 'property_rooms', $property_rooms);  
            update_post_meta($post_id, 'property_has_subunits', $property_has_subunits);  
            update_post_meta($post_id, 'property_subunits_list', $property_subunits_list); 
            
            if(is_array($property_subunits_list)){
            foreach ($property_subunits_list as $key) {
                update_post_meta(intval($key), 'property_subunits_master',$post_id );
            }
            }else{
                update_post_meta(intval($property_subunits_list), 'property_subunits_master',$post_id );
            }
        
            
            
            update_post_meta($post_id, 'property_bedrooms', $property_bedrooms);
            update_post_meta($post_id, 'property_bathrooms', $property_bathrooms);
            update_post_meta($post_id, 'property_price', $property_price);
            update_post_meta($post_id, 'property_label', $property_label);
            update_post_meta($post_id, 'property_label_before', $property_label_before);
            update_post_meta($post_id, 'property_year_tax', $property_year_tax);
            update_post_meta($post_id, 'property_hoa', $property_hoa);
            update_post_meta($post_id, 'embed_video_type', $video_type);
            update_post_meta($post_id, 'embed_video_id',  $embed_video_id );
            update_post_meta($post_id,  'embed_virtual_tour', $virtual_tour);                 
            update_post_meta($post_id, 'property_latitude', $property_latitude);
            update_post_meta($post_id, 'property_longitude', $property_longitude);
            update_post_meta($post_id, 'property_google_view',  $google_view);
            update_post_meta($post_id, 'google_camera_angle', $google_camera_angle);
            update_post_meta($post_id, 'pay_status', 'not paid');
            update_post_meta($post_id, 'page_custom_zoom', 16);
            
     
            $user_id_agent            =   get_the_author_meta( 'user_agent_id' , $current_user->ID  );
            update_post_meta($post_id, 'property_agent', $user_id_agent);                
           
           
            // save custom fields
            $custom_fields = wpresidence_get_option( 'wp_estate_custom_fields', true);  
     
            $i=0;
            if( !empty($custom_fields)){  
                while($i< count($custom_fields) ){
                    $name   =   $custom_fields[$i][0];
                    $type   =   $custom_fields[$i][2];
                    $slug   =   str_replace(' ','_',$name);
                    $slug   =   wpestate_limit45(sanitize_title( $name ));
                    $slug   =   sanitize_key($slug);
                    if( isset($_POST[$slug]) ){
                        if($type=='numeric'){
                            $value_custom    =   intval(wp_kses( $_POST[$slug],$allowed_html ) );

                            if($value_custom==0){
                                $value_custom='';
                            }

                           update_post_meta($post_id, $slug, $value_custom);
                        }else{
                            $value_custom    =   esc_html(wp_kses( $_POST[$slug],$allowed_html ) );
                            update_post_meta($post_id, $slug, $value_custom);
                        }
                        $custom_fields_array[$slug]= wp_kses( esc_html($_POST[$slug]),$allowed_html);
                    }
                   
                    $i++;
                }
            }
            
            
            // features &amm
            if(is_array($property_features)){
                foreach($property_features as $key => $term){
                    $feature_name   =   $term->slug;
                    //$feature_name   =   str_replace('%','', $feature_name);
                    if(isset($_POST[$feature_name]) && $_POST[$feature_name]==1){
                        wp_set_object_terms($post_id,trim($term->name),'property_features',true); 
                        $moving_array[]=$feature_name;
                    }
                }
            }
              
            // proeprty status
            wp_set_object_terms($post_id,$prop_stat,'property_status',true); 
            
            wpestate_update_hiddent_address_single($post_id);
            
            // get user dashboard link
            $redirect = wpestate_get_template_link('user_dashboard.php');
            
            $arguments=array(
                'new_listing_url'   => esc_url( get_permalink($post_id) ),
                'new_listing_title' => $submit_title
            );
            wpestate_select_email_type(get_option('admin_email'),'new_listing_submission',$arguments);
    
            wp_reset_query();
            wp_redirect( $redirect);
            exit;
        }
        
        }//end if user can submit   
} // end post

///////////////////////////////////////////////////////////////////////////////////////////
/////// Edit Part Code
///////////////////////////////////////////////////////////////////////////////////////////
if( isset($_POST) && isset($_POST['action'])  &&  $_POST['action']=='edit' ) {
        if (    ! isset( $_POST['dashboard_property_front_nonce'] )  || ! wp_verify_nonce( $_POST['dashboard_property_front_nonce'], 'dashboard_property_front_action' ) ) {
          esc_html_e('Sorry, your nonce did not verify.','wpresidence');
          exit;
       }

        if ( !isset($_POST['new_estate']) || !wp_verify_nonce($_POST['new_estate'],'submit_new_estate') ){
            exit('Sorry, your not submiting from site');
        }     
        $has_errors                     =   false;
        $wpestate_show_err                       =   '';
        $edited                         =   0;
        $edit_id                        =   intval( $_POST['edit_id'] );
        $post                           =   get_post( $edit_id ); 
        $author_id                      =   $post->post_author ;
        if($current_user->ID !=  $author_id   &&  !in_array($the_post->post_author , $agent_list) ){
            exit('you don\'t have the rights to edit');
        }
        
        $images_todelete                =   wp_kses( esc_html($_POST['images_todelete']),$allowed_html );

        $images_delete_arr              =   explode(',',$images_todelete);
        foreach ($images_delete_arr as $key=>$value){
            $img                       =   get_post( $value ); 
            $author_id                 =   $img->post_author ;
            if($current_user->ID !=  $author_id &&  !in_array($the_post->post_author , $agent_list) ){
                exit('you don\'t have the rights to delete images');
            }else{
                wp_delete_post( $value );   
            }
                      
        }
          
        
        if( !isset($_POST['prop_category']) ) {
            $prop_category=0;           
        }else{
            $prop_category  =   intval($_POST['prop_category']);
        }
        
        if($prop_category==-1){
            wp_delete_object_term_relationships($edit_id,'property_category'); 
        }
            
            
            
        if( !isset($_POST['prop_action_category']) ) {
            $prop_action_category=0;           
        }else{
            $prop_action_category  =   wp_kses(esc_html($_POST['prop_action_category']),$allowed_html);
        }
        
        if($prop_action_category==-1){
            wp_delete_object_term_relationships($edit_id,'property_action_category'); 
        }
            
            
            
        if( !isset($_POST['property_city']) ) {
            $property_city=0;           
        }else{
            $property_city  =   wp_kses(esc_html($_POST['property_city']),$allowed_html);
        }
        
        if( !isset($_POST['property_area']) ) {
            $property_area=0;           
        }else{
            $property_area  =   wp_kses(esc_html($_POST['property_area']),$allowed_html);
        }
        
        
        if( !isset($_POST['property_county']) ) {
            $property_county_state=0;           
        }else{
            $property_county_state  =   wp_kses(esc_html($_POST['property_county']),$allowed_html);
        }
        
     
            
       
           
        $submit_title                   =   '';
        if(isset($_POST['wpestate_title'])){
            $submit_title                   =   wp_kses( esc_html($_POST['wpestate_title']) ,$allowed_html); 
        }
           
        $submit_description                   =   '';
        if(isset($_POST['wpestate_description'])){
            $submit_description             =   wp_kses( $_POST['wpestate_description'],$allowed_html_desc);
        }
          
        $property_address                   =   '';
        if(isset($_POST['property_address'])){
            $property_address               =    wp_kses( esc_html($_POST['property_address']),$allowed_html);
        }
        
           
        $property_county                   =   '';
        if(isset($_POST['property_county'])){
            $property_county                =   wp_kses( esc_html($_POST['property_county']),$allowed_html);
        }
        
           
        $property_zip                   =   '';
        if(isset($_POST['property_zip'])){
            $property_zip                   =   wp_kses( esc_html($_POST['property_zip']),$allowed_html);
        }
        
        // energy effect
        $energy_class                   =   '';
        if(isset($_POST['energy_class'])){
            $energy_class                   =   wp_kses( esc_html($_POST['energy_class']),$allowed_html);
        }
        $energy_index                   =   '';
        if(isset($_POST['energy_index'])){
            $energy_index                   =   wp_kses( esc_html($_POST['energy_index']),$allowed_html);
        }
	
        $property_country                   =   '';
        if(isset($_POST['property_country'])){
            $property_country               =   wp_kses( esc_html($_POST['property_country']),$allowed_html);     
        }
        
           
        $prop_stat                   =   '';
        if(isset($_POST['property_status'])){
            $prop_stat                      =   wp_kses( esc_html($_POST['property_status']),$allowed_html);
        }
        
    
        
        $property_status                =   '';
        
        if(is_array($property_status_array)){
            foreach ($property_status_array as $key=>$term) {
                $property_status.='<option value="' . $term->name . '"';
                if ($term->name == $prop_stat) {
                    $property_status.='selected="selected"';
                }
                $property_status.='>' .stripslashes($term->name) . '</option>';
            }
        }
    
        
        $property_price                    =   '';
        if(isset($_POST['property_price'])){
            $property_price                 =   wp_kses( esc_html ($_POST['property_price']),$allowed_html);
        }
        
        $property_label                   =   '';
        if(isset($_POST['property_label'])){
            $property_label                 =   wp_kses( esc_html ($_POST['property_label']),$allowed_html); 
        }
        
        $property_label_before                   =   '';
        if(isset($_POST['property_label_before'])){
            $property_label_before          =   wp_kses( esc_html ($_POST['property_label_before']),$allowed_html);  
        }
        
        
        $property_year_tax                   =   '';
        if(isset($_POST['property_label_before'])){
            $property_year_tax          =   wp_kses( esc_html ($_POST['property_year_tax']),$allowed_html);  
        }
        
        $property_hoa                   =   '';
        if(isset($_POST['property_label_before'])){
            $property_hoa          =   wp_kses( esc_html ($_POST['property_hoa']),$allowed_html);  
        }
        
        
        
        
        $property_size                   =   '';
        if(isset($_POST['property_size'])){
            $property_size                  =   wp_kses( esc_html ($_POST['property_size']),$allowed_html);  
        }
        
        $owner_notes                   =   '';
        if(isset($_POST['owner_notes'])){
            $owner_notes                    =   wp_kses( esc_html ($_POST['owner_notes']),$allowed_html);  
        }
        
        $property_lot_size                   =   '';
        if(isset($_POST['property_lot_size'])){
            $property_lot_size              =   wp_kses( esc_html ($_POST['property_lot_size']),$allowed_html); 
        }
        
         $property_rooms                    =   '';
        if(isset($_POST['property_rooms'])){
            $property_rooms                 =   wp_kses( esc_html ($_POST['property_rooms']),$allowed_html); 
        }
        
        
        $property_bedrooms                   =   '';
        if(isset($_POST['property_bedrooms'])){
            $property_bedrooms              =   wp_kses( esc_html ($_POST['property_bedrooms']),$allowed_html); 
        }
        
        $property_bathrooms                   =   '';
        if(isset($_POST['property_bathrooms'])){
            $property_bathrooms             =   wp_kses( esc_html ($_POST['property_bathrooms']),$allowed_html); 
        }
        
        $option_video                   =   '';
        $video_values                   =   array('vimeo', 'youtube');
    
        
        
        $video_type                   =   '';
        if(isset($_POST['embed_video_type'])){
            $video_type                     =   wp_kses( esc_html ($_POST['embed_video_type']),$allowed_html); 
        }
        
        $google_camera_angle                   =   '';
        if(isset($_POST['google_camera_angle'])){
            $google_camera_angle            =   wp_kses( esc_html ($_POST['google_camera_angle']),$allowed_html); 
        }
        
        $property_has_subunits                   =   '';
        if(isset($_POST['property_has_subunits'])){
            $property_has_subunits          =   wp_kses( esc_html ($_POST['property_has_subunits']),$allowed_html); 
        }
        
        
        if(isset($_POST['property_subunits_list'])){
            $property_subunits_list         =     ($_POST['property_subunits_list']); 
        }else{
            $property_subunits_list='';
        }

        foreach ($video_values as $value) {
            $option_video.='<option value="' . $value . '"';
            if ($value == $video_type) {
                $option_video.='selected="selected"';
            }
            $option_video.='>' . $value . '</option>';
        }
        
        $option_slider='';
        $slider_values = array('full top slider', 'small slider');
    

        $embed_video_id                   =   '';
        if(isset($_POST['embed_video_id'])){
            $embed_video_id                 =   wp_kses( esc_html($_POST['embed_video_id']),$allowed_html); 
        }
        
        $iframe = array( 'iframe' => array(
                         'src' => array (),
                         'width' => array (),
                'name'  => array(),
                         'height' => array (),
                         'frameborder' => array(),
                          'style' => array(),
                         'allowFullScreen' => array() // add any other attributes you wish to allow
                          ) );
      
        
        $virtual_tour                   =   '';
        if(isset($_POST['embed_virtual_tour'])){
            $virtual_tour                   =    (trim($_POST['embed_virtual_tour'])) ;
        }
        
        $property_latitude                   =   '';
        if(isset($_POST['property_latitude'])){
            $property_latitude              =   floatval( $_POST['property_latitude']); 
        }
        
        $property_longitude                   =   '';
        if(isset($_POST['property_longitude'])){
            $property_longitude             =   floatval( $_POST['property_longitude']); 
        }
        
        $google_view                   =   '';
        if(isset($_POST['property_google_view'])){
            $google_view                    =   wp_kses( esc_html($_POST['property_google_view']),$allowed_html); 
        }
        
        if($google_view==1){
            $google_view_check=' checked="checked" ';
        }else{
             $google_view_check=' ';
        }
       
        
        $google_camera_angle                   =   '';
        if(isset($_POST['google_camera_angle'])){
            $google_camera_angle            =   intval( $_POST['google_camera_angle']); 
        }
        
        $prop_category                  =   get_term( $prop_category, 'property_category');
        if(isset($prop_category->term_id)){
            $prop_category_selected         =   $prop_category->term_id;
        }else{
           $prop_category = -1; 
        }
        
        $prop_action_category           =   get_term( $prop_action_category, 'property_action_category');     
        if(isset($prop_action_category->term_id)){
            $prop_action_category_selected  =   $prop_action_category->term_id;
        }else{
            $prop_action_category=-1;
        }
        
        //uploaded images
        $attchs     =   array();
        $post_id    =   $edit_id;
        if(isset($_POST['attachid'])){
            $attchs =   explode(',',$_POST['attachid']);
        }
        $last_id='';

        // check for deleted images
        $arguments = array(
                    'numberposts'   => -1,
                    'post_type'     => 'attachment',
                    'post_parent'   => $post_id,
                    'post_status'   => null,
                    'orderby'       => 'menu_order',
                    'order'         => 'ASC'
        );
        $post_attachments = get_posts($arguments);

        $new_thumb=0;
        $curent_thumb=get_post_thumbnail_id($post_id);
        foreach ($post_attachments as $attachment){
            if ( isset($_POST['attachid']) && !in_array ($attachment->ID,$attchs) ){
                wp_delete_post($attachment->ID);
                if( $curent_thumb == $attachment->ID ){
                    $new_thumb=1;
                }
            }
        }

        // check for deleted images

        $order=0;
     

        foreach($attchs as $att_id){
            if( !is_numeric($att_id) ){

            }else{
                if($last_id==''){
                    $last_id=  $att_id;  
                }
                $order++;
                wp_update_post( array(
                            'ID' => $att_id,
                            'post_parent' => $post_id, 
                            'menu_order'=>$order
                        ));


            }
        }

        
        
        if( isset($_POST['attachthumb']) && is_numeric($_POST['attachthumb']) && $_POST['attachthumb']!=''  ){
            set_post_thumbnail( $post_id, $_POST['attachthumb'] ); 
        } 
        
        if($new_thumb==1 || !has_post_thumbnail($post_id) || ( isset($_POST['attachthumb']) && $_POST['attachthumb']=='') ){
            set_post_thumbnail( $post_id, $last_id );
        }

        //end uploaded images
       
        if($submit_title==''){
            $has_errors=true;
            $errors[]=esc_html__('Please submit a title for your property','wpresidence');
          
        }
  
        
        $check_mandatory_field=wpestate_check_mandatory_fields($prop_category,$prop_action_category);
    
        if(!empty($check_mandatory_field)){
            $has_errors=true;
            $errors=array_merge($errors,$check_mandatory_field);
        }
    
        wp_Reset_query();
        
        if($has_errors){
            foreach($errors as $key=>$value){
                $wpestate_show_err.=$value.'</br>';
            }
            
        }else{
            $new_status='pending';
            $admin_submission_status = esc_html ( wpresidence_get_option('wp_estate_admin_submission','') );
            $paid_submission_status  = esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
              
            if($admin_submission_status=='no' ){
               $new_status=get_post_status($edit_id);  
            }
            
         
            $post = array(
                    'ID'            => $edit_id,
                    'post_title'    => $submit_title,
                    'post_content'  => $submit_description,
                    'post_type'     => 'estate_property',
                    'post_status'   => $new_status
            );
          
            $post_id =  wp_update_post($post );  
            $edited=1;
        }
        
        if( $edited==1) {
           
            
            if( isset($prop_category->name) ){
                wp_set_object_terms($post_id,$prop_category->name,'property_category'); 
            }  
           
            if ( isset ($prop_action_category->name) ){
                wp_set_object_terms($post_id,$prop_action_category->name,'property_action_category'); 
            }  
           
            
            
            if( isset($property_city) && $property_city!='none'  ){
                if($property_city == -1 ){
                    $property_city='';
                }
                wp_set_object_terms($post_id,$property_city,'property_city'); 
            }  
            
            if( isset($property_area) && $property_area!='none' ){
                wp_set_object_terms($post_id,$property_area,'property_area'); 
            }  
            
            if( isset($property_county_state) && $property_county_state!='none' ){
                if($property_county_state == -1){
                    $property_county_state='';
                }
                wp_set_object_terms($post_id,$property_county_state,'property_county_state'); 
            }  
            
            
            if($property_area!=''){
                $terms= get_term_by('name', $property_area, 'property_area');
           
                if (isset($terms->term_id)){
                    $t_id=$terms->term_id;
                    $term_meta=array('cityparent'=>$property_city);
                    add_option( "taxonomy_$t_id", $term_meta );
                }
               
            }
          
            
            if($property_city!=''){
                $terms= get_term_by('name', $property_city, 'property_city');
                if($terms!=''){
                    $t_id=$terms->term_id;
                    $term_meta=array('stateparent'=>$property_county_state);
                    add_option( "taxonomy_$t_id", $term_meta ); 
                }
                
            }
          
            
          
            update_post_meta($post_id, 'property_address', $property_address);
            update_post_meta($post_id, 'property_county', $property_county);
            update_post_meta($post_id, 'property_zip', $property_zip);
			
            // energy effective
            update_post_meta($post_id, 'energy_class', $energy_class);
            update_post_meta($post_id, 'energy_index', $energy_index);
            //ee end
			
            //   update_post_meta($post_id, 'property_state', $property_state);
            update_post_meta($post_id, 'property_country', $property_country);
                                 
            update_post_meta($post_id, 'property_size', $property_size);
            update_post_meta($post_id, 'owner_notes', $owner_notes);
            update_post_meta($post_id, 'property_lot_size', $property_lot_size);  
            update_post_meta($post_id, 'property_rooms', $property_rooms);  
            update_post_meta($post_id, 'property_bedrooms', $property_bedrooms);
            update_post_meta($post_id, 'property_bathrooms', $property_bathrooms);
          
            
            $old_property_subunits_list   =  get_post_meta($post_id, 'property_subunits_list', true); 
            if(is_array($old_property_subunits_list)){
                foreach ($old_property_subunits_list as $key) {
                    delete_post_meta(intval($key), 'property_subunits_master');
                }
            }else{
                delete_post_meta(intval($old_property_subunits_list), 'property_subunits_master' );
            }
            
            
            if(is_array($property_subunits_list)){
                foreach ($property_subunits_list as $key) {
                    update_post_meta(intval($key), 'property_subunits_master',$post_id );
                }
            }else{
                update_post_meta(intval($property_subunits_list), 'property_subunits_master',$post_id);
            }
            
            update_post_meta($post_id, 'property_subunits_list', $property_subunits_list);
            
            update_post_meta($post_id, 'property_has_subunits', $property_has_subunits);
            update_post_meta($post_id, 'property_price', $property_price);
            update_post_meta($post_id, 'property_label', $property_label);
            update_post_meta($post_id, 'property_label_before', $property_label_before);
            update_post_meta($post_id, 'property_year_tax', $property_year_tax);
            update_post_meta($post_id, 'property_hoa', $property_hoa);
            update_post_meta($post_id, 'embed_video_type', $video_type);
            update_post_meta($post_id, 'embed_video_id', $embed_video_id);
            update_post_meta($post_id, 'embed_virtual_tour',  $virtual_tour );
            update_post_meta($post_id, 'property_latitude', $property_latitude);
            update_post_meta($post_id, 'property_longitude', $property_longitude);
            update_post_meta($post_id, 'property_google_view', $google_view);
            update_post_meta($post_id, 'google_camera_angle', $google_camera_angle);
         
            wp_delete_object_term_relationships( $post_id, 'property_features' );
            
            if(is_array($property_features)){
                foreach($property_features as $key => $term){
                    $feature_name   =   $term->slug;
               //     $feature_name   =   str_replace('%','', $feature_name);
                    if(isset($_POST[$feature_name]) && $_POST[$feature_name]==1){
                        wp_set_object_terms($post_id,trim($term->name),'property_features',true); 
                    }
                }
            }
           
            wp_delete_object_term_relationships( $post_id, 'property_status' );
            wp_set_object_terms($post_id,$prop_stat,'property_status',true); 
                
    
            // save custom fields
            $i=0;
            if( !empty($custom_fields)){  
                while($i< count($custom_fields) ){
                    $name =   $custom_fields[$i][0];
                    $type =   $custom_fields[$i][1];
                    $slug =   str_replace(' ','_',$name);
                    $slug         =   wpestate_limit45(sanitize_title( $name ));
                    $slug         =   sanitize_key($slug);
                    if( isset($_POST[$slug]) ){
                        if($type=='numeric'){
                            $value_custom    =   intval(wp_kses( esc_html($_POST[$slug]),$allowed_html ) );
                            if($value_custom==0){
                                $value_custom='';
                            }
                            update_post_meta($post_id, $slug, $value_custom);
                        }else{
                            $value_custom    =   esc_html(wp_kses( $_POST[$slug],$allowed_html ) );
                            update_post_meta($post_id, $slug, $value_custom);
                        }
                            $custom_fields_array[$slug]= wp_kses( $_POST[$slug],$allowed_html); ;
                    }
                    $i++;
                }
            }
            
             wpestate_update_hiddent_address_single($post_id);
             
            // get user dashboard link
            $redirect = wpestate_get_template_link('user_dashboard.php');
            wp_reset_query();
            
            $arguments=array(
                'editing_listing_url'   => esc_url( get_permalink($post_id) ),
                'editing_listing_title' => $submit_title
            );
            wpestate_select_email_type(get_option('admin_email'),'listing_edit',$arguments);
           
            wp_redirect( $redirect);
            exit;
        }// end if edited
}




get_header();
$wpestate_options=wpestate_page_details($post->ID);



///////////////////////////////////////////////////////////////////////////////////////////
/////// Html Form Code below
///////////////////////////////////////////////////////////////////////////////////////////
?> 

<div id="cover"></div>
<div class="row row_user_dashboard">

    <?php  get_template_part('templates/dashboard-left-col');  ?>
    
    <div class="col-md-9 dashboard-margin">
        <?php   get_template_part('templates/breadcrumbs'); ?>
        <?php   get_template_part('templates/user_memebership_profile');  ?>
        <?php   get_template_part('templates/ajax_container'); ?>
        
        <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                <h3 class="entry-title"><?php the_title(); ?></h3>
            <?php } ?>

           <?php endwhile; // end of the loop. ?>
           <?php   include( locate_template('templates/front_end_submission.php') );  ?> 
    </div>
</div>   
<?php   
if(function_exists('wpestate_disable_filtering')){
    wpestate_disable_filtering('wp_kses_allowed_html', 'wpestate_add_allowed_tags');        
}
get_footer();
?>