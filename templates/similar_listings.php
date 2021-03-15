<?php
//related listings
global $wpestate_property_unit_slider;
global $wpestate_no_listins_per_row;
global $wpestate_uset_unit;
global $wpestate_custom_unit_structure;
global $wpestate_prop_unit;
global $post;

$not_in[]               =   $exclude=  $post->ID;    
$wpestate_custom_unit_structure  =   wpresidence_get_option('wpestate_property_unit_structure');
$wpestate_uset_unit     =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
$wpestate_no_listins_per_row     =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
$wpestate_property_unit_slider   =   wpresidence_get_option('wp_estate_prop_list_slider','');
$counter                =   0;
$post_category          =   get_the_terms($post->ID, 'property_category');
$post_action_category   =   get_the_terms($post->ID, 'property_action_category');
$post_city_category     =   get_the_terms($post->ID, 'property_city');
$similar_no             =   wpresidence_get_option('wp_estate_similar_prop_no');
$args                   =   '';
$items[]                =   '';
$items_actions[]        =   '';
$items_city[]           =   '';
$categ_array            =   '';
$action_array           =   '';
$city_array             =   '';
$not_in                 =   array();


////////////////////////////////////////////////////////////////////////////
/// compose taxomomy categ array
////////////////////////////////////////////////////////////////////////////

if ($post_category!=''):
    foreach ($post_category as $item) {
        $items[] = $item->term_id;
    }
    $categ_array=array(
            'taxonomy' => 'property_category',
            'field' => 'id',
            'terms' => $items
        );
endif;

////////////////////////////////////////////////////////////////////////////
/// compose taxomomy action array
////////////////////////////////////////////////////////////////////////////

if ($post_action_category!=''):
    foreach ($post_action_category as $item) {
        $items_actions[] = $item->term_id;
    }
    $action_array=array(
            'taxonomy' => 'property_action_category',
            'field' => 'id',
            'terms' => $items_actions
        );
endif;

////////////////////////////////////////////////////////////////////////////
/// compose taxomomy action city
////////////////////////////////////////////////////////////////////////////

if ($post_city_category!=''):
    foreach ($post_city_category as $item) {
        $items_city[] = $item->term_id;
    }
    $city_array=array(
            'taxonomy' => 'property_city',
            'field' => 'id',
            'terms' => $items_city
        );
endif;

////////////////////////////////////////////////////////////////////////////
/// compose wp_query
////////////////////////////////////////////////////////////////////////////

$args=array(
    'showposts'             => $similar_no,      
    'ignore_sticky_posts'   => 0,
    'post_type'             => 'estate_property',
    'post_status'           => 'publish',
    'post__not_in'          => array($exclude),
    'tax_query'             => array(
    'relation'              => 'AND',
                               $categ_array,
                               $action_array,
                                $city_array
                               )
);



if( !empty($categ_array) || !empty($action_array)){

    $wpestate_prop_unit          =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
    $compare_submit     =   wpestate_get_template_link('compare_listings.php');
    $my_query           =   new WP_Query($args);

    $property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
    $property_card_type_string  =   '';
    if($property_card_type==0){
        $property_card_type_string='';
    }else{
        $property_card_type_string='_type'.$property_card_type;
    }

    if ($my_query->have_posts()) { ?>	

        <div class="mylistings" id="property_similar_listings"> 
            <h3 class="agent_listings_title_similar" ><?php esc_html_e('Similar Listings', 'wpresidence'); ?></h3>   
            <?php
            while ($my_query->have_posts()):$my_query->the_post();
                   include( locate_template('templates/property_unit'.$property_card_type_string.'.php') );
            endwhile;
            ?>
        </div>	
    <?php 
        $sticky_menu_array['property_similar_listings listings']= esc_html__('Similar Listings', 'wpresidence'); 
    } //endif have post
}//end if empty
?>


<?php
wp_reset_query();
?> 