<!-- begin sidebar -->
<div class="clearfix visible-xs"></div>
<?php 
$sidebar_name   =   $wpestate_options['sidebar_name'];
$sidebar_class  =   $wpestate_options['sidebar_class'];
 
if( ('no sidebar' != $wpestate_options['sidebar_class']) && ('' != $wpestate_options['sidebar_class'] ) && ('none' != $wpestate_options['sidebar_class']) ){
?>    
    <div class="col-xs-12 <?php print esc_html($wpestate_options['sidebar_class']);?> widget-area-sidebar" id="primary" >
        <div id="primary_sidebar_wrapper">
            <?php 
            if(  'estate_property' == get_post_type() && !is_tax() ){

              $sidebar_agent_option_value=    get_post_meta($post->ID, 'sidebar_agent_option', true);    
                if($sidebar_agent_option_value =='global'){
                    $enable_global_property_page_agent_sidebar= esc_html ( wpresidence_get_option('wp_estate_global_property_page_agent_sidebar','') );
                    if($enable_global_property_page_agent_sidebar=='yes'){
                
                        include( locate_template ('/templates/property_list_agent.php') ); 
                    }
                }elseif ($sidebar_agent_option_value =='yes') {
                     include( locate_template ('/templates/property_list_agent.php') );
                }
            }
            ?>

            <?php    
            if ( is_active_sidebar( $wpestate_options['sidebar_name'] ) ) { ?>
                <ul class="xoxo">
                    <?php dynamic_sidebar( $wpestate_options['sidebar_name'] ); ?>
                </ul>
            <?php 
            } 
            ?>
        </div>
    </div>   

<?php
}
?>
<!-- end sidebar -->