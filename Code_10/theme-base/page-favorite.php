<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<ul class="list-group">
  <?php
  if (have_rows('favorite', 'option')) {
    while (have_rows('favorite', 'option')) {
      the_row();
      echo '<li class="list-group-item">';
      echo '<p>' . get_sub_field('title') . '</p>';
      echo '<a href="' . get_sub_field('link') . '" target="_blank">' . get_sub_field('link') . '</a>';
      echo '</li>';
    }
  }
  ?>
</ul>

<?php get_footer(); ?>