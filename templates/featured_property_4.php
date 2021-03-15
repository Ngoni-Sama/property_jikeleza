<?php


$return_string  =   '';    
$thumb_id       =   get_post_thumbnail_id($prop_id);
$preview        =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
if($preview[0]==''){
    $preview[0]= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
}
$link           =    esc_url( get_permalink() );
$title          =   get_the_title();
$price          =   floatval( get_post_meta($prop_id, 'property_price', true) );
$price_label    =   '<span class="price_label">'.esc_html ( get_post_meta($prop_id, 'property_label', true) ).'</span>';
$price_label_before    =   '<span class="price_label price_label_before">'.esc_html ( get_post_meta($prop_id, 'property_label_before', true) ).'</span>';
$wpestate_currency       =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$content        =   wpestate_strip_words( get_the_excerpt(),30).' ...';
$gmap_lat       =   esc_html( get_post_meta($prop_id, 'property_latitude', true));
$gmap_long      =   esc_html( get_post_meta($prop_id, 'property_longitude', true));
$featured           =   intval  ( get_post_meta($prop_id, 'prop_featured', true) );
$agent_id           =   intval  ( get_post_meta($prop_id, 'property_agent', true) );
$thumb_id           =   get_post_thumbnail_id($agent_id);
$agent_face         =   wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');
$property_bathrooms =   get_post_meta($prop_id, 'property_bathrooms', true);
$property_rooms     =   get_post_meta($prop_id, 'property_bedrooms', true);
$property_size      =   wpestate_get_converted_measure( $prop_id, 'property_size' ) ;
$measure_sys        =   esc_html(wpresidence_get_option('wp_estate_measure_sys', ''));

if ($agent_face[0]==''){
   $agent_face[0]= get_theme_file_uri('/img/default-user_1.png');
}


$agent_posit    =   esc_html( get_post_meta($agent_id, 'agent_position', true) );
$agent_permalink=   esc_url( get_permalink($agent_id) );
$agent_phone    =   esc_html( get_post_meta($agent_id, 'agent_phone', true) );
$agent_mobile   =   esc_html( get_post_meta($agent_id, 'agent_mobile', true) );
$agent_email    =   esc_html( get_post_meta($agent_id, 'agent_email', true) );

if ($price != 0) {
    $price = wpestate_show_price($prop_id,$wpestate_currency,$where_currency,1);  
}else{
    $price=$price_label_before.$price_label;
}

$current_user = wp_get_current_user();
$userID                     =   $current_user->ID;
$user_option                =   'favorites'.$userID;
$curent_fav                 =   get_option($user_option);
$favorite_class =   'icon-fav-off';
$fav_mes        =   esc_html__('add to favorites','wpresidence');
if($curent_fav){
    if ( in_array ($prop_id,$curent_fav) ){
    $favorite_class =   'icon-fav-on';   
    $fav_mes        =   esc_html__('remove from favorites','wpresidence');
    } 
}


$return_string.= '
    <div class="featured_property featured_property_type4">
            <div class="featured_img">';

                $return_string .= '<div class="tag-wrapper">';
                    if($featured==1){
                        $return_string .= '<div class="featured_div">'.esc_html__('Featured','wpresidence').'</div>';
                    }
                   $return_string .= wpestate_return_property_status($prop_id);
                    
                $return_string .= '</div>';
            
                if(  $wpestate_property_unit_slider==1){

                    $arguments      = array(
                          'numberposts' => -1,
                          'post_type' => 'attachment',
                          'post_mime_type' => 'image',
                          'post_parent' => $prop_id,
                          'post_status' => null,
                          'exclude' => get_post_thumbnail_id($prop_id),
                          'orderby' => 'menu_order',
                          'order' => 'ASC'
                      );
                    $post_attachments   = get_posts($arguments);

                    $slides='';

                    $no_slides = 0;
                    foreach ($post_attachments as $attachment) { 
                        $no_slides++;
                        $preview_att    =   wp_get_attachment_image_src($attachment->ID, 'property_listings');
                            if($preview_att[0]==''){
                                $preview_att[0]= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
                            }

                        $slides     .= '<div class="item" style="background-image:url('.esc_url($preview_att[0]).');"></div>';

                    }// end foreach

                    $return_string .=  '
                    <div id="property_unit_featured_carousel_'.esc_attr($prop_id).'" class="carousel slide  " data-ride="carousel" data-interval="false">
                        <div class="carousel-inner">         
                            <div class="item active" style="background-image:url('.esc_url($preview[0]).');"></div>
                            '.$slides.'
                        </div>
                        <a href="'.esc_url($link).'"> </a>';
                  
                        if( $no_slides >= 1){
                            $return_string .=  '<a class="left  carousel-control" href="#property_unit_featured_carousel_'.esc_attr($prop_id).'" data-slide="prev">
                                <i class="demo-icon icon-left-open-big"></i>
                            </a>

                            <a class="right  carousel-control" href="#property_unit_featured_carousel_'.esc_attr($prop_id).'" data-slide="next">
                                <i class="demo-icon icon-right-open-big"></i>
                            </a>';
                        }
                    $return_string .= '
                    </div>';
                }else{
                    $return_string .=  '<a href="'.esc_url($link).'"> <img src="'.esc_url($preview[0]).'" data-original="'.esc_url($preview[0]).'" class="lazyload img-responsive" alt="featured image"/></a>
                    <div class="listing-cover featured_cover" data-link="'.esc_url($link).'"></div>
                    <a href="'.esc_url($link).'"> <span class="listing-cover-plus">+</span></a>';
                }
            $return_string.= '</div>';
            $return_string.='';
            $return_string.= ' <div class="featured_secondline" data-link="'.esc_url($link).'">';
            
           

           
            $return_string .= '<h2><a href="'.esc_url($link).'">';
                $return_string .= mb_substr( $title,0,27); 
                if(mb_strlen($title)>27){
                    $return_string .= '...';   
                }
            $return_string.='</a></h2>';
            
            $return_string.='<div class="featured_prop_price">'.$price.' </div>';//escaped above
            
            $return_string.='<div class="listing_details the_grid_view">
                    '.wpestate_strip_excerpt_by_char(get_the_excerpt(),130,$prop_id).'</div>';
            
            
            
                    
            $return_string.='<div class="property_featured_details">';
                $return_string.='<a href="'.esc_url($link).'" class="unit_details_x">'.esc_html__('full info','wpresidence').'</a>';
                $return_string.='<a href="#" class="unit_map_featured">'._('map','wpresidence').'</a>';
            $return_string.='</div>';
            
           
                
           $return_string.='<div class="property_listing_details">';
        
           $return_string.='
                <div class="listing_actions">
                '.wpestate_share_unit_desing($prop_id).'
                <span class="share_list"  data-original-title="'.esc_attr__('share','wpresidence').'" ></span>
                <span class="icon-fav '.esc_html($favorite_class).'" data-original-title="'.esc_attr($fav_mes).'" data-postid="'.intval($prop_id).'"></span>     
            </div>';
   
                if($property_rooms!=''){
                    $return_string.='<span class="inforoom">'.esc_html($property_rooms).'</span>';
                }

                if($property_bathrooms!=''){
                    $return_string.='<span class="infobath">'.esc_html($property_bathrooms).'</span>';
                }

                if($property_size!=''){
                    $return_string.='<span class="infosize">'.trim($property_size).'</span>';//esca[ed above
                }
            $return_string.='</div>'; 
        $return_string.='</div>';
        $return_string .='
    </div>';

print trim($return_string);