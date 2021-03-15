<?php
global $wpestate_logo_header_align;
if($wpestate_logo_header_align=='center'){
    $wpestate_logo_header_align='left';
}
$text_header_align_select   =  wpresidence_get_option('wp_estate_text_header_align','');
?>
<div id="header_type3_wrapper" class="header_type3_menu_sidebar <?php echo 'header_'.esc_attr($wpestate_logo_header_align).' header_alignment_text_'.esc_attr($text_header_align_select);?>">
    
   <?php  if ( is_active_sidebar( 'sidebar-menu-widget-area-before' ) ) { ?>
        <ul class="xoxo">
            <?php dynamic_sidebar('sidebar-menu-widget-area-before'); ?>
        </ul>
    <?php } ?>
    
    <nav id="access">
        <?php 
            wp_nav_menu( 
                array(  'theme_location'    => 'primary' ,
                        'walker'            => new wpestate_custom_walker
                    ) 
            ); 
        ?>
    </nav><!-- #access -->
    
    
    <?php  if ( is_active_sidebar( 'sidebar-menu-widget-area-after' ) ) { ?>
        <ul class="xoxo">
            <?php dynamic_sidebar('sidebar-menu-widget-area-after'); ?>
        </ul>
    <?php } ?>
</div> 