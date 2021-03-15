<?php
$wpestate_currency  =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
?>
<div class="listing_unit_price_wrapper">
    <?php  wpestate_show_price($post->ID,$wpestate_currency,$where_currency); ?>
</div>
