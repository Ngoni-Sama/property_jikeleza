<?php
add_action('wpestate_ajax_handler_wpestate_property_modal_listing_details_second','wpestate_property_modal_listing_details_second');
add_action('wpestate_ajax_handler_nopriv_wpestate_property_modal_listing_details_second','wpestate_property_modal_listing_details_second');

if( !function_exists('wpestate_property_modal_listing_details_second') ):
    function wpestate_property_modal_listing_details_second(){
    
        $post_id                    =   intval($_POST['postid']);
        $wpestate_prop_all_details  =   get_post_custom($post_id);
        print json_encode( 
                array(
                    'response'      =>  true,
                    'yelp'          =>  wpestate_modal_yelp($post_id),
                    'floor_plans'   =>  wpestate_modal_floor($post_id,$wpestate_prop_all_details),
                    'mortgage'      =>  wpestate_property_modal_mortgage($post_id,$wpestate_prop_all_details),
                    'map'           =>  '<h4 class="panel-title">'.esc_html__('Map', 'wpresidence').'</h4>'.wpestate_property_page_map_modal_function($post_id),
                    'walkscore'     =>  wpestate_modal_walscore($post_id,$wpestate_prop_all_details,''),
                    ) 
                );
        die(); 
    
    }
endif;







    
add_action('wpestate_ajax_handler_wpestate_property_modal_listing_details','wpestate_property_modal_listing_details');
add_action('wpestate_ajax_handler_nopriv_wpestate_property_modal_listing_details','wpestate_property_modal_listing_details');

if( !function_exists('wpestate_property_modal_listing_details') ):
     function wpestate_property_modal_listing_details(){
    
        $post_id                    =   intval($_POST['postid']);
        $wpestate_prop_all_details  =   get_post_custom($post_id);
        
        $arguments      = array(
            'numberposts'       => -1,
            'post_type'         => 'attachment',
            'post_mime_type'    => 'image',
            'post_parent'       => $post_id,
            'post_status'       => null,
            'orderby'           => 'menu_order',
            'order'             => 'ASC',
            'exclude'           => get_post_thumbnail_id($post_id),
        );
        
        
        $attachemnt_img     =   wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
        $images             =   array();
        $full_images        =   array();
        $full_images[]      =   $attachemnt_img[0];
        
        $post_attachments   =   get_posts($arguments);
        foreach ($post_attachments as $attachment) {
            $attachemnt_img =   wp_get_attachment_image_src($attachment->ID, 'full');
            $full_images[]  =   $attachemnt_img[0];
            $attachemnt_img =   wp_get_attachment_image_src($attachment->ID, 'property_listings');
            $images[]       =   $attachemnt_img[0];
        }
    
        
        
        if (function_exists('icl_translate') ){
            $where_currency             =   icl_translate('wpestate','wp_estate_where_currency_symbol', esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') ) );
            $property_description_text  =   icl_translate('wpestate','wp_estate_property_description_text', esc_html( wpresidence_get_option('wp_estate_property_description_text') ) );
            $property_details_text      =   icl_translate('wpestate','wp_estate_property_details_text', esc_html( wpresidence_get_option('wp_estate_property_details_text') ) );
            $property_features_text     =   icl_translate('wpestate','wp_estate_property_features_text', esc_html( wpresidence_get_option('wp_estate_property_features_text') ) );
            $property_adr_text          =   icl_translate('wpestate','wp_estate_property_adr_text', esc_html( wpresidence_get_option('wp_estate_property_adr_text') ) );    
            $property_video_text        =   icl_translate('wpestate','wp_estate_property_video_text', esc_html( wpresidence_get_option('wp_estate_property_video_text') ) );    
   
        }else{
            $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
            $property_description_text  =   esc_html( wpresidence_get_option('wp_estate_property_description_text') );
            $property_details_text      =   esc_html( wpresidence_get_option('wp_estate_property_details_text') );
            $property_features_text     =   esc_html( wpresidence_get_option('wp_estate_property_features_text') );
            $property_adr_text          =   stripslashes ( esc_html( wpresidence_get_option('wp_estate_property_adr_text') ) );
            $property_video_text        =   esc_html( wpresidence_get_option('wp_estate_property_video_text') );
        }

        $wpestate_currency          =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $current_user               =   wp_get_current_user();
        $userID                     =   $current_user->ID;
        $user_option                =   'favorites'.intval($userID);
        $curent_fav                 =   get_option($user_option);
        $favorite_class             =   'isnotfavorite'; 
        $favorite_text              =   esc_html__('add to favorites','wpresidence');
        $pinteres                   =   array();
        $property_city              =   get_the_term_list($post_id, 'property_city', '', ', ', '') ;
        $property_area              =   get_the_term_list($post_id, 'property_area', '', ', ', '');
        $property_category          =   get_the_term_list($post_id, 'property_category', '', ', ', '') ;
        $property_action            =   get_the_term_list($post_id, 'property_action_category', '', ', ', ''); 
       
        
        
        
        $property_address           =   esc_html(wpestate_return_custom_field( $wpestate_prop_all_details, 'property_address') );

        if($curent_fav){
            if ( in_array ($post_id,$curent_fav) ){
                $favorite_class =   'isfavorite';     
                $favorite_text  =   esc_html__('favorite','wpresidence');
            } 
        }

        if (has_post_thumbnail()){
            $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(),'property_full_map');
        }

        
        
        $price                 =   floatval ( wpestate_return_custom_field( $wpestate_prop_all_details,'property_price') );
        $price_label           =   esc_html ( wpestate_return_custom_field( $wpestate_prop_all_details,'price_label')  ); 
        $price_label_before    =   esc_html ( wpestate_return_custom_field( $wpestate_prop_all_details,'price_label_before') );  
        
        if ($price != 0) {
            $price =wpestate_show_price_from_all_details($wpestate_currency,$where_currency,1,$wpestate_prop_all_details);           
        }else{
            $price='<span class="price_label price_label_before">'.esc_html($price_label_before).'</span><span class="price_label ">'.esc_html($price_label).'</span>';
        }
        
        print json_encode( 
                array(
                    'response'=>true,
                   
                    'title'         =>  get_the_title($post_id),
                    'link'          =>  get_permalink($post_id),
                    'price'         =>  $price,
                    'favorite'      =>  wpestate_modal_favorite($post_id),
                    'share'         =>  wpestate_modal_social_share($post_id),
                    'addr_section'  =>  wpestate_modal_compose_address($property_address,$property_city,$property_area),
                    'beds_section'  =>  wpestate_modal_beds_section($wpestate_prop_all_details),
                    'agent_section' =>  wpestate_modal_agent_section($post_id),
                    'content'       =>  wpestate_modal_contant($post_id,$wpestate_prop_all_details,$property_description_text),
                    'address'       =>  wpestate_modal_address($post_id,$wpestate_prop_all_details,$property_adr_text), 
                    'details'       =>  wpestate_modal_details($post_id,$wpestate_prop_all_details,$property_details_text),
                    'features'      =>  wpestate_modal_features($post_id,$wpestate_prop_all_details,$property_features_text),
                    'video'         =>  wpestate_modal_video($post_id,$wpestate_prop_all_details,$property_video_text),
                    'video_tour'    =>  wpestate_modal_video_tour($post_id,$wpestate_prop_all_details,''),
                    'images'        =>  $images,
                    'full_images'   =>  $full_images,
                    ) 
                );
        die(); 
    
    }
 
endif;





if( !function_exists('wpestate_return_custom_field') ):
function wpestate_return_custom_field($all_post_meta,$field){
    if( isset($all_post_meta[$field]) ){
        return $all_post_meta[$field][0];
    }else{
        return '';
    }
}
endif;


if( !function_exists('wpestate_modal_social_share') ):
function wpestate_modal_social_share($postid){
    if (has_post_thumbnail($postid)){
        $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id($postid),'property_full_map');
    }
    $email_link     =   'subject='.urlencode ( get_the_title($postid) ) .'&body='. urlencode( esc_url(get_permalink($postid)));
    
    $return ='<div class="prop_social">
                <div class="no_views dashboad-tooltip" data-original-title="'. esc_attr__('Number of Page Views','wpresidence').'"><i class="fas fa-eye-slash"></i>'. intval( get_post_meta($postid, 'wpestate_total_views', true) ).'</div>
                <i class="fas fa-print" id="print_page" data-propid="'.$postid.'"></i>
                <a href="https://www.facebook.com/sharer.php?u='. get_permalink($postid).'&amp;t='.urlencode(get_the_title($postid)).'" target="_blank" class="share_facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/intent/tweet?text='.urlencode(get_the_title($postid) .' '.  esc_url( get_permalink($postid) )).'" class="share_tweet" target="_blank"><i class="fab fa-twitter"></i></a>';
    
                if (isset($pinterest[0])){
                   $return.='<a href="https://pinterest.com/pin/create/button/?url='.get_permalink($postid).'&amp;media='.esc_url($pinterest[0]).'&amp;description='. urlencode(get_the_title($postid)).'" target="_blank" class="share_pinterest"> <i class="fab fa-pinterest-p"></i> </a> ';     
                }
                $return.='<a href="https://api.whatsapp.com/send?text='.urlencode( get_the_title($postid).' '. esc_url( get_permalink() )).'" class="social_email"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>   
                <a href="mailto:email@email.com?'. trim( esc_html($email_link) ).'"  class="social_email"> <i class="far fa-envelope"></i></a>';
    $return.='</div>';
    
    return $return;
    
}
endif;



if( !function_exists('wpestate_modal_favorite') ):
function wpestate_modal_favorite($postid){
    $current_user               =   wp_get_current_user();
    $userID                     =   $current_user->ID;
    $user_option                =   'favorites'.intval($userID);
    $curent_fav                 =   get_option($user_option);
    $favorite_class             =   'isnotfavorite'; 
    $favorite_text              =   esc_html__('add to favorites','wpresidence');
    
    if($curent_fav){
        if ( in_array ($postid,$curent_fav) ){
            $favorite_class =   'isfavorite';     
            $favorite_text  =   esc_html__('favorite','wpresidence');
        } 
    }


    $return ='  <div id="add_favorites" class="'.esc_attr($favorite_class).'" data-postid="'.$postid.'">'.esc_html($favorite_text).'</div>';
    return $return;
    
}
endif;



if( !function_exists('wpestate_modal_agent_section') ):
function wpestate_modal_agent_section($post_id){
    ob_start();    
        $is_modal           =   1;
        $modal_agent_id     =   intval( get_post_meta($post_id, 'property_agent', true) );
        include( locate_template ('/templates/agent_area.php' ) );  
        $return = ob_get_contents();
    ob_end_clean();
    
    return $return;
}
endif;



if( !function_exists('wpestate_property_modal_mortgage') ):
function wpestate_property_modal_mortgage($post_id,$wpestate_prop_all_details){
    $return ='<h4 class="panel-title">'.  esc_html__('Payment Calculator', 'wpresidence').'</h4>';
    ob_start();
        wpestate_morgage_calculator($post_id,$wpestate_prop_all_details); 
    $return.= ob_get_contents();
    ob_end_clean();
      
    return $return;
        
}
endif;




if(!function_exists('wpestate_modal_floor')):
    function wpestate_modal_floor($post_id,$wpestate_prop_all_details){
        $return         =   '';
    
        $return.='<div class="wpestate_property_modal_floor_plans"><h4 class="panel-title">';  
        $return.= esc_html__('Floor Plans','wpresidence');
        $return.='</h4>';
        ob_start();
        estate_floor_plan($post_id,0,$wpestate_prop_all_details);
        $return2= ob_get_contents();
        ob_end_clean();
        $return.=$return2;
        if(trim($return2)==''){
            return'';
        }
        return $return;
    }   
endif;    



if(!function_exists('wpestate_modal_yelp')):
    function wpestate_modal_yelp($post_id){
        $return         =   '';
    
        $return.='<div class="wpestate_property_modal_yelp"><h4 class="panel-title">';  
        $return.= esc_html__('What\'s Nearby','wpresidence');
        $return.='</h4>';
        ob_start();
            wpestate_yelp_details($post_id);
            $return2= ob_get_contents();
        ob_end_clean();
        $return.=$return2;
        if(trim($return2)==''){
            return'';
        }
        return $return;
    }   
endif;    
    
    
      
if(!function_exists('wpestate_modal_walscore')):
    function wpestate_modal_walscore($post_id,$wpestate_prop_all_details,$property_video_text){
        $return         =   '';
        $walkscore_api  = esc_html ( wpresidence_get_option('wp_estate_walkscore_api','') );
        if($walkscore_api!=''){


            $return.='<div class="wpestate_property_modal_walkscore"><h4 class="panel-title">';  
            if($property_video_text!=''){
                $return.= esc_html($property_video_text);
            }else{
                $return.= esc_html__('WalkScore','wpresidence');
            }
            $return.='</h4>';
            ob_start();
                wpestate_walkscore_details($post_id,$wpestate_prop_all_details);
                $return2= ob_get_contents();
            ob_end_clean();
            $return.=$return2;
            $return.='</div>';

            if(trim($return2)==''){
                return'';
            }

        }
        return $return;
        
    }
endif;




if(!function_exists('wpestate_modal_video_tour')):
    function wpestate_modal_video_tour($post_id,$wpestate_prop_all_details){
        $return         =   '';
    
        $return.='<div class="wpestate_property_modal_videos"><h4 class="panel-title"><h4 class="panel-title">'.esc_html__('Virtual Tour','wpresidence').'</h4>';
        
        $return2=wpestate_return_custom_field( $wpestate_prop_all_details,'embed_virtual_tour');
        $return.=$return2;
        $return.='</div>';
        
        
        if(trim($return2)==''){
            return'';
        }
        return $return;
        
    }
endif;








if(!function_exists('wpestate_modal_video')):
    function wpestate_modal_video($post_id,$wpestate_prop_all_details,$property_video_text){
        $return         =   '';
    
        $return.='<div class="wpestate_property_modal_videos"><h4 class="panel-title">';  
        if($property_video_text!=''){
            $return.= esc_html($property_video_text);
        }else{
            $return.= esc_html__('Video','wpresidence');
        }
        $return.='</h4>';
        
        $return2=wpestate_listing_video($post_id,$wpestate_prop_all_details);
        $return.=$return2;
        $return.='</div>';
        $full_img_path      =   esc_html ( wpestate_return_custom_field( $wpestate_prop_all_details,'property_custom_video') );
        if(trim($full_img_path)==''){
            return'';
        }
        
        return $return;
        
    }
endif;



if(!function_exists('wpestate_modal_features')):
    function wpestate_modal_features($post_id,$wpestate_prop_all_details,$property_features_text){
        $return         =   '';
    
        $return.='<div class="wpestate_property_modal_features"><h4 class="panel-title">';  
        if($property_features_text!=''){
            $return.= esc_html($property_features_text);
        }else{
            $return.= esc_html__('Amenities and Features','wpresidence');
        }
        $return.='</h4>';
        
        $return2=estate_listing_features($post_id,3,0,'',$wpestate_prop_all_details);
        $return.=$return2;
        $return.='</div>';
        
        if(trim($return2)==''){
            return'';
        }
        return $return;
        
        
    }
endif;






if(!function_exists('wpestate_modal_details')):
    function wpestate_modal_details($post_id,$wpestate_prop_all_details,$property_details_text){
        $return         =   '';
    
        $return.='<div class="wpestate_property_modal_details"><h4 class="panel-title">';  
        if($property_details_text!=''){
            $return.= esc_html($property_details_text);
        }else{
            $return.= esc_html__('Property Details','wpresidence');
        }
        $return.='</h4>';
        
        $return.=estate_listing_details($post_id,$wpestate_prop_all_details);
        $return.='</div>';
        
        return $return;
        
        
    }
endif;








if(!function_exists('wpestate_modal_address')):
    function wpestate_modal_address($post_id,$wpestate_prop_all_details,$property_description_text){
        $return         =   '';
    
        $return.='<div class="wpestate_property_modal_addr"><h4 class="panel-title">';  
        if($property_description_text!=''){
            $return.= esc_html($property_description_text);
        }else{
            $return.= esc_html__('Property Address','wpresidence');
        }
        $return.='</h4>';
        
        $return.=estate_listing_address($post_id,$wpestate_prop_all_details);
        $return.='</div>';
        
        return $return;
        
        
    }
endif;








if(!function_exists('wpestate_modal_contant')):
    function wpestate_modal_contant($post_id,$wpestate_prop_all_details,$property_description_text){
        $return         =   '';
        $content        =   get_post_field('post_content', $post_id);
        $content        =   apply_filters('the_content', $content);
        $content        =   str_replace(']]>', ']]&gt;', $content);
        
        if($content!=''){                            
            if($property_description_text!=''){
                $property_description_label = esc_html($property_description_text);
            }else{
               $property_description_label = esc_html__('Description','wpresidence');
            }

            
            $return.= '<div class="wpestate_property_description">
            <h4 class="panel-title">'.esc_html($property_description_label).'</h4>'.$content;
    
            $energy_index       =  wpestate_return_custom_field( $wpestate_prop_all_details,'energy_index');
            $energy_class       =  wpestate_return_custom_field( $wpestate_prop_all_details,'energy_class');

            if ( $energy_index != ''    || $energy_class != ''  ){ //  if energy data  exists

                $return.= '<div class="property_energy_saving_info">';
                $return.= wpestate_energy_save_features($post_id,$wpestate_prop_all_details);
                $return.= '</div>';  
                $return.= wpestare_return_documents($post_id);       
                $return.= '</div>';     
            }
        }
        
        return $return;
    }
endif;








if(!function_exists('wpestate_modal_beds_section')):
    function wpestate_modal_beds_section($wpestate_prop_all_details){
        $return = '';
        $property_bedrooms  =    floatval ( wpestate_return_custom_field( $wpestate_prop_all_details,'property_bedrooms') );
        $property_bathrooms =    floatval ( wpestate_return_custom_field( $wpestate_prop_all_details,'property_bathrooms') );
        $property_size      =     wpestate_get_converted_measure( $post_id, 'property_size',$wpestate_prop_all_details ); 
        
      
        if($property_bedrooms!=0){
            $return.='<span class="modal_bedrooms">'.$property_bedrooms.' '.esc_html('bd','wpresidence').'</span>';
        }
        if($property_bedrooms!=0){
            $return.='<span class="modal_bathrooms">'.$property_bathrooms.' '.esc_html('ba','wpresidence').'</span>';
        }
        if($property_bedrooms!=0){
            $return.='<span class="modal_size">'.$property_size.'</span>';
        }
        
        return $return;
        
    }
endif;





if(!function_exists('wpestate_modal_compose_address')):
    function wpestate_modal_compose_address($property_address,$property_city,$property_area){
        $return='';
        if($property_address!=''){
            $return.= esc_html($property_address);
        }

        if($property_city!=''){
            if($property_address!=''){
                $return.= ', ';
            }
            $return.= wp_kses_post($property_city);
        }

        if($property_area!=''){
            if($property_address!='' || $property_city!=''){
                $return.= ', ';
            }
            $return.= wp_kses_post($property_area);
        }
        return $return;
    }
endif;





add_action( 'wp_ajax_nopriv_wpestate_agency_listings', 'wpestate_agency_listings' );  
add_action( 'wp_ajax_wpestate_agency_listings', 'wpestate_agency_listings' );

if( !function_exists('wpestate_agency_listings') ):
    
    function wpestate_agency_listings(){
        check_ajax_referer( 'wpestate_developer_listing_nonce', 'security' );
        global $wpestate_options;
        global $wpestate_no_listins_per_row;
        global $wpestate_custom_unit_structure;
        global $show_remove_fav;
        global $prop_unit_class;
        global $wpestate_prop_unit;
        global $wpestate_currency;
        global $where_currency;
        $wpestate_currency                   =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
        global $wpestate_property_unit_slider;
        $wpestate_property_unit_slider       =   wpresidence_get_option('wp_estate_prop_list_slider','');
        $wpestate_prop_unit                  =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
        $prop_unit_class            =   '';
        if($wpestate_prop_unit=='list'){
            $prop_unit_class="ajax12";
            $align_class=   'the_list_view';
        }



        $show_remove_fav=0;
        wp_suspend_cache_addition(false);
        $wpestate_uset_unit         =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
        $wpestate_no_listins_per_row         =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
        $wpestate_custom_unit_structure      =   wpresidence_get_option('wpestate_property_unit_structure');
        $property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
        $property_card_type_string  =   '';
        $prop_no    =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
      
        if($property_card_type==0){
            $property_card_type_string='';
        }else{
            $property_card_type_string='_type'.$property_card_type;
        }
        
        $user_agency    =   intval($_POST['agency_id']);
        $wpestate_options        =   wpestate_page_details($user_agency);
     
        $agent_list     =   (array)get_user_meta($user_agency,'current_agent_list',true);
        $agent_list[]   =   $user_agency;


        $term_name=esc_html($_POST['term_name']);
    
        
        
        $is_agency = intval($_POST['is_agency']);
		$post_id = intval($_POST['post_id']);
        
        
        if( $is_agency ==1 ){
            $action_array=array(
                'taxonomy'     => 'property_action_category',
                'field'        => 'slug',
                'terms'        => $term_name
            );
        }else{
            $action_array=array(
                'taxonomy'     => 'property_category',
                'field'        => 'slug',
                'terms'        => $term_name
            );
        }

        
        if( count( $agent_list ) == 0 ){
	
            $args = array(
                'post_type'         =>  'estate_property',
                'paged'             =>  $paged,
                'posts_per_page'    =>  $prop_no,
                'post_status'       =>  'publish',
                'meta_key'          =>  'prop_featured',
                'orderby'           =>  'meta_value',
                'order'             =>  'DESC',
                'tax_query'         =>  array(
                                            'relation' => 'AND',
                                            $action_array,
                                        ),
                'meta_query' => array(
                                        array(
                                            'key'     => 'property_agent',
                                            'value'   => $post_id,
                                        ),
                                    ),
            );
        
        }else{
            $args = array(
                'post_type'         =>  'estate_property',
                'author__in'        =>  $agent_list,
                'paged'             =>  $paged,
                'posts_per_page'    =>  $prop_no,
                'post_status'       => 'publish',
                'meta_key'          => 'prop_featured',
                'orderby'           => 'meta_value',
                'order'             => 'DESC',
                'tax_query'         => array(
                                            'relation' => 'AND',
                                            $action_array,
                                        )
                );
            }
        
        if($term_name=='all'){
            unset($args['tax_query']);
        }
        
        
		
        if( (int)$_POST['loaded'] ){
            $args['offset'] = (int)$_POST['loaded'];
        }
		
        $wpestate_options['content_class']='col-md-12';
        $wpestate_options['sidebar_class']='x';
      
	  
	  
        $prop_selection = wpestate_return_filtered_by_order($args);
        
        
        if( $prop_selection->have_posts() ){
               
            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                include( locate_template('templates/property_unit'.$property_card_type_string.'.php' ) );
            endwhile;
           
        }else{
            print '<span class="no_results">'. esc_html__("We didn't find any results","wpresidence").'</>';
        }

        die();
    }
endif;

// agent page property listing call
add_action( 'wp_ajax_nopriv_wpestate_agent_listings', 'wpestate_agent_listings' );  
add_action( 'wp_ajax_wpestate_agent_listings', 'wpestate_agent_listings' );

