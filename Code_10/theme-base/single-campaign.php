<?php acf_form_head(); ?>
<?php get_header(); ?>

<?php
$post_id = $post->ID;
$post_title = $post->post_title;
$post_type = $post->post_type;
?>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>

    <!-- 내용 -->
    <h1><?php the_title(); ?></h1>
    <figure><?php echo project_featured_image('default.jpg'); ?></figure>
    <p><?php the_content(); ?></p>
    <p>날짜 : <?php echo date('Y년 m월 d일', strtotime(get_field('campaign_date')['start'])) . ' ~ ' . date('Y년 m월 d일', strtotime(get_field('campaign_date')['end'])); ?></p>
    <p>시간 : <?php echo get_field('campaign_time')['start'] . ' ~ ' . get_field('campaign_time')['end']; ?></p>
    <p>장소 : <?php echo get_field('campaign_space'); ?></p>
    <p class="text-right"><?php the_date(); ?> <?php the_time(); ?></p>
    <!-- //내용 -->

  <?php endwhile; ?>
<?php endif; ?>

<hr>

<!-- 작성 폼 -->
<h3>참여하기</h3>
<div>
  <?php
  acf_form(array(
    'post_id' => 'new_post',
    'new_post' => array(
      'post_type' => 'campaign_apply',
      'post_status' => 'pending',
      'post_title' => $post_title . ' (' . $post_id . ')',
    ),
    'submit_value' => '참여하기',
    'return' => add_query_arg('updated', 'true', home_url($post_type)),
  ));
  ?>
</div>
<!-- //작성 폼 -->

<div class="text-center p-5">
  <a href="<?php echo project_homeurl($post_type); ?>" class="btn btn-lg btn-light">목록으로</a>
</div>

<?php get_template_part('templates/content', 'share'); ?>

<hr>

<!-- 댓글 -->
<h3>댓글참여</h3>
<?php if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required()) : ?>
  <?php comments_template(); ?>
<?php endif; ?>
<!-- //댓글 -->

<?php get_footer(); ?>