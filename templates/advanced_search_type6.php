<?php 
global $post;
global $adv_search_type;
$adv_search_what            =   wpresidence_get_option('wp_estate_adv_search_what','');
$show_adv_search_visible    =   wpresidence_get_option('wp_estate_show_adv_search_visible','');
$close_class                =   '';

if($show_adv_search_visible=='no'){
    $close_class='adv-search-1-close';
}

$extended_search    =   wpresidence_get_option('wp_estate_show_adv_search_extended','');
$extended_class     =   '';

if ($adv_search_type==2){
     $extended_class='adv_extended_class2';
}

if ( $extended_search =='yes' ){
    $extended_class='adv_extended_class';
    if($show_adv_search_visible=='no'){
        $close_class='adv-search-1-close-extended';
    }
       
}
$adv6_taxonomy          =   wpresidence_get_option('wp_estate_adv6_taxonomy');
$adv6_taxonomy_terms    =   wpresidence_get_option('wp_estate_adv6_taxonomy_terms');     


?>
<div class="adv-search-1 <?php echo esc_attr($close_class.' '.$extended_class);?>" id="adv-search-6" > 
        <?php
        if (function_exists('icl_translate') ){
            print do_action( 'wpml_add_language_form_field' );
        }
        ?>   
                
        <div class="adv6-holder">
            <?php
            $custom_advanced_search         =   wpresidence_get_option('wp_estate_custom_advanced_search','');
            $adv_search_fields_no_per_row   =   ( floatval( wpresidence_get_option('wp_estate_search_fields_no_per_row') ) );
           
            print  wpestate_show_advanced_search_tabs($adv_submit,'mainform');
            ?>
        </div>
        <?php include( locate_template('templates/preview_template.php') ); ?>
       <div style="clear:both;"></div>
</div>