<?php
global $post;
?>
<div class="container_tour">
<?php
if( get_post_meta( $post->ID, 'embed_virtual_tour', true ) != '' ){
    echo get_post_meta( $post->ID, 'embed_virtual_tour', true );
}
?>
</div>
 