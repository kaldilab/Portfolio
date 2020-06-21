<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<div><?php echo get_field('about', 'option'); ?></div>

<?php get_footer(); ?>