<?php get_header(); ?>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php $post_type = $post->post_type; ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>

    <!-- 내용 -->
    <h1><?php the_title(); ?></h1>
    <figure><?php echo project_featured_image('default.jpg'); ?></figure>
    <p><?php the_content(); ?></p>
    <p class="text-right"><?php the_date(); ?> <?php the_time(); ?></p>
    <?php
    $file = get_field('board_admin_file');
    if ($file) {
      $count_file = the_attachment($file);
      $get_count_file = get_sw_counter($file);
      echo '<p><strong>[다운로드]</strong> : <a href="' . $file['url'] . '" download>' . $file['filename'] . '</a></p>';
      echo '<p><strong>[카운트용 다운로드]</strong> : ' . $count_file . '</p>';
      echo '<p><strong>[다운로드 카운트]</strong> : ' . (($get_count_file) ? $get_count_file : '0') . '회 다운로드</p>';
      if ($file['subtype'] == 'pdf') {
        echo '<p><strong>[뷰어로 보기]</strong> : <a href="' . get_template_directory_uri() . '/node_modules/pdfjs-dist-viewer-min/build/minified/web/viewer.html?file=' . $file['url'] . '" target="_blank">' . $file['filename'] . '</a></p>';
        echo '<p><strong>[프레임으로 보기]</strong> :</p>';
        echo '<div style="height: 700px;">';
        echo '<iframe src="' . get_template_directory_uri() . '/node_modules/pdfjs-dist-viewer-min/build/minified/web/viewer.html?file=' . $file['url'] . '" frameborder="0" width="100%" height="100%"></iframe>';
        echo '</div>';
      }
    } else {
      echo '[첨부파일이 없습니다.]';
    }
    ?>
    <!-- //내용 -->

  <?php endwhile; ?>
<?php endif; ?>

<div class="text-center p-5">
  <a href="<?php echo project_homeurl($post_type); ?>" class="btn btn-lg btn-light">목록으로</a>
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