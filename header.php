<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
 
<?php    
if( !has_site_icon() ){
    print '<link rel="shortcut icon" href="'.get_theme_file_uri('/img/favicon.gif').'" type="image/x-icon" />';
}
wp_head();?>    
</head>



<?php   
$logo_header_type   =   wpresidence_get_option('wp_estate_logo_header_type','');
$header_classes     =   wpestate_header_classes();
?>


<body <?php body_class(); ?>>
<?php get_template_part('templates/mobile_menu' ); ?> 
    

<div class="website-wrapper" id="all_wrapper" >
<div class="container main_wrapper <?php echo esc_attr($header_classes['main_wrapper_class']) ;?>">
    <div class="master_header <?php echo esc_attr($header_classes['master_header_class']); ?>">
        <?php   
            if(esc_html ( wpresidence_get_option('wp_estate_show_top_bar_user_menu','') )=="yes" && !is_page_template( 'splash_page.php' ) ){
                get_template_part( 'templates/top_bar' ); 
            } 
            get_template_part('templates/mobile_menu_header' );
        ?>
       
        
        <div class="header_wrapper <?php echo esc_attr($header_classes['header_wrapper_class']);?> ">
            <?php 
            if($logo_header_type  =='type5'){
                include( locate_template('templates/header5.php') );
            }else{
            ?>
            
            <div class="header_wrapper_inside <?php echo esc_attr($header_classes['header_wrapper_inside_class']);?>" 
                 data-logo="<?php print esc_attr($header_classes['logo']);?>" 
                 data-sticky-logo="<?php print esc_attr($header_classes['stikcy_logo_image']); ?>">
                
                <?php 
                
                print wpestate_display_logo($header_classes['logo']); 
                
                if(  $logo_header_type!='type3'){
                    get_template_part('templates/top_user_menu');  
                }
                
                if($logo_header_type!='type3'){
                
                ?>
                    <nav id="access">
                        <?php 
                            wp_nav_menu( 
                                array(  'theme_location'    => 'primary' ,
                                        'walker'            => new wpestate_custom_walker
                                    ) 
                            ); 
                        ?>
                    </nav><!-- #access -->
                <?php }else{ ?>
                    <a class="navicon-button header_type3_navicon" id="header_type3_trigger">
                        <div class="navicon"></div>
                    </a>
                <?php } 
                
                
                if($logo_header_type=='type4'){
                    if ( is_active_sidebar( 'header4-widget-area' ) ) {
                        print '<div id="header4_footer"><ul class="xoxo">';
                            dynamic_sidebar('header4-widget-area');
                        print'</ul></div>';
                    }
                }
                ?>    
                    
            </div>
            <?php } ?>
        </div>

     </div> 
    
    <?php get_template_part( 'header_media' ); ?>   
    
  <div class="container content_wrapper">