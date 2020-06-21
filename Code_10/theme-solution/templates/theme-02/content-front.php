<!-- visual -->
<?php
// get field
$visual = get_field('theme_02_main_visual', 'option');
?>
<section class="section visual">
  <div class="visual__slider slider swiper-container">
    <div class="swiper-wrapper">
      <?php
      if ($visual) {
        foreach ($visual as $row) {
          $image = (wp_is_mobile()) ? $row['image_mo'] : $row['image_pc'];
          echo '<div class="slider-slide swiper-slide" style="background-image:url(' . $image . ');">';
          echo '<div class="slider-opacity" style="opacity: ' . $row['opacity'] . ';"></div>';
          echo '<div class="slider-inner">';
          echo '<div class="slider-desc">';
          echo '<h2 class="d2 animated fadeInUp">' . $row['title'] . '</h2>';
          echo '<h5 class="h5_left animated fadeInUp delay-_5s">' . $row['description'] . '</h5>';
          echo '<a class="btn" href="' . $row['button_link'] . '">' . $row['button_name'] . '</a>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
      }
      ?>
    </div>
    <div class="visual__button slider-button swiper-button">
      <div class="visual__button--prev slider-button-prev swiper-button-prev"></div>
      <div class="visual__button--next slider-button-next swiper-button-next"></div>
    </div>
    <div class="visual__pagination slider-pagination swiper-pagination"></div>
  </div>
</section>
<!-- //visual -->

<!-- post-slide -->
<?php
// get field
$post_slide_set = get_field('theme_02_main_post_slide_set', 'option');
$post_slide = get_field('theme_02_main_post_slide', 'option');
$post_slide_tabmenu = $post_slide['tab'];
?>
<?php if ($post_slide_set) : ?>
  <section class="section post-slide">
    <h2 class="post-slide__title h2 opacity-0"><?php echo $post_slide['title']; ?></h2>
    <div class="post-slide__pagination swiper-pagination"></div>
    <div class="post-slide__wrap">
      <div class="post-slide__slider slider swiper-container">
        <div class="swiper-wrapper">
          <?php
          if ($post_slide['type'] == 'write') {
            $edit = $post_slide['edit'];
            if ($edit) {
              foreach ($edit as $row) {
                $thumb = $row['image'];
                echo '<div class="slider-slide swiper-slide">';
                echo '<div class="slider-inner row">';
                echo '<div class="left col-sm-6">';
                echo '<figure class="thumb">';
                echo '<img src="' . (($thumb) ? $thumb : project_image_uri('img_default.png')) . '" alt="' . $row['title'] . '">';
                echo '</figure>';
                echo '</div>';
                echo '<div class="right col-sm-6">';
                echo '<h3 class="h3">' . $row['title'] . '</h3>';
                echo '<p class="desc">' . $row['description'] . '</p>';
                echo '<a class="btn btn-sm" href="' . $row['link'] . '">자세히 보기</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }
            }
          } else {
            $args_post_slide = array(
              'post_type' => $post_slide['board'],
              'posts_per_page' => 5,
            );
            if ($post_slide['type'] == 'main') {
              $args_post_slide['meta_key'] = 'board_main';
              $args_post_slide['meta_value'] = '1';
            }
            $query_post_slide = new WP_Query($args_post_slide);
            if ($query_post_slide->have_posts()) {
              while ($query_post_slide->have_posts()) {
                $query_post_slide->the_post();
                $thumb = get_the_post_thumbnail_url();
                echo '<div class="slider-slide swiper-slide">';
                echo '<div class="slider-inner row">';
                echo '<div class="left col-sm-6">';
                echo '<figure class="thumb">';
                echo '<img src="' . (($thumb) ? $thumb : project_image_uri('img_default.png')) . '" alt="' . get_the_title() . '">';
                echo '</figure>';
                echo '</div>';
                echo '<div class="right col-sm-6">';
                echo '<h3 class="h3">' . get_the_title() . '</h3>';
                echo '<p class="desc">' . get_the_excerpt() . '</p>';
                echo '<a class="btn btn-sm" href="' . project_permalink() . '">자세히 보기</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }
            } else {
              echo '<div class="swiper-slide none">게시글이 없습니다.</div>';
            }
            wp_reset_postdata();
          }
          ?>
        </div>
        <div class="post-slide__button slider-button swiper-button">
          <div class="post-slide__button--prev slider-button-prev swiper-button-prev"></div>
          <div class="post-slide__button--next slider-button-next swiper-button-next"></div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>
<!-- //post-slide -->

<!-- feature -->
<?php
// get field
$feature_set = get_field('theme_02_main_feature_set', 'option');
$feature = get_field('theme_02_main_feature', 'option');
?>
<?php if ($feature_set) : ?>
  <section class="section feature">
    <h2 class="sr-only">특성글</h2>
    <?php
    if ($feature) {
      $feature_link = $feature['link'];
      echo '<div class="feature__inner row">';
      echo '<div class="left col-sm-6">';
      echo '<h3 class="h3">';
      if ($feature['link_set']) {
        echo '<a class="h3" href="' . $feature['link'] . '">' . $feature['title'] . '</a>';
      } else {
        echo $feature['title'];
      }
      echo '</h3>';
      echo '</div>';
      echo '<div class="right col-sm-6">';
      echo '<p class="desc">' . $feature['description'] . '</p>';
      echo '</div>';
      echo '</div>';
    }
    ?>
  </section>
<?php endif; ?>
<!-- //feature -->

<!-- post-col -->
<?php
// get field
$post_col_set = get_field('theme_02_main_post_col_set', 'option');
$post_col = get_field('theme_02_main_post_col', 'option');
?>
<?php if ($post_col_set) : ?>
  <section class="section post-col">
    <h2 class="post-col__title h2"><?php echo $post_col['title']; ?></h2>
    <ul class="post-col__list list-circle row">
      <?php
      if ($post_col['type'] == 'write') {
        $edit = $post_col['edit'];
        if ($edit) {
          foreach ($edit as $row) {
            $thumb = $row['image'];
            echo '<li class="circle-item col-sm-4">';
            echo '<figure class="thumb">';
            echo '<img src="' . (($thumb) ? $thumb : project_image_uri('img_default.png')) . '" alt="' . $row['title'] . '">';
            echo '</figure>';
            echo '<h4 class="h4">' . $row['title'] . '</h4>';
            echo '<p class="desc">' . $row['description'] . '</p>';
            echo '<a class="btn btn-xs" href="' . $row['link'] . '">자세히 보기</a>';
            echo '</li>';
          }
        } else {
          echo '<li class="board__item card-item col-12 none">게시글이 없습니다.</li>';
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
            $thumb = get_the_post_thumbnail_url();
            echo '<li class="circle-item col-sm-4">';
            echo '<figure class="thumb">';
            echo '<img src="' . (($thumb) ? $thumb : project_image_uri('img_default.png')) . '" alt="' . get_the_title() . '">';
            echo '</figure>';
            echo '<h4 class="h4">' . get_the_title() . '</h4>';
            echo '<p class="desc">' . get_the_excerpt() . '</p>';
            echo '<a class="btn btn-xs" href="' . project_permalink() . '">자세히 보기</a>';
            echo '</li>';
          }
        } else {
          echo '<li class="circle-item col-12 none">게시글이 없습니다.</li>';
        }
        wp_reset_postdata();
      }
      ?>
    </ul>
  </section>
<?php endif; ?>
<!-- //post-col -->

<!-- banner -->
<?php
// get field
$banner_set = get_field('theme_02_main_banner_set', 'option');
$banner = get_field('theme_02_main_banner', 'option');
?>
<?php if ($banner_set) : ?>
  <section class="section banner">
    <h2 class="sr-only">정보</h2>
    <?php
    if ($banner) {
      $image = (wp_is_mobile()) ? $banner['image_mo'] : $banner['image_pc'];
      echo '<div class="bg" style="background-image:url(' . $image . ');"></div>';
      echo '<div class="banner__inner">';
      echo '<h3 class="h3">' . $banner['title'] . '</h3>';
      echo '<p class="desc">' . $banner['description'] . '</p>';
      echo '<a class="btn" href="' . $banner['button_link'] . '">' . $banner['button_name'] . '</a>';
      echo '</div>';
    }
    ?>
  </section>
<?php endif; ?>
<!-- //banner -->

<script>
  jQuery(document).ready(function($) {

    // visual slider
    if ($('.visual__slider').length) {
      var visualSlider = new Swiper('.visual__slider', {
        loop: true,
        speed: 1000,
        grabCursor: true,
        autoplay: {
          delay: 5000,
          disableOnInteraction: false,
        },
        navigation: {
          nextEl: '.visual__button--next',
          prevEl: '.visual__button--prev',
        },
        pagination: {
          el: '.visual__pagination',
          clickable: true,
        },
      });
    }

    // post-slide slider
    if ($('.post-slide__slider').length) {
      var recentSlider = new Swiper('.post-slide__slider', {
        speed: 1000,
        grabCursor: true,
        autoplay: {
          delay: 8000,
          disableOnInteraction: false,
        },
        navigation: {
          nextEl: '.post-slide__button--next',
          prevEl: '.post-slide__button--prev',
        },
        pagination: {
          el: '.post-slide__pagination',
          clickable: true,
          renderBullet: function(index, className) {
            var tabmenu = <?php echo json_encode($post_slide_tabmenu); ?>;
            if (tabmenu[index].name) {
              menu = tabmenu[index].name;
            } else {
              menu = (index + 1);
            }
            return '<span class="' + className + '">' + menu + '</span>';
          },
        },
      });
    }

  });
</script>