<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="text" class="form-control" name="s" id="s" placeholder="<?php esc_html_e( 'Type Keyword', 'wpresidence' ); ?>" />
    <button class="wpresidence_button"  id="submit-form"><?php esc_html_e('Search','wpresidence');?></button>
    <?php wp_nonce_field( 'wpestate_default_search', 'wpestate_default_search_nonce' ); ?>
</form>
