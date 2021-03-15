<?php
$wpestate_currency  =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$link               =   get_permalink();
?>
<div class="listing_unit_price_wrapper">
      <a href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr(wpresidence_get_option('wp_estate_unit_card_new_page',''));?> ">
          <?php  wpestate_show_price($post->ID,$wpestate_currency,$where_currency); ?>
      </a>
</div>
