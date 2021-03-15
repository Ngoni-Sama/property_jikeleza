<?php
$return_string  =   '';    
$thumb_id       =   get_post_thumbnail_id($prop_id);
$preview        =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
if($preview[0]==''){
    $preview[0]= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
}
$link           =   esc_url ( get_permalink() );
$title          =   get_the_title();
$price          =   floatval( get_post_meta($prop_id, 'property_price', true) );
$price_label    =   '<span class="price_label">'.esc_html ( get_post_meta($prop_id, 'property_label', true) ).'</span>';
$price_label_before    =   '<span class="price_label price_label_before">'.esc_html ( get_post_meta($prop_id, 'property_label_before', true) ).'</span>';
$wpestate_currency       =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$content        =   wpestate_strip_words( get_the_excerpt(),30).' ...';


$featured           =   intval  ( get_post_meta($prop_id, 'prop_featured', true) );

$property_bathrooms =   get_post_meta($prop_id, 'property_bathrooms', true);
$property_rooms     =   get_post_meta($prop_id, 'property_bedrooms', true);
$property_size      =   wpestate_get_converted_measure( $prop_id, 'property_size' ) ;
$measure_sys        =   esc_html(wpresidence_get_option('wp_estate_measure_sys', ''));

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


$realtor_details=wpestate_return_agent_details($prop_id);

$return_string.= '
    <div class="featured_property featured_property_type3">
            <div class="featured_img">';


                $return_string.='<a href="'.esc_url($realtor_details['link']).'" class="featured_property_type3_agent" style="background-image:url('.esc_url($realtor_details['realtor_image']).');" ></a>';

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
                    <div id="property_unit_featured_carousel_'.intval($prop_id).'" class="carousel slide  " data-ride="carousel" data-interval="false">
                        <div class="carousel-inner"> 
                            <div class="featured_gradient"></div>
                            <div class="item active" style="background-image:url('.esc_url($preview[0]).');"></div>
                            '.$slides.'
                        </div>
                        <a href="'.esc_url($link).'"> </a>';
                  
                        if( $no_slides >= 1){
                            $return_string .=  '<a class="left  carousel-control" href="#property_unit_featured_carousel_'.intval($prop_id).'" data-slide="prev">
                                <i class="demo-icon icon-left-open-big"></i>
                            </a>

                            <a class="right  carousel-control" href="#property_unit_featured_carousel_'.intval($prop_id).'" data-slide="next">
                                <i class="demo-icon icon-right-open-big"></i>
                            </a>';
                        }
                    $return_string .= '
                    </div>';
                }else{
                    $return_string .=  '<a href="'.esc_url($link).'"> <div class="featured_gradient"></div><div class="feat_img" style="background-image:url('.esc_url($preview[0]).');"></div></a>
                    <div class="listing-cover featured_cover" data-link="'.esc_url($link).'"></div>
                    <a href="'.esc_url($link).'"></a>';
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
                    '.wpestate_strip_excerpt_by_char(get_the_excerpt(),70,$prop_id).'</div>';
            
             $protocol = is_ssl() ? 'https' : 'http';   
            $return_string.='
            <div class="listing_actions">
                '.wpestate_share_unit_desing($prop_id).'
                <span class="share_list"  data-original-title="'.esc_attr__('share','wpresidence').'" ></span>
                <span class="icon-fav '.esc_html($favorite_class).'" data-original-title="'.esc_attr($fav_mes).'" data-postid="'.intval($prop_id).'"></span>

                
            </div>';
            
           $return_string.='<div class="property_listing_details">';
                    if($property_rooms!=''){
                        $return_string.='<span class="inforoom"> <svg viewBox="0 0 90 50" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16 18C16 13.6 19.6 10 24 10C28.4 10 32 13.6 32 18C32 22.4 28.4 26 24 26C19.6 26 16 22.4 16 18ZM88 30H12V2C12 0.9 11.1 0 10 0H2C0.9 0 0 0.9 0 2V50H12V42H78V50H80H82H86H88H90V32C90 30.9 89.1 30 88 30ZM74 12H38C36.9 12 36 12.9 36 14V26H88C88 18.3 81.7 12 74 12Z" fill="black"/>
</svg>'.esc_html($property_rooms).'</span>';
                    }

                    if($property_bathrooms!=''){
                        $return_string.='<span class="infobath"><svg  viewBox="0 0 56 59" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2 37C2.00973 43.673 5.92011 49.724 12 52.4742V58C12.0016 58.5516 12.4484 58.9984 13 59H15C15.5516 58.9984 15.9984 58.5516 16 58V53.7186C16.9897 53.9011 17.9936 53.9953 19 54H37C38.0064 53.9953 39.0103 53.9011 40 53.7186V58C40.0016 58.5516 40.4484 58.9984 41 59H43C43.5516 58.9984 43.9984 58.5516 44 58V52.4742C50.0799 49.724 53.9903 43.673 54 37V31H2V37Z" fill="black"/>
<path d="M55 27H1C0.447715 27 0 27.4477 0 28C0 28.5523 0.447715 29 1 29H55C55.5523 29 56 28.5523 56 28C56 27.4477 55.5523 27 55 27Z" fill="black"/>
<path d="M5 21H7V22C7 22.5523 7.44772 23 8 23C8.55228 23 9 22.5523 9 22V18C9 17.4477 8.55228 17 8 17C7.44772 17 7 17.4477 7 18V19H5V7C5 4.23858 7.23858 2 10 2C12.7614 2 15 4.23858 15 7V7.09021C12.116 7.57866 10.004 10.0749 10 13C10.0016 13.5516 10.4484 13.9984 11 14H21C21.5516 13.9984 21.9984 13.5516 22 13C21.996 10.0749 19.884 7.57866 17 7.09021V7C17 3.13401 13.866 0 10 0C6.13401 0 3 3.13401 3 7V25.5H5V21Z" fill="black"/>
</svg>'.esc_html($property_bathrooms).'</span>';
                    }

                    if($property_size!=''){
                        $return_string.='<span class="infosize"><svg  viewBox="0 0 42 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M41 0H13C12.45 0 12 0.45 12 1V10H1C0.45 10 0 10.45 0 11V31C0 31.55 0.45 32 1 32H29C29.55 32 30 31.55 30 31V22H41C41.55 22 42 21.55 42 21V1C42 0.45 41.55 0 41 0ZM28 30H2V12H28V30ZM40 20H30V11C30 10.45 29.55 10 29 10H14V2H40V20Z" fill="black"/>
</svg>'.($property_size).'</span>';//esca[ed above
                    }
         $return_string.='</div>';

            $return_string.='</div>';

        $return_string .='
    </div>';

print trim($return_string);