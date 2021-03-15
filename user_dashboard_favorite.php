<?php
// Template Name: User Dashboard Favorite
// Wp Estate Pack
wpestate_dashboard_header_permissions();

global $wpestate_no_listins_per_row;
global $wpestate_uset_unit;
global $wpestate_custom_unit_structure;
        
$wpestate_custom_unit_structure    =   wpresidence_get_option('wpestate_property_unit_structure');
$wpestate_uset_unit       =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
$wpestate_no_listins_per_row       =   4;



$current_user = wp_get_current_user();  
$paid_submission_status         =   esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( wpresidence_get_option('wp_estate_price_submission','') );
$submission_curency_status      =   esc_html( wpresidence_get_option('wp_estate_submission_curency','') );
$userID                         =   $current_user->ID;
$user_option                    =   'favorites'.$userID;
$curent_fav                     =   get_option($user_option);
$show_remove_fav                =   1;   
$show_compare                   =   1;
$show_compare_only              =   'no';
$wpestate_currency                       =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency                 =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );

get_header();
$wpestate_options=wpestate_page_details($post->ID);

$property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
$property_card_type_string  =   '';
if($property_card_type==0){
    $property_card_type_string='';
}else{
    $property_card_type_string='_type'.$property_card_type;
}

?> 


<div class="row row_user_dashboard">
    <?php  get_template_part('templates/dashboard-left-col');  ?>
    
    <div class="col-md-9 dashboard-margin">
        <?php   get_template_part('templates/breadcrumbs'); ?>
        <?php   get_template_part('templates/user_memebership_profile');  ?>
        <?php   get_template_part('templates/ajax_container'); ?>
        
        <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
            <h3 class="entry-title"><?php the_title(); ?></h3>
        <?php } ?>
         
        <?php
        if( !empty($curent_fav)){
             $args = array(
                 'post_type'        => 'estate_property',
                 'post_status'      => 'publish',
                 'posts_per_page'   => -1 ,
                 'post__in'         => $curent_fav 
             );


             $prop_selection = new WP_Query($args);
             $counter = 0;
             $wpestate_options['related_no']=4;
             print '<div id="listing_ajax_container">';
             print'<div class="col-md-12 user_profile_div"> ';
             while ($prop_selection->have_posts()): $prop_selection->the_post(); 
      
                    include( locate_template('templates/property_unit'.$property_card_type_string.'.php' ) );
         
             endwhile;
             print '</div>';
             print '</div>';
        }else{
            print'<div class="col-md-12 row_dasboard-prop-listing">';
            print '<h4>'.esc_html__('You don\'t have any favorite properties yet!','wpresidence').'</h4>';
            print'</div>';
        }

        ?>    
           
    </div>
</div>   
<?php get_footer(); ?>