if( !function_exists('wpestate_agent_listings') ):
    
    function wpestate_agent_listings(){
        check_ajax_referer( 'wpestate_agent_listings_nonce', 'security' );
        global $wpestate_options;
        global $wpestate_no_listins_per_row;
        global $wpestate_custom_unit_structure;
        global $show_remove_fav;
        global $prop_unit_class;
        global $wpestate_prop_unit;
        global $wpestate_property_unit_slider;
        global $custom_post_type;
        global $col_class;
        global $wpestate_custom_unit_structure;
        global $wpestate_no_listins_per_row;
        global $wpestate_uset_unit;
        global $wpestate_included_ids;
    
  
        $wpestate_currency                   =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency                     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
        
        $term_name=esc_html($_POST['term_name']);
        $agent_id = esc_html($_POST['agent_id']);
        $post_id = esc_html($_POST['post_id']);
        
        
        $show_compare               =   1;
        $align_class                =   '';
        $wpestate_prop_unit                  =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
        $prop_unit_class            =   '';
        if($wpestate_prop_unit=='list'){
            $prop_unit_class="ajax12";
            $align_class=   'the_list_view';
        }
     
  
        $wpestate_uset_unit         =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
        $wpestate_no_listins_per_row         =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
        $wpestate_custom_unit_structure      =   wpresidence_get_option('wpestate_property_unit_structure');
        $taxonmy                    =   get_query_var('taxonomy');
        $term                       =   get_query_var( 'term' );
        $wpestate_property_unit_slider       =   wpresidence_get_option('wp_estate_prop_list_slider','');
        $property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
        $property_card_type_string  =   '';
        if($property_card_type==0){
            $property_card_type_string='';
        }else{
            $property_card_type_string='_type'.$property_card_type;
        }

        if( is_tax() && $custom_post_type=='estate_agent'){
        global $wpestate_no_listins_per_row;
        $wpestate_no_listins_per_row       =   intval( wpresidence_get_option('wp_estate_agent_listings_per_row', '') );

        $col_class=4;
        if($wpestate_options['content_class']=='col-md-12'){
            $col_class=3;
        }

        if($wpestate_no_listins_per_row==3){
            $col_class  =   '6';
            $col_org    =   6;
            if($wpestate_options['content_class']=='col-md-12'){
                $col_class  =   '4';
                $col_org    =   4;
            }
        }else{   
            $col_class  =   '4';
            $col_org    =   4;
            if($wpestate_options['content_class']=='col-md-12'){
                $col_class  =   '3';
                $col_org    =   3;
            }
        }

        }
        
        $page_id        =   get_user_meta($agent_id,'user_agent_id',true);
        $wpestate_options        =   wpestate_page_details($page_id);
  
    
        $show_remove_fav=0;
        wp_suspend_cache_addition(false);
        $wpestate_uset_unit                  =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
        $wpestate_no_listins_per_row         =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
	$wpestate_custom_unit_structure      =   wpresidence_get_option('wpestate_property_unit_structure');	
        $property_card_type                  =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
        $property_card_type_string           =   '';
        $prop_no                             =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
      
        if($property_card_type==0){
            $property_card_type_string='';
        }else{
            $property_card_type_string='_type'.$property_card_type;
        }
  
     
        $action_array=array(
			'taxonomy'     => 'property_category',
			'field'        => 'slug',
                        'terms'        => $term_name
        );
  

		if( $agent_id == '-1' ){
			$args = array(
				'post_type'         =>  'estate_property',
				 
				'paged'             =>  $paged,
				'posts_per_page'    =>  $prop_no,
				'post_status'       => 'publish',
				'meta_key'          => 'prop_featured',
				'orderby'           => 'meta_value',
				'order'             => 'DESC',
				'tax_query'         =>  array(
                                                            'relation' => 'AND',
                                                            $action_array,
                                                            ),
				'meta_query'        =>  array(
                                                            array(
                                                                    'key'     => 'property_agent',
                                                                    'value'   => $post_id,
                                                            ),
                                                        ),
				);
		}else{
			$args = array(
				'post_type'         =>  'estate_property',
				'author'            =>  $agent_id,
				'paged'             =>  $paged,
				'posts_per_page'    =>  $prop_no,
				'post_status'       =>  'publish',
				'meta_key'          =>  'prop_featured',
				'orderby'           =>  'meta_value',
				'order'             =>  'DESC',
				'tax_query'         =>  array(
                                                            'relation' => 'AND',
                                                            $action_array,
                                                        )
				);
		}
        
  
        if( (int)$_POST['loaded'] ){
            $args['offset'] = (int)$_POST['loaded'];
        }

        if($term_name=='all'){
            unset($args['tax_query']);
        }
       
        $prop_selection = wpestate_return_filtered_by_order($args);
	 
        if( $prop_selection->have_posts() ){
               
            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                include( locate_template('templates/property_unit'.$property_card_type_string.'.php') );
            endwhile;
 		
        }else{
            print '<span class="no_results">'. esc_html__("We didn't find any results","wpresidence").'</>';
        }

        die();
    }
endif;





add_action( 'wp_ajax_nopriv_wpestate_classic_ondemand_directory', 'wpestate_classic_ondemand_directory' );  
add_action( 'wp_ajax_wpestate_classic_ondemand_directory', 'wpestate_classic_ondemand_directory' );

if( !function_exists('wpestate_classic_ondemand_directory') ):
    
    function wpestate_classic_ondemand_directory(){
        //check_ajax_referer( 'wpestate_ajax_filtering', 'security' );
        global $wpestate_options;
        global $wpestate_no_listins_per_row;
        global $wpestate_custom_unit_structure;
        global $prop_unit_class;
        global $wpestate_prop_unit;
        global $wpestate_currency;
        global $where_currency;
        global $wpestate_property_unit_slider ;
        global $wpestate_uset_unit;
        

        $wpestate_property_unit_slider      =   wpresidence_get_option('wp_estate_prop_list_slider','');
        $wpestate_currency                  =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency                     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
        $wpestate_prop_unit                 =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
        $prop_unit_class            =   '';
        if($wpestate_prop_unit=='list'){
            $prop_unit_class="ajax12";
            $align_class=   'the_list_view';
        }


        wp_suspend_cache_addition(false);
        $wpestate_uset_unit         =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
        $wpestate_no_listins_per_row         =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
        $wpestate_custom_unit_structure      =   wpresidence_get_option('wpestate_property_unit_structure');
        $property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
        $property_card_type_string  =   '';
       
        if($property_card_type==0){
            $property_card_type_string='';
        }else{
            $property_card_type_string='_type'.$property_card_type;
        }

        $allowed_html=array();
        $type_name      =   'category_values';
        $type_name_value=   wp_kses( $_REQUEST[$type_name] ,$allowed_html );
        $action_name    =   'action_values';
        if(isset($_REQUEST[$action_name] )){
            $action_name_value  = wp_kses( $_REQUEST[$action_name] ,$allowed_html );
        }else{
            $action_name_value='';
        }

        if ( $type_name_value!='all' && $type_name_value!='' ){
            $taxcateg_include   =   array();     
            $taxcateg_include   =   sanitize_title ( wp_kses( $type_name_value ,$allowed_html ) );

            $categ_array=array(
                'taxonomy'     => 'property_category',
                'field'        => 'slug',
                'terms'        => $taxcateg_include
            );
        }

        if ( $action_name_value !='all' && $action_name_value !='') {
            $taxaction_include   =   array();   
            $taxaction_include   =   sanitize_title ( wp_kses( $action_name_value ,$allowed_html) );   

            $action_array=array(
                 'taxonomy'     => 'property_action_category',
                 'field'        => 'slug',
                 'terms'        => $taxaction_include
            );
         }

        if (isset($_REQUEST['city']) and $_REQUEST['city'] != 'all' && $_REQUEST['city'] != '') {
            $taxcity[] = sanitize_title ( wp_kses ( $_REQUEST['city'],$allowed_html ) );
            $city_array = array(
                'taxonomy'     => 'property_city',
                'field'        => 'slug',
                'terms'        => $taxcity
             );
         }


        if (isset($_REQUEST['area']) and $_REQUEST['area'] != 'all' && $_REQUEST['area'] != '') {
            $taxarea[] = sanitize_title ( wp_kses ($_REQUEST['area'],$allowed_html) );
            $area_array = array(
                'taxonomy'     => 'property_area',
                'field'        => 'slug',
                'terms'        => $taxarea
            );
        }

        
        
        
        if (isset($_REQUEST['county']) and $_REQUEST['county'] != 'all' && $_REQUEST['county'] != '') {
            $taxarea[] = sanitize_title ( wp_kses ($_REQUEST['county'],$allowed_html) );
            $county_array = array(
                'taxonomy'     => 'property_county_state',
                'field'        => 'slug',
                'terms'        => $taxarea
            );
        }
        
         
        $pagination = intval($_POST['pagination']);
         
        $price_low='';
        if( isset($_POST['price_low'])){
            $price_low = floatval( $_POST['price_low'] );
        }
        
        $price_max='';
        if( isset($_POST['price_max'])){
            $price_max = floatval( $_POST['price_max'] );
        }
        
        $min_size='';
        if( isset($_POST['min_size'])){
            $min_size =wpestate_convert_measure( floatval( $_POST['min_size'] ));
        }
        
        $max_size='';
        if( isset($_POST['max_size'])){
            $min_size = wpestate_convert_measure(floatval( $_POST['max_size']) );
        }
        
        $min_lot_size='';
        if( isset($_POST['min_lot_size'])){
            $min_lot_size= wpestate_convert_measure(floatval( $_POST['min_lot_size']) );
        }
        
        $max_lot_size='';
        if( isset($_POST['max_lot_size'])){
            $min_lot_size= wpestate_convert_measure(floatval( $_POST['max_lot_size'] ));
        }
        
        $min_rooms='';
        if( isset($_POST['min_rooms'])){
            $min_rooms= floatval( $_POST['min_rooms'] );
        }
        
        $max_rooms='';
        if( isset($_POST['max_rooms'])){
            $max_rooms= floatval( $_POST['max_rooms'] );
        }
        
        $min_bedrooms='';
        if( isset($_POST['min_bedrooms'])){
            $min_bedrooms= floatval( $_POST['min_bedrooms'] );
        }
        
        $max_bedrooms='';
        if( isset($_POST['max_bedrooms'])){
            $max_bedrooms= floatval( $_POST['max_bedrooms'] );
        }
        
        $min_bathrooms='';
        if( isset($_POST['min_bathrooms'])){
            $min_bathrooms= floatval( $_POST['min_bathrooms'] );
        }
        
        $max_bathrooms='';
        if( isset($_POST['max_bathrooms'])){
            $max_bathrooms= floatval( $_POST['max_bathrooms'] );
        }
        
        $status='';
        $status_array='';
        if( isset($_POST['status']) && $_POST['status']!=''){
            $status = esc_html( $_POST['status'] );
            $status= html_entity_decode($status,ENT_QUOTES);
          
            $status_array = array(
                'taxonomy'     => 'property_status',
                'field'        => 'name',
                'terms'        => $status
            );
            
        }
        
        
        
        
        $wpestate_keyword='';
        if( isset($_POST['keyword'])){
            $wpestate_keyword = esc_html( $_POST['keyword'] );
        }
        
        $meta_order         =   'prop_featured';
        $meta_directions    =   'DESC';   
        $order_by           =   'meta_value';
    
        if(isset($_POST['order'])) {
            $order=  wp_kses( $_POST['order'],$allowed_html );
            switch ($order){
                case 1:
                    $meta_order='property_price';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 2:
                    $meta_order='property_price';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
                case 3:
                    $meta_order='';
                    $meta_directions='DESC';
                    $order_by='ID';
                    break;
                case 4:
                    $meta_order='';
                    $meta_directions='ASC';
                    $order_by='ID';
                    break;
                case 5:
                    $meta_order='property_bedrooms';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 6:
                    $meta_order='property_bedrooms';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
                case 7:
                    $meta_order='property_bathrooms';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 8:
                    $meta_order='property_bedrooms';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
            }
        }
  
        $price_max          =   '';
        $custom_fields      =   wpresidence_get_option( 'wp_estate_multi_curr', '');
        $price_low          =   floatval($_REQUEST['price_low']);
        
        if( isset($_REQUEST['price_max'])  && $_REQUEST['price_max'] && floatval($_REQUEST['price_max'])>0 ){
            $price_max          = floatval($_REQUEST['price_max']);
            
            if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                $i=intval($_COOKIE['my_custom_curr_pos']);
                $price_max       =   $price_max / $custom_fields[$i][2];
                $price_low       =   $price_low / $custom_fields[$i][2];
            }
            
            
            $price['key']       = 'property_price';
            $price['value']     = array($price_low, $price_max);
            $price['type']      = 'numeric';
            $price['compare']   = 'BETWEEN';
            $meta_query[]       = $price;
        }
        
   
        $max_size               =   wpestate_convert_measure ( floatval($_REQUEST['max_size']),1 );
        $min_size               =   wpestate_convert_measure ( floatval($_REQUEST['min_size']),1 );
        $size_array             =   array(); 
        $size_array['key']      =   'property_size';
        $size_array['value']    =   array($min_size, $max_size);
        $size_array['type']     =   'numeric';
        $size_array['compare']  =   'BETWEEN';
        $meta_query[]           =   $size_array;
       
        
        $max_lot_size               =   wpestate_convert_measure ( floatval($_REQUEST['max_lot_size']),1);
        $min_lot_size               =   wpestate_convert_measure ( floatval($_REQUEST['min_lot_size']),1);
        $lotsize_array              =   array(); 
        $lotsize_array['key']       =   'property_lot_size';
        $lotsize_array['value']     =   array($min_lot_size, $max_lot_size);
        $lotsize_array['type']      =   'numeric';
        $lotsize_array['compare']   =   'BETWEEN';
        $meta_query[]               =   $lotsize_array;
    
        
        $max_rooms                  =   floatval($_REQUEST['max_rooms']);
        $min_rooms                  =   floatval($_REQUEST['min_rooms']);
        $rooms_array                =   array(); 
        $rooms_array['key']         =   'property_rooms';
        $rooms_array['value']       =   array($min_rooms, $max_rooms);
        $rooms_array['type']        =   'numeric';
        $rooms_array['compare']     =   'BETWEEN';
        $meta_query[]               =   $rooms_array;
        
        
         
        $max_bedrooms                  =   floatval($_REQUEST['max_bedrooms']);
        $min_bedrooms                  =   floatval($_REQUEST['min_bedrooms']);
        $bedrooms_array                =   array(); 
        $bedrooms_array['key']         =   'property_bedrooms';
        $bedrooms_array['value']       =   array($min_bedrooms, $max_bedrooms);
        $bedrooms_array['type']        =   'numeric';
        $bedrooms_array['compare']     =   'BETWEEN';
        $meta_query[]                  =   $bedrooms_array;
        
        
        $max_bathrooms                 =   floatval($_REQUEST['max_bathrooms']);
        $min_bathrooms                 =   floatval($_REQUEST['min_bathrooms']);
        $bedrooms_array                =   array(); 
        $bedrooms_array['key']         =   'property_bathrooms';
        $bedrooms_array['value']       =   array($min_bathrooms, $max_bathrooms);
        $bedrooms_array['type']        =   'numeric';
        $bedrooms_array['compare']     =   'BETWEEN';
        $meta_query[]                  =   $bedrooms_array;
        
        
    
        
        
        $prop_no    =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
        $features_array = wpestate_add_feature_to_search('ajax');
        $args = array(
            'cache_results'             =>  false,
            'update_post_meta_cache'    =>  false,
            'update_post_term_cache'    =>  false,

            'post_type'       => 'estate_property',
            'post_status'     => 'publish',
            'paged'           => $pagination,
            'posts_per_page'  => $prop_no,
            'meta_key'        => $meta_order,
            'orderby'         => $order_by,
            'order'           => $meta_directions,
            'tax_query'       => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $city_array,
                                    $area_array,
                                    $county_array,
                                    $features_array,
                                    $status_array

                                )
        );      
           
      
        $features = array();
        $metas = wpestate_convert_meta_to_postin($meta_query);
        if( !empty($metas)){
            $all_ids = $metas;
        }
        
        

        
        
        if(empty($all_ids)){
            $all_ids[]=0;
        }
        
      
        $args['post__in']=$all_ids;
       
        
        global $wpestate_keyword;
        $wpestate_keyword=esc_html ( $_POST['keyword']);
        
        if( !empty($wpestate_keyword)  ){
          add_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
        }
          
        $prop_selection= new Wp_Query($args);

      
        ob_start();
     
        if( $prop_selection->have_posts() ){
            if($pagination==1){
                print '<h1 style="margin-left: 15px;" class="entry-title title_prop half_results">'.$prop_selection->found_posts.' '.esc_html__('listings','wpresidence').'</h1>';   
            }
            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                 include( locate_template('templates/property_unit'.$property_card_type_string.'.php') );
            endwhile;
         
        }else{
            print '<span class="no_results">'. esc_html__("We didn't find any results","wpresidence").'</>';
        }

        $cards= ob_get_contents();
        ob_end_clean();
      

        if( !empty($wpestate_keyword) ){
            if(function_exists('wpestate_disable_filtering')){
                wpestate_disable_filtering( 'posts_where', 'wpestate_title_filter', 10, 2 );
            }
        }
         
    
        
        echo json_encode( array(    
                            'args'      =>  $args, 
                            'cards'   =>  $cards,
                            'no_results'=>  $prop_selection->found_posts,
                        ));
       wp_suspend_cache_addition(false);     
       die();
  }
  
 endif; // end   ajax_filter_listings 


function wpestate_show_license_form(){
    
    $theme_activated    =   get_option('is_theme_activated','');
    $ajax_nonce         =   wp_create_nonce( "my-check_ajax_license-string" );
    $current_screen= get_current_screen();
    
    if( $current_screen->id!='toplevel_page_WpResidence'){
        if( get_option('wp_estate_disable_notice','')=='yes' ){
            return;
        }
    }
              
      
      
    $return =1;
    
    
    if($theme_activated!='is_active'){
        
        $theme_active_time = get_option('activation_time','');
        if($theme_active_time==''){
            update_option('activation_time',time());
        }
        $ajax_nonce = wp_create_nonce( "wpestate_close_notice_nonce" );
        $ajax_nonce1 = wp_create_nonce( "wpestate_license_ajax_nonce" );
        print'<input type="hidden" id="wpestate_close_notice_nonce" value="'.esc_html($ajax_nonce).'" />    ';
        print '<div class="license_check_wrapper" id="license_check_wrapper">';
            echo' <div class="activate_notice notice_here">'.esc_html__('Please validate your purchase code in order to use the theme! See this link link  ','wpresidence') .'<a href="http://help.wpresidence.net/article/how-to-get-your-buyer-license-code/" target="_blank">link</a> '.esc_html__('if you don\'t know how to get your license key. Thank you!','wpresidence').'</div>';
           print '<div class="license_form">
                <input type="text" id="wpestate_license_key" name="wpestate_license_key">
                <input type="submit" name="submit" id="check_ajax_license" class="new_admin_submit" value="Check License">
                <input type="hidden" id="license_ajax_nonce" name="license_ajax_nonce" value="'.$ajax_nonce1.'">

            </div>';
            
            
        print '</div>';
////                <div class="activate_notice" id="wpestate_close_notice">'.esc_html__('Close this notice','wpresidence').'</div>
    }
    return $return;
          
}

                            

function wpestate_secondary_lic(){
 
    $theme_activated    =   get_option('is_theme_activated','');
    if($theme_activated!='is_active'){
        
        $theme_active_time = get_option('activation_time','');
        if($theme_active_time==''){
            update_option('activation_time',time());
        }
    
        if( $theme_active_time +24*60*60 < time() ){
            exit();            
        }
        
    }
}




add_action( 'wpestate_ajax_handler_nopriv_wpestate_load_recent_items_sh', 'wpestate_load_recent_items_sh' );  
add_action( 'wpestate_ajax_handler_wpestate_load_recent_items_sh', 'wpestate_load_recent_items_sh' );

if( !function_exists('wpestate_load_recent_items_sh') ):
    function wpestate_load_recent_items_sh(){
       // check_ajax_referer( 'wpestate_ajax_filtering', 'security' );
        $type                   =   sanitize_text_field($_POST['type']);
        $category_ids           =   sanitize_text_field($_POST['category_ids']);
        $action_ids             =   sanitize_text_field($_POST['action_ids']);
        $city_ids               =   sanitize_text_field($_POST['city_ids']);
        $area_ids               =   sanitize_text_field($_POST['area_ids']);
        $state_ids              =   sanitize_text_field($_POST['state_ids']);
        $status_ids             =   sanitize_text_field($_POST['status']);
        $number                 =   sanitize_text_field($_POST['number']);
        $align                  =   sanitize_text_field($_POST['align']);
        $show_featured_only     =   sanitize_text_field($_POST['show_featured_only']);
        $random_pick            =   sanitize_text_field($_POST['random_pick']);
        $featured_first         =   sanitize_text_field($_POST['featured_first']);
        $page                   =   intval($_POST['page']);
        $row_number             =   intval($_POST['row_number']);
  
        echo wpestate_display_listings_sh($page,$type ,$category_ids,$action_ids, $city_ids, $area_ids, $state_ids,$status_ids, $number, $align, $show_featured_only, $random_pick, $featured_first,$row_number);
  
        die();
    
    }
endif;



