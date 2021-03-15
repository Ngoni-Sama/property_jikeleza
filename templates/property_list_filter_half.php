<?php
$order_class            =   ' order_filter_single ';  
$selected_order         =   esc_html__('Sort by','wpresidence');
$listing_filter         =   '';
if( isset($post->ID) ){
    $listing_filter         = get_post_meta($post->ID, 'listing_filter',true );
}
$listing_filter_array   = array(
                            "1"=>esc_html__('Price High to Low','wpresidence'),
                            "2"=>esc_html__('Price Low to High','wpresidence'),
                            "3"=>esc_html__('Newest first','wpresidence'),
                            "4"=>esc_html__('Oldest first','wpresidence'),
                            "5"=>esc_html__('Bedrooms High to Low','wpresidence'),
                            "6"=>esc_html__('Bedrooms Low to high','wpresidence'),
                            "7"=>esc_html__('Bathrooms High to Low','wpresidence'),
                            "8"=>esc_html__('Bathrooms Low to high','wpresidence'),
                            "0"=>esc_html__('Default','wpresidence')
                        );




$listings_list='';
foreach($listing_filter_array as $key=>$value){
    $listings_list.= '<li role="presentation" data-value="'.esc_html($key).'">'.esc_html($value).'</li>';//escaped above

    if($key==$listing_filter){
        $selected_order     =   $value;
        $selected_order_num =   $key;
    }
} 

?>

  
<div class="dropdown listing_filter_select order_filter <?php print esc_attr($order_class);?>">
    <div data-toggle="dropdown" id="a_filter_order" class="filter_menu_trigger" data-value="<?php echo esc_attr($selected_order_num);?>"> <?php echo esc_html($selected_order); ?> <span class="caret caret_filter"></span> </div>           
     <ul id="filter_order" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_order">
         <?php print trim($listings_list); ?>                   
     </ul>        
</div> 