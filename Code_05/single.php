<?php
/**
 * The template for displaying posts
 *
 * @package kale
 */
?>
<?php get_header(); ?>

<?php
$kale_posts_meta_show = kale_get_option('kale_posts_meta_show');
$kale_posts_date_show = kale_get_option('kale_posts_date_show');
$kale_posts_category_show = kale_get_option('kale_posts_category_show');
$kale_posts_author_show = kale_get_option('kale_posts_author_show');
$kale_posts_tags_show = kale_get_option('kale_posts_tags_show');
$kale_posts_sidebar = kale_get_option('kale_posts_sidebar');
$kale_posts_featured_image_show = kale_get_option('kale_posts_featured_image_show');
$kale_sidebar_size = kale_get_option('kale_sidebar_size');
?>
<?php while ( have_posts() ) : the_post(); ?>
    <!-- Main Column -->
    <?php if($kale_posts_sidebar == 1) { ?>
    <div class="main-column <?php if($kale_sidebar_size == 0) { ?> col-md-8 <?php } else { ?> col-md-9 <?php } ?>">
    <?php } else { ?>
    <div class="main-column">
    <?php } ?>

        <!-- Post Content -->
        <div id="post-<?php the_ID(); ?>" <?php post_class('entry entry-post'); ?>>


            <?php $title = get_the_title(); ?>
            <?php if($title == '') { ?>
            <h1 class="entry-title"><?php esc_html_e('Post ID: ', 'kale'); the_ID(); ?></h1>
            <?php } else { ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php } ?>

            <?php
            if($kale_posts_featured_image_show == 1) {
                if(has_post_thumbnail()) { ?>
                <div class="entry-thumb"><?php the_post_thumbnail( 'full', array( 'alt' => get_the_title(), 'class'=>'img-responsive' ) ); ?></div><?php }
            } ?>

            <div class="entry-content">
                <?php the_content(); ?>
                <?php wp_link_pages(); ?>
                <?php if (in_category('repermit')) {
                    echo do_shortcode("[rating-system-posts]");
                } else {
                    echo do_shortcode("[rating-system-posts-disable-dislike]");
                } ?>
            </div>
            <div class="clearfix"></div>
            <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
            <?php if(  ( $kale_posts_meta_show == 1 && ($kale_posts_category_show == 1 || $kale_posts_tags_show == 1 || $kale_posts_author_show == 1) )  ) { ?>
            <?php } ?>

        </div>
        <!-- /Post Content -->

        <hr />

        <div class="pagination-post">
            <div class="previous_post"><?php previous_post_link('%link','%title',true); ?></div>
            <div class="next_post"><?php next_post_link('%link','%title',true); ?></div>
        </div>

        <!-- Post Comments -->
        <?php if ( comments_open() ) : ?>
        <hr />
        <?php comments_template(); ?>
        <?php endif; ?>
        <!-- /Post Comments -->

    </div>
    <!-- /Main Column -->


    <?php if($kale_posts_sidebar == 1)  get_sidebar();  ?>


<?php endwhile; ?>
<hr />

<?php get_footer(); ?>