<?php 
global $post;
if (is_single() ){ 
    ob_start();
    previous_post_link('%link', '%title',false);
    $template_pr = ob_get_contents();
    ob_end_clean(); 
    
    ob_start();
    next_post_link('%link',' %title',false); 
    $template_nxt = ob_get_contents();
    ob_end_clean(); 
    
?>
<div class="navigational_links">
    <?php if( $template_pr !=''){?>
            <div class="nav-prev-wrapper">
                <div class="nav-prev">
                    <?php print wp_kses_post($template_pr); ?>
                    <i class="fas fa-angle-left"></i>           
                </div>
            </div>
    <?php } ?>
     
    <?php if( $template_nxt !=''){?>
            <div class="nav-next-wrapper">
                 <div class="nav-next">    
                     <i class="fas fa-angle-right"></i>
                     <?php print wp_kses_post($template_nxt); ?>
                 </div>
            </div>  
    <?php }?>
</div> 
  
<?php
}
?>