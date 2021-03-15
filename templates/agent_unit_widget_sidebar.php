<?php
global $wpestate_options;
global $agent_wid;

$col_class=4;
if($wpestate_options['content_class']=='col-md-12'){
    $col_class=3;
}
?>

<div class="agent_unit_widget_sidebar" style="background-image: url(<?php echo esc_url($realtor_details['realtor_image']);?>)"></div>
<h4> <a href="<?php echo esc_url($realtor_details['link']); ?>"><?php echo esc_html($realtor_details['realtor_name']); ?></a></h4>
<div class="agent_position"><?php echo esc_html($realtor_details['realtor_position']); ?></div>
<div class="agent_listings"><?php  echo esc_html($realtor_details['counter']).' '.esc_html__('listings','wpresidence');?></div>
<div class="agent_sidebar_mobile">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" version="1.1" style="shape-rendering:geometricPrecision;text-rendering:geometricPrecision;image-rendering:optimizeQuality;" viewBox="0 0 295.64 369.5375" x="0px" y="0px" fill-rule="evenodd" clip-rule="evenodd"><defs></defs><g><path class="fil0" d="M231.99 189.12c18.12,10.07 36.25,20.14 54.37,30.21 7.8,4.33 11.22,13.52 8.15,21.9 -15.59,42.59 -61.25,65.07 -104.21,49.39 -87.97,-32.11 -153.18,-97.32 -185.29,-185.29 -15.68,-42.96 6.8,-88.62 49.39,-104.21 8.38,-3.07 17.57,0.35 21.91,8.15 10.06,18.12 20.13,36.25 30.2,54.37 4.72,8.5 3.61,18.59 -2.85,25.85 -8.46,9.52 -16.92,19.04 -25.38,28.55 18.06,43.98 55.33,81.25 99.31,99.31 9.51,-8.46 19.03,-16.92 28.55,-25.38 7.27,-6.46 17.35,-7.57 25.85,-2.85z"/></g></svg>
    <a href="tel:><?php echo esc_html($realtor_details['realtor_mobile']);?>" ><?php echo esc_html($realtor_details['realtor_mobile']);?></a>
</div>