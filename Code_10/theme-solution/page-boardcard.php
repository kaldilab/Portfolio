<?php get_header(); ?>

<div class="sub__top">
  <h2 class="sub__title"><?php the_title(); ?></h2>
  <?php get_template_part('templates/content', 'breadcrumb'); ?>
</div>

<?php get_template_part('templates/content', 'board_card'); ?>

<?php get_footer(); ?>