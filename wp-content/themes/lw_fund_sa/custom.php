<!--Logo-->
<?php
$logotype = ot_get_option('logotype',1);
if(isset($logotype) && $logotype==1){
    $logo = ot_get_option('logo');
    if( $logo ){
        ?>
        <a class="" href="<?php echo get_home_url(); ?>" title="<?php bloginfo('name'); ?>">
            <img src="<?php echo $logo; ?>" alt="" />
        </a>
    <?php
    } else {
        ?>
        <a class="" href="<?php echo get_home_url(); ?>" title="<?php bloginfo('name'); ?>">
            <img src="<?php echo THEME_PATH.'/images/logo.png' ?>" alt="" />
        </a>
    <?php }
}else{
    $logotext   =   ot_get_option('logoText','logo');
    ?>
    <a class="" href="<?php echo get_home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php echo $logotext; ?></a>
<?php } ?>

<!--Menu-->
<?php  wp_nav_menu(array(
    'theme_location'    => 'main_nav',
    'container'         => '',
    'menu_class'        => 'nav',
    'link_after'       => '<span class="nut"></span>',
)); ?>

<!--sidebar-->
<?php
if(function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar right')):
endif;
?>

<!--Show post-->
<?php
$args = array(
    'post_type'=> 'service',
    'posts_per_page' => 5,
    'showposts'     => 5,
    'order'          => 'asc'
);
$advance = new WP_Query( $args );
while ($advance->have_posts()) : $advance->the_post();
    ?>
<?php endwhile;wp_reset_query();?>

<!--Vòng lặp-->
<?php
$weblk  =   ot_get_option('weblk');
if(isset($weblk) && $weblk!=""):
    ?>
    <?php foreach($weblk as $cli):?>
    <a  href="<?php echo $cli['weblk_link']; ?>">
        <img class="" width="140px" height="80px" class="" title="" alt="" src="<?php echo $cli['weblk_images']; ?>">
    </a>
<?php endforeach; endif; ?>

<!--Next post link-->
<div class="nav-buttons">
    <?php
    $prev_post = get_previous_post();
    if($prev_post) {
        $prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
        echo '<a href="' . get_permalink($prev_post->ID) . '" class="button prev-article " title="">';
        echo '<i class="ss-navigateleft"></i><span class="cta">Trở lại</span>';
        echo '</a>';
    }else{
        echo '<a class="button prev-article inactive" title="">';
        echo '<i class="ss-navigateleft"></i><span class="cta">Trở lại</span>';
        echo '</a>';
    }
    ?>

    <?php
    $next_post = get_next_post();
    if($next_post) {
        $next_title = strip_tags(str_replace('"', '', $next_post->post_title));
        echo '<a href="' . get_permalink($next_post->ID) . '" class="button next-article " title="">';
        echo '<span class="cta">Xem tiếp</span><i class="ss-navigateright"></i>';
        echo '</a>';
    }else{
        echo '<a class="button next-article inactive" title="">';
        echo '<span class="cta">Xem tiếp</span><i class="ss-navigateright"></i>';
        echo '</a>';
    }
    ?>
</div>

<!--Bài viết liên quan theo category-->
<?php
$categories = get_the_category($post->ID);
if ($categories)
{
    $category_ids = array();
    foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

    $args=array(
        'category__in' => $category_ids,
        'post__not_in' => array($post->ID),
        'showposts'=>5, // Số bài viết bạn muốn hiển thị.
        'caller_get_posts'=>1
    );
    $my_query = new wp_query($args);
    if( $my_query->have_posts() )
    {
        echo '<h3 class="title">Tin khác</h3><ul>';
        while ($my_query->have_posts())
        {
            $my_query->the_post();
            ?>
            <li><a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?> <span>(<?php the_time('d/m/Y')?>)</span></a></li>
        <?php
        }
        echo '</ul>';
    }
}
?>

<?php query_posts(array('showposts' => 2,'offset' => 1,'post_type' =>'post')); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php endwhile;endif; ?>
<!--tag && cat-->
<?php
$cats           = get_the_category();
$tag_list       = get_the_tags();
?>

<?php
$countCat   =   count($terms);
$i =0;
foreach($cats as $cat){
    $i++;
    ?>
    <?php echo $cat->name; ?>
    <?php
    if($i < $countCat){
        echo",";
    }
}
?>

<?php
if(isset($tag_list) && !empty($tag_list)): ?>
    <?php
    foreach($tag_list as $tag):
        ?>
        <a href="<?php echo get_tag_link($tag->term_id); ?>">
            <?php echo $tag->name; ?>
        </a>
    <?php endforeach;?>
<?php endif;?>

<div class="ralated">
    <div class="related-new">
        <span class="name-bar"> Các bài viết Mới hơn</span>

    </div>
    <div class="related-cont">
        <?php $post_time = get_the_time('Y-m-d H:i:s'); $postcurent = strtotime($post_time);
        $pid = $post->ID;
        ?>
        <ul>
            <?php
            global $post;
            $args = array('category__in' => wp_get_post_categories($post->ID), 'numberposts' => 5,'orderby' => 'date','order' => 'ASC', 'post__not_in' => array($pid));
            $myposts = get_posts( $args );
            foreach( $myposts as $post ) :	setup_postdata($post); ?>
                <?php
                $postDate = strtotime( $post->post_date );
                //$todaysDate = time() - (time() % 86400);
                if ( $postDate >= $postcurent) : ?>
                    <li><a href="<?php the_permalink(); ?>" ><?php the_title_attribute(); ?></a><?php if ($dis_date) {} else {?><?php } ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

    </div>

    <div class="related-old">
        <span class="name-bar"> Các bài viết Cũ hơn</span>
    </div>
    <div class="related-cont">
        <ul>
            <?php
            global $post;
            $args = array('category__in' => wp_get_post_categories($post->ID), 'numberposts' => 5,'orderby' => 'date','order' => 'ASC', 'post__not_in' => array($pid));
            $myposts = get_posts( $args );
            foreach( $myposts as $post ) :	setup_postdata($post); ?>
                <?php
                $postDate = strtotime( $post->post_date );
                //$todaysDate = time() - (time() % 86400);
                if ( $postDate <= $postcurent) : ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title_attribute(); ?></a><?php if ($dis_date) {} else {?><?php } ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>

</div>


<div class="breadcrumb">
    <?php if(function_exists('bcn_display'))
    {
        bcn_display();
    }
    ?>
</div>