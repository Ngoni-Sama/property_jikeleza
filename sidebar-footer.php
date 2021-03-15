<?php
if (!is_active_sidebar('first-footer-widget-area') && !is_active_sidebar('second-footer-widget-area') && 
    !is_active_sidebar('third-footer-widget-area') && !is_active_sidebar('fourth-footer-widget-area')){
    return;  
}

$footer_type  =   wpresidence_get_option('wp_estate_footer_type','');
if($footer_type==''){
    $footer_type=1;
}

$class1 =   '';
$class2 =   '';
$class3 =   '';
$class4 =   '';

switch ($footer_type) {
    case 1:
        $class1 =   'col-md-3';
        $class2 =   'col-md-3';
        $class3 =   'col-md-3';
        $class4 =   'col-md-3';
        break;
    case 2:
        $class1 =   'col-md-4';
        $class2 =   'col-md-4';
        $class3 =   'col-md-4';
        $class4 =   '';
        break;
    case 3:
        $class1 =   'col-md-6';
        $class2 =   'col-md-6';
        $class3 =   '';
        $class4 =   '';
        break;
    case 4:
        $class1 =   'col-md-12';
        $class2 =   '';
        $class3 =   '';
        $class4 =   '';
        break;
    case 5:
        $class1 =   'col-md-6';
        $class2 =   'col-md-3';
        $class3 =   'col-md-3';
        $class4 =   '';
        break;
    case 6:
        $class1 =   'col-md-3';
        $class2 =   'col-md-6';
        $class3 =   'col-md-3';
        $class4 =   '';
        break;
    case 7:
        $class1 =   'col-md-3';
        $class2 =   'col-md-3';
        $class3 =   'col-md-6';
        $class4 =   '';
        break;
    case 8:
        $class1 =   'col-md-8';
        $class2 =   'col-md-4';
        $class3 =   '';
        $class4 =   '';
        break;
    case 9:
        $class1 =   'col-md-4';
        $class2 =   'col-md-8';
        $class3 =   '';
        $class4 =   '';
        break;
    
}
?>

<?php if (is_active_sidebar('first-footer-widget-area') && $class1!='' ) : ?>
    <div id="first" class="widget-area <?php print esc_attr($class1);?> ">
        <ul class="xoxo">
            <?php dynamic_sidebar('first-footer-widget-area'); ?>
        </ul>
    </div><!-- #first .widget-area -->
<?php endif; ?>
    
<?php if (is_active_sidebar('second-footer-widget-area') && $class2!='' ) : ?>
    <div id="second" class="widget-area <?php print esc_attr($class2);?>">
        <ul class="xoxo">
        <?php dynamic_sidebar('second-footer-widget-area'); ?>
        </ul>
    </div><!-- #second .widget-area -->
<?php endif; ?>
    
<?php if (is_active_sidebar('third-footer-widget-area') && $class3!='') : ?>
    <div id="third" class="widget-area <?php print esc_attr($class3);?>">
        <ul class="xoxo">
        <?php dynamic_sidebar('third-footer-widget-area'); ?>
        </ul>
    </div><!-- #third .widget-area -->
<?php endif; ?>
    
<?php if ( is_active_sidebar('fourth-footer-widget-area') && $class4!='' ) : ?>
    <div id="fourth" class="widget-area <?php print esc_attr($class4);?>">
        <ul class="xoxo">
        <?php dynamic_sidebar('fourth-footer-widget-area'); ?>
        </ul>
    </div><!-- #fourth .widget-area -->
<?php endif; ?>