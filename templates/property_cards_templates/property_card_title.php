<?php
$title          =   get_the_title();
$link           =   get_permalink();
?>
<h4>    
    <a href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr(wpresidence_get_option('wp_estate_unit_card_new_page',''));?> ">
            <?php
                echo mb_substr( $title,0,44); 
                if(mb_strlen($title)>44){
                    echo '...';   
                } 
            ?>
    </a> 
</h4>
