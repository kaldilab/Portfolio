<?php get_header(); ?>

<div class="container-fluid dashboard-content" id="backtoptop">

  <?php get_template_part('templates/content', 'breadcrumb'); ?>

  <?php
  $args_project = array(
    'post_type' => array(
      'project',
      'running',
      'onlyone',
    ),
    'posts_per_page' => -1,
    'p' => $_GET['id'],
  );
  $query_project = new WP_Query($args_project);
  ?>

  <?php if ($query_project->have_posts()) : ?>
    <?php while ($query_project->have_posts()) : $query_project->the_post(); ?>

      <?php get_template_part('templates/content', 'project'); ?>

      <?php
          if ($post->post_type == 'project') {
            get_template_part('templates/content', 'prevnext');
          }
          ?>
          
    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>

</div>

<?php get_footer(); ?>