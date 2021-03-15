<?php
$enable_show_breadcrumbs           =    wpresidence_get_option('wp_estate_show_breadcrumbs');
if($enable_show_breadcrumbs=='yes'){
    if( isset($post->ID) ){
        $postid         =   $post->ID;
        $custom_image   =   esc_html( get_post_meta($post->ID ,'page_custom_image', true) );
        $rev_slider     =   esc_html( esc_html(get_post_meta($post->ID, 'rev_slider', true)) );
    }else{
        $postid         =   '';
        $custom_image   =   '';
        $rev_slider     =   '';
    }

    $category='';
    if(is_singular('estate_property')){
        $category       =   get_the_term_list($postid, 'property_category', '', ', ', '');
    }
    
    if ( $category == '' ){
        $category=get_the_category_list(', ',$postid);
    }

    print '<div class="col-xs-12 col-md-12 breadcrumb_container">';

    if( !is_404() && !is_front_page()  && !is_search()){
        print '<ol class="breadcrumb">
               <li><a href="'.esc_url(home_url('/')).'">'.esc_html__('Home','wpresidence').'</a></li>';
        if (is_archive()) {
            if( is_category() || is_tax() ){
                print '<li class="active">'. single_cat_title('', false).'</li>';
            }else{
                print '<li class="active">'.esc_html__('Archives','wpresidence').'</li>';
            }
        }else{
            if( $category!=''){
               print '<li>'.wp_kses_post($category).'</li>';
            }
            if(!is_front_page()){
                global $post;

                $parents    = get_post_ancestors( $post->ID );
                if($parents){

                    $id         = ($parents) ? $parents[count($parents)-1]: $post->ID;
                    $parent     = get_page( $id );
                    print '<li><a href="'.esc_url( get_permalink($parent)).'">'.get_the_title($parent).'</a></li>';
                }


               print '<li class="active">'.get_the_title($post->ID).'</li>';   
            }
        } 
        print '</ol>';
    }else{
          print '<div style="height:30px;"></div>';
    }
    print '</div>';

} else{
    $breabcrumb_dashboard= '';
    if(wpestate_is_user_dashboard()){  
       $breabcrumb_dashboard= 'breabcrumb_dashboard';
    }
    print '<div class="col-xs-12 col-md-12 breadcrumb_container '.esc_attr($breabcrumb_dashboard).'"></div>';
}
?>