<?php $theme = wp_get_theme()->stylesheet; ?>

<?php get_header(); ?>

<?php
if ($theme == 'theme-origin') {
  get_template_part('templates/' . get_field('dev_theme', 'option') . '/content', 'front');
} else {
  get_template_part('templates/' . $theme . '/content', 'front');
}
?>

<?php get_footer(); ?>