function wpestate_display_listings_sh($page,$type ,$category_ids,$action_ids, $city_ids, $area_ids, $state_ids,$status_ids, $number, $align_received, $show_featured_only, $random_pick, $featured_first,$row_number){
    $orderby='';
    global $wpestate_options;
    global $align;
    global $align_class;
    global $post;
    global $wpestate_currency;
    global $where_currency;
    global $is_shortcode;
    global $show_compare_only;
    global $row_number_col;    
    global $current_user;
    global $curent_fav;
    global $wpestate_property_unit_slider;
    global $wpestate_no_listins_per_row;
    global $wpestate_uset_unit;
    global $wpestate_custom_unit_structure;
    $is_shortcode       =   1;
    $wpestate_currency                   =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
    $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
    $wpestate_custom_unit_structure    =   wpresidence_get_option('wpestate_property_unit_structure');
    $wpestate_uset_unit       =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
    $wpestate_no_listins_per_row       =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
    $userID             =   $current_user->ID;
    $user_option        =   'favorites'.$userID;
    $curent_fav         =   get_option($user_option);
    $wpestate_property_unit_slider = wpresidence_get_option('wp_estate_prop_list_slider','');
    
    $property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
    $property_card_type_string  =   '';
    if($property_card_type==0){
        $property_card_type_string='';
    }else{
        $property_card_type_string='_type'.$property_card_type;
    }
      
    
    if( $row_number == 4 ){
        $row_number_col = 3; // col value is 3 
    }else if( $row_number==3 ){
        $row_number_col = 4; // col value is 4
    }else if ( $row_number==2 ) {
        $row_number_col =  6;// col value is 6
    }else if ($row_number==1) {
        $row_number_col =  12;// col value is 12
        if($align_received=='vertical'){
             $row_number_col =  0;
        }
    }
    

    $align_class='';
    if($align_received =='horizontal'){
        $align="col-md-12";
      
        $align_class='the_list_view';
        $row_number_col='12';
    }
    

    
    if($random_pick==='yes'){
        $orderby    =   'rand';
    }
    
  
    if ($type == 'estate_property') {
        $type = 'estate_property';
        
        $category_array =   '';
        $action_array   =   '';
        $city_array     =   '';
        $area_array     =   '';
        $state_array    =   '';
        $status_array   =   '';
        // build category array
        if($category_ids!=''){
            $category_of_tax=array();
            $category_of_tax=  explode(',', $category_ids);
            $category_array=array(     
                            'taxonomy'  => 'property_category',
                            'field'     => 'term_id',
                            'terms'     => $category_of_tax
                            );
        }
            
        
        // build action array
        if($action_ids!=''){
            $action_of_tax=array();
            $action_of_tax=  explode(',', $action_ids);
            $action_array=array(     
                            'taxonomy'  => 'property_action_category',
                            'field'     => 'term_id',
                            'terms'     => $action_of_tax
                            );
        }
        
        // build city array
        if($city_ids!=''){
            $city_of_tax=array();
            $city_of_tax=  explode(',', $city_ids);
            $city_array=array(     
                            'taxonomy'  => 'property_city',
                            'field'     => 'term_id',
                            'terms'     => $city_of_tax
                            );
        }
        
        // build city array
        if($area_ids!=''){
            $area_of_tax=array();
            $area_of_tax=  explode(',', $area_ids);
            $area_array=array(     
                            'taxonomy'  => 'property_area',
                            'field'     => 'term_id',
                            'terms'     => $area_of_tax
                            );
        }
        
        if($state_ids!=''){
            $state_of_tax   =   array();
            $state_of_tax   =   explode(',', $state_ids);
            $state_array    =   array(     
                                'taxonomy'  => 'property_county_state',
                                'field'     => 'term_id',
                                'terms'     => $state_of_tax
                            );
        }
           
        
   
        if($status_ids!=''){
            $state_of_tax   =   array();
            $state_of_tax   =   explode(',', $status_ids);
            $status_array    =   array(     
                                'taxonomy'  => 'property_status',
                                'field'     => 'term_id',
                                'terms'     => $state_of_tax
                            );
        }
        
        
        
        
        $meta_query=array();                
        if($show_featured_only=='yes'){
            $compare_array=array();
            $compare_array['key']        = 'prop_featured';
            $compare_array['value']      = 1;
            $compare_array['type']       = 'numeric';
            $compare_array['compare']    = '=';
            $meta_query[]                = $compare_array;
        }

        if($featured_first=="no"){
            $orderby='ID';
        }
            
        $args = array(
            'post_type'         => $type,
            'post_status'       => 'publish',
            'paged'             => $page,
            'posts_per_page'    => $number,
            'meta_key'          => 'prop_featured',
            'orderby'           => $orderby,
            'order'             => 'DESC',
            'meta_query'        => $meta_query,
            'tax_query'         => array( 
                                    $category_array,
                                    $action_array,
                                    $city_array,
                                    $area_array,
                                    $state_array,
                                    $status_array
                                )

        );
        
          
    } else {
        $type = 'post';
  
       
        
        $args = array(
            'post_type'      => $type,
            'post_status'    => 'publish',
            'paged'          => $page,
            'posts_per_page' => $number,
            'orderby'        => $orderby,
           // 'cat'            => $category_ids
        );
   
    }
    
    
     if ($type == 'estate_property') {
        if($random_pick !=='yes'){
            if($featured_first=='yes'){
                add_filter( 'posts_orderby', 'wpestate_my_order' ); 
            }
            
            $recent_posts = new WP_Query($args);
            $count = 1;
            if($featured_first=='yes'){
                if(function_exists('wpestate_disable_filtering')){
                    wpestate_disable_filtering( 'posts_orderby', 'wpestate_my_order' );
                }
            }
        }else{
           
            $args['orderby']    =   'rand';
            $recent_posts = new WP_Query($args); 
            $count = 1;
        }
   
    }else{
        $recent_posts = new WP_Query($args);
        $count = 1;
    }
    

    ob_start();  
    $return_string='';
    while ($recent_posts->have_posts()): $recent_posts->the_post();
        if($type == 'estate_property'){
              include( locate_template('templates/property_unit'.$property_card_type_string.'.php') );
        } else {
         
            if( $align_received && $align_received == 'horizontal' ){
                include( locate_template('templates/blog_unit.php') ) ;
            }else{
		 include( locate_template('templates/blog_unit2.php') ) ;
            }
            
        }
    endwhile;

    $templates = ob_get_contents();
    ob_end_clean(); 
       wp_reset_query();
    $return_string .=$templates;
      
     $is_shortcode       =   0;
    return $return_string;
    
}



////////////////////////////////////////////////////////////////////////////////
// on demand pins - 

add_action( 'wpestate_ajax_handler_wpestate_custom_ondemand_pin_load', 'wpestate_custom_ondemand_pin_load' );  
add_action( 'wpestate_ajax_handler_nopriv_wpestate_custom_ondemand_pin_load', 'wpestate_custom_ondemand_pin_load' );

if( !function_exists('wpestate_custom_ondemand_pin_load') ):   
    function wpestate_custom_ondemand_pin_load(){
        //check_ajax_referer( 'wpestate_ajax_filtering', 'security' );
        wp_suspend_cache_addition(false);
        global $wpestate_keyword;
        $args =  wpestate_search_results_custom ('ajax');
        
        $adv_search_what    =   wpresidence_get_option('wp_estate_adv_search_what','');
        $adv_search_label   =   wpresidence_get_option('wp_estate_adv_search_label','');  
        
        
            
        $adv_search_fields_no       =   floatval( wpresidence_get_option('wp_estate_adv_search_fields_no') );
        $term_counter               =   intval($_REQUEST['term_counter']);
        $adv_search_what    =   array_slice($adv_search_what, ( $term_counter*$adv_search_fields_no),$adv_search_fields_no);
        $adv_search_how     =   array_slice($adv_search_how,    ($term_counter*$adv_search_fields_no),$adv_search_fields_no);
  
    
        $return_custom      =   wpestate_search_with_keyword_ajax($adv_search_what, $adv_search_label);
        
        if( isset( $return_custom['id_array']) ){
            $id_array       =   $return_custom['id_array']; 
            if($id_array!=0){
                $args=  array(  'post_type'     =>    'estate_property',
                            'p'             =>    $id_array
                );
            }
        }
        
        if(isset($return_custom['keyword'])){
            $wpestate_keyword        =   $return_custom['keyword'];
        }
        if( isset($_POST['keyword_search']) && trim($_POST['keyword_search'])!='' ){
            $allowed_html       =   array();
            $wpestate_keyword            =   esc_attr(  wp_kses ( $_POST['keyword_search'], $allowed_html));
       
        }
        //kraka
        $args['page']=1;
        $args['posts_per_page']=intval( wpresidence_get_option('wp_estate_map_max_pins') );
        
        
       
        
        $on_demand_results = wpestate_listing_pins_on_demand($args,0);
      
         
        echo json_encode( array(  
                            'xxx'       =>  $return_custom,
                            'args'      =>  $args, 
                            'markers'   =>  $on_demand_results['markers'],
                            'no_results'=>  $on_demand_results['results'] 
                        ));
       wp_suspend_cache_addition(false);     
       die();
  }
  
 endif; // end   ajax_filter_listings 
 

 
  
add_action( 'wpestate_ajax_handler_nopriv_wpestate_classic_ondemand_pin_load_type2_tabs', 'wpestate_classic_ondemand_pin_load_type2_tabs' );  
add_action( 'wpestate_ajax_handler_wpestate_classic_ondemand_pin_load_type2_tabs', 'wpestate_classic_ondemand_pin_load_type2_tabs' );

if( !function_exists('wpestate_classic_ondemand_pin_load_type2_tabs') ):
    
    function wpestate_classic_ondemand_pin_load_type2_tabs(){
       // check_ajax_referer( 'wpestate_ajax_filtering', 'security' );
        wp_suspend_cache_addition(false);
   
        $args =  wpestated_advanced_search_tip2_ajax_tabs ();
        //krakau
        $args['page']=1;
        $args['posts_per_page']=intval( wpresidence_get_option('wp_estate_map_max_pins') );
        $on_demand_results = wpestate_listing_pins_on_demand($args);
      
         
        echo json_encode( array(    
                            'args'      =>  $args, 
                            'markers'   =>  $on_demand_results['markers'],
                            'no_results'=>  $on_demand_results['results'] 
                        ));
       wp_suspend_cache_addition(false);     
       die();
  }
  
 endif; // end   ajax_filter_listings 
 
add_action( 'wp_ajax_nopriv_wpestate_classic_ondemand_pin_load_type2', 'wpestate_classic_ondemand_pin_load_type2' );  
add_action( 'wp_ajax_wpestate_classic_ondemand_pin_load_type2', 'wpestate_classic_ondemand_pin_load_type2' );

if( !function_exists('wpestate_classic_ondemand_pin_load_type2') ):
    
    function wpestate_classic_ondemand_pin_load_type2(){
       // check_ajax_referer( 'wpestate_ajax_filtering', 'security' );
        wp_suspend_cache_addition(false);
        
        $args =  wpestated_advanced_search_tip2_ajax ();
        
        //krakau
        $args['page']=1;
        $args['posts_per_page']=intval( wpresidence_get_option('wp_estate_map_max_pins') );
        $on_demand_results = wpestate_listing_pins_on_demand($args);
        
         
        echo json_encode( array(    
                            'args'      =>  $args, 
                            'markers'   =>  $on_demand_results['markers'],
                            'no_results'=>  $on_demand_results['results'] 
                        ));
       wp_suspend_cache_addition(false);     
       die();
  }
  
 endif; // end   ajax_filter_listings 
 
 
 
////////////////////////////////////////////////////////////////////////////////
// on demand pins - 

add_action( 'wp_ajax_nopriv_wpestate_classic_ondemand_pin_load', 'wpestate_classic_ondemand_pin_load' );  
add_action( 'wp_ajax_wpestate_classic_ondemand_pin_load', 'wpestate_classic_ondemand_pin_load' );

if( !function_exists('wpestate_classic_ondemand_pin_load') ):
    
    function wpestate_classic_ondemand_pin_load(){
       // check_ajax_referer( 'wpestate_ajax_filtering', 'security' );
        wp_suspend_cache_addition(false);
        
        $args                   =  wpestate_search_results_default ('ajax');
        $args['page']           =   1;
        $args['posts_per_page'] =   intval( wpresidence_get_option('wp_estate_map_max_pins') );

        $on_demand_results      =   wpestate_listing_pins_on_demand($args);
        
         
        echo json_encode( array(    
                            'args'      =>  $args, 
                            'markers'   =>  $on_demand_results['markers'],
                            'no_results'=>  $on_demand_results['results'] 
                        ));
       wp_suspend_cache_addition(false);     
       die();
  }
  
 endif; // end   ajax_filter_listings 
 





////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_filter_listings_search', 'wpestate_ajax_filter_listings_search' );  
add_action( 'wp_ajax_wpestate_ajax_filter_listings_search', 'wpestate_ajax_filter_listings_search' );

if( !function_exists('wpestate_ajax_filter_listings_search') ):
    
    function wpestate_ajax_filter_listings_search(){
        //check_ajax_referer( 'wpestate_ajax_filtering', 'security' );
        wp_suspend_cache_addition(false);
        global $post;
        global $wpestate_options;
        global $show_compare_only;
        global $wpestate_currency;
        global $where_currency;
        global $wpestate_property_unit_slider;
        global $is_col_md_12;
        global $wpestate_prop_unit;
        global $wpestate_no_listins_per_row;
        global $wpestate_uset_unit;
        global $wpestate_custom_unit_structure;
        
        $wpestate_custom_unit_structure      =   wpresidence_get_option('wpestate_property_unit_structure');
        $wpestate_uset_unit         =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
        $wpestate_prop_unit                  =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
        $show_compare_only          =   'yes';
        if( get_option( 'page_on_front') == intval ( $_POST['postid']) ){
            $show_compare_only  =   'no'; 
        }  
        
        $property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
        $property_card_type_string  =   '';
        if($property_card_type  ==  0){
            $property_card_type_string  =   '';
        }else{
            $property_card_type_string  =   '_type'.$property_card_type;
        }
        
        
        
        $current_user               =   wp_get_current_user();
        $userID                     =   $current_user->ID;
        $user_option                =   'favorites'.$userID;
        $curent_fav                 =   get_option($user_option);
        $wpestate_currency                   =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
        $area_array                 =   '';  
        $city_array                 =   '';  
        $action_array               =   '';   
        $categ_array                =   '';
        $wpestate_property_unit_slider       =   wpresidence_get_option('wp_estate_prop_list_slider','');
        $wpestate_options                    =   wpestate_page_details(intval($_POST['postid']));
        $allowed_html               =   array();
        $wpestate_no_listins_per_row         =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
        $half_map =   0;
        if (isset($_POST['halfmap'])){
            $half_map = intval($_POST['halfmap']);
        }  
        
        $args =  wpestate_search_results_default ('ajax');

        $order= intval($_POST['order']);
        $meta_order         =   'prop_featured';
        $meta_directions    =   'DESC';   
        $order_by           =   'meta_value';
    
        if(isset($_POST['order'])) {
            $order=  wp_kses( $_POST['order'],$allowed_html );
            switch ($order){
                case 1:
                    $meta_order='property_price';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 2:
                    $meta_order='property_price';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
                case 3:
                    $meta_order='';
                    $meta_directions='DESC';
                    $order_by='ID';
                    break;
                case 4:
                    $meta_order='';
                    $meta_directions='ASC';
                    $order_by='ID';
                    break;
                case 5:
                    $meta_order='property_bedrooms';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 6:
                    $meta_order='property_bedrooms';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
                case 7:
                    $meta_order='property_bathrooms';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 8:
                    $meta_order='property_bedrooms';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
            }
        }
        
        
        
        $args ['meta_key']        = $meta_order;
        $args ['orderby']         = $order_by;
        $args ['order']           = $meta_directions;
        
 
        
        if(isset($_POST['order'])) {
            $prop_selection = new WP_Query($args);
        }else{
           $prop_selection = wpestate_return_filtered_by_order($args);
        }
  
        ob_start();  
        $counter          =   0;
        $compare_submit   =   wpestate_get_template_link('compare_listings.php');
        print '<span id="scrollhere"></span>';

       
        $paged      =   intval($_POST['newpage']);
      
        if( $prop_selection->have_posts() ){
                if($half_map==1){
                    $is_col_md_12=1;
                }
                while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                      include( locate_template('templates/property_unit'.$property_card_type_string.'.php') );
                endwhile;
            wpestate_pagination_ajax($prop_selection->max_num_pages, $range =2,$paged,'pagination_ajax_search'); 
        }else{
            print '<span class="no_results">'. esc_html__("We didn't find any results","wpresidence").'</>';
        }

       wp_suspend_cache_addition(false);  
       
         
        $cards= ob_get_contents();
        ob_end_clean();
        echo json_encode( array('sent'=>true, 'args'=>$args,'cards'=>$cards,'no_founs'=> $prop_selection->found_posts.' '.esc_html__('Listings','wpresidence') ) ); 
      
        
       die();
  }
  
 endif; // end   ajax_filter_listings 
 
















    
    


if( !function_exists('estate_property_page_design_tab_options') ):
function  estate_property_page_design_tab_options(){
    $tab_options = array(
    'description'=>array(
                    'label'=>'Description'
                    ),
    'property_address'=>array(
                    'label'=>'Property Address'
                    ),
    'property_details'=>array(
                    'label'=>'Property Details'
                    ),
    'amenities_features'=>array(
                    'label'=>'Amenities and Features'
                    ),
    'map'=>array(
                    'label'=>'Map'
                    ),
    'walkscore'=>array(
                    'label'=>'Walkscore'
                    ),
    'floor_plans'=>array(
                    'label'=>'Floor Plans'
                    ),
    'page_view'=>array(
                    'label'=>'Page Views'
                    ),
    );
}
endif;


if( !function_exists('estate_property_page_design_accordion_options') ):
function estate_property_page_design_accordion_options(){
    
}
endif;

if( !function_exists('estate_property_page_design_detailsoptions') ):
function estate_property_page_design_detailsoptions(){
    
}
endif;


























add_action( 'wp_ajax_wpestate_save_property_page_design', 'wpestate_save_property_page_design' );

if( !function_exists('wpestate_save_property_page_design') ):
    function wpestate_save_property_page_design(){
        
        check_ajax_referer( 'wpestate_save_prop_design', 'security' );
    
        if( !current_user_can('administrator') ){   
            exit('out pls');
        }
        
        $content=$_POST['content'];
        echo mb_detect_encoding($content);
        update_option('wpestate_property_page_content',$content);
        Redux::setOption('wpresidence_admin','wpestate_property_page_content', $content );
        

        
        $doc = new DOMDocument();
        $doc->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        
        
        $finder = new DomXPath($doc);
        $classname="prop_full_width";

        
        $divs = $doc->getElementsByTagName('div');
        $nodes = $finder->query("//*[contains(@class, '$classname')]");

        $structure_array = array();
        foreach ( $nodes as $div ) {
         
           $structure_array []= wpestate_unit_return_row($div);
        }
        update_option('wpestate_property_unit_structure',$structure_array);
        Redux::setOption('wpresidence_admin','wpestate_property_unit_structure',  $structure_array );
        die();
      
      
    }
 endif;   


 
 if( !function_exists('wpestate_unit_return_row') ):
 function  wpestate_unit_return_row($div){
     
     

        $return_array=array();
        foreach ( $div->childNodes as $rows ) {
          
        
            $class  =   stripslashes( trim( (string) $rows->getAttribute('class') ) );
            $class  =   str_replace('"', '', $class);
       
            if($class=='prop-columns'){
                $columns_array=array();
                
                foreach ( $rows->childNodes as $elements ) {
             
                    $class  =    stripslashes( trim( (string) $elements->getAttribute('class') ) );
                    $class  =    str_replace('"', '', $class);
                  
                
                    if($class==='design_element_col'){
                        $unit_element=array();
                        
                        $class_name     = ( $elements->getAttribute('data-mystyle-class')   );
                        $class_content  = ( $elements->getAttribute('data-mystyle') );
                        $element_name   = ( $elements->getAttribute('data-tip') );
                        $element_text   = ( $elements->getAttribute('data-custom-text') );
                        $element_icon   = ( $elements->getAttribute('data-icon-image') );
                        $element_font_s = ( $elements->getAttribute('data-font-size') );
                        $element_color  = ( $elements->getAttribute('data-color') );
                        $element_align  = ( $elements->getAttribute('data-text-align') );
                        $element_extra  = ( $elements->getAttribute('data-extra_css') );
                       
                        $unit_element['element_name']   =  wpestate_unit_data_cleam($element_name );
                        $unit_element['class_content']  =  wpestate_unit_data_cleam($class_content);
                        $unit_element['class_name']     =  wpestate_unit_data_cleam($class_name);
                        $unit_element['text']           =  wpestate_unit_data_cleam($element_text);
                        $unit_element['icon']           =  wpestate_unit_data_cleam($element_icon);
                        $unit_element['font']           =  wpestate_unit_data_cleam($element_font_s);
                        $unit_element['color']          =  wpestate_unit_data_cleam($element_color);
                        $unit_element['text-align']     =  wpestate_unit_data_cleam($element_align);
                        $unit_element['extra_class']    =  wpestate_unit_data_cleam($element_extra);
                      
                        $columns_array[]=$unit_element;
                    }
                }
                $return_array[]=$columns_array;
            }
        }

    return $return_array;            

        
}
endif; 

if( !function_exists('wpestate_unit_data_cleam') ):
function wpestate_unit_data_cleam($element){
    $element=(string)$element;
    $element  =   str_replace('\"', '', $element);
    return $element;
}
endif; 
 
if( !function_exists('wpestate_go_home') ):
 function wpestate_go_home($element){
    $element=(string)$element;
    $element  =   str_replace('\"', '', $element);
    return $element;
 }
endif;
 

 
 
 
 
add_action('wp_logout','wpestate_go_home');
if( !function_exists('wpestate_go_home') ):
function wpestate_go_home(){
    wp_redirect( esc_url( home_url('/') ) );
    exit();
}
endif;



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_disable_listing', 'wpestate_disable_listing' );

if( !function_exists('wpestate_disable_listing') ):
    function wpestate_disable_listing(){  
        if( isset($_POST['is_agent']) && intval($_POST['is_agent'])==1 ){
            check_ajax_referer( 'wpestate_agent_actions', 'security' );
        }else{
            check_ajax_referer( 'wpestate_property_actions', 'security' );
        }
        $current_user       =   wp_get_current_user();
        $userID             =   $current_user->ID;
        $user_login         =   $current_user->user_login;
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }

        $prop_id=intval($_POST['prop_id']);
        if(!is_numeric($prop_id)) {
            exit();
        }
        $agent_list                     =   (array)get_user_meta($userID,'current_agent_list',true);
        $the_post= get_post( $prop_id); 
       
        if( $current_user->ID != $the_post->post_author   &&  !in_array($the_post->post_author , $agent_list)  ) {    
            exit('you don\'t have the right to delete this');
        }
        
        if($the_post->post_status=='disabled'){
            $new_status='publish';
        }else{
            $new_status='disabled';
        }
        $my_post = array(
            'ID'           => $prop_id,
            'post_status'   => $new_status
        );

        wp_update_post( $my_post );
        die();       
    }
endif;    


////////////////////////////////////////////////////////////////////////////////
/// filter invoices
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_load_stats_property', 'wpestate_load_stats_property' );  
add_action( 'wp_ajax_wpestate_load_stats_property', 'wpestate_load_stats_property' );

if( !function_exists('wpestate_load_stats_property') ):
    function wpestate_load_stats_property(){
    check_ajax_referer( 'wpestate_tab_stats', 'security' );
    $listing_id     =   intval($_POST['postid']);
    
    $labels         =   wp_estate_return_traffic_labels($listing_id,30);
    $array_values   =   wp_estate_return_traffic_data($listing_id,30);
  
    echo json_encode( array('array_values'=>$array_values,'labels'=>$labels) );
    die();       
    }
 endif;   

////////////////////////////////////////////////////////////////////////////////
/// filter invoices
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_filter_invoices', 'wpestate_ajax_filter_invoices' );

if( !function_exists('wpestate_ajax_filter_invoices') ):
    function wpestate_ajax_filter_invoices(){
        check_ajax_referer( 'wpestate_invoices_actions', 'security' );
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
        
       
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        
        $start_date       =  sanitize_text_field( esc_html($_POST['start_date']) );
        $end_date         =  sanitize_text_field( esc_html($_POST['end_date']) );
        $type             =  sanitize_text_field( esc_html($_POST['type']) );
        $status           =  sanitize_text_field( esc_html($_POST['status']) );
        
        
        $meta_query =   array();
        
        if( isset($_POST['type']) &&  $_POST['type']!='' ){
            $temp_arr             =   array();
            $type                 =   esc_html($_POST['type']);
            $temp_arr['key']      =   'invoice_type';
            $temp_arr['value']    =   $type;
            $temp_arr['type']     =   'char';
            $temp_arr['compare']  =   'LIKE'; 
            $meta_query[]         =   $temp_arr;
        }
        
        
        if( isset($_POST['status']) &&  $_POST['status'] !='' ){
            $temp_arr             =   array();
            $type                 =   esc_html($_POST['status']);
            $temp_arr['key']      =   'pay_status';
            $temp_arr['value']    =   $type;
            $temp_arr['type']     =   'numeric';
            $temp_arr['compare']  =   '='; 
            $meta_query[]         =   $temp_arr;
        }
      
        $date_query=array();
        
        if( isset($_POST['start_date']) &&  $_POST['start_date'] !='' ){
            $start_date = esc_html( $_POST['start_date'] );
            $date_query ['after']  = $start_date; 
        }
         
        if( isset($_POST['end_date']) &&  $_POST['end_date'] !='' ){
            $end_date = esc_html( $_POST['end_date'] );
            $date_query ['before']  = $end_date; 
        }
       $date_query ['inclusive'] = true;
        
        $args = array(
            'post_type'        => 'wpestate_invoice',
            'post_status'      => 'publish',
            'posts_per_page'   => -1 ,
            'author'           => $userID, 
            'meta_query'       => $meta_query,
            'date_query'       => $date_query
        );
        
        
       
        $prop_selection = new WP_Query($args);
        $total_confirmed = 0;
        $total_issued=0;
            
        ob_start(); 
        while ($prop_selection->have_posts()): $prop_selection->the_post(); 
            include( locate_template('templates/invoice_listing_unit.php' ) ); 
            $inv_id=get_the_ID();
            $status = esc_html(get_post_meta($inv_id, 'invoice_status', true));
            $type   = esc_html(get_post_meta($inv_id, 'invoice_type', true));
            $price = esc_html(get_post_meta($inv_id, 'item_price', true));
            $total_confirmed = $total_confirmed + $price;
            
           
        endwhile;
        $templates = ob_get_contents();
        ob_end_clean(); 
             
     
        
       echo json_encode(array('results'=>$templates, 'invoice_confirmed'=> wpestate_show_price_custom_invoice ( $total_confirmed ) ));
       
        die();
    }
