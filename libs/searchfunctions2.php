<?php
if( !function_exists('wpestate_price_form_adv_search_with_tabs') ): 
    function wpestate_price_form_adv_search_with_tabs($position,$slug,$label,$use_name,$term_id,$adv6_taxonomy_terms,$adv6_min_price,$adv6_max_price){
        $show_slider_price            =   wpresidence_get_option('wp_estate_show_slider_price','');
        
        
        $price_key=array_search($term_id,$adv6_taxonomy_terms);
            $slider_id      =   'slider_price_'.$term_id.'_'.$position;
            $price_low_id   =   'price_low_'.$term_id;
            $price_max_id   =   'price_max_'.$term_id;
            $ammount_id     =   'amount_'.$term_id.'_'.$position;
            
            
//        if($position=='mainform'){
//            $slider_id      =   'slider_price_'.$term_id;
//            $price_low_id   =   'price_low_'.$term_id;
//            $price_max_id   =   'price_max_'.$term_id;
//            $ammount_id     =   'amount_'.$term_id;
//            
//        }else if($position=='sidebar') {
//            $slider_id      =   'slider_price_widget';
//            $price_low_id   =   'price_low_widget';
//            $price_max_id   =   'price_max_widget';
//            $ammount_id     =   'amount_wd';
//            
//        }else if($position=='shortcode') {
//            $slider_id      =   'slider_price_sh';
//            $price_low_id   =   'price_low_sh';
//            $price_max_id   =   'price_max_sh';
//            $ammount_id     =   'amount_sh';
//            
//        }else if($position=='mobile') {
//            $slider_id      =   'slider_price_mobile';
//            $price_low_id   =   'price_low_mobile';
//            $price_max_id   =   'price_max_mobile';
//            $ammount_id     =   'amount_mobile';
//           
//        }else if($position=='half') {
//            $slider_id='slider_price';
//            $price_low_id   =   'price_low';
//            $price_max_id   =   'price_max';
//            $ammount_id     =   'amount';
//            
//        }
        
        $search_term_id=0;
        if(isset($_GET['term_id'])){
            $search_term_id=intval($_GET['term_id']);
        }
        
        
        if ($show_slider_price==='yes'){
                $min_price_slider=  floatval($adv6_min_price[$price_key] );
                $max_price_slider=  floatval($adv6_max_price[$price_key] );

                if(isset($_GET['price_low_'.$search_term_id]) && $search_term_id==$term_id ){
                    $min_price_slider=  floatval($_GET['price_low_'.$search_term_id]) ;
                }

                if(isset($_GET['price_low_'.$search_term_id]) && $search_term_id==$term_id ){
                    $max_price_slider=  floatval($_GET['price_max_'.$search_term_id]) ;
                }

                $where_currency         =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
                $wpestate_currency               =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );

                $price_slider_label = wpestate_show_price_label_slider($min_price_slider,$max_price_slider,$wpestate_currency,$where_currency);
                
               
                
                $return_string='';
//                if($position=='half'){
//                    $return_string.='<div class="col-md-6 adv_search_slider">';
//                }else{
                    $return_string.='<div class="adv_search_slider">';
               // }
                
                $return_string.=' 
                    <p>
                        <label for="amount">'. esc_html__('Price range:','wpresidence').'</label>
                        <span id="'.$ammount_id.'"  class="wpresidence_slider_price" >'.$price_slider_label.'</span>
                    </p>
                    <div id="'.$slider_id.'"></div>';
                $custom_fields = wpresidence_get_option( 'wp_estate_multi_curr', '');
                if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                    $i=intval($_COOKIE['my_custom_curr_pos']);

                    if( !isset($_GET['price_low_'.$search_term_id]) && !isset($_GET['price_max_'.$search_term_id])  ){
                        $min_price_slider       =   $min_price_slider * $custom_fields[$i][2];
                        $max_price_slider       =   $max_price_slider * $custom_fields[$i][2];
                    }
                }
                
                $return_string.='
                    <input type="hidden" id="'.$price_low_id.'" class="adv6_price_low price_active" name="'.$price_low_id.'"  value="'.$min_price_slider.'"/>
                    <input type="hidden" id="'.$price_max_id.'" class="adv6_price_max price_active" name="'.$price_max_id.'"  value="'.$max_price_slider.'"/>
                </div>';
                
                
        }else{
            $return_string='';
            if($position=='half'){
                //$return_string.='<div class="col-md-3">';
            }
                
            $return_string.='<input type="text" id="'.$slug.'"  name="'.$slug.'" placeholder="'.$label.'" value="';
            if (isset($_GET[$slug])) {
                $allowed_html = array();
                $return_string.= esc_attr ( $_GET[$slug] );
            }
            $return_string.='" class="advanced_select form-control" />';
            
            if($position=='half'){
              //  $return_string.='</div>';
            }
        }
        return $return_string;
}
endif;


function wpestate_show_adv6_form($active,$position,$adv_search_what,$adv_search_fields_no_per_row,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$select_county_state_list,$use_name,$term_id,$adv_search_fields_no,$term_counter){

    $return_string='';
    ob_start();
    $adv_search_what= array_slice($adv_search_what, ($term_counter*$adv_search_fields_no),$adv_search_fields_no);
    $force_location        =   wpresidence_get_option('wp_estate_force_location_only','');
    
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

            
        
        if(is_front_page() && $force_location=='yes' && $search_field!=='wpestate location'){
           continue;
        }
        
        
        print '<div class="col-md-'.esc_attr($search_col).' '.str_replace(" ","_",$search_field).'">';
        wpestate_show_search_field_with_tabs($active,$position,$search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key,$select_county_state_list,$use_name,$term_id,$adv_search_fields_no,$term_counter);
        print '</div>';
        }


    print '<div class="col-md-'.esc_attr($search_col_submit).' submit_container_half ">';
    print '<input name="submit" type="submit" class="wpresidence_button advanced_submit_4"  value="'.esc_html__('Search Properties','wpresidence').'">';
    print '</div>';
    
    $return_string=  ob_get_contents();
    ob_end_clean();
    
    return $return_string;
    // end form creation                    
}
