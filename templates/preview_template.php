     
<div id="results">
    <div class="results_header">
        <?php esc_html_e('We found ','wpresidence'); ?> <span id="results_no">0</span> <?php esc_html_e('results.','wpresidence'); ?>  
        <span id="preview_view_all"><?php esc_html_e('View results','wpresidence');?></span>
     
    </div>
    <div id="results_wrapper">
    </div>
    
     <?php wp_nonce_field( 'wpestate_regular_search', 'wpestate_regular_search_nonce' ); ?>
</div>