endif;







add_action( 'wp_ajax_wpestate_cancel_stripe', 'wpestate_cancel_stripe' );

if( !function_exists('wpestate_cancel_stripe') ):
    function wpestate_cancel_stripe(){
        check_ajax_referer( 'wpestate_stripe_cancel_nonce', 'security' );
        $current_user   =   wp_get_current_user();
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }


        global $wpestate_global_payments; 
        $wpestate_global_payments->stripe_payments->cancel_stripe_recurring();
        exit();
   
    }
endif;



add_action( 'wp_ajax_nopriv_wpestate_set_cookie_multiple_curr', 'wpestate_set_cookie_multiple_curr' );  
add_action( 'wp_ajax_wpestate_set_cookie_multiple_curr', 'wpestate_set_cookie_multiple_curr' );

if( !function_exists('wpestate_set_cookie_multiple_curr') ):
    function wpestate_set_cookie_multiple_curr(){
        check_ajax_referer( 'wpestate_change_currency', 'security' );
        $curr               =   sanitize_text_field($_POST['curr']);
        $pos                =   sanitize_text_field($_POST['pos']);
        $symbol             =   sanitize_text_field($_POST['symbol']);
        $coef               =   sanitize_text_field($_POST['coef']);
        $curpos             =   sanitize_text_field($_POST['curpos']);
     
        setcookie("my_custom_curr", $curr,time()+3600,"/");
        setcookie("my_custom_curr_pos", $pos,time()+3600,"/");
        setcookie("my_custom_curr_symbol", $symbol,time()+3600,"/");
        setcookie("my_custom_curr_coef", $coef,time()+3600,"/");
        setcookie("my_custom_curr_cur_post", $curpos,time()+3600,"/");
        
    }
endif;



////////////////////////////////////////////////////////////////////////////////
// set measure unit cookies
////////////////////////////////////////////////////////////////////////////////


add_action( 'wp_ajax_nopriv_wpestate_set_cookie_measure_unit', 'wpestate_set_cookie_measure_unit' );  
add_action( 'wp_ajax_wpestate_set_cookie_measure_unit', 'wpestate_set_cookie_measure_unit' );

if( !function_exists('wpestate_set_cookie_measure_unit') ):
    function wpestate_set_cookie_measure_unit(){
        check_ajax_referer( 'wpestate_change_measure', 'security' );
        $value               =   sanitize_text_field($_POST['value']);
 
        setcookie("my_measure_unit", $value ,time()+3600,"/");        
    }
endif;


////////////////////////////////////////////////////////////////////////////////
/// activate purchase
////////////////////////////////////////////////////////////////////////////////


add_action( 'wp_ajax_wpestate_activate_purchase_listing', 'wpestate_activate_purchase_listing' );

if( !function_exists('wpestate_activate_purchase_listing') ):
    function wpestate_activate_purchase_listing(){
    	check_ajax_referer( 'wpestate_activate_pack_listing', 'security' );
        if ( !is_user_logged_in() ) {   
            exit('out pls');
        }
     
        if( !current_user_can('administrator') ){
            exit('out pls');
        }
        
        $item_id            =   intval($_POST['item_id']);
        $invoice_id         =   intval($_POST['invoice_id']);
        $type               =   intval($_POST['type']);
        $owner_id           =   get_post_meta($invoice_id, 'buyer_id', true);
        
        $user               =   get_user_by('id',$owner_id); 
        $user_email         =   $user->user_email;
        
        if ($type==1) { // Listing
            update_post_meta($item_id, 'pay_status', 'paid');
            $post = array(
                    'ID'            => $item_id,
                    'post_status'   => 'publish'
                    );
            $post_id =  wp_update_post($post ); 
            
        }elseif ($type==2) { //Upgrade to Featured
            update_post_meta($item_id, 'prop_featured', 1);
          
        }elseif ($type==3){ //Publish Listing with Featured
            update_post_meta($item_id, 'pay_status', 'paid');
            update_post_meta($item_id, 'prop_featured', 1);
            $post = array(
                    'ID'            => $item_id,
                    'post_status'   => 'publish'
                    );
            $post_id =  wp_update_post($post ); 
            
        }
        
        update_post_meta($invoice_id, 'pay_status', 1);  
        $arguments=array();
        wpestate_select_email_type($user_email,'purchase_activated',$arguments);    
        
    }
         
        
endif;    

////////////////////////////////////////////////////////////////////////////////
/// activate purchase per listing
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_direct_pay_pack_per_listing', 'wpestate_direct_pay_pack_per_listing' );

if( !function_exists('wpestate_direct_pay_pack_per_listing') ):
    function wpestate_direct_pay_pack_per_listing(){
        check_ajax_referer( 'wpresidence_simple_pay_actions_nonce', 'security' );
        $current_user = wp_get_current_user();
        if ( !is_user_logged_in() ) {   
            exit('out pls');
        }
        
        $userID                     =   $current_user->ID;
        $user_email                 =   $current_user->user_email ;       
        $listing_id                 =   intval($_POST['selected_pack']);
        $include_feat               =   intval($_POST['include_feat']);
        $pay_status                 =   get_post_meta($listing_id, 'pay_status', true);
        $price_submission           =   floatval( wpresidence_get_option('wp_estate_price_submission','') );
        $price_featured_submission  =   floatval( wpresidence_get_option('wp_estate_price_featured_submission','') );

      
        
        $total_price    =   0;
        $time           =   time(); 
        $date           =   date('Y-m-d H:i:s',$time);
    
        if( $include_feat==1 ){
            if( $pay_status ==  'paid' ){
                $invoice_no = wpestate_insert_invoice('Upgrade to Featured','One Time',$listing_id,$date,$current_user->ID,0,1,'' );
                wpestate_email_to_admin(1);
                $total_price    =   $price_featured_submission;
            }else{
                $invoice_no = wpestate_insert_invoice('Publish Listing with Featured','One Time',$listing_id,$date,$current_user->ID,1,0,'' );
                wpestate_email_to_admin(0);
                $total_price    =   $price_submission + $price_featured_submission;
            }
        }else{
            $invoice_no = wpestate_insert_invoice('Listing','One Time',$listing_id,$date,$current_user->ID,0,0,'' );
            wpestate_email_to_admin(0);
            $total_price    =   $price_submission;
        }
        
        $wpestate_currency                   =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
        if ($total_price != 0) {
            if ($where_currency == 'before') {
                $total_price = $wpestate_currency . ' ' . $total_price;
            } else {
                $total_price = $total_price . ' ' . $wpestate_currency;
            }
        }
        
        
        // send email
        /**/
        $headers = 'From: No Reply <noreply@'.wpestate_replace_server_global(site_url()).'>' . "\r\n";
        $message  = esc_html__('Hi there,','wpresidence') . "\r\n\r\n";
        $message .= sprintf( esc_html__("We received your  Wire Transfer payment request on %s ! Please follow the instructions below in order to start submitting properties as soon as possible.",'wpresidence'), get_option('blogname')) . "\r\n\r\n";
        $message .= esc_html__('The invoice number is: ','wpresidence').$invoice_no." ".esc_html__('Amount:','wpresidence').' '.$total_price."\r\n\r\n";
        $message .= esc_html__('Instructions: ','wpresidence'). "\r\n\r\n";
        
        if (function_exists('icl_translate') ){
            $mes =  strip_tags( wpresidence_get_option('wp_estate_direct_payment_details','') );
            $payment_details      =   icl_translate('wpestate','wp_estate_property_direct_payment_text', $mes );
        }else{
            $payment_details =  strip_tags( wpresidence_get_option('wp_estate_direct_payment_details','') );
        }
                    
        $message .= $payment_details;
       
      
        update_post_meta($invoice_no, 'pay_status', 0);  
       
        
        $arguments=array(
            'invoice_no'        =>  $invoice_no,
            'total_price'       =>  $total_price,
            'payment_details'   =>  $payment_details,
        );
        wpestate_select_email_type($user_email,'new_wire_transfer',$arguments);
        $company_email      =  get_bloginfo('admin_email');
        wpestate_select_email_type($company_email,'admin_new_wire_transfer',$arguments);
        
        die();        
}
endif;



////////////////////////////////////////////////////////////////////////////////
/// activate purchase
////////////////////////////////////////////////////////////////////////////////



add_action( 'wp_ajax_wpestate_activate_purchase', 'wpestate_activate_purchase' );

if( !function_exists('wpestate_activate_purchase') ):
    function wpestate_activate_purchase(){
        check_ajax_referer( 'wpestate_activate_pack', 'security' );
        if ( !is_user_logged_in() ) {   
            exit('out pls');
        }
        if( !current_user_can('administrator') ){
            exit('out pls');
        }
        
        
        $pack_id        =   intval($_POST['item_id']);
        $invoice_id     =   intval($_POST['invoice_id']);
        $userID         =   get_post_meta($invoice_id, 'buyer_id', true);
                   
        if( wpestate_check_downgrade_situation($userID,$pack_id) ){
            wpestate_downgrade_to_pack( $userID, $pack_id );
            wpestate_upgrade_user_membership($userID,$pack_id,1,'',1);
        }else{
            wpestate_upgrade_user_membership($userID,$pack_id,1,'',1);
        }
        update_post_meta($invoice_id, 'pay_status', 1); 
    }
endif;


////////////////////////////////////////////////////////////////////////////////
/// direct pay issue invoice
////////////////////////////////////////////////////////////////////////////////




add_action( 'wp_ajax_wpestate_direct_pay_pack', 'wpestate_direct_pay_pack' );

if( !function_exists('wpestate_direct_pay_pack') ):
    
    function wpestate_direct_pay_pack(){
        check_ajax_referer( 'wpresidence_simple_pay_actions_nonce', 'security' );
        $current_user = wp_get_current_user();
        
        if ( !is_user_logged_in() ) {   
            exit('out pls');
        }
        
        $userID                   =   $current_user->ID;
        $user_email               =   $current_user->user_email ;
        $selected_pack            =   intval( $_POST['selected_pack'] );
        $total_price              =   get_post_meta($selected_pack, 'pack_price', true);
        $wpestate_currency                 =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency           =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
        
        if ($total_price != 0) {
            if ($where_currency == 'before') {
                $total_price = $wpestate_currency . ' ' . $total_price;
            }   else {
                $total_price = $total_price . ' ' . $wpestate_currency;
            }
        }
        
        
        // insert invoice
        $time           =   time(); 
        $date           =   date('Y-m-d H:i:s',$time); 
        $is_featured    =   0;
        $is_upgrade     =   0;
        $paypal_tax_id  =   '';
                 
        $invoice_no = wpestate_insert_invoice('Package','One Time',$selected_pack,$date,$userID,$is_featured,$is_upgrade,$paypal_tax_id);
        
        // send email
        $headers    = 'From: No Reply <noreply@'.wpestate_replace_server_global(site_url()).'>' . "\r\n";
        $message    = esc_html__('Hi there,','wpresidence') . "\r\n\r\n";
        
        if (function_exists('icl_translate') ){
            $mes                  =     strip_tags( wpresidence_get_option('wp_estate_direct_payment_details','') );
            $payment_details      =     icl_translate('wpestate','wp_estate_property_direct_payment_text', $mes );
        }else{
            $payment_details      =     strip_tags( wpresidence_get_option('wp_estate_direct_payment_details','') );
        }
        
        update_post_meta($invoice_no, 'pay_status', 0);
        $arguments=array(
            'invoice_no'        =>  $invoice_no,
            'total_price'       =>  $total_price,
            'payment_details'   =>  $payment_details,
        );
     
        // email sending
        wpestate_select_email_type($user_email,'new_wire_transfer',$arguments);
        $company_email      =  get_bloginfo('admin_email');
        wpestate_select_email_type($company_email,'admin_new_wire_transfer',$arguments);
         
         
    }

endif;








////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_advanced_search_filters', 'wpestate_advanced_search_filters' );  
add_action( 'wp_ajax_wpestate_advanced_search_filters', 'wpestate_advanced_search_filters' );

if( !function_exists('wpestate_advanced_search_filters') ):
    
    function wpestate_advanced_search_filters(){
       // check_ajax_referer( 'wpestate_search_nonce', 'security' );
        wp_suspend_cache_addition(true);
        wp_reset_query();
        wp_reset_postdata();
      
        global $wpestate_currency;
        global $where_currency;
        global $post;
        global $wpestate_options;
        global $wpestate_prop_unit;
        global $prop_unit_class;
        global $wpestate_property_unit_slider;
        global $wpestate_no_listins_per_row;
        global $wpestate_uset_unit;
        global $wpestate_custom_unit_structure;
        
        $wpestate_custom_unit_structure    =   wpresidence_get_option('wpestate_property_unit_structure');
        $wpestate_uset_unit       =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
        $current_user             =   wp_get_current_user();
        $userID                   =   $current_user->ID;
        $user_option              =   'favorites'.$userID;
        $curent_fav               =   get_option($user_option);
        $wpestate_currency                 =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency           =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
        $show_compare             =   1;
        $wpestate_options                  =   wpestate_page_details(intval($_REQEST['page_id']));
        $allowed_html             =   array();
        $wpestate_property_unit_slider     =   wpresidence_get_option('wp_estate_prop_list_slider','');
        $wpestate_no_listins_per_row       =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
        $args1 = stripslashes($_POST['args']);
        
        $property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
        $property_card_type_string  =   '';
        if($property_card_type==0){
            $property_card_type_string='';
        }else{
            $property_card_type_string='_type'.$property_card_type;
        }
        
        $args=  json_decode($args1,true);
        //$args = get_object_vars($args2);
        $wpestate_prop_unit          =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
        $prop_unit_class    =   '';
        if($wpestate_prop_unit=='list'){
            $prop_unit_class="ajax12";
        }
       
              
        //////////////////////////////////////////////////////////////////////////////////////
        ///// order details
        //////////////////////////////////////////////////////////////////////////////////////
        $order=esc_html(wp_kses($_POST['value'],$allowed_html));
        
        $meta_directions    =   'DESC';
        $meta_order         =   'prop_featured';
        $order_by           =   'meta_value_num';

        
          switch ($order){
                case 0:
                    $meta_order         =   'prop_featured';
                    $meta_directions    =   'DESC';
                    $order_by           =   'meta_value_num';
                    break;
                
                case 1:
                    $meta_order         =   'property_price';
                    $meta_directions    =   'DESC';
                    $order_by           =   'meta_value_num';
                    break;
                case 2:
                    $meta_order         =   'property_price';
                    $meta_directions    =   'ASC';
                    $order_by           =   'meta_value_num';
                    break;
                case 3:
                    $meta_order         =   '';
                    $meta_directions    =   'DESC';
                    $order_by           =   'ID';
                    break;
                case 4:
                    $meta_order         =   '';
                    $meta_directions    =   'ASC';
                    $order_by           =   'ID';
                    break;
                case 5:
                    $meta_order         =   'property_bedrooms';
                    $meta_directions    =   'DESC';
                    $order_by           =   'meta_value_num';
                    break;
                case 6:
                    $meta_order         =   'property_bedrooms';
                    $meta_directions    =   'ASC';
                    $order_by           =   'meta_value_num';
                    break;
                case 7:
                    $meta_order         =   'property_bathrooms';
                    $meta_directions    =   'DESC';
                    $order_by           =   'meta_value_num';
                    break;
                case 8:
                    $meta_order         =   'property_bathrooms';
                    $meta_directions    =   'ASC';
                    $order_by           =   'meta_value_num';
                    break;
            }
            
            
            
        $args['meta_key']               =   $meta_order;
        $args['orderby']                =   $order_by;
        $args['order']                  =   $meta_directions;
        $args['cache_results']          =   false;
        $args['update_post_meta_cache'] =   false;
        $args['update_post_term_cache'] =   false;
        
        $prop_no    =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
         
        // checks
        
      
        if ( $args['post_type']!='estate_property' || $args['post_status']!='publish'){
            exit('out pls');
        }
        
        $prop_selection = new WP_Query($args);
        print '<span id="scrollhere"></span>';  
        $counter = 0;

        if( $prop_selection->have_posts() ){
            while ( $prop_selection->have_posts() ): $prop_selection->the_post(); 
                include( locate_template('templates/property_unit'.$property_card_type_string.'.php') );
            endwhile;
        }else{
            print '<span class="no_results">'. esc_html__("We didn't find any results","wpresidence").'</span>';
        }

        wp_reset_query();        
        wp_reset_postdata();

        wp_suspend_cache_addition(false);
        die();
  }
  
 endif; // end   ajax_filter_listings_search 
 
 
 

      







////////////////////////////////////////////////////////////////////////////////
/// delete search function
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_delete_search', 'wpestate_delete_search' );
if( !function_exists('wpestate_delete_search') ):
    
function wpestate_delete_search(){
    check_ajax_referer( 'wpestate_searches_actions', 'security' );
    $current_user           = wp_get_current_user();
    $userID                 =   $current_user->ID;

    if ( !is_user_logged_in() ) {   
        exit('ko');
    }
    if($userID === 0 ){
        exit('out pls');
    }


        
   
    if( isset( $_POST['search_id'] ) ) {
        if( !is_numeric($_POST['search_id'] ) ){
            exit('you don\'t have the right to delete this');
        }else{
            $delete_id  =   intval($_POST['search_id'] );
            $the_post   =   get_post( $delete_id); 
            if( $current_user->ID != $the_post->post_author ) {
                esc_html_e("you don't have the right to delete this","wpresidence");
                die();
            }else{
                echo "deleted";
                wp_delete_post( $delete_id );
                die();
            }  

        }
    }
    
}  
    
endif;

////////////////////////////////////////////////////////////////////////////////
/// save search function
////////////////////////////////////////////////////////////////////////////////


add_action( 'wp_ajax_wpestate_save_search_function', 'wpestate_save_search_function' );

if( !function_exists('wpestate_save_search_function') ):
    function wpestate_save_search_function(){
        check_ajax_referer( 'wpestate_save_search_nonce', 'security' );
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
        $userEmail      =   $current_user->user_email;
        
       
        $allowed_html   =   array();
        
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }

        
     
        $search_name    =   sanitize_text_field( wp_kses(    $_POST['search_name'],$allowed_html ) );
        $search         =    wp_kses ($_POST['search'],$allowed_html );
        $meta           =   sanitize_text_field( wp_kses(    $_POST['meta'],$allowed_html  ) );
        
        $new_post = array(
            'post_title'    =>  $search_name,
            'post_author'   =>  $userID,
            'post_type'     =>  'wpestate_search',
    
            );
        $post_id = wp_insert_post($new_post);
        update_post_meta($post_id, 'search_arguments', $search);
        update_post_meta($post_id, 'meta_arguments', $meta);
        update_post_meta($post_id, 'user_email', $userEmail);
        print esc_html__('Search has been saved. You will receive an email notification when new properties matching your search have been published','wpresidence');
        die();
    
    }
endif;    



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Register function
////////////////////////////////////////////////////////////////////////////////


add_action( 'wp_ajax_wpestate_update_menu_bar', 'wpestate_update_menu_bar' );

