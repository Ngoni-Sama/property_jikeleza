 <?php
$agents_secondary   =   get_post_meta($post->ID, 'property_agent_secondary', true);

if( is_array($agents_secondary) && !empty($agents_secondary) && $agents_secondary[0]!=''  ){
    $sticky_menu_array['property_other_agents']= esc_html__('Other Agents', 'wpresidence'); 
    echo'<div class="mylistings" id="property_other_agents"> 
    <h3 class="agent_listings_title_similar">'.esc_html__('Other Agents','wpresidence').'</h3>';

    $wpestate_no_listins_per_row       =   intval( wpresidence_get_option('wp_estate_agent_listings_per_row', '') );
    global $wpestate_options;
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

    
    $agents_sec_list = implode(',',$agents_secondary);
    $args = array(
        'post_type'         => 'estate_agent',
        'posts_per_page'    => -1 ,
        'post__in'         =>  $agents_secondary
        );

    
    $agent_selection = new WP_Query($args);
    $per_row_class='';
    $agent_listings_per_row = wpresidence_get_option('wp_estate_agent_listings_per_row');
    if( $agent_listings_per_row==4){
        $per_row_class =' agents_4per_row ';
    }
                            
    while ($agent_selection->have_posts()): $agent_selection->the_post();
    print '<div class="col-md-'.esc_attr($col_class.$per_row_class).' listing_wrapper">';
        get_template_part('templates/agent_unit'); 
        print '</div>';
    endwhile;

        
    echo'</div>';
    
    wp_reset_postdata();
    wp_reset_query();
}        
?>