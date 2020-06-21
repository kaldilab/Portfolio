<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<!-- 리스트 -->
<?php
$args_terms_list = array(
  'post_type' => 'terms',
  'posts_per_page' => -1,
  'orderby' => 'date',
  'order' => 'ASC',
);
$query_terms_list = new WP_Query($args_terms_list);
?>
<ul class="list-group">
  <?php if ($query_terms_list->have_posts()) : ?>
    <?php while ($query_terms_list->have_posts()) : $query_terms_list->the_post(); ?>
      <li class="list-group-item"><a href="<?php echo project_homeurl('/terms/?q='); ?><?php the_ID(); ?>"><?php the_title(); ?></a></li>
    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
</ul>
<!-- //리스트 -->

<!-- 내용 -->
<?php
$args_terms = array(
  'post_type' => 'terms',
  'posts_per_page' => 1,
);
isset($_GET['q']) ? $args_terms['p'] = $_GET['q'] : $q = null;

$query_terms = new WP_Query($args_terms);
?>
<div class="mt-5">
  <?php if ($query_terms->have_posts()) : ?>
    <?php while ($query_terms->have_posts()) : $query_terms->the_post(); ?>
      <h3 class="text-center mb-3"><?php the_title(); ?></h3>
      <div><?php the_content(); ?></div>
    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
</div>
<!-- //내용 -->

<?php get_footer(); ?>