if( !function_exists('wpestate_update_menu_bar') ):
    function wpestate_update_menu_bar(){
      //  wp_verify_nonce($_POST['security'],'wpestate_ajax_filtering');
        $user_id    = intval ( $_POST['newuser'] );
  
        if ($user_id!=0 && $user_id!=''){
            
            $add_link               =   wpestate_get_template_link('user_dashboard_add.php');
            $dash_profile           =   wpestate_get_template_link('user_dashboard_profile.php');
            $dash_favorite          =   wpestate_get_template_link('user_dashboard_favorite.php');
            $dash_link              =   wpestate_get_template_link('user_dashboard.php');
            $dash_invoices          =   wpestate_get_template_link('user_dashboard_invoices.php');
            $dash_searches          =   wpestate_get_template_link('user_dashboard_searches.php');
            $dash_inbox             =   wpestate_get_template_link('user_dashboard_inbox.php');
            $no_unread              =   intval(get_user_meta($user_id,'unread_mess',true));
            if( $no_unread>0 ){
                $no_unread= '<div class="unread_mess">'.$no_unread.'</div>';
            }
            
            
            $menu='
            <ul id="user_menu_open" class="dropdown-menu menulist topmenux" role="menu" aria-labelledby="user_menu_trigger">     
                <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$dash_profile.'"  class="active_profile"><i class="fas fa-cog"></i>'.esc_html__('My Profile','wpresidence').'</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$dash_link.'"     class="active_dash"><i class="fas fa-map-marker-alt"></i>'.esc_html__('My Properties List','wpresidence').'</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$add_link.'"      class="active_add"><i class="fas fa-plus"></i>'.esc_html__('Add New Property','wpresidence').'</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$dash_favorite.'" class="active_fav"><i class="fas fa-heart"></i>'.esc_html__('Favorites','wpresidence').'</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$dash_searches.'" class="active_fav"><i class="fas fa-search"></i>'. esc_html__('Saved Searches','wpresidence').'</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$dash_invoices.'" class="active_fav"><i class="far fa-file-alt"></i>'.esc_html__('My Invoices','wpresidence').'</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$dash_inbox.'" class="active_fav"><i class="far fa-envelope"></i> '.esc_html__('Inbox','wpresidence').'</a>';
               
                    if  ($no_unread>0){
                        $menu.='<div class="unread_mess">'.$no_unread.'</div>';
                    }
                
                $menu.='</li>
                <li role="presentation" class="divider"></li>
                <li role="presentation"><a href="'. wp_logout_url( esc_url(home_url('/')) ).'" title="Logout" class="menulogout"><i class="fas fa-power-off"></i>'.esc_html__('Log Out','wpresidence').'</a></li>
            </ul>';
            
            $user_small_picture_id      =   get_the_author_meta( 'small_custom_picture' , $user_id,true  );
            if( $user_small_picture_id == '' ){
                $user_small_picture[0]=get_theme_file_uri('/img/default_user_small.png');
            }else{
                $user_small_picture=wp_get_attachment_image_src($user_small_picture_id,'user_thumb');
            }
            
            echo json_encode(array('picture'=>$user_small_picture[0], 'menu'=>$menu,'nonce_contact'=>wp_create_nonce( 'ajax-property-contact' )));    
        }
        die();
    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// New user notification
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_wp_new_user_notification') ):

function wpestate_wp_new_user_notification( $user_id, $plaintext_pass = '' ) {

		$user = new WP_User( $user_id );

		$user_login = stripslashes( $user->user_login );
		$user_email = stripslashes( $user->user_email );
                
                $arguments=array(
                    'user_login_register'      =>  $user_login,
                    'user_email_register'      =>  $user_email
                );
                
                wpestate_select_email_type(get_option('admin_email'),'admin_new_user',$arguments);
                
                
                
                
		if ( empty( $plaintext_pass ) )
			return;

                 $arguments=array(
                    'user_login_register'      =>  $user_login,
                    'user_email_register'      =>  $user_email,
                    'user_pass_register'       => $plaintext_pass
                );
                wpestate_select_email_type($user_email,'new_user',$arguments);
                
	}
        
 endif; // end   wpestate_wp_new_user_notification        
        
 
 
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Register function Topbar
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_register_user', 'wpestate_ajax_register_user' );  
add_action( 'wp_ajax_wpestate_ajax_register_user', 'wpestate_ajax_register_user' );

if( !function_exists('wpestate_ajax_register_user') ):
   
function wpestate_ajax_register_user(){
        check_ajax_referer( 'wpestate_ajax_log_reg', 'security' );
        $type       =   intval( $_POST['type'] );
        $capthca    =   sanitize_text_field ( $_POST['capthca'] );
        
        if( wpresidence_get_option('wp_estate_use_captcha','')=='yes'){
            if(!isset($_POST['capthca']) || $_POST['capthca']==''){
                exit( esc_html__('wrong captcha','wpresidence') );
            }

            $secret    = wpresidence_get_option('wp_estate_recaptha_secretkey','');
            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                require_once (ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }
            $response = $wp_filesystem->get_contents( wpestate_recaptcha_path($secret,$captcha) );

            $response=json_decode(json_decode);
            if ($response['success'] = false) {
                exit('out pls captcha');
            }
        }
        
      
        $allowed_html               =   array();
        $user_email                 =   trim( sanitize_text_field(wp_kses( $_POST['user_email_register'] ,$allowed_html) ) );
        $user_name                  =   trim( sanitize_text_field(wp_kses( $_POST['user_login_register'] ,$allowed_html) ) );
        $enable_user_pass_status    =   esc_html ( wpresidence_get_option('wp_estate_enable_user_pass','') );
        
        $new_user_type              =   intval($_POST['new_user_type']);
      
        
        if (preg_match("/^[0-9A-Za-z_]+$/", $user_name) == 0) {
            print esc_html__('Invalid username (do not use special characters or spaces)!','wpresidence');
            die();
        }
        
        if ($user_email=='' || $user_name=='' ){
            print esc_html__('Username and/or Email field is empty!','wpresidence');
            exit();
        }
        
        if(filter_var($user_email,FILTER_VALIDATE_EMAIL) === false) {
            print esc_html__('The email doesn\'t look right !','wpresidence');
            exit();
        }
        
        $domain = mb_substr(strrchr($user_email, "@"), 1);
        if( !checkdnsrr ($domain) ){
            print esc_html__('The email\'s domain doesn\'t look right.','wpresidence');
            exit();
        }
        
        
        $user_id     =   username_exists( $user_name );
        if ($user_id){
            print esc_html__('Username already exists.  Please choose a new one.','wpresidence');
            exit();
        }
        
        if($enable_user_pass_status=='yes' ){
            $user_pass              =   trim( sanitize_text_field(wp_kses( $_POST['user_pass'] ,$allowed_html) ) );
            $user_pass_retype       =   trim( sanitize_text_field(wp_kses( $_POST['user_pass_retype'] ,$allowed_html) ) );
        
            if ($user_pass=='' || $user_pass_retype=='' ){
                print esc_html__('One of the password field is empty!','wpresidence');
                exit();
            }
            
            if ($user_pass !== $user_pass_retype ){
                print esc_html__('Passwords do not match','wpresidence');
                exit();
            }
        }
         
 
         
        if ( !$user_id and email_exists($user_email) == false ) {
            if($enable_user_pass_status=='yes' ){
                $user_password = $user_pass; // no so random now!
            }else{
                $user_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
            }
            
            $user_id         = wp_create_user( $user_name, $user_password, $user_email );
         
            if ( is_wp_error($user_id) ){
        
            }else{
                if($enable_user_pass_status=='yes' ){
                    print esc_html__('Your account was created and you can login now!','wpresidence');
                }else{
                    print esc_html__('An email with the generated password was sent!','wpresidence');
                }
                  
                wpestate_update_profile($user_id);
                wpestate_wp_new_user_notification( $user_id, $user_password ) ;
                update_user_meta( $user_id, 'user_estate_role', $new_user_type) ;
             
                if($new_user_type!==0 && $new_user_type!==1 ){  
                    wpestate_register_as_user($user_name,$user_id,$new_user_type);
                }
             }
             
        } else {
           print esc_html__('Email already exists.  Please choose a new one.','wpresidence');
        }
        die(); 
              
}

endif; // end   ajax_register_form 

 

////////////////////////////////////////////////////////////////////////////////
/// register as agent
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_register_as_user') ):
    function  wpestate_register_as_user($user_name,$user_id,$new_user_type=0,$first_name='',$last_name=''){
        $post_type  =   '';
        $app_type   =   '';
        if($new_user_type==2){
            $post_type                  =   'estate_agent'; 
            $app_type                   =   esc_html__('Agent','wpresidence');
            $app_type_no_translation    =   'Agent';
        }else if($new_user_type==3){
            $post_type                      =   'estate_agency'; 
            $app_type                       =   esc_html__('Agency','wpresidence');
             $app_type_no_translation       =   'Agency';
        }else if($new_user_type==4){
            $post_type                  =   'estate_developer';
            $app_type                   =   esc_html__('Developer','wpresidence');
            $app_type_no_translation    =   'Developer';
        }
        $admin_submission_user_role = wpresidence_get_option('wp_estate_admin_submission_user_role','');
    
        
        
        $post_approve = 'publish';
        if(in_array($app_type_no_translation, $admin_submission_user_role)){
            $post_approve = 'pending';  
        }
        
        
        if($post_type!=''){
            $post = array(
              'post_title'      => $user_name,
              'post_status'     => $post_approve, 
              'post_type'       => $post_type ,
            );
            $post_id =  wp_insert_post($post );  
            update_post_meta($post_id, 'user_meda_id', $user_id);
            update_user_meta($user_id, 'user_agent_id', $post_id);
        }

     
       
        $user_email             =   get_the_author_meta( 'user_email' , $user_id );
         
        if($post_type!=''){
            update_post_meta($post_id, 'agent_email',   $user_email);
        }
          
        if($first_name!=''){
            update_user_meta( $user_id, 'first_name' , $first_name) ; 
        }
        if($last_name!=''){
            update_user_meta( $user_id, 'last_name' , $last_name) ; 
        }
     }
 endif;
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Login function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_loginx_form_topbar', 'wpestate_ajax_loginx_form_topbar' );  
add_action( 'wp_ajax_wpestate_ajax_loginx_form_topbar', 'wpestate_ajax_loginx_form_topbar' );  

if( !function_exists('wpestate_ajax_loginx_form_topbar') ):

function wpestate_ajax_loginx_form_topbar(){
        check_ajax_referer( 'wpestate_ajax_log_reg', 'security' );
        if ( is_user_logged_in() ) { 
            echo json_encode(array('loggedin'=>true, 'message'=>esc_html__('You are already logged in! redirecting...','wpresidence')));   
            exit();
        } 
     
        $allowed_html   =   array();
        $login_user     =  sanitize_text_field ( wp_kses ( $_POST['login_user'], $allowed_html)) ;
        $login_pwd      =  sanitize_text_field ( wp_kses ( $_POST['login_pwd'] , $allowed_html)) ;
        $ispop          =  intval ( $_POST['ispop'] );
       
        if ($login_user=='' || $login_pwd==''){      
            echo json_encode(array('loggedin'=>false, 'message'=>esc_html__('Username and/or Password field is empty!','wpresidence')));   
            exit();
        }
        
        $vsessionid = session_id();
        if (empty($vsessionid)) {
            session_name('PHPSESSID'); 
            session_start();
        }


        wp_clear_auth_cookie();
        $info                   =   array();
        $info['user_login']     =   $login_user;
        $info['user_password']  =   $login_pwd;
        $info['remember']       =   false;
        $user_signon            =   wp_signon( $info, true );
      
        
        if ( is_wp_error($user_signon) ){
            echo json_encode(array('loggedin'=>false, 'message'=>esc_html__('Wrong username or password!','wpresidence')));       
        } else {
            wp_set_current_user($user_signon->ID);
            do_action('set_current_user');
            global $current_user;
            $current_user = wp_get_current_user();
            echo json_encode(array('loggedin'=>true,'ispop'=>$ispop,'newuser'=>$user_signon->ID, 'message'=>esc_html__('Login successful, redirecting...','wpresidence')));
            wpestate_update_old_users($user_signon->ID);
        }
        
        die();       
}
endif; // end   ajax_loginx_form 




add_action( 'wp_ajax_nopriv_wpestate_ajax_loginx_form_mobile', 'wpestate_ajax_loginx_form_mobile' );  
add_action( 'wp_ajax_wpestate_ajax_loginx_form_mobile', 'wpestate_ajax_loginx_form_mobile' );  

if( !function_exists('wpestate_ajax_loginx_form_mobile') ):

function wpestate_ajax_loginx_form_mobile(){
        check_ajax_referer( 'wpestate_ajax_log_reg', 'security' );
        if ( is_user_logged_in() ) { 
            echo json_encode(array('loggedin'=>true, 'message'=>esc_html__('You are already logged in! redirecting...','wpresidence')));   
            exit();
        } 
       
        
        $allowed_html   =   array();
        $login_user     =   sanitize_text_field ( wp_kses ( $_POST['login_user'], $allowed_html) );
        $login_pwd      =   sanitize_text_field ( wp_kses ( $_POST['login_pwd'] , $allowed_html) );
       
       
        if ($login_user=='' || $login_pwd==''){      
            echo json_encode(array('loggedin'=>false, 'message'=>esc_html__('Username and/or Password field is empty!','wpresidence')));   
            exit();
        }
        
        $vsessionid = session_id();
        if (empty($vsessionid)) {
            session_name('PHPSESSID'); 
            session_start();       
        }


        wp_clear_auth_cookie();
        $info                   = array();
        $info['user_login']     = $login_user;
        $info['user_password']  = $login_pwd;
        $info['remember']       = false;
     
        $user_signon            = wp_signon( $info, true );
      
        
        if ( is_wp_error($user_signon) ){
            echo json_encode(array('loggedin'=>false, 'message'=>esc_html__('Wrong username or password!','wpresidence')));       
        } else {
            wp_set_current_user($user_signon->ID);
            do_action('set_current_user');
            global $current_user;
            $current_user = wp_get_current_user();
            echo json_encode(array('loggedin'=>true,'newuser'=>$user_signon->ID, 'message'=>esc_html__('Login successful, redirecting...','wpresidence')));
            wpestate_update_old_users($user_signon->ID);
        }
        die(); 
              
}
endif; // end   ajax_loginx_form 

////////////////////////////////////////////////////////////////////////////////
/// Ajax  Login function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_loginx_form', 'wpestate_ajax_loginx_form' );  
add_action( 'wp_ajax_wpestate_ajax_loginx_form', 'wpestate_ajax_loginx_form' );  

if( !function_exists('wpestate_ajax_loginx_form') ):

function wpestate_ajax_loginx_form(){
        check_ajax_referer( 'wpestate_ajax_log_reg', 'security' );
        if ( is_user_logged_in() ) { 
            echo json_encode(array('loggedin'=>true, 'message'=>esc_html__('You are already logged in! redirecting...','wpresidence')));   
            exit();
        } 
        
        
        $allowed_html   =   array();
        $login_user  =  wp_kses ( $_POST['login_user'],$allowed_html ) ;
        $login_pwd   =  wp_kses ( $_POST['login_pwd'], $allowed_html) ;
        $ispop       =  intval ( $_POST['ispop'] );
       
        if ($login_user=='' || $login_pwd==''){      
          echo json_encode(array('loggedin'=>false, 'message'=>esc_html__('Username and/or Password field is empty!','wpresidence')));   
          exit();
        }
        wp_clear_auth_cookie();
        $info                   = array();
        $info['user_login']     = $login_user;
        $info['user_password']  = $login_pwd;
        $info['remember']       = true;
        $user_signon            = wp_signon( $info, true );
      
   
         if ( is_wp_error($user_signon) ){
             echo json_encode(array('loggedin'=>false, 'message'=>esc_html__('Wrong username or password!','wpresidence')));       
        } else {
            global $current_user;
            wp_set_current_user($user_signon->ID);
            do_action('set_current_user');
            $current_user = wp_get_current_user();
            
            
            echo json_encode(array('loggedin'=>true,'ispop'=>$ispop,'newuser'=>$user_signon->ID, 'message'=>esc_html__('Login successful, redirecting...','wpresidence')));
            wpestate_update_old_users($user_signon->ID);
        }
        die(); 
              
}
endif; // end   wpestate_ajax_loginx_form 



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Forgot Pass function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_forgot_pass', 'wpestate_ajax_forgot_pass' );  
add_action( 'wp_ajax_wpestate_ajax_forgot_pass', 'wpestate_ajax_forgot_pass' );  

if( !function_exists('wpestate_ajax_forgot_pass') ):
   
function wpestate_ajax_forgot_pass(){
    check_ajax_referer( 'wpestate_ajax_log_reg', 'security' );
    global $wpdb;

    $allowed_html   =   array();
    $post_id        =   intval( $_POST['postid'] ) ;
    $forgot_email   =   sanitize_text_field( wp_kses( $_POST['forgot_email'],$allowed_html ) );
    $type           =   intval($_POST['type']);
       
     
    if ($forgot_email==''){      
        echo esc_html__('Email field is empty!','wpresidence');   
        exit();
    }

    $user_input = trim($forgot_email);
 
        if ( strpos($user_input, '@') ) {
                $user_data = get_user_by( 'email', $user_input );
                if(empty($user_data) || isset( $user_data->caps['administrator'] ) ) {
                    echo esc_html__('Invalid E-mail address!','wpresidence');
                    exit();
                }
                            
        }
        else {
            $user_data = get_user_by( 'login', $user_input );
            if( empty($user_data) || isset( $user_data->caps['administrator'] ) ) {
               echo esc_html__('Invalid Username!','wpresidence');
               exit();
            }
        }
        $user_login = $user_data->user_login;
        $user_email = $user_data->user_email;

 
        $key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
        if(empty($key)) {
                //generate reset key
                $key = wp_generate_password(20, false);
                $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
        }
 
        //emailing password change request details to the user
        $headers = 'From: No Reply <noreply@'.wpestate_replace_server_global(site_url()).'>' . "\r\n";
        $arguments=array(
            'reset_link'        =>  wpestate_tg_validate_url($post_id,$type) . "action=reset_pwd&key=$key&login=" . rawurlencode($user_login)
        );
        wpestate_select_email_type($user_email,'password_reset_request',$arguments);

        echo '<div>'.esc_html__('We have just sent you an email with Password reset instructions.','wpresidence').'</div>';
        die(); 
              
}
endif; // end   wpestate_ajax_forgot_pass 


if( !function_exists('wpestate_tg_validate_url') ):

function wpestate_tg_validate_url($post_id,$type) {
       
    $page_url = esc_url(home_url('/'));     
    $urlget = strpos($page_url, "?");
    if ($urlget === false) {
            $concate = "?";
    } else {
            $concate = "&";
    }
    return $page_url.$concate;
}

endif; // end   wpestate_tg_validate_url 


////////////////////////////////////////////////////////////////////////////////
/// Ajax  register agent
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_register_agent', 'wpestate_ajax_register_agent' );  
if( !function_exists('wpestate_ajax_register_agent') ):
   
   function wpestate_ajax_register_agent(){
        check_ajax_referer( 'wpestate_register_agent_nonce', 'security' );
        error_reporting(E_ALL);
	   
        $allowed_html       =   array();
        $current_user           =   wp_get_current_user();
        $userID                 =   $current_user->ID;
        $user_login             =   $current_user->user_login;
        check_ajax_referer( 'profile_ajax_nonce', 'security-profile' );
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        $user_role = get_user_meta( $current_user->ID, 'user_estate_role', true) ;
        if($user_role!=3 && $user_role !=4){
            exit;
        }
        
        $user_email                 =   trim( sanitize_text_field(wp_kses( $_POST['useremail'] ,$allowed_html) ) );
        $user_name                  =   trim( sanitize_text_field(wp_kses( $_POST['agent_username'] ,$allowed_html) ) );
        $firstname                  =   sanitize_text_field ( wp_kses( $_POST['firstname'] ,$allowed_html) );
        $secondname                 =   sanitize_text_field ( wp_kses( $_POST['secondname'] ,$allowed_html) );
        $new_user_type              =   2;//agent
        $errors                     =   array();
        $is_agent_edit              =   intval($_POST['agentedit']);
        $user_id                    =   intval($_POST['userid']);
        $agent_id                   =   intval($_POST['agentid']);
        
        if( $is_agent_edit!=1){
            
            if (preg_match("/^[0-9A-Za-z_]+$/", $user_name) == 0) {
                $errors[]= esc_html__('Invalid username (do not use special characters or spaces)!','wpresidence');
            }
            
            if ($user_email=='' || $user_name=='' ){
                $errors[]= esc_html__('Username and/or Email field is empty!','wpresidence');
            }
            
            $user_id     =   username_exists( $user_name );
            if ($user_id){
                $errors[]= esc_html__('Username already exists.  Please choose a new one.','wpresidence');
            }
            
            $user_pass              =   trim( sanitize_text_field(wp_kses( $_POST['agent_password'] ,$allowed_html) ) );
            $user_pass_retype       =   trim( sanitize_text_field(wp_kses( $_POST['agent_repassword'] ,$allowed_html) ) );

            if ($user_pass=='' || $user_pass_retype=='' ){
                $errors[]= esc_html__('One of the password field is empty!','wpresidence');
            }

            if ($user_pass !== $user_pass_retype ){
                $errors[]= esc_html__('Passwords do not match','wpresidence');
            }

            if( email_exists($user_email) ){
                $errors[]= esc_html__('Email already exists.  Please choose a new one.','wpresidence');
            }
        }
         
        if( $is_agent_edit==1){
            if ($user_email==''  ){
                $errors[]= esc_html__('Username and/or Email field is empty!','wpresidence');
            }
            if( $user_email != get_post_meta($agent_id, 'agent_email', true) ){
                if( email_exists($user_email) ){
                    $errors[]= esc_html__('Email already exists.  Please choose a new one.','wpresidence');
                }
            }
        }
        
        if($firstname=='' && $secondname==''){
            $errors[]= esc_html__('Agent need a first & last name','wpresidence');
        }
       
        
        if(filter_var($user_email,FILTER_VALIDATE_EMAIL) === false) {
            $errors[]= esc_html__('The email doesn\'t look right !','wpresidence');
        }
        
        $domain = mb_substr(strrchr($user_email, "@"), 1);
        if( !checkdnsrr ($domain) ){
            $errors[]=  esc_html__('The email\'s domain doesn\'t look right.','wpresidence');
        }
        
        
      
        
        if( !empty($errors) ){
            $erros_mess =   '';
            foreach($errors as $key=>$text){
                $erros_mess .= $text.'</br>';
            }
            print json_encode(array ('added'=>false, 'mesaj'=>$erros_mess ));
            die();
        }
 
        if($is_agent_edit!=1){
            $new_user_id    =   wp_create_user( $user_name, $user_pass, $user_email );
        }else{
            $new_user_id    =   $user_id;
        }
        
       
        
        
        
        $allowed_html               =   array('</br>');
        $firstname                  =   sanitize_text_field ( wp_kses( $_POST['firstname'] ,$allowed_html) );
        $secondname                 =   sanitize_text_field ( wp_kses( $_POST['secondname'] ,$allowed_html) );
        $useremail                  =   sanitize_text_field ( wp_kses( $_POST['useremail'] ,$allowed_html) );
        $userphone                  =   sanitize_text_field ( wp_kses( $_POST['userphone'] ,$allowed_html) );
        $usermobile                 =   sanitize_text_field ( wp_kses( $_POST['usermobile'] ,$allowed_html) );
        $userskype                  =   sanitize_text_field ( wp_kses( $_POST['userskype'] ,$allowed_html) );
        $usertitle                  =   sanitize_text_field ( wp_kses( $_POST['usertitle'] ,$allowed_html) );
        $about_me                   =   wp_kses( $_POST['description'],$allowed_html );
        $profile_image_url_small    =   sanitize_text_field ( wp_kses($_POST['profile_image_url_small'],$allowed_html) );
        $profile_image_url          =   sanitize_text_field ( wp_kses($_POST['profile_image_url'],$allowed_html) );       
        $userfacebook               =   sanitize_text_field ( wp_kses( $_POST['userfacebook'],$allowed_html) );
        $usertwitter                =   sanitize_text_field ( wp_kses( $_POST['usertwitter'],$allowed_html) );
        $userlinkedin               =   sanitize_text_field ( wp_kses( $_POST['userlinkedin'],$allowed_html) );
        $userpinterest              =   sanitize_text_field ( wp_kses( $_POST['userpinterest'],$allowed_html ) );
        $userinstagram              =   sanitize_text_field ( wp_kses( $_POST['userinstagram'],$allowed_html ) );
		 

        $agent_custom_label          =   $_POST['agent_custom_label'];
        $agent_custom_value          =   $_POST['agent_custom_value'];

        // prcess fields data
        $agent_fields_array = array();
        for( $i=1; $i<count( $agent_custom_label  ); $i++ ){
                $agent_fields_array[] = array( 'label' => sanitize_text_field( $agent_custom_label[$i] ), 'value' => sanitize_text_field( $agent_custom_value[$i] ) );
        }
  
        $userurl                    =   sanitize_text_field ( wp_kses( $_POST['userurl'],$allowed_html ) );
        $agent_category_submit      =   sanitize_text_field ( wp_kses( $_POST['agent_category_submit'],$allowed_html ) );
        $agent_action_submit        =   sanitize_text_field ( wp_kses( $_POST['agent_action_submit'],$allowed_html ) );
        $agent_city                 =   sanitize_text_field ( wp_kses( $_POST['agent_city'],$allowed_html ) );
        $agent_county               =   sanitize_text_field ( wp_kses( $_POST['agent_county'],$allowed_html ) );
        $agent_area                 =   sanitize_text_field ( wp_kses( $_POST['agent_area'],$allowed_html ) );
        $agent_member               =   sanitize_text_field ( wp_kses( $_POST['agent_member'],$allowed_html ) ); 
       
        update_user_meta( $new_user_id, 'first_name', $firstname ) ;
        update_user_meta( $new_user_id, 'last_name',  $secondname) ;
        update_user_meta( $new_user_id, 'phone' , $userphone) ;
        update_user_meta( $new_user_id, 'skype' , $userskype) ;
        update_user_meta( $new_user_id, 'title', $usertitle) ;
        update_user_meta( $new_user_id, 'custom_picture',$profile_image_url);
        update_user_meta( $new_user_id, 'small_custom_picture',$profile_image_url_small);     
        update_user_meta( $new_user_id, 'mobile' , $usermobile) ;
        update_user_meta( $new_user_id, 'facebook' , $userfacebook) ;
        update_user_meta( $new_user_id, 'twitter' , $usertwitter) ;	
        update_user_meta( $new_user_id, 'agent_custom_data' , $agent_fields_array) ;
        update_user_meta( $new_user_id, 'linkedin' , $userlinkedin) ;
        update_user_meta( $new_user_id, 'pinterest' , $userpinterest) ;
        update_user_meta( $new_user_id, 'instagram' , $userinstagram) ;
        update_user_meta( $new_user_id, 'website' , $userurl) ;
        update_user_meta( $new_user_id, 'user_estate_role', 2) ;
        update_user_meta( $new_user_id, 'agent_member' , $agent_member) ;
 
 
        if($is_agent_edit!=1){
            $post = array(
                'post_title'        => $firstname.' '.$secondname,
                'post_status'       => 'publish', 
                'post_type'         => 'estate_agent' ,
                'author'            => $userID ,
                'post_content'      =>  $about_me
            );

            $new_agent_id =  wp_insert_post($post );  
            update_post_meta( $new_agent_id, 'user_meda_id', $new_user_id);
            update_user_meta( $new_user_id, 'user_agent_id', $new_agent_id);
            
            $current_agent_list = (array)get_user_meta($userID,'current_agent_list',true);
            if(!is_array($current_agent_list)){
                $current_agent_list = array();
            }
            $current_agent_list[]=$new_user_id;
            update_user_meta( $userID, 'current_agent_list',array_unique( $current_agent_list) );
        }else{
            $post = array(
                'ID'                =>  $agent_id,
                'post_title'        =>  $firstname.' '.$secondname,
                'post_content'      =>  $about_me
            );
            wp_update_post( $post );
            $new_agent_id   =   $agent_id;
        }
   
		update_post_meta($new_agent_id, 'agent_custom_data',   $agent_fields_array);
	 
        update_post_meta($new_agent_id, 'first_name',   $firstname);
        update_post_meta($new_agent_id, 'last_name',   $secondname);
        update_post_meta($new_agent_id, 'agent_email',   $useremail);
        update_post_meta($new_agent_id, 'agent_phone',   $userphone);
        update_post_meta($new_agent_id, 'agent_mobile',  $usermobile);
        update_post_meta($new_agent_id, 'agent_skype',   $userskype);
        update_post_meta($new_agent_id, 'agent_position',  $usertitle);
        update_post_meta($new_agent_id, 'agent_facebook',   $userfacebook);
        update_post_meta($new_agent_id, 'agent_twitter',   $usertwitter);
        update_post_meta($new_agent_id, 'agent_linkedin',   $userlinkedin);
        update_post_meta($new_agent_id, 'agent_pinterest',   $userpinterest);
        update_post_meta($new_agent_id, 'agent_instagram',   $userinstagram);
        update_post_meta($new_agent_id, 'agent_website',   $userurl);
        update_post_meta($new_agent_id, 'agent_member',   $agent_member);
        set_post_thumbnail($new_agent_id, $profile_image_url_small );


        $agent_category           =   get_term( $agent_category_submit, 'property_category_agent');     
        if(isset($agent_category->term_id)){
            $agent_category_submit  =   $agent_category->name;
        }else{
            $agent_category_submit=-1;
        }

        if( isset($agent_category_submit) && $agent_category_submit!='none' ){
            wp_set_object_terms($new_agent_id,$agent_category_submit,'property_category_agent'); 
        }  

        //---

        $agent_category           =   get_term( $agent_action_submit, 'property_action_category_agent');     
        if(isset($agent_category->term_id)){
            $agent_action_submit  =   $agent_category->name;
        }else{
            $agent_action_submit=-1;
        }

        if( isset($agent_action_submit) && $agent_action_submit!='none' ){
            wp_set_object_terms($new_agent_id,$agent_action_submit,'property_action_category_agent'); 
        }  


        if( isset($agent_city) && $agent_city!='none' ){
            wp_set_object_terms($new_agent_id,$agent_city,'property_city_agent'); 
        }  

        if( isset($agent_county) && $agent_county!='none' ){
            wp_set_object_terms($new_agent_id,$agent_county,'property_county_state_agent'); 
        }  

        if( isset($agent_area) && $agent_area!='none' ){
            wp_set_object_terms($new_agent_id,$agent_area,'property_area_agent'); 
        }  

        if( empty($errors) && $is_agent_edit!=1 ){
            /// to do
            $arguments=array(
                'user_profile'      =>  $user_name,
            );
            wpestate_select_email_type(get_option('admin_email'),'agent_added',$arguments);
            echo json_encode(array('added'=>true, 'mesaj'=> esc_html__('Agent was added... You will be redirected to your agent list...','wpresidence') ));
        }else{
            $arguments=array(
                'user_profile'      =>  $user_name,
            );
            wpestate_select_email_type(get_option('admin_email'),'agent_update_profile',$arguments);
            echo json_encode(array('added'=>true, 'mesaj'=> esc_html__('Agent profile edited','wpresidence') ));
        }
        
        
        
        
        
        die(); 
        
    
   }
endif; // end   wpestate_ajax_update_profile 
   



////////////////////////////////////////////////////////////////////////////////
/// Ajax  upadte profile
////////////////////////////////////////////////////////////////////////////////
// for user 
add_action( 'wp_ajax_wpestate_ajax_update_profile', 'wpestate_ajax_update_profile' );  
if( !function_exists('wpestate_ajax_update_profile') ):
   
   function wpestate_ajax_update_profile(){
        check_ajax_referer( 'wpestate_update_profile_nonce', 'security' );
        $current_user           =   wp_get_current_user();
        $userID                 =   $current_user->ID;
        $user_login             =   $current_user->user_login;
        check_ajax_referer( 'profile_ajax_nonce', 'security-profile' );
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }


        
        $allowed_html               =   array('</br>');
        $firstname                  =   sanitize_text_field ( wp_kses( $_POST['firstname'] ,$allowed_html) );
        $secondname                 =   sanitize_text_field ( wp_kses( $_POST['secondname'] ,$allowed_html) );
        $useremail                  =   sanitize_text_field ( wp_kses( $_POST['useremail'] ,$allowed_html) );
        $userphone                  =   sanitize_text_field ( wp_kses( $_POST['userphone'] ,$allowed_html) );
        $usermobile                 =   sanitize_text_field ( wp_kses( $_POST['usermobile'] ,$allowed_html) );
        $userskype                  =   sanitize_text_field ( wp_kses( $_POST['userskype'] ,$allowed_html) );
        $usertitle                  =   sanitize_text_field ( wp_kses( $_POST['usertitle'] ,$allowed_html) );
        $about_me                   =   wp_kses( $_POST['description'],$allowed_html );
        $profile_image_url_small    =   sanitize_text_field ( wp_kses($_POST['profile_image_url_small'],$allowed_html) );
        $profile_image_url          =   sanitize_text_field ( wp_kses($_POST['profile_image_url'],$allowed_html) );       
        $userfacebook               =   sanitize_text_field ( wp_kses( $_POST['userfacebook'],$allowed_html) );
        $usertwitter                =   sanitize_text_field ( wp_kses( $_POST['usertwitter'],$allowed_html) );
        $userlinkedin               =   sanitize_text_field ( wp_kses( $_POST['userlinkedin'],$allowed_html) );
        $userpinterest              =   sanitize_text_field ( wp_kses( $_POST['userpinterest'],$allowed_html ) );
        $userinstagram              =   sanitize_text_field ( wp_kses( $_POST['userinstagram'],$allowed_html ) );
        $userurl                    =   sanitize_text_field ( wp_kses( $_POST['userurl'],$allowed_html ) );
        $agent_category_submit      =   sanitize_text_field ( wp_kses( $_POST['agent_category_submit'],$allowed_html ) );
        $agent_action_submit        =   sanitize_text_field ( wp_kses( $_POST['agent_action_submit'],$allowed_html ) );
        $agent_city                 =   sanitize_text_field ( wp_kses( $_POST['agent_city'],$allowed_html ) );
        $agent_county               =   sanitize_text_field ( wp_kses( $_POST['agent_county'],$allowed_html ) );
        $agent_area                 =   sanitize_text_field ( wp_kses( $_POST['agent_area'],$allowed_html ) );     
        $agent_member               =   sanitize_text_field ( wp_kses( $_POST['agent_member'],$allowed_html ) );   
        
		$agent_custom_label          =   $_POST['agent_custom_label'];
		$agent_custom_value          =   $_POST['agent_custom_value'];
	 
		// prcess fields data
		$agent_fields_array = array();
		for( $i=1; $i<count( $agent_custom_label  ); $i++ ){
			$agent_fields_array[] = array( 'label' => sanitize_text_field( $agent_custom_label[$i] ), 'value' => sanitize_text_field( $agent_custom_value[$i] ) );
		}
		
		
		
        update_user_meta( $userID, 'first_name', $firstname ) ;
        update_user_meta( $userID, 'last_name',  $secondname) ;
        update_user_meta( $userID, 'phone' , $userphone) ;
        update_user_meta( $userID, 'skype' , $userskype) ;
        update_user_meta( $userID, 'title', $usertitle) ;
        update_user_meta( $userID, 'custom_picture',$profile_image_url);
        update_user_meta( $userID, 'small_custom_picture',$profile_image_url_small);     
        update_user_meta( $userID, 'mobile' , $usermobile) ;
        
        
        
        update_user_meta( $userID, 'facebook' , $userfacebook) ;
        update_user_meta( $userID, 'twitter' , $usertwitter) ;
        update_user_meta( $userID, 'linkedin' , $userlinkedin) ;
        update_user_meta( $userID, 'pinterest' , $userpinterest) ;
        update_user_meta( $userID, 'instagram' , $userinstagram) ;
        update_user_meta( $userID, 'description' , $about_me) ;
        update_user_meta( $userID, 'website' , $userurl) ;
        
        
        
        $agent_id=get_user_meta( $userID, 'user_agent_id',true);
        update_post_meta( $agent_id, 'agent_custom_data' , $agent_fields_array) ;
	 
      
                
        wpestate_update_user_agent ($agent_member,$agent_category_submit,$agent_action_submit,$agent_city,$agent_county,$agent_area,$userurl,$agent_id, $firstname ,$secondname ,$useremail,$userphone,$userskype,$usertitle,$profile_image_url,$usermobile,$about_me,$profile_image_url_small,$userfacebook,$usertwitter,$userlinkedin,$userpinterest,$userinstagram) ;
       
        
        if( $current_user->user_email != $useremail ) {
            $user_id=email_exists( $useremail ) ;
            if ( $user_id){
                esc_html_e('The email was not saved because it is used by another user.','wpresidence');
            } else{
                $args = array(
                    'ID'         => $userID,
                    'user_email' => $useremail
                ); 
                wp_update_user( $args );
            } 
        }
        
        $arguments=array(
            'user_profile'      =>  $user_login,
        );

        wpestate_select_email_type(get_option('admin_email'),'agent_update_profile',$arguments);
        esc_html_e('Profile updated','wpresidence');
        die(); 
   }
