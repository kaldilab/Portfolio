<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<ul class="list-group">
  <?php
  if (have_rows('people', 'option')) {
    while (have_rows('people', 'option')) {
      the_row();
      echo '<li class="list-group-item">';
      echo '<span>이름 : <strong>' . get_sub_field('name') . '</strong></span>';
      echo '<span>직책 : <strong>' . get_sub_field('position') . '</strong></span>';
      echo '</li>';
    }
  }
  ?>
</ul>

<?php get_footer(); ?>