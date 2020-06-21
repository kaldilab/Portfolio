<?php get_header(); ?>

<div class="sub__top">
  <h2 class="sub__title"><?php the_title(); ?></h2>
  <?php get_template_part('templates/content', 'breadcrumb'); ?>
</div>

<?php
// get field
$business_slider_set = get_field('business_slider_set', 'option');
$business_slider = get_field('business_slider', 'option');
$business_list_tile_set = get_field('business_list_tile_set', 'option');
$business_list_tile = get_field('business_list_tile', 'option');
$business_list_circle_set = get_field('business_list_circle_set', 'option');
$business_list_circle = get_field('business_list_circle', 'option');
$business_information_set = get_field('business_information_set', 'option');
$business_information = get_field('business_information', 'option');
?>

<!-- slider -->
<?php if ($business_slider_set) : ?>
  <section class="section business busivis">
    <div class="busivis__slider slider swiper-container">
      <div class="swiper-wrapper">
        <?php
        if ($business_slider) {
          foreach ($business_slider as $row) {
            $link_set = $row['link_set'];
            echo '<div class="slider-slide swiper-slide" style="background-image:url(' . ((wp_is_mobile()) ? $row['image_mo'] : $row['image_pc']) . ');">';
            echo '<div class="slider-inner">';
            if ($link_set) {
              echo '<a class="slider-link" href="' . $row['link'] . '">';
            }
            echo '<div class="slider-desc">';
            echo '<h2 class="d1">' . $row['title'] . '</h2>';
            echo '<h3 class="h3">' . $row['subtitle'] . '</h3>';
            echo '<h5 class="h5_left">' . $row['description'] . '</h5>';
            echo '</div>';
            if ($link_set) {
              echo '</a>';
            }
            echo '</div>';
            echo '</div>';
          }
        }
        ?>
      </div>
      <div class="busivis__button slider-button swiper-button">
        <div class="busivis__button--prev slider-button-prev swiper-button-prev"></div>
        <div class="busivis__button--next slider-button-next swiper-button-next"></div>
      </div>
      <div class="busivis__pagination slider-pagination swiper-pagination"></div>
    </div>
  </section>
<?php endif; ?>
<!-- //slider -->

<!-- list-tile -->
<?php if ($business_list_tile_set) : ?>
  <section class="section business">
    <div class="business__head">
      <span class="stit"><?php echo $business_list_tile['subtitle']; ?></span>
      <h2 class="h2"><?php echo $business_list_tile['title']; ?></h2>
      <p class="desc"><?php echo $business_list_tile['description']; ?></p>
    </div>

    <!-- 리스트 -->
    <div class="business__body">
      <?php
      $list_tile = $business_list_tile['list'];
      if ($list_tile) {
        foreach ($list_tile as $row) {
          $button_set = $row['button_set'];
          echo '<ul class="list-tile row">';
          echo '<li class="tile-item col-sm-6">';
          echo '<figure class="thumb">';
          echo '<img src="' . $row['image'] . '" alt="' . $row['title'] . '">';
          echo '</figure>';
          echo '</li>';
          echo '<li class="tile-item col-sm-6">';
          echo '<span class="stit">' . $row['subtitle'] . '</span>';
          echo '<h3 class="h3">' . $row['title'] . '</h3>';
          echo '<p class="desc">' . $row['description'] . '</p>';
          if ($button_set) {
            echo '<a class="btn btn-sm" href="' . $row['button_link'] . '" target="_blank">' . $row['button_name'] . '</a>';
          }
          echo '</li>';
          echo '</ul>';
        }
      }
      ?>
    </div>
    <!-- //리스트 -->

  </section>
<?php endif; ?>
<!-- //list-tile -->

<!-- list-circle -->
<?php if ($business_list_circle_set) : ?>
  <section class="section business">
    <div class="business__head">
      <span class="stit"><?php echo $business_list_circle['subtitle']; ?></span>
      <h2 class="h2"><?php echo $business_list_circle['title']; ?></h2>
    </div>

    <!-- 리스트 -->
    <div class="business__body">
      <ul class="list-circle row">
        <?php
        $list_circle = $business_list_circle['list'];
        if ($list_circle) {
          foreach ($list_circle as $row) {
            echo '<li class="circle-item col-sm-4">';
            echo '<figure class="thumb">';
            echo '<img src="' . $row['image'] . '" alt="' . $row['title'] . '">';
            echo '</figure>';
            echo '<h4 class="h4">' . $row['title'] . '</h4>';
            echo '<p class="desc">' . $row['description'] . '</p>';
            echo '</li>';
          }
        }
        ?>
      </ul>
    </div>
    <!-- //리스트 -->

  </section>
<?php endif; ?>
<!-- //list-circle -->

<!-- information -->
<?php if ($business_information_set) : ?>
  <section class="section business">
    <h3 class="sr-only">정보</h3>
    <div class="information inform-link">
      <p class="desc"><?php echo $business_information['description']; ?></p>
      <a href="<?php echo $business_information['button_link']; ?>" class="btn btn-gray"><?php echo $business_information['button_name']; ?></a>
    </div>
  </section>
<?php endif; ?>
<!-- //information -->

<script>
  jQuery(document).ready(function($) {

    // busivis slider
    if ($('.busivis__slider').length) {
      var busivisSlider = new Swiper('.busivis__slider', {
        loop: true,
        speed: 1000,
        grabCursor: true,
        autoplay: {
          delay: 5000,
          disableOnInteraction: false,
        },
        navigation: {
          nextEl: '.busivis__button--next',
          prevEl: '.busivis__button--prev',
        },
        pagination: {
          el: '.busivis__pagination',
        },
      });
    }

  });
</script>

<?php get_footer(); ?>