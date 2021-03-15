<?php 
global $post;
global $adv_search_type;
$adv_search_what            =   wpresidence_get_option('wp_estate_adv_search_what','');
$show_adv_search_visible    =   wpresidence_get_option('wp_estate_show_adv_search_visible','');
$close_class                =   '';
 $allowed_html              =   array();
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
?>

<div class="adv-search-1 <?php echo esc_html($close_class.' '.$extended_class);?>" id="adv-search-1" > 
  
    <form role="search" method="get"   action="<?php print esc_url($adv_submit); ?>" >
        <?php
        if (function_exists('icl_translate') ){
            print do_action( 'wpml_add_language_form_field' );
        }
        ?>   
        
        <div class="col-md-8">
            <input type="text" id="adv_location" class="form-control" name="adv_location"  placeholder="<?php esc_html_e('Type address, state, city or area','wpresidence');?>" value="<?php
                    if(isset($_GET['adv_location'])){
                        echo esc_attr( wp_kses($_GET['adv_location'], $allowed_html) );
                    }
                ?>">      
        </div>
        
          
        <?php
        if(isset($_GET['filter_search_action'][0]) && $_GET['filter_search_action'][0]!='' && $_GET['filter_search_action'][0]!='all'){
            $full_name = get_term_by('slug', esc_html( wp_kses( $_GET['filter_search_action'][0],$allowed_html) ),'property_action_category');
            $adv_actions_value=$adv_actions_value1= $full_name->name;
            $adv_actions_value1 = mb_strtolower ( str_replace(' ', '-', $adv_actions_value1) );
        }else{
            $adv_actions_value=esc_html__('Types','wpresidence');
            $adv_actions_value1='all';
        }

        print'
        <div class="col-md-2">    
            <div class="dropdown form-control " >
                <div data-toggle="dropdown" id="adv_actions" class="filter_menu_trigger" data-value="'.strtolower ( rawurlencode ( esc_attr($adv_actions_value1)) ).'"> 
                    '.$adv_actions_value.' 
                <span class="caret caret_filter"></span> </div>           
                <input type="hidden" name="filter_search_action[]" value="'; 
                if(isset($_GET['filter_search_action'][0])){
                     echo  strtolower( esc_attr($_GET['filter_search_action'][0]) );

                }; 
                echo '">
                <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions">
                    '.$action_select_list.'
                </ul>        
            </div>
        </div>';
        ?> 
        
        <div class="col-md-2">
            <div class="adv_handler"><i class="fas fa-sliders-h" aria-hidden="true"></i></div>
            <input name="submit" type="submit" class="wpresidence_button" id="advanced_submit_10" value="<?php esc_html_e('Search','wpresidence');?>">
        </div>
        
        <input type="hidden" name="is10" value="10">
        
        
        <div class="adv_search_hidden_fields ">
     
            <?php
            $custom_advanced_search         =   wpresidence_get_option('wp_estate_custom_advanced_search','');
            $adv_search_fields_no_per_row   =   ( floatval( wpresidence_get_option('wp_estate_search_fields_no_per_row') ) );
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
       
        
        <?php include( locate_template('templates/preview_template.php') ); ?>

    </form>   
    <div style="clear:both;"></div>
</div>  