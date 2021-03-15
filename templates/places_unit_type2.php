<?php
global $full_page;
global $is_shortcode;
global $wpestate_places_slider;
global $row_number_col;
global $place_id;
global $place_per_row;
$place_id                       =   intval($place_id);
$category_attach_id             =   '';
$category_tax                   =   '';
$category_featured_image        =   '';
$category_name                  =   '';
$category_featured_image_url    =   '';
$term_meta                      =   get_option( "taxonomy_$place_id");
$category_tagline               =   ''; 
$col_class                      =   'col-md-6';
$col_org                        =   4;


if(isset($is_shortcode) && $is_shortcode==1 ){
    $col_class='col-md-'.esc_attr($row_number_col).' shortcode-col';
}

if(isset($is_widget) && $is_widget==1 ){
    $col_class='col-md-12';
    $col_org    =   12;
}
$category_description='';

$category_count =0;



if(isset($term_meta['category_featured_image'])){
    $category_featured_image=$term_meta['category_featured_image'];
}

if(isset($term_meta['category_attach_id'])){
    $category_attach_id=$term_meta['category_attach_id'];
    $category_tagline = $term_meta['category_tagline'];
    
    $category_featured_image= wp_get_attachment_image_src( $category_attach_id, 'property_full');
    $category_featured_image_url=$category_featured_image[0];
}
        
if(isset($term_meta['category_tax']) &&  $term_meta['category_tax'] != ''){
    	
    $category_tax=$term_meta['category_tax'];
    $term= get_term( $place_id, $category_tax);
    if(isset($term->name)){
        $category_name=$term->name;
        $category_count=$term->count;
        $category_description = $term->description;
    }
}

 if(isset($term_meta['category_tagline'])){
    $category_tagline=  stripslashes( $term_meta['category_tagline'] );           
}

$term_link =  get_term_link( $place_id, $category_tax );
if ( is_wp_error( $term_link ) ) {
    $term_link='';
}
 
if($category_featured_image_url==''){
    $category_featured_image_url=get_theme_file_uri('/img/defaults/default_property_listings.jpg');
}



$inline_style=" background-image: url(".esc_attr($category_featured_image_url).");";

if(isset($item_height) && $item_height!=''){
    $inline_style.="height:".floatval($item_height)."px;";
}

?>  

<div class="places_wrapper_type_2" style="<?php echo trim($inline_style); ?>"> 
    
    <div class="places_cover" data-link="<?php echo esc_attr($term_link);?>" ></div>
    <div class="places_type_2_content"  >
        <h4><a href="<?php echo esc_url($term_link); ?>">
            <?php
                echo mb_substr( $category_name,0,44); 
                if(mb_strlen($category_name)>44){
                    echo '...';   
                } 
            ?>
            </a> 
        </h4> 
        
        <div class="places_type_2_tagline">
            <?php print esc_html($category_tagline);?>
        </div>
        
        <div class="places_type_2_listings_no">
            <?php echo esc_html($category_count).' '.esc_html__('Listings','wpresidence' )?>   
        </div>
        
    </div>          
</div>