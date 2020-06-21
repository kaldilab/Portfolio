<?php get_header(); ?>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php $post_type = $post->post_type; ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>

    <?php
    $today = date_i18n('Y-m-d');
    $date_start = get_field('program_date')['start'];
    $date_end = get_field('program_date')['end'];
    $finish_number = get_field('program_number');

    // post program apply
    $args_program_apply = array(
      'post_type' => 'program_apply',
      'post_status' => 'pending, publish',
      'posts_per_page' => -1,
      'meta_query' => array(
        'relation' => 'AND',
        array(
          'key' => 'program_apply_id',
          'value' => $post->ID,
        ),
      ),
    );
    $query_program_apply = new WP_Query($args_program_apply);
    $count_program_apply = $query_program_apply->found_posts;
    ?>

    <!-- 신청하기 -->
    <?php if (current_user_can('subscriber') || current_user_can('administrator')) : ?>
      <div class="text-right">
        <a class="btn btn-danger" href="#">외부신청</a>
        <?php if ($today <= $date_end && $count_program_apply < $finish_number) : ?>
          <a class="btn btn-dark" href="<?php echo project_homeurl('program-add/?id=') . get_the_id() . '&return=' . $post_type; ?>">신청하기</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
    <!-- //신청하기 -->

    <!-- 내용 -->
    <h1><?php the_title(); ?></h1>
    <figure><?php echo project_featured_image('default.jpg'); ?></figure>
    <p><?php the_content(); ?></p>
    <p>날짜 :
      <?php
      if ($today <= $date_end) {
        echo date('Y년 m월 d일', strtotime($date_start)) . ' ~ ' . date('Y년 m월 d일', strtotime($date_end));
      } else {
        echo '신청 기간이 종료되었습니다.';
      }
      ?>
    </p>
    <p>시간 : <?php echo get_field('program_time')['start'] . ' ~ ' . get_field('program_time')['end']; ?></p>
    <p>장소 : <?php echo get_field('program_space'); ?></p>
    <p>인원수 : <?php echo ($count_program_apply < $finish_number) ? (get_field('program_number') . '명') : '인원수 초과로 마감되었습니다.'; ?></p>
    <p>참가비 : <?php echo get_field('program_money'); ?></p>
    <p class="text-right"><?php the_date(); ?> <?php the_time(); ?></p>
    <!-- //내용 -->

  <?php endwhile; ?>
<?php endif; ?>

<div class="text-center p-5">
  <a href="<?php echo project_homeurl($post_type); ?>" class="btn btn-lg btn-light">캘린더로</a>
</div>

<?php get_template_part('templates/content', 'share'); ?>

<?php get_footer(); ?>