<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<!-- 리스트 -->
<?php
$args_privacy_list = array(
  'post_type' => 'privacy',
  'posts_per_page' => -1,
  'orderby' => 'date',
  'order' => 'ASC',
);
$query_privacy_list = new WP_Query($args_privacy_list);
?>
<ul class="list-group">
  <?php if ($query_privacy_list->have_posts()) : ?>
    <?php while ($query_privacy_list->have_posts()) : $query_privacy_list->the_post(); ?>
      <li class="list-group-item"><a href="<?php echo project_homeurl('/privacy/?q='); ?><?php the_ID(); ?>"><?php the_title(); ?></a></li>
    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
</ul>
<!-- //리스트 -->

<!-- 내용 -->
<?php
$args_privacy = array(
  'post_type' => 'privacy',
  'posts_per_page' => 1,
);

if (!empty($_GET['q'])) {
  $q = $_GET['q'];
  $args_privacy['p'] = $_GET['q'];
} else {
  $q = null;
}
$query_privacy = new WP_Query($args_privacy);
?>
<div class="mt-5">
  <?php if ($query_privacy->have_posts()) : ?>
    <?php while ($query_privacy->have_posts()) : $query_privacy->the_post(); ?>
      <h3 class="text-center mb-3"><?php the_title(); ?></h3>
      <div><?php the_content(); ?></div>
    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
</div>
<!-- //내용 -->

<?php get_footer(); ?>