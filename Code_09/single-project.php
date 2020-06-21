<?php get_header(); ?>

<div class="container-fluid dashboard-content" id="backtoptop">

  <?php get_template_part('templates/content', 'breadcrumb'); ?>

  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

      <?php get_template_part('templates/content', 'project'); ?>

      <?php
          if ($post->post_type == 'project') {
            get_template_part('templates/content', 'prevnext');
          }
          ?>

    <?php endwhile; ?>
  <?php endif; ?>


</div>

<?php get_footer(); ?>