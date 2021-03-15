<?php 
global $post;
global $adv_search_type;
$adv_search_what            =   wpresidence_get_option('wp_estate_adv_search_what','');
$show_adv_search_visible    =   wpresidence_get_option('wp_estate_show_adv_search_visible','');
$close_class                =   '';

if($show_adv_search_visible=='no'){
    $close_class=' float_search_closed ';
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

?>

<div class="adv-search-1 " id="adv-search-1" > 
    <div id="adv-search-header-1"> <?php esc_html_e('Advanced Search','wpresidence');?></div>   
    <form role="search" method="get"  id="adv_search_form"  action="<?php print esc_url($adv_submit); ?>" >
        <?php
        if (function_exists('icl_translate') ){
            print do_action( 'wpml_add_language_form_field' );
        }
        ?>   
        
        
        <div class="adv1-holder">
            <?php
            $custom_advanced_search         =   wpresidence_get_option('wp_estate_custom_advanced_search','');
            $adv_search_fields_no_per_row   =   ( floatval( wpresidence_get_option('wp_estate_search_fields_no_per_row') ) );
            $force_location                 =   wpresidence_get_option('wp_estate_force_location_only','');
             
            if ( $custom_advanced_search == 'yes'){
                foreach($adv_search_what as $key=>$search_field){
                    $search_col         =   3;
                    $search_col_price   =   6;
                    if($adv_search_fields_no_per_row==2){
                        $search_col         =   6;
                        $search_col_price   =   12;
                    }else  if($adv_search_fields_no_per_row==3){
                        $search_col         =   4;
                        $search_col_price   =   8;
                    }
                    if($search_field=='property price' &&  wpresidence_get_option('wp_estate_show_slider_price','')=='yes'){
                        $search_col=$search_col_price;
                    }
                    
                    if(is_front_page() && $force_location=='yes' && $search_field!=='wpestate location'){
                        continue;
                    }
                    
                    print '<div class="col-md-'.esc_attr($search_col).' '.str_replace(" ","_",$search_field).'">';
                    wpestate_show_search_field('mainform',$search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key,$select_county_state_list);
                    print '</div>';
                    
                }
            }else{
                print wpestate_show_search_field_classic_form('main',$action_select_list,$categ_select_list ,$select_city_list,$select_area_list);
            }

            if($extended_search=='yes'){
               show_extended_search('adv');
            }
            ?>
        </div>
       
        <input name="submit" type="submit" class="wpresidence_button" id="advanced_submit_2" value="<?php esc_html_e('SEARCH PROPERTIES','wpresidence');?>">
       
         <?php include( locate_template('templates/preview_template.php') ); ?>
     

    </form>   
       <div style="clear:both;"></div>
   
</div>  