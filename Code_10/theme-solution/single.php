<?php ob_start(); ?>

<?php get_header(); ?>

<?php
$post_type = get_post_type();
$page_name = str_replace('_', '', $post_type);
$taxonomy = 'tax_' . $post_type;
$post_type_object = get_post_type_object($post_type);
$post_type_title = $post_type_object->label;
$post_type_description = $post_type_object->description;
$blog = ($post_type_description == 'blog') ? true : false;
?>

<?php if (!$blog) : ?>
  <div class="sub__top">
    <h2 class="sub__title"><?php echo $post_type_title; ?></h2>
    <?php get_template_part('templates/content', 'breadcrumb'); ?>
  </div>
<?php endif; ?>

<article class="view <?php echo ($blog) ? ('view-' . $post_type_description) : ''; ?>">

  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

      <?php
      $term = get_the_terms(false, $taxonomy);
      if ($term) {
        $term_name = $term[0]->name;
      }
      $tag_check = wp_get_post_tags($post->ID);
      $file = get_field('board_file');
      $file_name = $file['filename'];
      $file_url = $file['url'];
      $thumbnail = get_the_post_thumbnail_url();
      $thumbnail_view = get_field('board_thumb');
      ?>

      <?php if ($blog) : ?>

        <?php
        // recent
        $args_recent_posts = array(
          'post_type' => $post_type,
          'posts_per_page' => 3,
          'post__not_in' => array($post->ID),
        );
        $query_recent_posts = new WP_Query($args_recent_posts);
        // related
        $related_posts = get_field('board_related');
        ?>

        <!-- blog -->
        <div class="view-inner">
          <div class="view-side">
            <div class="view-head">
              <?php if ($term) : ?>
                <h6 class="view-category"><?php echo $term_name; ?></h6>
              <?php endif; ?>
              <h1 class="view-title"><?php the_title(); ?></h1>
              <p class="view-date"><?php the_date(); ?> <?php the_time(); ?></p>
              <h6 class="view-subtit"><?php the_author(); ?></h6>
            </div>
            <?php if ($file) : ?>
              <div class="view-file">
                <h6 class="view-subtit">첨부파일</h6>
                <span class="file"></span>
                <a class="link" href="<?php echo $file_url; ?>" download><?php echo $file_name; ?></a>
              </div>
            <?php endif; ?>
            <div class="view-share">
              <h6 class="view-subtit">공유하기</h6>
              <div>
                <?php get_template_part('templates/content', 'share'); ?>
              </div>
            </div>
            <?php if ($tag_check) : ?>
              <div class="view-tag">
                <h6 class="view-subtit">태그</h6>
                <div class="view-tags">
                  <?php get_template_part('templates/content', 'tags'); ?>
                </div>
              </div>
            <?php endif; ?>
            <div class="view-recent">
              <h6 class="view-subtit">최근 포스트</h6>
              <div class="board-blog board-recent">
                <?php
                if ($query_recent_posts->have_posts()) {
                  while ($query_recent_posts->have_posts()) {
                    $query_recent_posts->the_post();
                    echo '<ul class="blog-item">';
                    echo '<li class="blog-image">';
                    echo '<a class="blog-link" href="' . project_permalink() . '">';
                    echo project_featured_image('img_default.png');
                    echo '</a>';
                    echo '</li>';
                    echo '<li class="blog-body">';
                    echo '<a class="blog-link" href="' . project_permalink() . '">';
                    echo '<p class="tit">' . get_the_title() . '</p>';
                    echo '</a>';
                    echo '<p class="date">' . get_the_date() . ' ' . get_the_time() . '</p>';
                    echo '</li>';
                    echo '</ul>';
                  }
                } else {
                  echo '<ul class="blog-item none">최근 포스트가 없습니다.</ul>';
                }
                wp_reset_postdata();
                ?>
              </div>
            </div>
            <div class="view-gotolist">
              <a class="btn" href="<?php echo project_homeurl('/' . $page_name); ?>">목록 보기</a>
            </div>
          </div>
          <div class="view-article">
            <div class="view-body">
              <?php if ($thumbnail && $thumbnail_view) : ?>
                <figure class="view-figure">
                  <img class="thumb" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                </figure>
              <?php endif; ?>
              <div class="view-content"><?php the_content(); ?></div>
            </div>
          </div>
        </div>
        <div class="view-related">
          <h6 class="view-subtit">관련 포스트</h6>
          <ul class="board-card row">
            <?php
            if ($related_posts) {
              foreach ($related_posts as $post) {
                setup_postdata($post);
                $tax = 'tax_' . get_post_type();
                $terms = get_the_terms(false, $tax);
                $term = ($terms) ? ('<span class="cat"><strong>' . $terms[0]->name . '</strong></span>') : '';
                echo '<li class="card-item col-sm-4">';
                echo '<a class="card-link" href="' . project_permalink() . '">';
                echo '<div class="card-image">';
                echo project_featured_image('img_default.png');
                echo $term;
                echo '</div>';
                echo '<div class="card-body">';
                echo '<div class="tit">' . get_the_title() . '</div>';
                echo '<div class="desc">' . get_the_excerpt() . '</div>';
                echo '</div>';
                echo '</a>';
                echo '<div class="card-foot">' . get_the_date() . ' ' . get_the_time() . '</div>';
                echo '</li>';
              }
            } else {
              echo '<li class="card-item col-12 none">관련 포스트가 없습니다.</li>';
            }
            wp_reset_postdata();
            ?>
          </ul>
        </div>
        <!-- //blog -->

      <?php else : ?>

        <!-- general -->
        <div class="view-head">
          <?php if ($term) : ?>
            <h6 class="view-category"><?php echo $term_name; ?></h6>
          <?php endif; ?>
          <h1 class="view-title"><?php the_title(); ?></h1>
          <p class="view-date"><?php the_date(); ?> <?php the_time(); ?></p>
          <h6 class="view-subtit"><?php the_author(); ?></h6>
          <div class="view-share">
            <?php get_template_part('templates/content', 'share'); ?>
          </div>
        </div>
        <?php if ($file) : ?>
          <div class="view-file">
            <span class="file"></span>
            <h6 class="view-subtit">첨부파일 : </h6>
            <a class="link" href="<?php echo $file_url; ?>" download><?php echo $file_name; ?></a>
          </div>
        <?php endif; ?>
        <div class="view-body">
          <?php if ($thumbnail && $thumbnail_view) : ?>
            <figure class="view-figure">
              <img class="thumb" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
            </figure>
          <?php endif; ?>
          <div class="view-content"><?php the_content(); ?></div>
        </div>
        <div class="view-gotolist">
          <a class="btn" href="<?php echo project_homeurl('/' . $page_name); ?>">목록 보기</a>
        </div>
        <div class="view-prevnext">
          <?php get_template_part('templates/content', 'prevnext'); ?>
        </div>
        <!-- //general -->

      <?php endif; ?>

    <?php endwhile; ?>
  <?php endif; ?>

</article>


<?php get_footer(); ?>

<?php ob_end_flush(); ?>