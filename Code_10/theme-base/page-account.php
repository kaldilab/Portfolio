<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php echo do_shortcode('[ultimatemember_account]'); ?>

<?php get_footer(); ?>