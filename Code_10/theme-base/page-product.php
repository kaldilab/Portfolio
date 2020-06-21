<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<ul class="list-group">
  <?php
  if (have_rows('product', 'option')) {
    while (have_rows('product', 'option')) {
      the_row();
      echo '<li class="list-group-item">';
      echo '<p>' . get_sub_field('title') . '</p>';
      echo '<p>' . get_sub_field('content') . '</p>';
      echo '<figure><img src="' . get_sub_field('image') . '"></figure>';
      echo '</li>';
    }
  }
  ?>
</ul>

<?php get_footer(); ?>