endif; // end   wpestate_ajax_update_profile 
   




////////////////////////////////////////////////////////////////////////////////
/// Ajax  upadte profile agency
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_wpestate_ajax_update_profile_agency', 'wpestate_ajax_update_profile_agency' );  
if( !function_exists('wpestate_ajax_update_profile_agency') ):
   
   function wpestate_ajax_update_profile_agency(){
        check_ajax_referer( 'wpestate_update_profile_nonce', 'security' );
        $current_user           =   wp_get_current_user();
        $userID                 =   $current_user->ID;
        $user_login             =   $current_user->user_login;
        check_ajax_referer( 'profile_ajax_nonce', 'security-profile' );
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        $user_role = intval (get_user_meta( $current_user->ID, 'user_estate_role', true) );
        
        if($user_role!=3){
            exit('not the right role');
        }
        
        $agent_id=get_user_meta( $userID, 'user_agent_id',true);

        
        $allowed_html               =   array('</br>');
        $agency_name                =   sanitize_text_field ( wp_kses( $_POST['agency_name'] ,$allowed_html) );
        $useremail                  =   sanitize_text_field ( wp_kses( $_POST['useremail'] ,$allowed_html) );
        $userphone                  =   sanitize_text_field ( wp_kses( $_POST['userphone'] ,$allowed_html) );
        $usermobile                 =   sanitize_text_field ( wp_kses( $_POST['usermobile'] ,$allowed_html) );
        $userskype                  =   sanitize_text_field ( wp_kses( $_POST['userskype'] ,$allowed_html) );
        $usertitle                  =   sanitize_text_field ( wp_kses( $_POST['usertitle'] ,$allowed_html) );
        $about_me                   =   wp_kses( $_POST['description'],$allowed_html );
        $profile_image_url_small    =   sanitize_text_field ( wp_kses($_POST['profile_image_url_small'],$allowed_html) );
        $profile_image_url          =   sanitize_text_field ( wp_kses($_POST['profile_image_url'],$allowed_html) );       
        $userfacebook               =   sanitize_text_field ( wp_kses( $_POST['userfacebook'],$allowed_html) );
        $usertwitter                =   sanitize_text_field ( wp_kses( $_POST['usertwitter'],$allowed_html) );
        $userlinkedin               =   sanitize_text_field ( wp_kses( $_POST['userlinkedin'],$allowed_html) );
        $userpinterest              =   sanitize_text_field ( wp_kses( $_POST['userpinterest'],$allowed_html ) );
        $userinstagram              =   sanitize_text_field ( wp_kses( $_POST['userinstagram'],$allowed_html ) );
        $userurl                    =   sanitize_text_field ( wp_kses( $_POST['userurl'],$allowed_html ) );         
        $agency_languages           =   sanitize_text_field ( wp_kses( $_POST['agency_languages'],$allowed_html ) );
        $agency_website             =   sanitize_text_field ( wp_kses( $_POST['agency_website'],$allowed_html ) );
        $agency_taxes               =   sanitize_text_field ( wp_kses( $_POST['agency_taxes'],$allowed_html ) );     
        $agency_category_submit     =   sanitize_text_field ( wp_kses( $_POST['agency_category_submit'],$allowed_html ) );
        $agency_action_submit       =   sanitize_text_field ( wp_kses( $_POST['agency_action_submit'],$allowed_html ) );
        $agency_city                =   sanitize_text_field ( wp_kses( $_POST['agency_city'],$allowed_html ) );
        $agency_county              =   sanitize_text_field ( wp_kses( $_POST['agency_county'],$allowed_html ) );
        $agency_area                =   sanitize_text_field ( wp_kses( $_POST['agency_area'],$allowed_html ) );     
        $agency_address             =   sanitize_text_field ( wp_kses( $_POST['agency_address'],$allowed_html ) );
        $agency_lat                 =   sanitize_text_field ( wp_kses( $_POST['agency_lat'],$allowed_html ) );
        $agency_long                =   sanitize_text_field ( wp_kses( $_POST['agency_long'],$allowed_html ) );
        $agency_opening_hours       =   sanitize_text_field ( wp_kses( $_POST['agency_opening_hours'],$allowed_html ) );
        $agent_id=get_user_meta( $userID, 'user_agent_id',true);
       
       
        update_user_meta( $userID, 'custom_picture',$profile_image_url);
        update_user_meta( $userID, 'small_custom_picture',$profile_image_url_small);     
    
        
        
         if($firstname!=='' || $secondname!='' ){
            $post = array(
                    'ID'            => $agent_id,
                    'post_title'    => $agency_name,
                    'post_content'  => $about_me,
            );
            $post_id =  wp_update_post($post );  
        }
    
     
        update_post_meta($agent_id, 'agent_email',   $useremail);
        update_post_meta($agent_id, 'agency_email',   $useremail);
        update_post_meta($agent_id, 'agency_phone',   $userphone);
        update_post_meta($agent_id, 'agency_mobile',  $usermobile);
        update_post_meta($agent_id, 'agency_skype',   $userskype);
        update_post_meta($agent_id, 'agency_opening_hours',   $agency_opening_hours);
        
        update_post_meta($agent_id, 'agency_facebook',   $userfacebook);
        update_post_meta($agent_id, 'agency_twitter',   $usertwitter);
        update_post_meta($agent_id, 'agency_linkedin',   $userlinkedin);
        update_post_meta($agent_id, 'agency_pinterest',   $userpinterest);
        update_post_meta($agent_id, 'agency_instagram',   $userinstagram);
        update_post_meta($agent_id, 'agency_languages',   $agency_languages);
        update_post_meta($agent_id, 'agency_website',   $agency_website);
        update_post_meta($agent_id, 'agency_taxes',   $agency_taxes);
        update_post_meta($agent_id, 'agency_address',   $agency_address);
        update_post_meta($agent_id, 'agency_lat',   $agency_lat);
        update_post_meta($agent_id, 'agency_long',   $agency_long);
     
        
 

  
        $agency_category           =   get_term( $agency_category_submit, 'category_agency');     
        if(isset($agency_category->term_id)){
            $agency_category_submit  =   $agency_category->name;
        }else{
            $agency_category_submit=-1;
        }
        
        if( isset($agency_category_submit) && $agency_category_submit!='none' ){
            wp_set_object_terms($agent_id,$agency_category_submit,'category_agency'); 
        }  

        
        
        
        
        $agency_category           =   get_term( $agency_action_submit, 'action_category_agency');     
        if(isset($agency_category->term_id)){
            $agency_action_submit  =   $agency_category->name;
        }else{
            $agency_action_submit=-1;
        }
        
        if( isset($agency_action_submit) && $agency_action_submit!='none' ){
            wp_set_object_terms($agent_id,$agency_action_submit,'action_category_agency'); 
        }  

        
        if( isset($agency_city) && $agency_city!='none' ){
            wp_set_object_terms($agent_id,$agency_city,'city_agency'); 
        }  
        
        if( isset($agency_area) && $agency_area!='none' ){
            wp_set_object_terms($agent_id,$agency_area,'area_agency'); 
        }  
        
        if( isset($agency_county) && $agency_county!='none' ){
            wp_set_object_terms($agent_id,$agency_county,'county_state_agency'); 
        }  

     

     
        set_post_thumbnail( $agent_id, $profile_image_url_small );

        
        
        
        
        
        if( $current_user->user_email != $useremail ) {
            $user_id=email_exists( $useremail ) ;
            if ( $user_id){
                esc_html_e('The email was not saved because it is used by another user.','wpresidence');
            } else{
                $args = array(
                    'ID'         => $userID,
                    'user_email' => $useremail
                ); 
                wp_update_user( $args );
            } 
        }
        
        $arguments=array(
            'user_profile'      =>  $user_login,
        );

        wpestate_select_email_type(get_option('admin_email'),'agent_update_profile',$arguments);
        esc_html_e('Profile updated','wpresidence');
        die(); 
   }
endif; // end   wpestate_ajax_update_profile agency



////////////////////////////////////////////////////////////////////////////////
/// Ajax  upadte profile developer
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_wpestate_ajax_update_profile_developer', 'wpestate_ajax_update_profile_developer' );  
if( !function_exists('wpestate_ajax_update_profile_developer') ):
   
   function wpestate_ajax_update_profile_developer(){
        check_ajax_referer( 'wpestate_update_profile_nonce', 'security' );
        $current_user           =   wp_get_current_user();
        $userID                 =   $current_user->ID;
        $user_login             =   $current_user->user_login;
        check_ajax_referer( 'profile_ajax_nonce', 'security-profile' );
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        $user_role = intval (get_user_meta( $current_user->ID, 'user_estate_role', true) );
        
        if($user_role!=4){
            exit('not the right role');
        }
        
        $developer_id=get_user_meta( $userID, 'user_agent_id',true);

        
        $allowed_html               =   array('</br>');
        $developer_name             =   sanitize_text_field ( wp_kses( $_POST['developer_name'] ,$allowed_html) );
        $useremail                  =   sanitize_text_field ( wp_kses( $_POST['useremail'] ,$allowed_html) );
        $userphone                  =   sanitize_text_field ( wp_kses( $_POST['userphone'] ,$allowed_html) );
        $usermobile                 =   sanitize_text_field ( wp_kses( $_POST['usermobile'] ,$allowed_html) );
        $userskype                  =   sanitize_text_field ( wp_kses( $_POST['userskype'] ,$allowed_html) );
        $usertitle                  =   sanitize_text_field ( wp_kses( $_POST['usertitle'] ,$allowed_html) );
        $about_me                   =   wp_kses( $_POST['description'],$allowed_html );
        $profile_image_url_small    =   sanitize_text_field ( wp_kses($_POST['profile_image_url_small'],$allowed_html) );
        $profile_image_url          =   sanitize_text_field ( wp_kses($_POST['profile_image_url'],$allowed_html) );       
        $userfacebook               =   sanitize_text_field ( wp_kses( $_POST['userfacebook'],$allowed_html) );
        $usertwitter                =   sanitize_text_field ( wp_kses( $_POST['usertwitter'],$allowed_html) );
        $userlinkedin               =   sanitize_text_field ( wp_kses( $_POST['userlinkedin'],$allowed_html) );
        $userpinterest              =   sanitize_text_field ( wp_kses( $_POST['userpinterest'],$allowed_html ) );
        $userinstagram              =   sanitize_text_field ( wp_kses( $_POST['userinstagram'],$allowed_html ) );
        $userurl                    =   sanitize_text_field ( wp_kses( $_POST['userurl'],$allowed_html ) );         
        $developer_languages           =   sanitize_text_field ( wp_kses( $_POST['developer_languages'],$allowed_html ) );
        $developer_website             =   sanitize_text_field ( wp_kses( $_POST['developer_website'],$allowed_html ) );
        $developer_taxes               =   sanitize_text_field ( wp_kses( $_POST['developer_taxes'],$allowed_html ) );     
        $developer_category_submit     =   sanitize_text_field ( wp_kses( $_POST['developer_category_submit'],$allowed_html ) );
        $developer_action_submit       =   sanitize_text_field ( wp_kses( $_POST['developer_action_submit'],$allowed_html ) );
        $developer_city                =   sanitize_text_field ( wp_kses( $_POST['developer_city'],$allowed_html ) );
        $developer_county              =   sanitize_text_field ( wp_kses( $_POST['developer_county'],$allowed_html ) );
        $developer_area                =   sanitize_text_field ( wp_kses( $_POST['developer_area'],$allowed_html ) );     
        $developer_address             =   sanitize_text_field ( wp_kses( $_POST['developer_address'],$allowed_html ) );
        $developer_lat                 =   sanitize_text_field ( wp_kses( $_POST['developer_lat'],$allowed_html ) );
        $developer_long                =   sanitize_text_field ( wp_kses( $_POST['developer_long'],$allowed_html ) );
       
        
      
        $developer_id=get_user_meta($userID,'user_agent_id',true);
        
        update_user_meta( $userID, 'custom_picture',$profile_image_url);
        update_user_meta( $userID, 'small_custom_picture',$profile_image_url_small);     
    
        
        
         if($firstname!=='' || $secondname!='' ){
            $post = array(
                    'ID'            => $developer_id,
                    'post_title'    => $developer_name,
                    'post_content'  => $about_me,
            );
            $post_id =  wp_update_post($post );  
        }
    
              update_post_meta($developer_id, 'agent_email',   $useremail);
        update_post_meta($developer_id, 'developer_email',   $useremail);
        update_post_meta($developer_id, 'developer_phone',   $userphone);
        update_post_meta($developer_id, 'developer_mobile',  $usermobile);
        update_post_meta($developer_id, 'developer_skype',   $userskype);

        update_post_meta($developer_id, 'developer_facebook',   $userfacebook);
        update_post_meta($developer_id, 'developer_twitter',   $usertwitter);
        update_post_meta($developer_id, 'developer_linkedin',   $userlinkedin);
        update_post_meta($developer_id, 'developer_pinterest',   $userpinterest);
        update_post_meta($developer_id, 'developer_instagram',   $userinstagram);
        update_post_meta($developer_id, 'developer_languages',   $developer_languages);
        update_post_meta($developer_id, 'developer_website',   $developer_website);
        update_post_meta($developer_id, 'developer_taxes',   $developer_taxes);
        update_post_meta($developer_id, 'developer_address',   $developer_address);
        update_post_meta($developer_id, 'developer_lat',   $developer_lat);
        update_post_meta($developer_id, 'developer_long',   $developer_long);
        
        
 

  
        $developer_category           =   get_term( $developer_category_submit, 'property_category_developer');     
        if(isset($developer_category->term_id)){
            $developer_category_submit  =   $developer_category->name;
        }else{
            $developer_category_submit=-1;
        }
        
        if( isset($developer_category_submit) && $developer_category_submit!='none' ){
            wp_set_object_terms($developer_id,$developer_category_submit,'property_category_developer'); 
        }  

        
        
        
        
        $developer_category           =   get_term( $developer_action_submit, 'property_action_developer');     
        if(isset($developer_category->term_id)){
            $developer_action_submit  =   $developer_category->name;
        }else{
            $developer_action_submit=-1;
        }
        
        if( isset($developer_action_submit) && $developer_action_submit!='none' ){
            wp_set_object_terms($developer_id,$developer_action_submit,'property_action_developer'); 
        }  

        
        if( isset($developer_city) && $developer_city!='none' ){
            wp_set_object_terms($developer_id,$developer_city,'property_city_developer'); 
        }  
        
        if( isset($developer_area) && $developer_area!='none' ){
            wp_set_object_terms($developer_id,$developer_area,'property_area_developer'); 
        }  
        
        if( isset($developer_county) && $developer_county!='none' ){
            wp_set_object_terms($developer_id,$developer_county,'property_county_state_developer'); 
        }  

     

     
        set_post_thumbnail( $developer_id, $profile_image_url_small );

        
        
        
        
        
        if( $current_user->user_email != $useremail ) {
            $user_id=email_exists( $useremail ) ;
            if ( $user_id){
                esc_html_e('The email was not saved because it is used by another user.','wpresidence');
            } else{
                $args = array(
                    'ID'         => $userID,
                    'user_email' => $useremail
                ); 
                wp_update_user( $args );
            } 
        }
        
        $arguments=array(
            'user_profile'      =>  $user_login,
        );

        wpestate_select_email_type(get_option('admin_email'),'agent_update_profile',$arguments);
        esc_html_e('Profile updated','wpresidence');
        die(); 
   }
