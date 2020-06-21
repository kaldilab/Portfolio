<!-- visual -->
<?php
// get field
$visual = get_field('theme_01_main_visual', 'option');
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
          echo '<a class="slider-link" href="' . $row['link'] . '">';
          echo '<div class="slider-desc">';
          echo '<h2 class="d1 animated fadeInUp">' . $row['title'] . '</h2>';
          echo '<h3 class="h3 animated fadeInUp delay-_3s">' . $row['subtitle'] . '</h3>';
          echo '<h5 class="h5_left animated fadeIn delay-_6s">' . $row['description'] . '</h5>';
          echo '</div>';
          echo '</a>';
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

<!-- post-col -->
<?php
// get field
$post_col_set = get_field('theme_01_main_post_col_set', 'option');
$post_col = get_field('theme_01_main_post_col', 'option');
?>
<?php if ($post_col_set) : ?>
  <section class="section post-col">
    <h2 class="post-col__title h2 opacity-0"><?php echo $post_col['title']; ?></h2>
    <p class="post-col__text"><?php echo $post_col['description']; ?></p>
    <ul class="post-col__list board__list board-card row">
      <?php
      if ($post_col['type'] == 'write') {
        $edit = $post_col['edit'];
        if ($edit) {
          foreach ($edit as $row) {
            $thumb = $row['image'];
            echo '<li class="board__item card-item col-sm-4">';
            echo '<a class="card-link" href="' . $row['link'] . '">';
            echo '<div class="card-image">';
            echo '<img class="thumb" src="' . (($thumb) ? $thumb : project_image_uri('img_default.png')) . '" alt="' . $row['title'] . '">';
            echo '</div>';
            echo '<div class="card-body">';
            echo '<h4 class="h4">' . $row['title'] . '</h4>';
            echo '<div class="desc">' . $row['description'] . '</div>';
            echo '</div>';
            echo '</a>';
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
            $tax = 'tax_' . get_post_type();
            $terms = get_the_terms(false, $tax);
            $term = ($terms) ? ('<span class="cat"><strong>' . $terms[0]->name . '</strong></span>') : '';
            echo '<li class="board__item card-item col-sm-4">';
            echo '<a class="card-link" href="' . project_permalink() . '">';
            echo '<div class="card-image">';
            echo project_featured_image('img_default.png');
            echo $term;
            echo '</div>';
            echo '<div class="card-body">';
            echo '<h4 class="h4">' . get_the_title() . '</h4>';
            echo '<div class="desc">' . get_the_excerpt() . '</div>';
            echo '</div>';
            echo '</a>';
            echo '<div class="card-foot">' . get_the_date() . ' ' . get_the_time() . '</div>';
            echo '</li>';
          }
        } else {
          echo '<li class="board__item card-item col-12 none">게시글이 없습니다.</li>';
        }
        wp_reset_postdata();
      }
      ?>
    </ul>
    <div class="post-col__more">
      <a class="btn btn-ghost" href="<?php echo $post_col['button_link']; ?>"><?php echo $post_col['button_name']; ?></a>
    </div>
  </section>
<?php endif; ?>
<!-- //post-col -->

