<?php
 global $lightbox;
 wp_enqueue_script('owl_carousel');
?>
<div class="lightbox_property_wrapper_floorplans">
    
    <div class="lightbox_property_wrapper_level2">
        
        <div class="lightbox_property_content row">
            <div class="lightbox_property_slider col-md-12">
                <div  id="owl-demo-floor" class="owl-carousel owl-theme">
                    <?php print trim($lightbox);?>
                </div>
            </div>
        </div>


       
        <div class="lighbox-image-close-floor">
            <i class="fas fa-times" aria-hidden="true"></i>
        </div>
    
    </div>
    
    <div class="lighbox_overlay"></div>    
</div>
<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function(){
       estate_start_lightbox_floorplans(); 
    });
    //]]>
</script>