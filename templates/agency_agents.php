<?php
global $wpestate_options;
global $wpestate_property_unit_slider;
global $wpestate_no_listins_per_row;
global $wpestate_uset_unit;
global $wpestate_custom_unit_structure;
global $align_class;
global $wpestate_prop_unit;
$col_class=4;
if($wpestate_options['content_class']=='col-md-12'){
    $col_class=3;
}
$wpestate_no_listins_per_row         =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
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
$user_agency    =   get_post_meta($post->ID,'user_meda_id',true);

if($user_agency!=0){
   
    $args = array(
            'post_type'         =>  'estate_agent',
            'author'            =>  $user_agency,
            'posts_per_page'    =>  -1,
            'post_status'       => 'publish',

            );
    $prop_selection = new WP_Query($args);
    echo '<div class="mylistings agency_agents_wrapper">';
    if( !$prop_selection->have_posts() ){
        print '<h4 class="no_agents">'.esc_html__('We don\'t have any agents yet!','wpresidence').'</h4>';
    }else{
        echo '<h3 class="agent_listings_title">'.esc_html__('Our Agents','wpresidence').'</h3>';
        $per_row_class ='  ';
        while ($prop_selection->have_posts()): $prop_selection->the_post();       
            print '<div class="col-md-4 listing_wrapper '.esc_attr($per_row_class).'">';
                get_template_part('templates/agent_unit');
            print '</div>';  
        endwhile;
    }   
    echo '</div>';

    wp_reset_postdata();
    wp_reset_query();
    
}