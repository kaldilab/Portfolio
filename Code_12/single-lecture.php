<?php get_header(); ?>

<?php get_template_part('templates/content', 'breadcrumb_product'); ?>

<?php
$lecture_visual = get_field('lecture_visual');
$lecture_visual_keyvisual = $lecture_visual['keyvisual'];
$lecture_spec = get_field('lecture_spec');
$lecture_spec_seperate = $lecture_spec['seperate'];
$lecture_key_feature = get_field('lecture_key_feature');
$lecture_sub_feature = get_field('lecture_sub_feature');
$lecture_catalog = get_field('lecture_catalog');
$lecture_catalog = get_field('lecture_catalog');
$lecture_catalog_toggle = $lecture_catalog['catalog_toggle'];
$lecture_catalog_file = $lecture_catalog['catalog_file'];
$lecture_layout = get_field('lecture_layout');
$lecture_layout_toggle = $lecture_layout['layout_toggle'];
$lecture_layout_image = $lecture_layout['layout_image'];
?>

<div class="sub__top top_visual top_lecture">
  <div class="top_visual__slider swiper-container">
    <div class="swiper-wrapper">
      <?php
      if ($lecture_visual_keyvisual) {
        foreach ($lecture_visual_keyvisual as $row) {
          $video_toggle = $row['video_toggle'];
          echo '<div class="swiper-slide ' . $row['subcopy_color'] . ($video_toggle ? ' video-slide' : '') . '"' . ($video_toggle ? '' : ' data-swiper-autoplay="6000"') . '>';
          if($video_toggle) {
            $video_file = $row['video_file'];
            echo '<div class="top_visual__video">';
            echo '<video class="visual-video" muted playsinline>';
            echo '<source type="video/mp4" src="'. project_video_uri($video_file) .'">';
            echo '</video>';
            echo '<button class="btn btn_sound muted"><span class="text-hide">소리</span></button>';
            echo '</div>';
          } else {
            echo '<div class="top_visual__bg pc" style="background-image:url(' . $row['image_pc'] . ');"></div>';
            echo '<div class="top_visual__bg mo" style="background-image:url(' . $row['image_mo'] . ');"></div>';
          }
          echo '</div>';
        }
      }
      ?>
    </div>
    <div class="top_visual__inner">
      <div class="sub__top--inner">
        <div class="text_wrap">
          <h2 class="tit">
            <?php
            $title = get_the_title();
            $pattern = '/[\xE0-\xFF][\x80-\xFF][\x80-\xFF]/';
            $result = preg_replace($pattern, '<span>$0</span>', $title);
            echo $result;
            ?>
          </h2>
          <p class="h3-en"><?php echo $lecture_visual['subcopy']; ?></p>
        </div>
      </div>
    </div>
    <div class="swiper-pagination"></div>
    <?php
    if($lecture_visual['award_toggle']) {
      echo '<img class="top_visual__if_logo" src="' . $lecture_visual['award_logo'] . '" alt="Award">';
    }
    ?>
  </div>
</div>

<section class="sub__spec">
  <div class="sub__spec--text">
    <h3 class="tit tit_lecture"><?php echo $lecture_spec['headcopy']; ?></strong></h3>
    <p class="desc"><?php echo $lecture_spec['subcopy']; ?></p>
  </div>
  <div class="sub__spec--figure">
    <img class="pc" src="<?php echo $lecture_spec_seperate['image_pc']; ?>" alt="<?php the_title(); ?>">
    <img class="mo" src="<?php echo $lecture_spec_seperate['image_mo']; ?>" alt="<?php the_title(); ?>">
  </div>
</section>

