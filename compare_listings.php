<?php
// Template Name: Compare Listings
// Wp Estate Pack

if(!function_exists('wpestate_residence_functionality')){
    esc_html_e('This page will not work without WpResidence Core Plugin, Please activate it from the plugins menu!','wpresidence');
    exit();
}

get_header();
$wpestate_options        =   wpestate_page_details($post->ID);
$show_string    =   '';

if (!isset($_POST['selected_id'])) {
    print '<div class="nocomapare">'.esc_html__('page should be accesible only via the compare button','wpresidence').'</div>';
    exit();
}

foreach ($_POST['selected_id'] as $key => $value) {
    if (!is_numeric($value)) {
        exit();
    }
    $list_prop[] = $value;
}


$unit           =   esc_html ( wpresidence_get_option('wp_estate_measure_sys', '') );
$wpestate_currency       =   esc_html ( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency =   esc_html ( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$measure_sys    =   esc_html ( wpresidence_get_option('wp_estate_measure_sys','') ); 
$counter        =   0;
$properties     =   array();
$id_array       =   array();
$args = array(
        'post_type'     => 'estate_property',
        'post_status'   => 'publish',
        'post__in'      => $list_prop
);

$prop_selection = new WP_Query($args);
while ($prop_selection->have_posts()): $prop_selection->the_post();

    $property = array();
    $id_array[]                     =   $post->ID;
    $property['link']               =   esc_url ( get_permalink($post->ID) );
    $property['title']              =   get_the_title();
    $attr                           =   array(
                                            'class'=>'lazyload img-responsive'
                                        ); 
    $property['image']              =   get_the_post_thumbnail($post->ID, 'property_listings',$attr );
    $property['type']               =   get_the_term_list($post->ID, 'property_category', '', ', ', '');
    $property['property_city']      =   get_the_term_list($post->ID, 'property_city', '', ', ', '');
    $property['property_area']      =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
    $property['property_zip']       =   esc_html ( get_post_meta($post->ID, 'property_zip', true) );
    $property['property_size']      =   wpestate_get_converted_measure( $post->ID, 'property_size' ) ;
    $property['property_lot_size']  =   wpestate_get_converted_measure( $post->ID, 'property_lot_size' ) ;  
    $property['property_rooms']     =   floatval( get_post_meta($post->ID, 'property_rooms', true));
    $property['property_bedrooms']  =   floatval( get_post_meta($post->ID, 'property_bedrooms', true));
    $property['property_bathrooms'] =   floatval ( get_post_meta($post->ID, 'property_bathrooms', true));
   
   // energy saving
   $property['energy_index'] =   get_post_meta($post->ID, 'energy_index', true);
   $property['energy_class'] =   get_post_meta($post->ID, 'energy_class', true);
   $property['property_id']  =   $post->ID;
   
   // ee end
   
    if( floatval( get_post_meta($post->ID, 'property_price', true) ) !=0 ){
        $price =  wpestate_show_price($post->ID,$wpestate_currency,$where_currency,1);
    }else{
        $price='';
    }
    $property['price']  =   $price;
   
     $terms              =   get_terms( array(
                                'taxonomy' => 'property_features',
                                'hide_empty' => false,
                            ));

    foreach($terms as $checker => $term){
       
        if( has_term( $term->name, 'property_features',$post->ID ) ) {
            $property[$term->name] =1;
        }else{
            $property[$term->name] =0;
        }
    }
    $counter++;
    $properties[] = $property;
endwhile; 
wp_reset_query();
wp_reset_postdata();
?>


<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    
    <?php get_template_part('templates/ajax_container'); ?>
    
        <h1 class="entry-title compare_title"><?php esc_html_e('Compare Listings', 'wpresidence'); ?></h1>
        <div class="compare_wrapper col-md-12">
            
                        <div class="compare_legend_head"></div>
                        <?php
                        for ($i = 0; $i <= $counter - 1; $i++) {
                            ?>
                            <div class="compare_item_head"> 
                                <a href="<?php print esc_url($properties[$i]['link']); ?>"><?php print trim($properties[$i]['image']); ?></a>				
                                <h4><a href="<?php print esc_url($properties[$i]['link']); ?>"><?php print esc_html($properties[$i]['title']); ?></a> </h4>  
                         
                                <div class="property_price"><?php print trim($properties[$i]['price']); ?></div>
                                <div class="article_property_type"><?php print esc_html__('Type: ','wpresidence').wp_kses_post($properties[$i]['type']); ?></div>
                            </div>          
                            <?php
                        }
                        ?>
                        
                         <?php
                    $show_att = array(
                        'property_city'                     =>esc_html__('city','wpresidence'),
                        'property_area'                     =>esc_html__('area','wpresidence'),
                        'property_zip'                      =>esc_html__('zip','wpresidence'),
                        'property_size'                     =>esc_html__('size','wpresidence'),
                        'property_lot_size'                 =>esc_html__('lot size','wpresidence'),
                        'property_rooms'                    =>esc_html__('rooms','wpresidence'),
                        'property_bedrooms'                 =>esc_html__('bedrooms','wpresidence'),
                        'property_bathrooms'                =>esc_html__('bathrooms','wpresidence'),
                        'energy_index'                      =>esc_html__('Energy Index','wpresidence'),
                        'energy_class'                	    =>esc_html__('Energy Class','wpresidence'),
                        'property_id'                	    =>esc_html__('Property ID','wpresidence'),
                    );

                    foreach ($show_att as $key => $value) {
                    
                        print '<div class="compare_item '.esc_attr($key).'"> 
                               <div class="compare_legend_head_in">' .esc_html($value). '</div>';

                        for ($i = 0; $i <= $counter - 1; $i++) {
                            print'<div class="prop_value">' .wp_kses_post($properties[$i][$key]). '</div>';
                        }
                        print'</div>';
                    }

                    /////////////////////////////////////////////////// custom fields
                    $j= 0;
                    $custom_fields = wpresidence_get_option( 'wp_estate_custom_fields', ''); 
                    if( !empty($custom_fields)){  
                        while($j< count($custom_fields) ){
                            $name =   $custom_fields[$j][0];
                            $label=   $custom_fields[$j][1];
                            $type =   $custom_fields[$j][2];
                            //$slug =   sanitize_key( str_replace(' ','_',$name) );
                            $slug         =   wpestate_limit45(sanitize_title( $name )); 
                            $slug         =   sanitize_key($slug);
                            if (function_exists('icl_translate') ){
                                $label     =   icl_translate('wpestate','wp_estate_property_custom_'.esc_html($label), $label ) ;
                            }
                            print '<div class="compare_item '.esc_html($slug).'"> 
                            <div class="compare_legend_head_in">' .stripslashes($label) . '</div>';
                            for ($i = 0; $i < count($id_array); $i++) {
                               print'<div class="prop_value">'. esc_html(get_post_meta($id_array[$i], $slug, true)) . '</div>';
                             }                        
                            $j++;       
                            print'</div>';
                         }
                    }          

                    // on off attributes         
                    foreach($terms as $checker => $term){
                       
                        print '<div class="compare_item '.esc_attr($term->name).'"> 
                               <div class="compare_legend_head_in">' .trim($term->name). '</div>';

                        for ($i = 0; $i <= $counter - 1; $i++) {
                            print'<div class="prop_value">';
                            if ($properties[$i][trim($term->name)] == 1) {
                                print '<i class="fas fa-check compare_yes"></i>';
                            } else {
                                print '<i class="fas fa-times compare_no"></i>';
                            }
                            print'</div>';
                        }
                        print'</div>';
                                                     
                    }
                    ?>
        
        </div><!-- end compare wrapper-->
     
</div>   
<?php get_footer(); ?>