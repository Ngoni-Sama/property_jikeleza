<?php 
global $post;
$show_adv_search_visible    =   wpresidence_get_option('wp_estate_show_adv_search_visible','');
$close_class                =   '';
if($show_adv_search_visible=='no'){
    $close_class='adv-search-1-close';
}
if(isset( $post->ID)){
    $post_id = $post->ID;
}else{
    $post_id = '';
}

?>
<div class="adv-search-1  adv-search-2 <?php echo esc_html($close_class);?>" id="adv-search-2" data-postid="<?php echo intval($post_id); ?>"> 
        <form role="search" method="get" class="visible-wrapper" id="adv_search_form"  action="<?php print esc_url($adv_submit); ?>" >
                <?php
                if (function_exists('icl_translate') ){
                    print do_action( 'wpml_add_language_form_field' );
                }
                ?> 
                
                <div class="col-md-4">
                    <input type="text" id="adv_location" class="form-control" name="adv_location"  placeholder="<?php esc_html_e('Search State, City or Area','wpresidence');?>" value="">      
                </div>

                <div class="col-md-8 adv2_nopadding">
                
                    <div class="col-md-4">
                        <div class="dropdown form-control" >
                            <div data-toggle="dropdown" id="adv_categ" class="filter_menu_trigger" data-value=""> 
                                <?php 
                                echo  esc_html__('Categories','wpresidence');
                                ?> 
                            <span class="caret caret_filter"></span> </div>   
                            <input type="hidden" name="filter_search_type[]" value="<?php if(isset($_GET['filter_search_type'][0])){echo esc_attr( wp_kses($_GET['filter_search_type'][0], $allowed_html) );}?>">
                            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ">
                                <?php print trim($categ_select_list);?>
                            </ul>        
                        </div> 
                    </div>    

                    <div class="col-md-4">
                        <div class="dropdown form-control" >
                            <div data-toggle="dropdown" id="adv_actions" class="filter_menu_trigger" data-value=""> 
                                <?php esc_html_e('Types','wpresidence');?> 
                                <span class="caret caret_filter"></span> </div>           

                            <input type="hidden" name="filter_search_action[]" value="<?php if(isset($_GET['filter_search_action'][0])){echo esc_attr( wp_kses($_GET['filter_search_action'][0], $allowed_html) );}?>">
                            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions">
                                <?php print trim($action_select_list);?>
                            </ul>        
                        </div>
                    </div>   

                    <input type="hidden" name="is2" value="1">
                    <div class="col-md-4">
                        <input name="submit" type="submit" class="wpresidence_button" id="advanced_submit_22" value="<?php esc_html_e('Search Properties','wpresidence');?>">
                    </div>
                </div>

              <?php include( locate_template('templates/preview_template.php') ); ?>
        </form> 
    
    
</div>  

<?php
$availableTags='';
$args = array(
    'orderby' => 'count',
    'hide_empty' => 0,
); 

$terms = get_terms( 'property_city', $args );
foreach ( $terms as $term ) {
   $availableTags.= '"'.esc_html($term->name).'",';
}

$terms = get_terms( 'property_area', $args );
foreach ( $terms as $term ) {
   $availableTags.= '"'.esc_html($term->name).'",';
}

$terms = get_terms( 'property_county_state', $args );
foreach ( $terms as $term ) {
   $availableTags.= '"'.esc_html($term->name).'",';
}
//$availableTags is escpaped above
 print '<script type="text/javascript">
        //<![CDATA[
        jQuery(document).ready(function(){
             var availableTags = ['.$availableTags.'];
             jQuery("#adv_location").autocomplete({
                 source: availableTags,
                 change: function() {
                     wpestate_show_pins();
                 }
             });
        });
        //]]>
        </script>';
 
?>