<?php get_header(); ?>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php $category = get_the_category(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>

    <!-- 내용 -->
    <h1><?php the_title(); ?></h1>
    <figure><?php echo project_featured_image('default.jpg'); ?></figure>
    <p><?php the_content(); ?></p>
    <p class="text-right"><?php the_date(); ?> <?php the_time(); ?></p>
    <!-- //내용 -->

  <?php endwhile; ?>
<?php endif; ?>

<div class="text-center p-5">
  <a href="<?php echo project_homeurl('/cat'); ?>" class="btn btn-lg btn-light">목록으로</a>
</div>

<?php get_template_part('templates/content', 'share'); ?>

<?php get_template_part('templates/content', 'tags'); ?>

<!-- 댓글 -->
<?php if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required()) : ?>
  <?php comments_template(); ?>
<?php endif; ?>
<!-- //댓글 -->

<?php get_template_part('templates/content', 'prevnext'); ?>

<?php get_footer(); ?>