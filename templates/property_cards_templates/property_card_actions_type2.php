<div class="listing_actions">
    <?php print wpestate_share_unit_desing($post->ID);
    $compare   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider_thumb');?>
    <span class="share_list"  data-original-title="<?php esc_attr_e('share', 'wpresidence'); ?>" ></span>
    <span class="compare-action" data-original-title="<?php  esc_attr_e('compare','wpresidence');?>" data-pimage="<?php if( isset($compare[0])){echo esc_attr($compare[0]);} ?>" data-pid="<?php echo intval($post->ID); ?>"></span>

</div>