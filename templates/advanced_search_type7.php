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
$adv6_max_price         =   wpresidence_get_option('wp_estate_adv6_max_price');     
$adv6_min_price         =   wpresidence_get_option('wp_estate_adv6_min_price');     
?>

<div class="adv-search-1 <?php echo esc_attr($close_class.' '.$extended_class);?>" id="adv-search-7" > 

        <?php
        if (function_exists('icl_translate') ){
            print do_action( 'wpml_add_language_form_field' );
        }
        ?>   
        
        
        <div class="adv7-holder">
            <?php
            $custom_advanced_search         =   wpresidence_get_option('wp_estate_custom_advanced_search','');
            $adv_search_fields_no_per_row   =   ( floatval( wpresidence_get_option('wp_estate_search_fields_no_per_row') ) );
            if ( $custom_advanced_search == 'yes'){
                
                  
                    print '<div role="tabpanel" class="adv_search_tab '.wpestate_search_tab_align().' " id="tab_prpg_adv6">';
                    
                        $tab_items      =   '';
                        $tab_content    =   '';
                        $active         =   'active';
                        if(isset($_GET['adv6_search_tab']) && $_GET['adv6_search_tab']!=''){
                            $active         =   '';
                        }
                        
                        foreach ($adv6_taxonomy_terms as $term_id){
                            $term               =   get_term( $term_id, $adv6_taxonomy);
                            $use_name           =   sanitize_title($term->name);
                            $use_title_name     =   $term->name;
                            
                            
                            if(isset($_GET['adv6_search_tab']) && $_GET['adv6_search_tab']==$use_name){
                                $active         =   'active';
                            }
                                
                            $tab_items.= '<div class="adv_search_tab_item '.esc_attr($active).' '.esc_attr($use_name).'" data-term="'.esc_attr($use_name).'" data-termid="'.esc_attr($term_id).'" data-tax="'.esc_attr($adv6_taxonomy).'">
                            <a href="#'.urldecode($use_name).'" aria-controls="'.urldecode($use_name).'" role="tab" class="adv6_tab_head" data-toggle="tab">'.urldecode (str_replace("-"," ",$use_title_name)).'</a>
                            </div>';
                            
                          
                            $tab_content.='  
                            <div role="tabpanel" class="tab-pane '.esc_attr($active).'" id="'.urldecode($use_name).'">
                                <form  role="search" method="get" action="'.esc_url($adv_submit).'" >';
                                    
                                    if($adv6_taxonomy=='property_category'){
                                        $tab_content.='<input type="hidden" name="filter_search_type[]" value="'.esc_attr($use_name).'" >';
                                    }else if($adv6_taxonomy=='property_action_category'){
                                        $tab_content.='<input type="hidden" name="filter_search_action[]" value="'.esc_attr($use_name).'" >';
                                    }else if($adv6_taxonomy=='property_city'){
                                        $tab_content.='<input type="hidden" name="advanced_city" value="'.esc_attr($use_name).'" >';
                                    }else if($adv6_taxonomy=='property_area'){
                                        $tab_content.='<input type="hidden" name="advanced_area" value="'.esc_attr($use_name).'" >';
                                    }else if($adv6_taxonomy=='property_county_state'){
                                        $tab_content.='<input type="hidden" name="advanced_contystate" value="'.esc_attr($use_name).'" >';
                                    }
                                    
                            
                                    $tab_content.='<input type="hidden" name="adv6_search_tab" value="'.esc_attr($use_name).'">
                                    <input type="hidden" name="term_id" class="term_id_class"  value="'.esc_attr($term_id).'">
                                    '.wpestate_show_adv6_form($adv_search_what,$adv_search_fields_no_per_row,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$select_county_state_list,$use_name,$term_id);
                                    if($extended_search=='yes'){
                                        ob_start();
                                        show_extended_search('adv');
                                        $tab_content.=ob_get_contents();
                                        ob_end_clean();
                                    }    
                                $tab_content.='</form>        
                            </div>  ';
                            $active='';
                        }
                      
                
                    print '<div class="nav nav-tabs" role="tablist">'.$tab_items.'</div>';    //escaped above
                    print '<div class="tab-content">'.$tab_content.'</div>';//escaped above       
                    print'</div>';
          
            }else{
                // classinc
                print wpestate_show_search_field_classic_form('main',$action_select_list,$categ_select_list ,$select_city_list,$select_area_list);
                print '<div class="col-md-3">';
                print '<input name="submit" type="submit" class="wpresidence_button advanced_submit_4"  value="'.esc_html__('Search Properties','wpresidence').'">';
                print '</div>';
            }
        
            ?>
        </div>

        <?php include( locate_template('templates/preview_template.php') ); ?>
       <div style="clear:both;"></div>
</div>  


<?php

function wpestate_show_adv6_form($adv_search_what,$adv_search_fields_no_per_row,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$select_county_state_list,$use_name,$term_id){
    // form creation     
    $return_string='';
    ob_start();
    foreach($adv_search_what as $key=>$search_field){
        $search_col=3;
        if($adv_search_fields_no_per_row==2){
            $search_col=6;
        }else  if($adv_search_fields_no_per_row==3){
            $search_col=4;
        }

        $search_col_submit = $search_col;
        if($search_field=='property price' &&  wpresidence_get_option('wp_estate_show_slider_price','')=='yes'){
            $search_col=$search_col*2;
        }

        print '<div class="col-md-'.esc_attr($search_col).' '.str_replace(" ","_",$search_field).'">';
        wpestate_show_search_field_with_tabs('mainform',$search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key,$select_county_state_list,$use_name,$term_id);
        print '</div>';
        }


    print '<div class="col-md-'.esc_attr($search_col_submit).'">';
    print '<input name="submit" type="submit" class="wpresidence_button advanced_submit_4"  value="'.esc_html__('Search Properties','wpresidence').'">';
    print '</div>';
    
    $return_string=  ob_get_contents();
    ob_end_clean();
    
    return $return_string;
    // end form creation                    
}

?>