<!-- post-slide -->
<?php
// get field
$post_slide_set = get_field('theme_01_main_post_slide_set', 'option');
$post_slide = get_field('theme_01_main_post_slide', 'option');
?>
<?php if ($post_slide_set) : ?>
  <section class="section post-slide">
    <div class="post-slide__wrap">
      <div class="post-slide__inner">
        <h2 class="post-slide__title h2"><?php echo $post_slide['title']; ?></h2>
        <p class="post-slide__text"><?php echo $post_slide['description']; ?></p>
        <div class="post-slide__slider swiper swiper-container">
          <div class="swiper-wrapper">
            <?php
            if ($post_slide['type'] == 'write') {
              $edit = $post_slide['edit'];
              if ($edit) {
                foreach ($edit as $row) {
                  $thumb = $row['image'];
                  echo '<div class="swiper-slide">';
                  echo '<a class="link" href="' . $row['link'] . '">';
                  echo '<div class="image">';
                  echo '<img class="thumb" src="' . (($thumb) ? $thumb : project_image_uri('img_default.png')) . '" alt="' . $row['title'] . '">';
                  echo '</div>';
                  echo '<div class="text">';
                  echo '<div class="tit">' . $row['title'] . '</div>';
                  echo '<div class="desc">' . $row['description'] . '</div>';
                  echo '<div class="go">자세히 보기</div>';
                  echo '</div>';
                  echo '</a>';
                  echo '</div>';
                }
              } else {
                echo '<div class="swiper-slide none">게시글이 없습니다.</div>';
              }
            } else {
              $args_post_slide = array(
                'post_type' => $post_slide['board'],
                'posts_per_page' => 8,
              );
              if ($post_slide['type'] == 'main') {
                $args_post_slide['meta_key'] = 'board_main';
                $args_post_slide['meta_value'] = '1';
              }
              $query_post_slide = new WP_Query($args_post_slide);
              if ($query_post_slide->have_posts()) {
                while ($query_post_slide->have_posts()) {
                  $query_post_slide->the_post();
                  echo '<div class="swiper-slide">';
                  echo '<a class="link" href="' . project_permalink() . '">';
                  echo '<div class="image">';
                  echo project_featured_image('img_default.png');
                  echo '</div>';
                  echo '<div class="text">';
                  echo '<div class="tit">' . get_the_title() . '</div>';
                  echo '<div class="desc">' . get_the_excerpt() . '</div>';
                  echo '<div class="go">자세히 보기</div>';
                  echo '</div>';
                  echo '</a>';
                  echo '</div>';
                }
              } else {
                echo '<div class="swiper-slide none">게시글이 없습니다.</div>';
              }
              wp_reset_postdata();
            }
            if (!wp_is_mobile()) {
              echo '<div class="swiper-slide"></div>';
              echo '<div class="swiper-slide"></div>';
            }
            ?>
          </div>
        </div>
        <div class="post-slide__button swiper-button">
          <div class="post-slide__button--prev swiper-button-prev"></div>
          <div class="post-slide__pagination swiper-pagination"></div>
          <div class="post-slide__button--next swiper-button-next"></div>
        </div>
        <div class="post-slide__more">
          <a class="btn btn-ghost" href="<?php echo $post_slide['button_link']; ?>"><?php echo $post_slide['button_name']; ?></a>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>
<!-- //post-slide -->

<!-- feature -->
<?php
// get field
$feature_set = get_field('theme_01_main_feature_set', 'option');
$feature = get_field('theme_01_main_feature', 'option');
?>
<?php if ($feature_set) : ?>
  <section class="section feature">
    <h2 class="sr-only">특성글</h2>
    <ul class="feature__list row">
      <?php
      if ($feature) {
        foreach ($feature as $row) {
          echo '<li class="feature__item col-sm-6">';
          echo '<div class="feature__inner">';
          echo '<h4 class="h4">' . $row['title'] . '</h4>';
          echo '<div class="desc">' . $row['description'] . '</div>';
          echo '<a class="link" href="' . $row['link'] . '">자세히 보기</a>';
          echo '</div>';
          echo '</li>';
        }
      }
      ?>
    </ul>
  </section>
<?php endif; ?>
<!-- //feature -->

<!-- banner -->
<?php
// get field
$banner_set = get_field('theme_01_main_banner_set', 'option');
$banner = get_field('theme_01_main_banner', 'option');
?>
<?php if ($banner_set) : ?>
  <section class="section banner">
    <h2 class="sr-only">정보</h2>
    <?php
    if ($banner) {
      echo '<div class="information inform-tel">';
      echo '<div class="left">';
      echo '<h5 class="h5_left">' . $banner['title'] . '</h5>';
      echo '<p class="desc">' . $banner['description'] . '</p>';
      echo '</div>';
      echo '<div class="right">';
      echo '<span>' . $banner['tel_name'] . '</span>';
      echo '<strong>' . $banner['tel_number'] . '</strong>';
      echo '</div>';
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
        speed: 800,
        grabCursor: true,
        slidesPerView: 'auto',
        spaceBetween: 32,
        navigation: {
          nextEl: '.post-slide__button--next',
          prevEl: '.post-slide__button--prev',
        },
        pagination: {
          el: '.post-slide__pagination',
          type: 'fraction',
        },
      });
    }

  });
</script>