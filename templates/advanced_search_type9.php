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
$allowed_html=array();

?>
<div class="adv-search-1 <?php echo esc_attr($close_class.' '.$extended_class);?>" id="adv-search-9" > 

        <?php
        if (function_exists('icl_translate') ){
            print do_action( 'wpml_add_language_form_field' );
        }
        ?>   
        
        
        <div class="adv9-holder">
            <?php
            $custom_advanced_search         =   wpresidence_get_option('wp_estate_custom_advanced_search','');
            $adv_search_fields_no_per_row   =   ( floatval( wpresidence_get_option('wp_estate_search_fields_no_per_row') ) );
           
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
                                        $tab_content.='<input type="hidden" class="picked_tax" name="filter_search_type[]" value="'.esc_attr($use_name).'" >';
                                    }else if($adv6_taxonomy=='property_action_category'){
                                        $tab_content.='<input type="hidden" class="picked_tax" name="filter_search_action[]" value="'.esc_attr($use_name).'" >';
                                    }else if($adv6_taxonomy=='property_city'){
                                        $tab_content.='<input type="hidden" class="picked_tax" name="advanced_city" value="'.esc_attr($use_name).'" >';
                                    }else if($adv6_taxonomy=='property_area'){
                                        $tab_content.='<input type="hidden" class="picked_tax" name="advanced_area" value="'.esc_attr($use_name).'" >';
                                    }else if($adv6_taxonomy=='property_county_state'){
                                        $tab_content.='<input type="hidden" class="picked_tax" name="advanced_contystate" value="'.esc_attr($use_name).'" >';
                                    }
                                    
                            
                                    $tab_content.='<input type="hidden" name="adv6_search_tab" value="'.esc_attr($use_name).'">
                                    <input type="hidden" name="term_id" value="'.esc_attr($term_id).'">'; 
                                    
  
                                    if (function_exists('icl_translate') ){
                                        $tab_content.= do_action( 'wpml_add_language_form_field' );
                                    }
                                   
                                    $tab_content.='
                                        <div class="col-md-6">
                                            <input type="text" id="adv_location" class="form-control adv_locations_search" name="adv_location"  placeholder="'. esc_html__('Search State, City or Area','wpresidence').'" value="">      
                                        </div>

                                        <div class="col-md-6 adv2_nopadding">';

                                            if($adv6_taxonomy!=='property_category'){

                                                $tab_content.='<div class="col-md-6">
                                                    <div class="dropdown form-control" >
                                                        <div data-toggle="dropdown" id="adv_categ" class="filter_menu_trigger" data-value="">';

                                                        if ( isset($_GET['filter_search_type'][0]) && trim($_GET['filter_search_type'][0])!='' && trim($_GET['filter_search_type'][0])!='all' ){
                                                            //$tab_content.= ucwords ( str_replace("-"," ",  esc_attr( wp_kses( rawurldecode   ( stripslashes( $_GET['filter_search_type'][0] ) ), $allowed_html) ) ) );
                                                            $full_name   =  get_term_by('slug', ( ( $_GET['filter_search_type'][0] ) ),'property_category');
                                                            $tab_content.=  $full_name->name;
                                                            
                                                        }else{
                                                            $tab_content.= esc_html__('Categories','wpresidence'); 
                                                        }   
                                                            
                                                        $tab_content.= '<span class="caret caret_filter"></span> </div>   

                                                        <input type="hidden" name="filter_search_type[]" value="';

                                                            if(isset($_GET['filter_search_type'][0])){
                                                                $tab_content.= ucwords ( str_replace("-"," ",  esc_attr( wp_kses($_GET['filter_search_type'][0], $allowed_html) ) ) );
                                                            } 

                                                        $tab_content.='    ">

                                                        <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ">
                                                            '.$categ_select_list.'
                                                        </ul>        
                                                    </div> 
                                                </div>';
                                            }

                                            if($adv6_taxonomy!=='property_action_category'){
                                                
                                                $tab_content.='<div class="col-md-6">
                                                    <div class="dropdown form-control" >
                                                        <div data-toggle="dropdown" id="adv_actions" class="filter_menu_trigger" data-value=""> ';
                                                        
                                                        if( isset($_GET['filter_search_action'][0])  && trim($_GET['filter_search_action'][0])!='' && trim($_GET['filter_search_action'][0])!='all' ){
                                                            //$tab_content.= ucwords ( str_replace("-"," ",esc_attr( wp_kses(   rawurldecode ( stripslashes(  $_GET['filter_search_action'][0]) ), $allowed_html) ) ) );
                                                            $full_name   =  get_term_by('slug', ( ( $_GET['filter_search_action'][0] ) ),'property_action_category');
                                                            $tab_content.=  $full_name->name;
                                                        }else{
                                                            $tab_content.= esc_html__('Types','wpresidence'); 
                                                        }
                                                           
                                                        $tab_content.='<span class="caret caret_filter"></span> </div>           

                                                        <input type="hidden" name="filter_search_action[]" value="';

                                                        if(isset($_GET['filter_search_action'][0])){
                                                            $tab_content.= ucwords ( str_replace("-"," ", esc_attr( wp_kses($_GET['filter_search_action'][0], $allowed_html) ) ) );
                                                        }
                                                           

                                                        $tab_content.='">
                                                        <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions">
                                                            '.$action_select_list.'
                                                        </ul>        
                                                    </div>
                                                </div>';   
                                            }
                                            
                                            $tab_content.='
                                            <input type="hidden" name="is2" value="1">

                                            <div class="col-md-6">
                                                <input name="submit" type="submit" class="wpresidence_button" id="advanced_submit_22" value="'.esc_html__('Search Properties','wpresidence').'">
                                            </div>
                                        </div>';

                                    if($extended_search=='yes'){
                                        ob_start();
                                        show_extended_search('adv');
                                        $tab_content.=ob_get_contents();
                                        ob_end_clean();
                                    }    
                                    
                                $tab_content.='<input type="hidden" name="adv6_search_tab" value="'.esc_html($use_name).'">
                                <input type="hidden" name="term_id" value="'.esc_html($term_id).'">';    
                                
                                $tab_content.='</form>        
                            </div>  ';
                            $active='';
                        }
                      
                
                    print '<div class="nav nav-tabs" role="tablist">'.$tab_items.'</div>';    //escaped above
                    print '<div class="tab-content">'.$tab_content.'</div>';//escaped above        
                    print'</div>';
            ?>
            <?php include( locate_template('templates/preview_template.php') ); ?>
        </div>

       <div style="clear:both;"></div>
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
//$availableTags is escaped above

 print '<script type="text/javascript">
                       //<![CDATA[
                       jQuery(document).ready(function(){
                            var availableTags = ['.$availableTags.'];
                            jQuery(".adv_locations_search").autocomplete({
                                source: availableTags,
                                change: function() {
                                    wpestate_show_pins();
                                }
                            });
                       });
                       //]]>
                       </script>';
 
?>