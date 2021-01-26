<?php get_header(); ?>

<?php get_template_part('templates/content', 'breadcrumb_product'); ?>

<?php
$office_visual = get_field('office_visual');
$office_visual_keyvisual = $office_visual['keyvisual'];
$office_spec = get_field('office_spec');
$office_spec_seperate = $office_spec['seperate'];
$office_key_feature = get_field('office_key_feature');
$office_sub_feature = get_field('office_sub_feature');
$office_catalog = get_field('office_catalog');
$office_catalog_toggle = $office_catalog['catalog_toggle'];
$office_catalog_file = $office_catalog['catalog_file'];
$office_layout = get_field('office_layout');
$office_layout_toggle = $office_layout['layout_toggle'];
$office_layout_image = $office_layout['layout_image'];
?>

<div class="sub__top top_visual top_office">
  <div class="top_visual__slider swiper-container">
    <div class="swiper-wrapper">
      <?php
      if ($office_visual_keyvisual) {
        foreach ($office_visual_keyvisual as $row) {
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
          <p class="h3-en"><?php echo $office_visual['subcopy']; ?></p>
        </div>
      </div>
    </div>
    <div class="swiper-pagination"></div>
    <?php
    if($office_visual['award_toggle']) {
      echo '<img class="top_visual__if_logo" src="' . $office_visual['award_logo'] . '" alt="Award">';
    }
    ?>
  </div>
</div>

<section class="sub__spec">
  <div class="sub__spec--text">
    <h3 class="tit tit_office"><?php echo $office_spec['headcopy']; ?></strong></h3>
    <p class="desc"><?php echo $office_spec['subcopy']; ?></p>
  </div>
  <div class="sub__spec--figure">
    <img class="pc" src="<?php echo $office_spec_seperate['image_pc']; ?>" alt="<?php the_title(); ?>">
    <img class="mo" src="<?php echo $office_spec_seperate['image_mo']; ?>" alt="<?php the_title(); ?>">
  </div>
</section>

<div class="sub__inner">

  <!-- office-catalog -->
  <section class="section office-catalog">
    <h3 class="sr-only">CATALOG</h3>
    <div class="section__cont">
      <?php
      if ($office_key_feature) {
        foreach ($office_key_feature as $row) {
          $image = $row['image'];
          echo '<ul class="office-catalog__list">';
          echo '<li class="office-catalog__item item_image">';
          echo '<figure class="thumb">';
          echo '<img class="img-fluid pc" src="' . $image['image_pc'] . '" alt="' . $row['title'] . '">';
          echo '<img class="img-fluid mo" src="' . $image['image_mo'] . '" alt="' . $row['title'] . '">';
          echo '</figure>';
          echo '</li>';
          echo '<li class="office-catalog__item item_text">';
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
  <!-- //office-catalog -->

  <!-- office-feature -->
  <section class="section office-feature">
    <h3 class="section__title">FEATURE</h3>
    <div class="swiper-button slider-button office-feature-button">
      <div class="swiper-button-prev slider-button-prev office-feature-button-prev"></div>
      <div class="swiper-button-next slider-button-next office-feature-button-next"></div>
    </div>
    <div class="office-feature__slider swiper-container">
      <div class="swiper-wrapper">
        <?php
        if ($office_sub_feature) {
          $index = 1;
          foreach ($office_sub_feature as $row) {
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
      <div class="swiper-pagination slider-pagination office-feature-pagination"></div>
    </div>
  </section>
  <!-- //office-feature -->

  <!-- office-download -->
  <?php if($office_catalog_toggle) : ?>
  <section class="section office-download">
    <h3 class="sr-only">Catalog Download</h3>
    <div class="section__cont">
      <h4 class="office-download__title"><?php the_title(); ?></h4>
      <p class="office-download__description">카탈로그를 다운받으시려면 다운로드 버튼을 클릭해주세요.</p>
      <a class="office-download__button" href="<?php echo $office_catalog_file; ?>" download>카탈로그 다운로드</a>
    </div>
  </section>
  <?php endif; ?>
  <!-- //office-download -->

  <!-- office-layout -->
  <?php if($office_layout_toggle) : ?>
  <section class="section office-layout">
    <h3 class="section__title">LAYOUT</h3>
    <div class="swiper-button slider-button office-layout-button">
      <div class="swiper-button-prev slider-button-prev office-layout-button-prev"></div>
      <div class="swiper-button-next slider-button-next office-layout-button-next"></div>
    </div>
    <div class="office-layout__slider swiper-container">
      <div class="swiper-wrapper">
        <?php
        if ($office_layout_image) {
          foreach ($office_layout_image as $row) {
            echo '<div class="swiper-slide">';
            echo '<figure class="thumb"><img class="img-fluid" src="' . $row['image'] . '" alt="Layout"></figure>';
            echo '</div>';
          }
        }
        ?>
      </div>
      <div class="swiper-pagination slider-pagination office-layout-pagination"></div>
    </div>
  </section>
  <?php endif; ?>
  <!-- //office-layout -->

</div>

<?php get_footer(); ?>