endif; // end   wpestate_ajax_update_profile developer


////////////////////////////////////
//delete profile wpestate_delete_profile
//////////////////////////////////
add_action( 'wp_ajax_wpestate_delete_profile', 'wpestate_delete_profile' );  

if( !function_exists('wpestate_delete_profile') ):   
    function wpestate_delete_profile(){
        check_ajax_referer( 'wpestate_update_profile_nonce', 'security' );
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        
         $args = array(
                'post_type' => array('estate_property',
                                    'estate_agent',
                                    'estate_agency',
                                    'estate_developer',
                                    'post',
                                    'wpestate_message',
                                    'attachment'
                                    ),
                'author'           =>  $userID,
                'posts_per_page'    => -1,
            );
        

        $prop_selection = new WP_Query($args);

         
        while ($prop_selection->have_posts()): $prop_selection->the_post(); 
           wp_delete_post( get_the_ID()  ); 
        endwhile;
        
        //delete comments
        $args = array(
            'user_id' => $userID, // use user_id
        );
        
        $comments = get_comments($args);

        foreach($comments as $comment) :
            wp_delete_comment($comment->comment_ID);
        endforeach;
        
        $agent_page =   get_user_meta( $userID, 'user_agent_id' , true) ;
        wp_delete_post($agent_page);

        wp_delete_user($userID);
 
        die(); 
    }
endif; // end   wpestate_delete_profile

/////////////////////////////////////////////////// update user   

if( !function_exists('wpestate_update_user_agent') ):
function    wpestate_update_user_agent ($agent_member,$agent_category_submit,$agent_action_submit,$agent_city,$agent_county,$agent_area,$userurl,$agent_id, $firstname ,$secondname ,$useremail,$userphone,$userskype,$usertitle,$profile_image_url,$usermobile,$about_me,$profile_image_url_small,$userfacebook,$usertwitter,$userlinkedin,$userpinterest,$userinstagram) {
  
    
    if (intval($agent_id)==0){
        return;
    }
    
    if($firstname!=='' || $secondname!='' ){
        $post = array(
            'ID'            => $agent_id,
            'post_title'    => $firstname.' '.$secondname,
            'post_content'  => $about_me,
        );
        wp_update_post($post );  
    }
     
    update_post_meta($agent_id, 'agent_member',$agent_member);
    update_post_meta($agent_id, 'first_name',   $firstname);
    update_post_meta($agent_id, 'last_name',   $secondname);   
    update_post_meta($agent_id, 'agent_email',   $useremail);
    update_post_meta($agent_id, 'agent_phone',   $userphone);
    update_post_meta($agent_id, 'agent_mobile',  $usermobile);
    update_post_meta($agent_id, 'agent_skype',   $userskype);
    update_post_meta($agent_id, 'agent_position',  $usertitle);
    update_post_meta($agent_id, 'agent_facebook',   $userfacebook);
    update_post_meta($agent_id, 'agent_twitter',   $usertwitter);
    update_post_meta($agent_id, 'agent_linkedin',   $userlinkedin);
    update_post_meta($agent_id, 'agent_pinterest',   $userpinterest);
    update_post_meta($agent_id, 'agent_instagram',   $userinstagram);
    update_post_meta($agent_id, 'agent_website',   $userurl);
    set_post_thumbnail( $agent_id, $profile_image_url_small );


    $agent_category           =   get_term( $agent_category_submit, 'property_category_agent');     
    if(isset($agent_category->term_id)){
        $agent_category_submit  =   $agent_category->name;
    }else{
        $agent_category_submit=-1;
    }

    if( isset($agent_category_submit) && $agent_category_submit!='none' ){
        wp_set_object_terms($agent_id,$agent_category_submit,'property_category_agent'); 
    }  
        
    //---

    $agent_category           =   get_term( $agent_action_submit, 'property_action_category_agent');     
    if(isset($agent_category->term_id)){
        $agent_action_submit  =   $agent_category->name;
    }else{
        $agent_action_submit=-1;
    }
         
    if( isset($agent_action_submit) && $agent_action_submit!='none' ){
        wp_set_object_terms($agent_id,$agent_action_submit,'property_action_category_agent'); 
    }  


    if( isset($agent_city) && $agent_city!='none' ){
        wp_set_object_terms($agent_id,$agent_city,'property_city_agent'); 
    }  

    if( isset($agent_county) && $agent_county!='none' ){
        wp_set_object_terms($agent_id,$agent_county,'property_county_state_agent'); 
    }  

    if( isset($agent_area) && $agent_area!='none' ){
        wp_set_object_terms($agent_id,$agent_area,'property_area_agent'); 
    }  

 
 }
endif; // end   ajax_update_profile         
 



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Forgot Pass function
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_update_pass', 'wpestate_ajax_update_pass' );  
if( !function_exists('wpestate_ajax_update_pass') ):
   
   function wpestate_ajax_update_pass(){
        check_ajax_referer( 'pass_ajax_nonce', 'security-pass' );
        $current_user   =   wp_get_current_user();
        $allowed_html   =   array();
        $userID         =   $current_user->ID;
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        
        $oldpass        =  sanitize_text_field ( wp_kses( $_POST['oldpass'] ,$allowed_html) );
        $newpass        =  sanitize_text_field ( wp_kses( $_POST['newpass'] ,$allowed_html) );
        $renewpass      =  sanitize_text_field ( wp_kses( $_POST['renewpass'] ,$allowed_html) ) ;
        
        if($newpass=='' || $renewpass=='' ){
            esc_html_e('The new password is blank','wpresidence');
            die();
        }
       
        if($newpass != $renewpass){
            esc_html_e('Passwords do not match','wpresidence');
            die();
        }
        
        
        $user = get_user_by( 'id', $userID );
        if ( $user && wp_check_password( $oldpass, $user->data->user_pass, $user->ID) ){
            wp_set_password( $newpass, $user->ID );
            esc_html_e('Password Updated','wpresidence');
        }else{
            esc_html_e('Old Password is not correct','wpresidence');
        }
     
        die();         
   }
endif; // end   wpestate_ajax_update_pass 



   
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Upload   function
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_add_fav', 'wpestate_ajax_add_fav' );  

if( !function_exists('wpestate_ajax_add_fav') ):

    function wpestate_ajax_add_fav(){
        //check_ajax_referer( 'wpestate_ajax_filtering', 'security' );
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
        $user_option    =   'favorites'.$userID;
        
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        
        $post_id        =   intval( $_POST['post_id']);
        $curent_fav     =   get_option($user_option);
       
        
        if($curent_fav==''){ // if empy / first time
            $fav    =   array();
            $fav[]  =   $post_id;
            update_option($user_option,$fav);
            echo json_encode(array('added'=>true, 'response'=>esc_html__('addded','wpresidence')));
            die();
        }else{
            if ( ! in_array ($post_id,$curent_fav) ){
                $curent_fav[]=$post_id;                  
                update_option($user_option,$curent_fav);
                echo json_encode(array('added'=>true, 'response'=>esc_html__('addded','wpresidence')));
                die();
            }else{
                if(($key = array_search($post_id, $curent_fav)) !== false) {
                    unset($curent_fav[$key]);
                }
                update_option($user_option,$curent_fav);
                echo json_encode(array('added'=>false, 'response'=>esc_html__('removed','wpresidence')));
                die();
            }
        }     
        die();
    }
endif; // end   wpestate_ajax_add_fav 
 
 
 
 
 



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wpestate_ajax_handler_nopriv_wpestate_ajax_filter_listings', 'wpestate_ajax_filter_listings' );  
add_action( 'wpestate_ajax_handler_wpestate_ajax_filter_listings', 'wpestate_ajax_filter_listings' );

if( !function_exists('wpestate_ajax_filter_listings') ):
    
    function wpestate_ajax_filter_listings(){
       // check_ajax_referer( 'wpestate_ajax_filtering', 'security' );
        wp_suspend_cache_addition(true);
   
     
        global $wpestate_currency;
        global $where_currency;
        global $post;
        global $wpestate_options;
        global $wpestate_prop_unit;
        global $wpestate_property_unit_slider;
        global $wpestate_no_listins_per_row;
        global $wpestate_uset_unit;
        global $wpestate_custom_unit_structure;
        global $align_class;
        $wpestate_custom_unit_structure    =   wpresidence_get_option('wpestate_property_unit_structure');        
        $wpestate_uset_unit       =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
        $current_user             =   wp_get_current_user();
        $userID                   =   $current_user->ID;
        $user_option              =   'favorites'.$userID;
        $curent_fav               =   get_option($user_option);
        $wpestate_currency                 =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency           =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
        $area_array               =   '';   
        $city_array               =   '';
        $action_array             =   '';
        $categ_array              =   '';
        $show_compare             =   1;
        $wpestate_property_unit_slider     =   wpresidence_get_option('wp_estate_prop_list_slider','');
        $wpestate_no_listins_per_row       =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );   
        $wpestate_options                  =   wpestate_page_details(intval($_POST['page_id']));
        
         global $align;
        global $row_number_col;
        
        if(isset($_POST['align']) && $_POST['align']=='horizontal' ){
            
            $align          =   'col-md-12';
            $row_number_col =   12;
            $is_col_md_12   =   0;
        }
        
        $wpestate_prop_unit          =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
        $prop_unit_class    =   '';
        $align_class        =   '';
        if( $wpestate_prop_unit == 'list' ){
            $prop_unit_class    =   "ajax12";
            $align_class        =   'the_list_view';
        }

        $property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
        $property_card_type_string  =   '';
        if($property_card_type==0){
            $property_card_type_string  =   '';
        }else{
            $property_card_type_string  =   '_type'.$property_card_type;
        }

        //////////////////////////////////////////////////////////////////////////////////////
        ///// category filters 
        //////////////////////////////////////////////////////////////////////////////////////
        $allowed_html   =   array();
        if (isset($_POST['category_values']) && trim($_POST['category_values']) != 'Categories' && $_POST['category_values']!=''&& $_POST['category_values']!='all' && $_POST['category_values']!='all-types'){
            $taxcateg_include   =   sanitize_title ( wp_kses(  $_POST['category_values'],$allowed_html  ) );
            $categ_array    =   array(
                'taxonomy'  => 'property_category',
                'field'     => 'slug',
                'terms'     => $taxcateg_include
            );
        }
         
     
                
        //////////////////////////////////////////////////////////////////////////////////////
        ///// action  filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if ( ( isset($_POST['action_values']) && trim($_POST['action_values']) != 'Types' ) && $_POST['action_values']!='' && $_POST['action_values']!='all' && $_POST['action_values']!='all-actions'){
            $taxaction_include   =   sanitize_title ( wp_kses(  $_POST['action_values'],$allowed_html  ) );   
            $action_array   =   array(
                'taxonomy'  => 'property_action_category',
                'field'     => 'slug',
                'terms'     => $taxaction_include
            );
        }

		
		//////////////////////////////////////////////////////////////////////////////////////
        ///// county filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['county']) and trim($_POST['county']) !='States' && $_POST['county'] && trim($_POST['county']) != 'all' /* && trim($_POST['county']) != 'all-cities' */ )  {
            $taxcounty[] = sanitize_title ( wp_kses($_POST['county'],$allowed_html) );
            $county_array     = array(
                'taxonomy'  => 'property_county_state',
                'field'     => 'slug',
                'terms'     => $taxcounty
            );
        }
   
      
        //////////////////////////////////////////////////////////////////////////////////////
        ///// city filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['city']) and trim($_POST['city']) !='Cities' && $_POST['city'] && trim($_POST['city']) != 'all' && trim($_POST['city']) != 'all-cities' ) {
            $taxcity[] = sanitize_title ( wp_kses($_POST['city'],$allowed_html) );
            $city_array     = array(
                'taxonomy'  => 'property_city',
                'field'     => 'slug',
                'terms'     => $taxcity
            );
        }
 
    
        //////////////////////////////////////////////////////////////////////////////////////
        ///// area filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if ( isset( $_POST['area'] ) && trim($_POST['area']) != 'Areas' && $_POST['area'] && trim($_POST['area']) != 'all' && trim($_POST['area']) != 'all-areas' ) {
            $taxarea[] = sanitize_title ( wp_kses ($_POST['area'],$allowed_html) );
            $area_array = array(
                'taxonomy'  => 'property_area',
                'field'     => 'slug',
                'terms'     => $taxarea
            );
        }

               
        //////////////////////////////////////////////////////////////////////////////////////
        ///// order details
        //////////////////////////////////////////////////////////////////////////////////////
        $meta_directions    =   'DESC';
        $meta_order         =   'prop_featured';
        $order_by           =   'meta_value_num';

        $order=intval($_POST['order']);

        switch ($order){
                case 1:
                    $meta_order         =   'property_price';
                    $meta_directions    =   'DESC';
                    $order_by           =   'meta_value_num';
                    break;
                case 2:
                    $meta_order         =   'property_price';
                    $meta_directions    =   'ASC';
                    $order_by           =   'meta_value_num';
                    break;
                case 3:
                    $meta_order         =   '';
                    $meta_directions    =   'DESC';
                    $order_by           =   'ID';
                    break;
                case 4:
                    $meta_order         =   '';
                    $meta_directions    =   'ASC';
                    $order_by           =   'ID';
                    break;
                case 5:
                    $meta_order         =   'property_bedrooms';
                    $meta_directions    =   'DESC';
                    $order_by           =   'meta_value_num';
                    break;
                case 6:
                    $meta_order         =   'property_bedrooms';
                    $meta_directions    =   'ASC';
                    $order_by           =   'meta_value_num';
                    break;
                case 7:
                    $meta_order         =   'property_bathrooms';
                    $meta_directions    =   'DESC';
                    $order_by           =   'meta_value_num';
                    break;
                case 8:
                    $meta_order         =   'property_bathrooms';
                    $meta_directions    =   'ASC';
                    $order_by           =   'meta_value_num';
                    break;
            }
        $paged      =   intval( $_POST['newpage'] );
        $prop_no    =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
            
        

        $max_pins                   =   intval( wpresidence_get_option('wp_estate_map_max_pins') );
        $args = array(
            'cache_results'             =>  false,
            'update_post_meta_cache'    =>  false,
            'update_post_term_cache'    =>  false,
            'post_type'         => 'estate_property',
            'post_status'       => 'publish',
            'paged'             => $paged,
            'posts_per_page'    => $prop_no,
            'orderby'           => $order_by, 
            'meta_key'          => $meta_order,
            'order'             => $meta_directions,
            'tax_query'         => array(
                                'relation' => 'AND',
                                        $categ_array,
                                        $action_array,
                                        $county_array,
                                        $city_array,
                                        $area_array
                                )
        );
    

        if( intval($order) === 0 ){
            $prop_selection = wpestate_return_filtered_by_order($args);
        }else{
            $prop_selection = new WP_Query($args);
        }
      
        
        
        
        $to_show= '<span id="scrollhere"></span>';  
        $counter = 0;
        ob_start();
        if( $prop_selection->have_posts() ){
            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                include( locate_template('templates/property_unit'.$property_card_type_string.'.php') );
            endwhile;
            wpestate_pagination_ajax_newver($prop_selection->max_num_pages, $range =2,$paged,'pagination_ajax',$order); 
        }else{
            print '<span class="no_results">'. esc_html__("We didn't find any results","wpresidence").'</>';
        }
        
        $to_show.=ob_get_contents();
        ob_end_clean();
        
        wp_reset_query();
        wp_suspend_cache_addition(false);   
        
         //krakau
        $args['page']=1;
        $args['posts_per_page']=intval( wpresidence_get_option('wp_estate_map_max_pins') );
        $args['offset']          =   ($paged-1)*$prop_no;
        $on_demand_results = wpestate_listing_pins_on_demand($args);
        
         
        echo json_encode( array(    
                            'args'      =>  $args, 
                            'markers'   =>  $on_demand_results['markers'],
                            'no_results'=>  $on_demand_results['results'],
                            'to_show'   =>  $to_show,
                        ));
        die();
  }
  
 endif; // end   wpestate_ajax_filter_listings 
 


 
 ////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wpestate_ajax_handler_nopriv_wpestate_custom_adv_ajax_filter_listings_search', 'wpestate_custom_adv_ajax_filter_listings_search' );  
add_action( 'wpestate_ajax_handler_wpestate_custom_adv_ajax_filter_listings_search', 'wpestate_custom_adv_ajax_filter_listings_search' );

if( !function_exists('wpestate_custom_adv_ajax_filter_listings_search') ):
    
    function wpestate_custom_adv_ajax_filter_listings_search(){
       // check_ajax_referer( 'wpestate_ajax_filtering', 'security' );
        wp_suspend_cache_addition(true);
        global $post;      
        global $wpestate_options;
        global $show_compare_only;
        global $wpestate_currency;
        global $where_currency;
        global $wpestate_keyword;
        global $wpestate_property_unit_slider;
        global $is_col_md_12;
        global $wpestate_no_listins_per_row;
        global $wpestate_uset_unit;
        global $wpestate_custom_unit_structure;
        
        $wpestate_custom_unit_structure      =   wpresidence_get_option('wpestate_property_unit_structure');
        $wpestate_uset_unit         =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
        $current_user               =   wp_get_current_user();
        $show_compare_only          =   'yes';
        $allowed_html               =   array();
        $id_array                   =   '';
        
        if( get_option( 'page_on_front') == intval($_POST['postid']) ){
            $show_compare_only  =   'no'; 
        }  
        
        $userID             =   $current_user->ID;
        $user_option        =   'favorites'.$userID;
        $curent_fav         =   get_option($user_option);
        $wpestate_currency           =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
        $area_array         =   '';   
        $city_array         =   ''; 
        $action_array       =   '';   
        $categ_array        =   '';
        $meta_query         =   array();
        $wpestate_options            =   wpestate_page_details(intval($_POST['postid']));
          
        $adv_search_what    =   wpresidence_get_option('wp_estate_adv_search_what','');
        $adv_search_how     =   wpresidence_get_option('wp_estate_adv_search_how','');
        $adv_search_label   =   wpresidence_get_option('wp_estate_adv_search_label','');                    
        $adv_search_type    =   wpresidence_get_option('wp_estate_adv_search_type','');
         
        
        $adv_search_fields_no               =   floatval( wpresidence_get_option('wp_estate_adv_search_fields_no') );
        $term_counter=intval($_REQUEST['term_counter']);
        $adv_search_what    = array_slice($adv_search_what, ($term_counter*$adv_search_fields_no),$adv_search_fields_no);
        $adv_search_label   = array_slice($adv_search_label, ($term_counter*$adv_search_fields_no),$adv_search_fields_no);
        $adv_search_how     = array_slice($adv_search_how, ($term_counter*$adv_search_fields_no),$adv_search_fields_no);
        
        
        
        $wpestate_property_unit_slider = wpresidence_get_option('wp_estate_prop_list_slider','');
        $wpestate_no_listins_per_row       =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
          
        $half_map =   0;
        if (isset($_POST['halfmap'])){
            $half_map = intval($_POST['halfmap']);
        }  
        global $wpestate_prop_unit;
        global $prop_unit_class;
        global $align_class;
        $wpestate_prop_unit          =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
        $prop_unit_class    =   '';
        if( $wpestate_prop_unit == 'list' ){
            $prop_unit_class    =   "ajax12";
            $align_class        =   'the_list_view';
        }


        $property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
        $property_card_type_string  =   '';
        
        if( $property_card_type ==0 ){
            $property_card_type_string='';
        }else{
            $property_card_type_string='_type'.$property_card_type;
        }
        
        $paged                  =   intval($_POST['newpage']);
        $prop_no                =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
        $args                   =   wpestate_search_results_custom ('ajax'); 
        $args['posts_per_page'] =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
       
        //////////////////////////////////////////////////// in case of slider search
      
        $return_custom      =   wpestate_search_with_keyword_ajax($adv_search_what, $adv_search_label);
        
        if( isset( $return_custom['id_array']) ){
            $id_array       =   $return_custom['id_array']; 
            if($id_array!=0){
                $args=  array(  'post_type'     =>    'estate_property',
                    'p'             =>    $id_array
                );
            }
        }
        
        if(isset($return_custom['keyword'])){
            $wpestate_keyword        =   $return_custom['keyword'];
        }
        
        
        if( isset($_POST['keyword_search']) && trim($_POST['keyword_search'])!='' ){
            $allowed_html       =   array();
            $wpestate_keyword            =   esc_attr(  wp_kses ( $_POST['keyword_search'], $allowed_html));
       
        }
    
   
        if( wpresidence_get_option('wp_estate_use_geo_location','')=='yes' && $_POST['geo_lat']!='' && $_POST['geo_long']!='' ){
           
            $geo_lat = $_POST['geo_lat'];
            $geo_long = $_POST['geo_long'];
            $geo_rad = $_POST['geo_rad'];
            $args = wpestate_geo_search_filter_function($args, $geo_lat, $geo_long, $geo_rad);
        }
        
        ////////////////////////////////////////////////////////// end in case of slider search 

        
        
        $order= intval($_POST['order']);
        $meta_order         =   'prop_featured';
        $meta_directions    =   'DESC';   
        $order_by           =   'meta_value';
    
        if(isset($_POST['order'])) {
            $order=  wp_kses( $_POST['order'],$allowed_html );
            switch ($order){
                case 1:
                    $meta_order='property_price';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 2:
                    $meta_order='property_price';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
                case 3:
                    $meta_order='';
                    $meta_directions='DESC';
                    $order_by='ID';
                    break;
                case 4:
                    $meta_order='';
                    $meta_directions='ASC';
                    $order_by='ID';
                    break;
                case 5:
                    $meta_order='property_bedrooms';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 6:
                    $meta_order='property_bedrooms';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
                case 7:
                    $meta_order='property_bathrooms';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 8:
                    $meta_order='property_bedrooms';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
            }
        }
        
        
        $args['posts_per_page'] =   intval(wpresidence_get_option('wp_estate_prop_no_adv_search',''));
        $args ['meta_key']        = $meta_order;
        $args ['orderby']         = $order_by;
        $args ['order']           = $meta_directions;
        
    
       
        if($id_array!=0){
          
            $prop_selection     = new WP_Query($args);
        }else{
            if($order==0){
                add_filter( 'posts_orderby', 'wpestate_my_order' );
            }
            
            if( !empty($wpestate_keyword) ){
                $wpestate_keyword    =  str_replace('-', ' ', $wpestate_keyword);
                add_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
                $prop_selection     = new WP_Query($args);
                if(function_exists('wpestate_disable_filtering')){ 
                    wpestate_disable_filtering( 'posts_where', 'wpestate_title_filter', 10, 2 );
                }
            }else{
               $prop_selection     = new WP_Query($args);
            }
            if($order==0){
                if(function_exists('wpestate_disable_filtering')){
                    wpestate_disable_filtering( 'posts_orderby', 'wpestate_my_order' );
                }
            }
        }
        
    
        $counter            =   0;
        $compare_submit     =   wpestate_get_template_link('compare_listings.php');
             
        
        
        
        
        
        
        ob_start();
        print '<span id="scrollhere"></span>'; 
        if( $prop_selection->have_posts() ){
                  if($half_map==1){
                    $is_col_md_12=1;
                }
                while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                      include( locate_template('templates/property_unit'.$property_card_type_string.'.php') );
                endwhile;
            
  
            wpestate_pagination_ajax($prop_selection->max_num_pages, $range =2,$paged,'pagination_ajax_search'); 
        }else{
            print '<span class="no_results">'. esc_html__("We didn't find any results","wpresidence").'</>';
        }
        
       //wp_reset_query();
       // wp_reset_postdata();
        wp_suspend_cache_addition(false);
        
        $cards= ob_get_contents();
        ob_end_clean();
        echo json_encode( array('sent'=>true, 'args'=>$args,'cards'=>$cards,'no_founs'=> $prop_selection->found_posts.' '.esc_html__('Listings','wpresidence') ) ); 
        die();
  }
  
 endif; // end   ajax_filter_listings 
 
 
 ////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_custom_adv_get_filtering_ajax_result', 'wpestate_custom_adv_get_filtering_ajax_result' );  
