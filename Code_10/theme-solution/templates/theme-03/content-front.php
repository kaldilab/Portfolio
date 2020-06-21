<!-- visual -->
<?php
// get field
$visual = get_field('theme_03_main_visual', 'option');
?>
<section class="section visual">
  <div class="visual__wrap">
    <div class="visual__slider slider swiper-container">
      <div class="swiper-wrapper">
        <?php
        if ($visual) {
          foreach ($visual as $row) {
            $image = (wp_is_mobile()) ? $row['image_mo'] : $row['image_pc'];
            echo '<div class="slider-slide swiper-slide">';
            echo '<div class="slider-bg" style="background-image:url(' . $image . ');"></div>';
            echo '<div class="slider-opacity" style="opacity: ' . $row['opacity'] . ';"></div>';
            echo '<div class="slider-inner">';
            echo '<div class="slider-desc">';
            echo '<h2 class="d1 animated fadeInUp">' . $row['title'] . '</h2>';
            if (wp_is_mobile()) {
              echo '<h3 class="h3">' . $row['subtitle'] . '</h3>';
            }
            echo '<a class="btn" href="' . $row['button_link'] . '">' . $row['button_name'] . '</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
        }
        ?>
      </div>
    </div>
  </div>
  <ul class="visual__list row">
    <?php
    if ($visual) {
      $item_index = 1;
      foreach ($visual as $row) {
        $image = (wp_is_mobile()) ? $row['image_mo'] : $row['image_pc'];
        echo '<li class="visual__item col-4">';
        echo '<div class="thumb" style="background-image:url(' . $image . ');"></div>';
        echo '<div class="wrap">';
        echo '<h4 class="tit animated fadeInUp delay-_' . ($item_index * 2) . 's">' . $row['subtitle'] . '</h4>';
        echo '<a class="link" href="' . $row['button_link'] . '">' . $row['button_name'] . '</a>';
        echo '</div>';
        echo '</li>';
        $item_index++;
      }
    }
    ?>
  </ul>
</section>
<!-- //visual -->

<!-- post-slide -->
<?php
// get field
$post_slide_set = get_field('theme_03_main_post_slide_set', 'option');
$post_slide = get_field('theme_03_main_post_slide', 'option');
?>
<?php if ($post_slide_set) : ?>
  <section class="section post-slide">
    <h2 class="post-slide__title h2">
      <?php echo $post_slide['title']; ?>
    </h2>
    <a class="btn btn-sm btn-ghost" href="<?php echo $post_slide['button_link']; ?>"><?php echo $post_slide['button_name']; ?></a>
    <div class="post-slide__wrap">
      <div class="post-slide__slider swiper-container">
        <div class="swiper-wrapper">
          <?php
          $post_count = 1;
          if ($post_slide['type'] == 'write') {
            $edit = $post_slide['edit'];
            $edit_count = count($edit);
            $page = ceil($edit_count / 5);
            $page_limit = 3;
            $page_check = ($page >= $page_limit) ? $page_limit : $page;
            if ($page) {
              while ($post_count <= $page_check) {
                echo '<div class="swiper-slide">';
                echo '<div class="post-slide__list">';
                $range_post = (5 * $post_count);
                if ($edit) {
                  $post_index = 0;
                  foreach ($edit as $row) {
                    $post_first = $range_post - 5;
                    if ($post_index >= $post_first && $post_index < $range_post) {
                      $thumb = $row['image'];
                      echo '<div class="post-slide__item ' . (($post_index == $post_first) ? 'item-lg' : 'item-sm') . '">';
                      echo '<figure class="thumb">';
                      echo '<img src="' . (($thumb) ? $thumb : project_image_uri('img_default.png')) . '" alt="' . $row['title'] . '">';
                      echo '</figure>';
                      echo '<h3 class="tit">' . $row['title'] . '</h3>';
                      if ($post_index == $post_first) {
                        echo '<p class="desc">' . $row['description'] . '</p>';
                      }
                      echo '<a class="link" href="' . $row['link'] . '">자세히 보기</a>';
                      echo '</div>';
                    }
                    $post_index++;
                  }
                }
                echo '</div>';
                echo '</div>';
                $post_count++;
              }
            } else {
              echo '<div class="swiper-slide none">게시글이 없습니다.</div>';
            }
          } else {
            $args_post_slide = array(
              'post_type' => $post_slide['board'],
              'posts_per_page' => -1,
            );
            if ($post_slide['type'] == 'main') {
              $args_post_slide['meta_key'] = 'board_main';
              $args_post_slide['meta_value'] = '1';
            }
            $query_post_slide = new WP_Query($args_post_slide);
            $query_post_slide_count = $query_post_slide->found_posts;
            $page = ceil($query_post_slide_count / 5);
            $page_limit = 3;
            $page_check = ($page >= $page_limit) ? $page_limit : $page;
            if ($page) {
              while ($post_count <= $page_check) {
                echo '<div class="swiper-slide">';
                echo '<div class="post-slide__list">';
                $range_post = (5 * $post_count);
                if ($query_post_slide->have_posts()) {
                  while ($query_post_slide->have_posts()) {
                    $query_post_slide->the_post();
                    $post_index = $query_post_slide->current_post;
                    $post_first = $range_post - 5;
                    if ($post_index >= $post_first && $post_index < $range_post) {
                      $thumb = get_the_post_thumbnail_url();
                      echo '<div class="post-slide__item ' . (($post_index == $post_first) ? 'item-lg' : 'item-sm') . '">';
                      echo '<figure class="thumb">';
                      echo '<img src="' . (($thumb) ? $thumb : project_image_uri('img_default.png')) . '" alt="' . get_the_title() . '">';
                      echo '</figure>';
                      echo '<h3 class="tit">' . get_the_title() . '</h3>';
                      if ($post_index == $post_first) {
                        echo '<p class="desc">' . get_the_excerpt() . '</p>';
                      }
                      echo '<a class="link" href="' . project_permalink() . '">자세히 보기</a>';
                      echo '</div>';
                    }
                  }
                }
                wp_reset_postdata();
                echo '</div>';
                echo '</div>';
                $post_count++;
              }
            } else {
              echo '<div class="swiper-slide none">게시글이 없습니다.</div>';
            }
          }
          ?>
        </div>
        <div class="post-slide__pagination"></div>
      </div>
      <div class="post-slide__button slider-button swiper-button">
        <div class="post-slide__button--prev slider-button-prev swiper-button-prev"></div>
        <div class="post-slide__button--next slider-button-next swiper-button-next"></div>
      </div>
    </div>
  </section>
<?php endif; ?>
<!-- //post-slide -->

<!-- feature -->
<?php
// get field
$feature_set = get_field('theme_03_main_feature_set', 'option');
$feature = get_field('theme_03_main_feature', 'option');
?>
<?php if ($feature_set) : ?>
  <section class="section feature">
    <h2 class="sr-only">특성글</h2>
    <?php
    if ($feature) {
      $feature_link = $feature['link'];
      echo '<div class="feature__inner">';
      echo '<h3 class="h3">';
      if ($feature['link_set']) {
        echo '<a class="h3" href="' . $feature['link'] . '">' . $feature['title'] . '</a>';
      } else {
        echo $feature['title'];
      }
      echo '</h3>';
      echo '<p class="desc">' . $feature['description'] . '</p>';
      echo '<h6 class="h6">' . $feature['subtitle'] . '</h6>';
      echo '</div>';
    }
    ?>
  </section>
<?php endif; ?>
<!-- //feature -->

<!-- post-col -->
<?php
// get field
$post_col_set = get_field('theme_03_main_post_col_set', 'option');
$post_col = get_field('theme_03_main_post_col', 'option');
?>
<?php if ($post_col_set) : ?>
  <section class="section post-col row">
    <div class="post-col__left col-sm-6">
      <h2 class="post-col__title h2"><?php echo $post_col['title']; ?></h2>
      <p class="post-col__text"><?php echo $post_col['description']; ?></p>
      <a class="btn btn-sm btn-ghost" href="<?php echo $post_col['button_link']; ?>"><?php echo $post_col['button_name']; ?></a>
    </div>
    <div class="post-col__right col-sm-6">
      <?php
      if ($post_col['type'] == 'write') {
        $edit = $post_col['edit'];
        if ($edit) {
          foreach ($edit as $row) {
            echo '<div class="post-col__card">';
            echo '<h4 class="h4">' . $row['title'] . '</h4>';
            echo '<div class="desc">' . $row['description'] . '</div>';
            echo '<a class="link" href="' . $row['link'] . '">자세히 보기</a>';
            echo '</div>';
          }
        } else {
          echo '<li class="post-col__card none">게시글이 없습니다.</li>';
        }
      } else {
        $args_post_col = array(
          'post_type' => $post_col['board'],
          'posts_per_page' => 3,
        );
        if ($post_col['type'] == 'main') {
          $args_post_col['meta_key'] = 'board_main';
          $args_post_col['meta_value'] = '1';
        }
        $query_post_col = new WP_Query($args_post_col);
        if ($query_post_col->have_posts()) {
          while ($query_post_col->have_posts()) {
            $query_post_col->the_post();
            echo '<div class="post-col__card">';
            echo '<h4 class="h4">' . get_the_title() . '</h4>';
            echo '<div class="desc">' . get_the_excerpt() . '</div>';
            echo '<a class="link" href="' . project_permalink() . '">자세히 보기</a>';
            echo '</div>';
          }
        } else {
          echo '<li class="post-col__card none">게시글이 없습니다.</li>';
        }
        wp_reset_postdata();
      }
      ?>
    </div>
  </section>
<?php endif; ?>
<!-- //post-col -->

<script>
  jQuery(document).ready(function($) {

    // visual slider
    if ($('.visual__slider').length) {
      var visualSlider = new Swiper('.visual__slider', {
        effect: 'fade',
        loop: true,
        speed: 1000,
        grabCursor: true,
        autoplay: {
          delay: 6000,
          disableOnInteraction: false,
        },
      });
      $('.visual__item').hover(function() {
        var itemIndex = $(this).index() + 1;
        visualSlider.slideTo(itemIndex);
      });
    }

    // post-slide slider
    if ($('.post-slide__slider').length) {
      var recentSlider = new Swiper('.post-slide__slider', {
        speed: 800,
        spaceBetween: 32,
        navigation: {
          nextEl: '.post-slide__button--next',
          prevEl: '.post-slide__button--prev',
        },
        pagination: {
          el: '.post-slide__pagination',
          clickable: true,
        },
      });
    }

  });
</script>