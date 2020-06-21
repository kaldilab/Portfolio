<?php get_header(); ?>

<div class="container-fluid dashboard-content" id="backtoptop">

  <?php get_template_part('templates/content', 'breadcrumb'); ?>

  <?php
  $args_tf = array(
    'post_type' => 'tf',
    'posts_per_page' => -1,
    'p' => $_GET['id'],
  );
  $query_tf = new WP_Query($args_tf);
  ?>

  <?php if ($query_tf->have_posts()) : ?>
    <?php while ($query_tf->have_posts()) : $query_tf->the_post(); ?>

      <?php get_template_part('templates/content', 'tf'); ?>

    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>

</div>

<?php get_footer(); ?>