<div class="sub__inner">

  <!-- lecture-catalog -->
  <section class="section lecture-catalog">
    <h3 class="sr-only">CATALOG</h3>
    <div class="section__cont">
      <?php
      if ($lecture_key_feature) {
        foreach ($lecture_key_feature as $row) {
          $image = $row['image'];
          echo '<ul class="lecture-catalog__list">';
          echo '<li class="lecture-catalog__item item_image">';
          echo '<figure class="thumb">';
          echo '<img class="img-fluid pc" src="' . $image['image_pc'] . '" alt="' . $row['title'] . '">';
          echo '<img class="img-fluid mo" src="' . $image['image_mo'] . '" alt="' . $row['title'] . '">';
          echo '</figure>';
          echo '</li>';
          echo '<li class="lecture-catalog__item item_text">';
          echo '<span class="tit_01">' . $row['title'] . '</span>';
          echo '<p class="txt">' . $row['headcopy'] . '</p>';
          echo '<p class="desc">' . $row['subcopy'] . '</p>';
          if($row['layout_toggle']) {
            echo '<span class="tit_02">LAYOUT</span>';
            echo '<img class="fig" src="' . $row['layout_image']. '" alt="Layout">';
          }
          echo '</li>';
          echo '</ul>';
        }
      }
      ?>
    </div>
  </section>
  <!-- //lecture-catalog -->

  <!-- lecture-feature -->
  <section class="section lecture-feature">
    <h3 class="section__title">FEATURE</h3>
    <div class="swiper-button slider-button lecture-feature-button">
      <div class="swiper-button-prev slider-button-prev lecture-feature-button-prev"></div>
      <div class="swiper-button-next slider-button-next lecture-feature-button-next"></div>
    </div>
    <div class="lecture-feature__slider swiper-container">
      <div class="swiper-wrapper">
        <?php
        if ($lecture_sub_feature) {
          $index = 1;
          foreach ($lecture_sub_feature as $row) {
            $index_digits = str_pad(strval($index), 2, '0', STR_PAD_LEFT);
            echo '<div class="swiper-slide">';
            echo '<figure class="thumb">';
            echo '<img class="img-fluid" src="' . $row['image'] . '" alt="Feature">';
            echo '</figure>';
            echo '<h5 class="tit"><span>' . $index_digits . '</span>' . $row['title'] . '</h5>';
            echo '<p class="desc">' . $row['description'] . '</p>';
            echo '</div>';
            $index++;
          }
        }
        ?>
      </div>
      <div class="swiper-pagination slider-pagination lecture-feature-pagination"></div>
    </div>
  </section>
  <!-- //lecture-feature -->

  <!-- lecture-download -->
  <?php if($lecture_catalog_toggle) : ?>
  <section class="section lecture-download">
    <h3 class="sr-only">Catalog Download</h3>
    <div class="section__cont">
      <h4 class="lecture-download__title"><?php the_title(); ?></h4>
      <p class="lecture-download__description">카탈로그를 다운받으시려면 다운로드 버튼을 클릭해주세요.</p>
      <a class="lecture-download__button" href="<?php echo $lecture_catalog_file; ?>" download>카탈로그 다운로드</a>
    </div>
  </section>
  <?php endif; ?>
  <!-- //lecture-download -->

  <!-- lecture-layout -->
  <?php if($lecture_layout_toggle) : ?>
  <section class="section lecture-layout">
    <h3 class="section__title">LAYOUT</h3>
    <div class="swiper-button slider-button lecture-layout-button">
      <div class="swiper-button-prev slider-button-prev lecture-layout-button-prev"></div>
      <div class="swiper-button-next slider-button-next lecture-layout-button-next"></div>
    </div>
    <div class="lecture-layout__slider swiper-container">
      <div class="swiper-wrapper">
        <?php
        if ($lecture_layout_image) {
          foreach ($lecture_layout_image as $row) {
            echo '<div class="swiper-slide">';
            echo '<figure class="thumb"><img class="img-fluid" src="' . $row['image'] . '" alt="Layout"></figure>';
            echo '</div>';
          }
        }
        ?>
      </div>
      <div class="swiper-pagination slider-pagination lecture-layout-pagination"></div>
    </div>
  </section>
  <?php endif; ?>
  <!-- //lecture-layout -->

</div>

<?php get_footer(); ?>