add_action( 'wp_ajax_wpestate_custom_adv_get_filtering_ajax_result', 'wpestate_custom_adv_get_filtering_ajax_result' );

if( !function_exists('wpestate_custom_adv_get_filtering_ajax_result') ):
    
    function wpestate_custom_adv_get_filtering_ajax_result(){
        wp_suspend_cache_addition(true);
        global $post;
       
        global $wpestate_options;
        global $show_compare_only;
        global $wpestate_currency;
        global $where_currency;
        global $wpestate_keyword;
          
        $show_compare_only          =   'no';
        $allowed_html               =   array();
        $current_user               =   wp_get_current_user();
        $userID                     =   $current_user->ID;
        $user_option                =   'favorites'.$userID;
        $curent_fav                 =   get_option($user_option);
        $wpestate_currency                   =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
        $area_array                 =   '';   
        $city_array                 =   '';    
        $action_array               =   '';   
        $categ_array                =   '';
        $meta_query                 =   array();
        $wpestate_options                    =   wpestate_page_details(intval($_POST['postid']));
        $adv_search_what            =   wpresidence_get_option('wp_estate_adv_search_what','');
        $adv_search_how             =   wpresidence_get_option('wp_estate_adv_search_how','');
        $adv_search_label           =   wpresidence_get_option('wp_estate_adv_search_label','');                    
        $adv_search_type            =   wpresidence_get_option('wp_estate_adv_search_type','');

     
        
        $args       =   wpestate_search_results_custom ('ajax');
        $wpestate_keyword    =   wpestate_search_with_keyword_ajax($adv_search_what,$adv_search_label );
         
        ////////////////////////////////////////////////////////// end in case of slider search 
        add_filter( 'posts_orderby', 'wpestate_my_order' );
        if( !empty($wpestate_keyword) ){
            $prop_selection = wpestate_return_filtered_by_order($args);
        }else{
            $prop_selection     = new WP_Query($args);
        }
        if(function_exists('wpestate_disable_filtering')){
            wpestate_disable_filtering( 'posts_orderby', 'wpestate_my_order' );
        }
         
        if( $prop_selection->have_posts() ){
            print intval($prop_selection->post_count);

        }else{
            print '0';
        }

        wp_suspend_cache_addition(false); 
        die();
  }
  
 endif; // end   ajax_filter_listings 
 
 
 

////////////////////////////////////////////////////////////////////////////////
/// wpestate_filter_query
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_filter_query') ):


function wpestate_filter_query( $orderby )
{
    $orderby = " DD.prop_featured  DESC ";
    return $orderby;
}
endif; 
// end   wpestate_filter_query 
 
 
 
 


  

  
  
  
  
  

  
  
    
 ////////////////////////////////////////////////////////////////////////////////
/// pay via paypal - per listing
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_listing_pay', 'wpestate_ajax_listing_pay' );  

if( !function_exists('wpestate_ajax_listing_pay') ):  

    function wpestate_ajax_listing_pay(){
        check_ajax_referer( 'wpestate_payments_nonce', 'security' );
        $current_user   =   wp_get_current_user();
        $is_featured    =   intval($_POST['is_featured']);
        $prop_id        =   intval($_POST['propid']);
        $is_upgrade     =   intval($_POST['is_upgrade']); 
        $userID         =   $current_user->ID;
        $post           =   get_post($prop_id); 


        if ( !is_user_logged_in() ) {   
            exit('ko');
        }

        if($userID === 0 ){
            exit('out pls');
        }

        if( $post->post_author != $userID){
            exit('get out of my cloud');
        }

        $paypal_status                  =   esc_html( wpresidence_get_option('wp_estate_paypal_api','') );
        $host                           =   'https://api.sandbox.paypal.com';  
        $price_submission               =   floatval( wpresidence_get_option('wp_estate_price_submission','') );
        $price_featured_submission      =   floatval( wpresidence_get_option('wp_estate_price_featured_submission','') );
        $submission_curency_status      =   esc_html( wpresidence_get_option('wp_estate_submission_curency','') );
        $pay_description                =   esc_html__('Listing payment on ','wpresidence').esc_url( home_url('/') );

        if( $is_featured==0 ){
            $total_price =  number_format($price_submission, 2, '.','');
        }else{
            $total_price = $price_submission + $price_featured_submission;
            $total_price = number_format($total_price, 2, '.','');
        }


        if ($is_upgrade==1){
            $total_price        =  number_format($price_featured_submission, 2, '.','');
            $pay_description    =   esc_html__('Upgrade to featured listing on ','wpresidence').esc_url( home_url('/') );
        }

        $sandbox_profile = 'sandbox';
        if($paypal_status=='live'){
            $host               =   'https://api.paypal.com';
            $sandbox_profile    =   '';
            $createdProfile     =    get_option('paypal_web_profile_live','');
        }else{
            $createdProfile     =    get_option('paypal_web_profile_sandbox','');
        }
        $url                =   $host.'/v1/oauth2/token'; 
        $postArgs           =   'grant_type=client_credentials';
        
        $token='';
        if(function_exists('wpestate_get_access_token')){
            $token              =   wpestate_get_access_token($url,$postArgs);
        }
        
        $url                =   $host.'/v1/payment-experience/web-profiles'; 





        if($createdProfile === ''){
            // create profile for no shipiing
            $site_title = get_bloginfo();

            $profile = array (
                           "name" => $site_title,
                           "presentation" => array(
                                       "brand_name"  => $site_title.$sandbox_profile,

                                       ),
                           "input_fields" => array( 
                                       "allow_note"=> true,
                                       "no_shipping"=> 0,
                                       "address_override"=> 1)

                           );
            $json           =   json_encode($profile);
            $json_resp      =   wpestate_make_post_call($url, $json,$token);
            $createdProfile =   $json_resp['id'];
            if( $paypal_status=='live' ){
                update_option( 'paypal_web_profile_live', $json_resp['id'] );           
            }else{
                update_option( 'paypal_web_profile_sandbox', $json_resp['id'] );  
            }
        }


        $url                =   $host.'/v1/payments/payment';
        $dash_link          =   wpestate_get_template_link('user_dashboard.php');
        $processor_link     =   wpestate_get_template_link('processor.php');


        $payment = array(
                        'intent' => 'sale',
                        "experience_profile_id" =>  $createdProfile,
                        "redirect_urls"=>array(
                                "return_url"            =>  $processor_link,                  
                                "cancel_url"            =>  $dash_link
                            ),
                        'payer' => array("payment_method"=>"paypal"),

                    );


        $payment['transactions'][0] = array(
                                            'amount' => array(
                                                'total' => $total_price,
                                                'currency' => $submission_curency_status,
                                                'details' => array(
                                                    'subtotal' => $total_price,
                                                    'tax' => '0.00',
                                                    'shipping' => '0.00'
                                                    )
                                                ),
                                            'description' => $pay_description
                                           );
         // prepare individual items


        if ($is_upgrade==1){
                $payment['transactions'][0]['item_list']['items'][] = array(
                                                'quantity' => '1',
                                                'name' => esc_html__('Upgrade to Featured Listing','wpresidence'),
                                                'price' => $total_price,
                                                'currency' => $submission_curency_status,
                                                'sku' => 'Upgrade Featured Listing',
                                                );
        }else{
               if( $is_featured==0 ){
                    $payment['transactions'][0]['item_list']['items'][] = array(
                                                         'quantity' => '1',
                                                         'name' => esc_html__('Listing Payment','wpresidence'),
                                                         'price' => $total_price,
                                                         'currency' => $submission_curency_status,
                                                         'sku' => 'Paid Listing',

                                                        );
                  }
                  else{
                      $payment['transactions'][0]['item_list']['items'][] = array(
                                                         'quantity' => '1',
                                                         'name' => esc_html__('Listing Payment with Featured option','wpresidence'),
                                                         'price' => $total_price,
                                                         'currency' => $submission_curency_status,
                                                         'sku' => 'Featured Paid Listing',
                                                         );

                  } // end is featured
        } // end is upgrade




        $json       =   json_encode($payment);
        $json_resp  =   wpestate_make_post_call($url, $json,$token);
        foreach ($json_resp['links'] as $link) {
                if($link['rel'] == 'execute'){
                    $payment_execute_url    = $link['href'];
                    $payment_execute_method = $link['method'];
                } else if($link['rel'] == 'approval_url'){
                    $payment_approval_url       = $link['href'];
                    $payment_approval_method    = $link['method'];
                }
        }





        $executor['paypal_execute']     =   $payment_execute_url;
        $executor['paypal_token']       =   $token;
        $executor['listing_id']         =   $prop_id;
        $executor['is_featured']        =   $is_featured;
        $executor['is_upgrade']         =   $is_upgrade;
        $save_data[$current_user->ID]   =   $executor;
        update_option('paypal_transfer',$save_data);

        print trim($payment_approval_url);

        die();
    }
endif; // end   wpestate_ajax_listing_pay 
  
  
  
////////////////////////////////////////////////////////////////////////////////
/// pay via paypal - per listing
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_resend_for_approval', 'wpestate_ajax_resend_for_approval' );  
if( !function_exists('wpestate_ajax_resend_for_approval') ):

    function wpestate_ajax_resend_for_approval(){ 
        check_ajax_referer( 'wpestate_property_actions', 'security' );
        $current_user   =   wp_get_current_user();
        $prop_id        =   intval($_POST['propid']);
        $userID         =   $current_user->ID;
        $post           =   get_post($prop_id); 

        if ( !is_user_logged_in() ) {   
            exit('ko');
        }

        if($userID === 0 ){
            exit('out pls');
        }
        
        
        $accont_owner       = $userID;
        $agent_id           = get_user_meta($userID,'user_agent_id',true);
       
        
        $owner_author_id    = intval(get_post_field( 'post_author', $agent_id)  );
        
        
        if($owner_author_id!=0 && $owner_author_id!=1){
            $accont_owner=$owner_author_id;
        }
      
        $agent_list                     =   (array)get_user_meta($accont_owner,'current_agent_list',true);
      
        
        if( $post->post_author != $userID ){
            if(!in_array($post->post_author , $agent_list)){
                exit('get out of my cloud');
            }
        }

 
        
        
        $free_list  =   get_user_meta($accont_owner, 'package_listings',true);

        if( $free_list>0 ||  $free_list==-1 ){

            $paid_submission_status     =   esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
            $new_status                 =   'pending';
            $admin_submission_status    =   esc_html ( wpresidence_get_option('wp_estate_admin_submission','') );
            if($admin_submission_status=='no' && $paid_submission_status!='per listing'){
                $new_status='publish';  
            }

            $prop = array(
                'ID'            => $prop_id,
                'post_type'     => 'estate_property',
                'post_status'   =>  $new_status
            );
            
            wp_update_post($prop );
            update_post_meta($prop_id, 'prop_featured', 0); 

            if($free_list!=-1){ // if !unlimited
                update_user_meta($accont_owner, 'package_listings',$free_list-1);
            }
            print esc_html__('Sent for approval','wpresidence');
            $submit_title   =   get_the_title($prop_id);
            $arguments=array(
                'submission_title'        =>    $submit_title,
                'submission_url'          =>    esc_url (get_permalink($prop_id))
            );

            wpestate_select_email_type(wpresidence_get_option('admin_email'),'admin_expired_listing',$arguments);



        }else{
            print esc_html__('no listings available','wpresidence');
        }
        die();
     
  
     
   }
  
 endif; // end   wpestate_ajax_resend_for_approval 
 
 
 
 

if( !function_exists('wpestate_insert_calendar') ):
    function wpestate_insert_calendar($agent_id,$name,$email,$phone,$schedule_day,$schedule_hour){
        $calendar=get_post_meta($agent_id,'agent_calendar',true);

        if(!is_array($calendar)){
            $calendar=array();
        }
        $temp_array = array();
        $temp_array['status']=0;
        $temp_array['name']=$name;
        $temp_array['email']=$email;
        $temp_array['phone']=$phone;
        $date= strtotime ($schedule_day.' '.$schedule_hour);

        if( isset( $calendar[$date]) && $calendar[$date]!='' ){
            $response =$schedule_day.$schedule_hour. esc_html__('The date & time is already booked. Please choose a new one','wpresidence');
            $response.=implode('|',$calendar);
            echo json_encode(array('sent'=>true, 'response'=>$response ) ); 
            die();
        }else{
            $calendar[$date] = $temp_array;
            update_post_meta($agent_id,'agent_calendar',$calendar);
        }
    }
         
endif;






////////////////////////////////////////////////////////////////////////////////
/// Ajax  Package Paypal function
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_paypal_pack_generation', 'wpestate_ajax_paypal_pack_generation' );  

if( !function_exists('wpestate_ajax_paypal_pack_generation') ):

function wpestate_ajax_paypal_pack_generation(){
    check_ajax_referer( 'wpestate_payments_nonce', 'security' );
    $current_user   =   wp_get_current_user();
    $userID         =   $current_user->ID;
    
    if ( !is_user_logged_in() ) {   
        exit('ko');
    }
    
    if($userID === 0 ){
        exit('out pls');
    }
    
    $allowed_html   =   array();
    $packName       =   esc_html(wp_kses($_POST['packName'],$allowed_html));
    $pack_id        =   intval($_POST['packId']);
    $is_pack        =   get_posts('post_type=membership_package&p='.$pack_id);
    
    
    if( !empty ( $is_pack ) ) {
            
            $pack_price                     =   get_post_meta($pack_id, 'pack_price', true);
            $submission_curency_status      =   esc_html( wpresidence_get_option('wp_estate_submission_curency','') );
            $paypal_status                  =   esc_html( wpresidence_get_option('wp_estate_paypal_api','') );
          
            $host                           =   'https://api.sandbox.paypal.com';
            if($paypal_status=='live'){
                $host   =   'https://api.paypal.com';
            }
            
            $url        = $host.'/v1/oauth2/token'; 
            $postArgs   = 'grant_type=client_credentials';
            $token='';
            if(function_exists('wpestate_get_access_token')){
                $token      = wpestate_get_access_token($url,$postArgs);
            }
          
            $url        = $host.'/v1/payments/payment';
            

           $dash_profile_link = wpestate_get_template_link('user_dashboard_profile.php');


            $payment = array(
                            'intent' => 'sale',
                            "redirect_urls"=>array(
                                "return_url"=>$dash_profile_link,
                                "cancel_url"=>$dash_profile_link
                                ),
                            'payer' => array("payment_method"=>"paypal"),

                );

            
                    $payment['transactions'][0] = array(
                                        'amount' => array(
                                            'total' => $pack_price,
                                            'currency' => $submission_curency_status,
                                            'details' => array(
                                                'subtotal' => $pack_price,
                                                'tax' => '0.00',
                                                'shipping' => '0.00'
                                                )
                                            ),
                                        'description' => $packName.' '.esc_html__('membership payment on ','wpresidence').esc_url( home_url('/') )
                                       );

                    //
                    // prepare individual items
                    $payment['transactions'][0]['item_list']['items'][] = array(
                                                            'quantity' => '1',
                                                            'name' => esc_html__('Membership Payment','wpresidence'),
                                                            'price' => $pack_price,
                                                            'currency' => $submission_curency_status,
                                                            'sku' => $packName.' '.esc_html__('Membership Payment','wpresidence'),
                                                           );
                   
                    
                    $json = json_encode($payment);
                    $json_resp = wpestate_make_post_call($url, $json,$token);
              
                
                    foreach ($json_resp['links'] as $link) {
                            if($link['rel'] == 'execute'){
                                    $payment_execute_url = $link['href'];
                                    $payment_execute_method = $link['method'];
                            } else  if($link['rel'] == 'approval_url'){
                                        $payment_approval_url = $link['href'];
                                        $payment_approval_method = $link['method'];
                            }
                    }



                    $executor['paypal_execute']     =   $payment_execute_url;
                    $executor['paypal_token']       =   $token;
                    $executor['pack_id']            =   $pack_id;
                    $save_data[$current_user->ID ]  =   $executor;
                    update_option('paypal_pack_transfer',$save_data);
                    print trim($payment_approval_url);
       }
//       /die();
}

endif; // end   ajax_paypal_pack_generation  - de la ajax_upload






// front submit check login/pass
add_action( 'wp_ajax_nopriv_wpestate_front_property_submit', 'wpestate_wpestate_front_property_submit' );  
add_action( 'wp_ajax_wpestate_front_property_submit', 'wpestate_wpestate_front_property_submit' );

if( !function_exists('wpestate_wpestate_front_property_submit') ):
    function wpestate_wpestate_front_property_submit(){
		
 
        $action_type               =   sanitize_text_field($_POST['action_type']);
        $front_user_login                =   sanitize_text_field($_POST['front_user_login']);
        $front_user_name             =   sanitize_text_field($_POST['front_user_name']);
        $front_user_pass               =   sanitize_text_field($_POST['front_user_pass']);
        $front_user_email             =   sanitize_text_field($_POST['front_user_email']);
     
	 
		if( $action_type == 'login' ){
			$user = get_user_by( 'login', $front_user_login );
			if ( $user && wp_check_password( $front_user_pass, $user->data->user_pass, $user->ID) ){
				
				//wp_clear_auth_cookie();
				wp_set_current_user ( $user->ID );
				wp_set_auth_cookie  ( $user->ID );
				
				echo json_encode( array( 'result' => 'success', 'redirect' => wpestate_get_template_link( 'front_property_submit.php' ) ) );
			}else{
				echo json_encode( array( 'result' => 'error', 'message' => esc_html__('Unable to login. Please, check login/password and try again', 'wpresidence') ) );
			}
		}
		if( $action_type == 'register' ){
 
			$user_id = username_exists( $front_user_name );
			
			if( !is_email($front_user_email) ){
				echo json_encode( array( 'result' => 'error', 'message' => esc_html__('Please, enter correct email', 'wpresidence') ) );
				die();
			}
			
			
			if ( !$user_id and email_exists($front_user_email) == false ) {
				$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
				$user_id = wp_create_user( $front_user_name, $random_password, $front_user_email );
				if( $user_id ){
					//wp_clear_auth_cookie();
					wp_set_current_user ( $user_id );
					wp_set_auth_cookie  ( $user_id );
					echo json_encode( array( 'result' => 'success', 'redirect' => wpestate_get_template_link( 'front_property_submit.php' ) ) );
				}else{
					echo json_encode( array( 'result' => 'error', 'message' => esc_html__('Can\t create user with this credentials', 'wpresidence') ) );
				}
				
			} else {
				echo json_encode( array( 'result' => 'error', 'message' => esc_html__('Sorry, user already exists. Try different username/email', 'wpresidence') ) );
			}
			
			
		}
		die();
    }
endif;



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Package Paypal function - recuring payments REST API
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_wpestate_ajax_paypal_pack_recuring_generation_rest_api', 'wpestate_ajax_paypal_pack_recuring_generation_rest_api' );  
   
if( !function_exists('wpestate_ajax_paypal_pack_recuring_generation_rest_api') ):

    function wpestate_ajax_paypal_pack_recuring_generation_rest_api(){
        check_ajax_referer( 'wpestate_payments_nonce', 'security' );
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }

        $allowed_html   =   array();
        $packName       =   wp_kses($_POST['packName'],$allowed_html);
        $pack_id        =   intval($_POST['packId']);
        if(!is_numeric($pack_id)){
            exit();
        }

        
        $is_pack = get_posts('post_type=membership_package&p='.$pack_id);
        if( !empty ( $is_pack ) ) {
            $pack_price                     =   get_post_meta($pack_id, 'pack_price', true);
            $billing_period                 =   get_post_meta($pack_id, 'biling_period', true);
            $billing_freq                   =   intval(get_post_meta($pack_id, 'billing_freq', true));
            $pack_name                      =   get_the_title($pack_id);
            $submission_curency_status      =   esc_html( wpresidence_get_option('wp_estate_submission_curency','') );
            
            $host                           =   'https://api.sandbox.paypal.com';
            $paypal_status                  =   esc_html( wpresidence_get_option('wp_estate_paypal_api','') );
            if($paypal_status=='live'){
                $host   =   'https://api.paypal.com';
            }
            $url        = $host.'/v1/oauth2/token'; 
            $postArgs   = 'grant_type=client_credentials';
          
            $token='';
            if(function_exists('wpestate_get_access_token')){
                $token      = wpestate_get_access_token($url,$postArgs);
            }
          
            $payment_plan = get_post_meta($pack_id, 'paypal_payment_plan_'.$paypal_status, true);
    
          
            if( !is_array($payment_plan)|| $payment_plan['id']=='' || $payment_plan==''){
                wpestate_create_paypal_payment_plan($pack_id,$token);
                $payment_plan = get_post_meta($pack_id, 'paypal_payment_plan_'.$paypal_status, true);
            }

            $url        = $host.'/v1/payments/billing-plans/'.$payment_plan['id'];
    
            $json_resp  = wpestate_make_get_call($url,$token);
       
                 
            
            if( $json_resp['state']!='ACTIVE' ){
                wpestate_activate_paypal_payment_plan( $json_resp['id'],$token);
            }
            
            echo wpestate_create_paypal_payment_agreement($pack_id,$token);
            die();
             

        }
    }

    
endif;



?>
