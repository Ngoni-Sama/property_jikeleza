<?php
global $option_slider;
?>

<div class="submit_container">  
<div class="submit_container_header"><?php esc_html_e('Slider Option','wpresidence');?></div>

   <p class="full_form">
       <label for="prop_slider_type"><?php esc_html_e('Slider type ','wpresidence');?></label>
       <select id="prop_slider_type" name="prop_slider_type" class="select-submit2">
           <?php print trim($option_slider);?>
       </select>
    </p>
</div>
