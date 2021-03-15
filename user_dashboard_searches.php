<?php
// Template Name: User Dashboard  Saved Searches
// Wp Estate Pack
wpestate_dashboard_header_permissions();

$current_user                   =   wp_get_current_user();  
$paid_submission_status         =   esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( wpresidence_get_option('wp_estate_price_submission','') );
$submission_curency_status      =   esc_html( wpresidence_get_option('wp_estate_submission_curency','') );
$userID                         =   $current_user->ID;
$user_option                    =   'favorites'.$userID;
$curent_fav                     =   get_option($user_option);
$show_remove_fav                =   1;   
$show_compare                   =   1;
$show_compare_only              =   'no';
$wpestate_currency              =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency                 =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$custom_advanced_search         =   wpresidence_get_option('wp_estate_custom_advanced_search','');
$adv_search_what                =   wpresidence_get_option('wp_estate_adv_search_what','');
$adv_search_how                 =   wpresidence_get_option('wp_estate_adv_search_how','');
$adv_search_label               =   wpresidence_get_option('wp_estate_adv_search_label','');                    
$wpestate_options               =   wpestate_page_details($post->ID);

get_header();
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
 
            $args = array(
                'post_type'        => 'wpestate_search',
                'post_status'      =>  'any',
                'posts_per_page'   => -1 ,
                'author'      => $userID
              
            );
     
      
            $prop_selection = new WP_Query($args);
            $counter = 0;
      
          
            if($prop_selection->have_posts()){ 
                print '<div id="listing_ajax_container">';
                while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                     include( locate_template('templates/search_unit.php'));
                endwhile;
                print '</div>';
            }else{
                print'<div class="col-md-12 row_dasboard-prop-listing">';
                print '<h4>'.esc_html__('You don\'t have any saved searches yet!','wpresidence').'</h4>';
                print'</div>';
            }
        ?>    
             
    </div>  
</div>   
<?php 
$ajax_nonce = wp_create_nonce( "wpestate_searches_actions" );
print ' <input type="hidden" id="wpestate_searches_actions" value="'.esc_html($ajax_nonce).'" />';
get_footer(); ?>