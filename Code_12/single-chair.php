<?php get_header(); ?>

<?php get_template_part('templates/content', 'breadcrumb_product'); ?>

<?php
$chair_visual = get_field('chair_visual');
$chair_visual_keyvisual = $chair_visual['keyvisual'];
$chair_spec = get_field('chair_spec');
$chair_spec_seperate = $chair_spec['seperate'];
$chair_model_order = get_field('chair_model_order');
$chair_model = get_field('chair_model');
$chair_key_feature = get_field('chair_key_feature');
$chair_sub_feature_toggle = get_field('chair_sub_feature_toggle');
$chair_sub_feature = get_field('chair_sub_feature');
$chair_related = get_field('chair_related');
?>

<?php
// series
$get_series = get_the_title();
$series = $get_series;

// model data
$model_index = 0;
$model_symbol_data = array();
$model_info_data = array();
foreach ($chair_model as $row) {
  $model_name = $row['name'];
  $model_size = $row['size'];
  $model_spec = $row['spec'];
  $model_exception = $row['exception'];
  $model_surface = $row['surface'];

  // color variation
  $color_var = $row['color_variation'];
  $color_var_set = 'color_variation_' . $color_var;
  $color_var_set_symbol = $row[$color_var_set]['symbol'];
  $color_var_set_frame = $row[$color_var_set]['frame'];
  $color_var_set_back = $row[$color_var_set]['back'];
  $color_var_set_seat = $row[$color_var_set]['seat'];
  $color_var_set_symbol_frame = $color_var_set_symbol['color_frame'];
  $color_var_set_symbol_back = $color_var_set_symbol['color_back'];
  $color_var_set_symbol_seat = $color_var_set_symbol['color_seat'];

  // color chip
  $color_click = $row['color_click'];

  // model array
  $model_symbol_data[] = [$model_name, $color_var_set_symbol_frame, $color_var_set_symbol_seat, $color_var_set_symbol_back];
  $model_info_data[] = [$model_name, $model_size, $model_spec, $model_exception, $model_surface, $color_var, $color_var_set_frame, $color_var_set_back, $color_var_set_seat, $color_click];

  // first model
  if ($model_index == 0) {
    $first_model = $model_name;
  }
  $model_index++;
}

// model
$get_model = $_GET['model'];
if (isset($get_model)) {
  $model = $get_model;
} else {
  $model = $first_model;
}

// model use
if ($model_symbol_data) {
  foreach ($model_symbol_data as $key) {
    if ($key[0] == $model) {
      $default_frame = $key[1];
      $default_seat = $key[2];
      $default_back = $key[3];
    }
  }
}
if ($model_info_data) {
  foreach ($model_info_data as $key) {
    if ($key[0] == $model) {
      $model_size = $key[1];
      $model_spec = $key[2];
      $model_exception = $key[3];
      $model_surface = $key[4];
      $model_variation = $key[5];
      $model_frame = $key[6];
      $model_back = $key[7];
      $model_seat = $key[8];
      $model_click = $key[9];
    }
  }
}
?>

<div class="sub__top top_visual top_chair">
  <div class="top_visual__slider swiper-container">
    <div class="swiper-wrapper">
      <?php
      if ($chair_visual_keyvisual) {
        foreach ($chair_visual_keyvisual as $row) {
          $video_toggle = $row['video_toggle'];
          echo '<div class="swiper-slide ' . $row['subcopy_color'] . ($video_toggle ? ' video-slide' : '') . '"' . ($video_toggle ? '' : ' data-swiper-autoplay="6000"') . '>';
          if ($video_toggle) {
            $video_file = $row['video_file'];
            echo '<div class="top_visual__video">';
            echo '<video class="visual-video" muted playsinline>';
            echo '<source type="video/mp4" src="' . project_video_uri($video_file) . '">';
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
          <p class="h3-en"><?php echo $chair_visual['subcopy']; ?></p>
        </div>
      </div>
    </div>
    <div class="swiper-pagination"></div>
    <?php
    if ($chair_visual['award_toggle']) {
      echo '<img class="top_visual__if_logo" src="' . $chair_visual['award_logo'] . '" alt="Award">';
    }
    ?>
  </div>
</div>

<section class="sub__spec">
  <div class="sub__spec--text">
    <h3 class="tit"><?php echo $chair_spec['headcopy']; ?></strong></h3>
    <p class="desc"><?php echo $chair_spec['subcopy']; ?></p>
  </div>
  <div class="sub__spec--figure">
    <img class="pc" src="<?php echo $chair_spec_seperate['image_pc']; ?>" alt="<?php the_title(); ?>">
    <img class="mo" src="<?php echo $chair_spec_seperate['image_mo']; ?>" alt="<?php the_title(); ?>">
  </div>
</section>

<!-- chair-thumbs -->
<section class="section chair-thumbs">
  <div class="section__inner">
    <h3 class="sr-only">Thumbs</h3>
    <div class="chair-thumbs__slider swiper-container">
      <div class="swiper-wrapper">
        <?php
        foreach ($chair_model_order as $row) {
          $order_name = $row['name'];
          foreach ($chair_model as $row) {
            $model_name = $row['name'];
            if ($order_name == $model_name) {
              $color_var = $row['color_variation'];
              $color_var_set = 'color_variation_' . $color_var;
              $color_var_set_symbol = $row[$color_var_set]['symbol'];
              $symbol_frame = $color_var_set_symbol['color_frame'];
              $symbol_seat = $color_var_set_symbol['color_seat'];
              $symbol_back = $color_var_set_symbol['color_back'];
              if ($symbol_back) {
                $symbol_back = '_' . $symbol_back;
              } else {
                $symbol_back = '';
              }
              $active = ($model == $model_name) ? 'active' : '';
              $href = project_permalink() . '?model=' . $model_name;
              $src = project_image_uri('product/' . $series . '/' . $model_name . '/' . $model_name . '_'  . $symbol_frame . $symbol_back . '_01_'  . $symbol_seat . '.jpg');
              echo '<div class="swiper-slide ' . $active . '">';
              echo '<a class="thumb" href="' . $href . '"><img src="' . $src . '" alt="' . $model_name . '"></a>';
              echo '</div>';
            }
          }
        }
        ?>
      </div>
    </div>
    <div class="chair-thumbs-button-prev swiper-button-prev"></div>
    <div class="chair-thumbs-button-next swiper-button-next"></div>
  </div>
</section>
<!-- //chair-thumbs -->

<!-- chair-catalog -->
<section class="section chair-catalog">
  <div class="section__inner">
    <h3 class="sr-only">Catalog</h3>
    <div class="chair-catalog__container">
      <!-- model -->
      <div id="<?php echo $model; ?>" class="chair-catalog__model">
        <div class="chair-catalog__left">
          <h4 class="M-h1-en"><?php echo $model; ?></h4>
          <p class="size"><?php echo $model_size; ?></p>
          <div class="surface">
            <ul>
              <?php
              if ($model_surface) {
                foreach ($model_surface as $row) {
                  $image = $row['image'];
                  $name = $row['name'];
                  echo '<li><img src="' . $image . '" alt="Surface"><span>' . $name . '</span></li>';
                }
              }
              ?>
            </ul>
          </div>
          <p class="desc">
            <?php echo $model_spec . (($model_exception) ? ('<br>' . $model_exception) : ''); ?>
          </p>
          <ul class="option">
            <!-- frame -->
            <li class="frame_color">
              <span class="tit">FRAME</span>
              <?php
              if ($model_frame) {
                $index = 1;
                foreach ($model_frame as $row) {
                  $name = $row['name'];
                  $code = $row['code'];
                  $frameback_changer = ($model_variation == 'set_3') ? 'frameback_changer' : '';
                  $frameseat_changer = ($model_variation == 'set_4') ? 'frameseat_changer' : '';
                  $checked = ($name == $default_frame) ? 'checked' : '';
                  echo '<input class="chair_image_changer color_chip_radio ' . $frameback_changer . $frameseat_changer . '" type="radio" name="frame" id="frame_' . $index . '" value="' . $name . '" ' . $checked . '>';
                  echo '<label class="color_chip text-hide" for="frame_' . $index . '" style="background-color:' . $code . ';">' . $name . '</label>';
                  $index++;
                }
              }
              ?>
            </li>
            <!-- //frame -->
            <!-- back -->
            <?php if ($model_variation == 'set_2' || $model_variation == 'set_4') : ?>
              <li class="back_color back">
                <?php
                if ($model_back) {
                  $index = 1;
                  $title = $model_back['title'];
                  $color = $model_back['color'];
                  echo '<span class="tit">' . strtoupper($title) . '</span> ';
                  foreach ($color as $row) {
                    $name = $row['name'];
                    $code = $row['code'];
                    $checked = ($name == $default_back) ? 'checked' : '';
                    echo '<input class="chair_image_changer color_chip_radio" type="radio" name="back" id="back_' . $index . '" value="' . $name . '" ' . $checked . '>';
                    echo '<label class="color_chip text-hide" for="back_' . $index . '" style="background-color:' . $code . ';">' . $name . '</label>';
                    $index++;
                  }
                }
                ?>
              </li>
            <?php elseif ($model_variation == 'set_3') : ?>
              <?php
              if ($model_back) {
                $index_color = 1;
                $title = $model_back['title'];
                $color = $model_back['color'];
                foreach ($color as $row_color) {
                  $index_set = 1;
                  $set = $row_color['set'];
                  echo '<li class="back_color back' . $index_color . '">';
                  echo '<span class="tit">' . strtoupper($title) . '</span> ';
                  foreach ($set as $row_set) {
                    $name = $row_set['name'];
                    $code = $row_set['code'];
                    $checked = ($name == $default_back) ? 'checked' : '';
                    echo '<input class="chair_image_changer color_chip_radio" type="radio" name="back' . $index_color . '" id="back' . $index_color . '_' . $index_set . '" value="' . $name . '" ' . $checked . '>';
                    echo '<label class="color_chip text-hide" for="back' . $index_color . '_' . $index_set . '" style="background-color:' . $code . ';">' . $name . '</label>';
                    $index_set++;
                  }
                  echo '</li>';
                  $index_color++;
                }
              }
              ?>
            <?php endif; ?>
            <!-- //back -->
          </ul>
        </div>
        <div class="chair-catalog__center">
          <!-- chair figure -->
          <figure id="chairFigure" class="figure"></figure>
          <!-- //chair figure -->
          <!-- seat -->
          <?php if ($model_variation == 'set_4') : ?>
            <?php
            if ($model_seat) {
              $index_color = 1;
              foreach ($model_seat as $row_color) {
                $index_set = 1;
                $set = $row_color['set'];
                echo '<div class="seat_color frameseat_color frameseat' . $index_color . '">';
                foreach ($set as $row_set) {
                  $name = $row_set['name'];
                  $code = $row_set['code'];
                  $checked = ($name == $default_seat) ? 'checked' : '';
                  echo '<input class="chair_image_changer color_chip_radio" type="radio" name="seat' . $index_color . '" id="seat' . $index_color . '_' . $index_set . '" value="' . $name . '" ' . $checked . '>';
                  echo '<label class="color_chip text-hide" for="seat' . $index_color . '_' . $index_set . '" style="background-color: ' . $code . ';">' . $name . '</label>';
                  $index_set++;
                }
                echo '</div>';
                $index_color++;
              }
            }
            ?>
          <?php else : ?>
            <div class="seat_color">
              <?php
              if ($model_seat) {
                $index = 1;
                foreach ($model_seat as $row) {
                  $name = $row['name'];
                  $code = $row['code'];
                  $checked = ($name == $default_seat) ? 'checked' : '';
                  echo '<input class="chair_image_changer color_chip_radio" type="radio" name="seat" id="seat_' . $index . '" value="' . $name . '" ' . $checked . '>';
                  echo '<label class="color_chip text-hide" for="seat_' . $index . '" style="background-color:' . $code . ';">' . $name . '</label>';
                  $index++;
                }
              }
              ?>
            </div>
          <?php endif; ?>
          <!-- //seat -->
        </div>
        <div class="chair-catalog__right">
          <div class="angle_image">
            <?php
            $angleIndex = 0;
            while ($angleIndex < 5) {
              $angleNumber = $angleIndex + 1;
              $angleChecked = ($angleNumber == 1) ? 'checked' : '';
              echo '<input class="chair_image_changer angle_chip_radio" type="radio" name="angle" id="angle' . $angleNumber . '" value="0' . $angleNumber . '" ' . $angleChecked . '>';
              echo '<label class="angle_chip" for="angle' . $angleNumber . '"></label>';
              $angleIndex++;
            }
            ?>
          </div>
        </div>
      </div>
      <!-- //model -->
    </div>
  </div>
</section>
<!-- //chair-catalog -->

<!-- chair-feature -->
<section class="section chair-feature">
  <h3 class="sr-only">Feature</h3>
  <div class="chair-feature__visual">
    <?php
    if ($chair_key_feature) {
      $index = 1;
      foreach ($chair_key_feature as $row) {
        $image = $row['image'];
        echo '<div id="feature' . $index . '" class="chair-feature__container">';
        echo '<img class="figure pc" src="' . $image['image_pc'] . '" alt="Feature">';
        echo '<img class="figure mo" src="' . $image['image_mo'] . '" alt="Feature">';
        echo '<div class="section__inner">';
        echo '<div class="text_wrap">';
        echo '<span class="cat">' . $row['title'] . '</span>';
        echo '<h4 class="tit">' . $row['headcopy'] . '</h4>';
        echo '<p class="desc">' . $row['subcopy'];
        if ($row['exception']) {
          echo '<br><span class="co_gray_6">' . $row['exception'] . '</span>';
        }
        echo '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        $index++;
      }
    }
    ?>
  </div>
  <div class="chair-feature__button">
    <?php
    if ($chair_key_feature) {
      $index = 1;
      foreach ($chair_key_feature as $row) {
        $on = ($index == 1) ? 'on' : '';
        echo '<a class="btn_feature ' . $on . '" href="#feature' . $index . '">';
        echo '<span class="cat">' . $row['title'] . '</span>';
        echo '<h5>' . $row['headcopy'] . '</h5>';
        echo '</a>';
        $index++;
      }
    }
    ?>
    <?php if ($chair_sub_feature_toggle) : ?>
      <a class="btn_feature_more modal__open" href="#featureModal">
        <span class="cat">FEATURE MORE</span>
        <span class="more"></span>
      </a>
    <?php endif; ?>
  </div>
</section>
<!-- //chair-feature -->

<!-- feature-modal -->
<?php if ($chair_sub_feature_toggle) : ?>
  <section id="featureModal" class="feature-modal modal">
    <h3 class="sr-only">Feature Modal</h3>
    <div class="feature-modal__slider swiper-container">
      <div class="swiper-wrapper">
        <?php
        if ($chair_sub_feature) {
          foreach ($chair_sub_feature as $row) {
            echo '<div class="swiper-slide">';
            echo '<figure class="feature-modal__figure">';
            echo '<img class="img-fluid" src="' . $row['image'] . '" alt="Feature">';
            echo '</figure>';
            echo '<div class="feature-modal__text">';
            echo '<h5>' . $row['title'] . '</h5>';
            echo '<p class="desc">' . $row['description'];
            echo '<br><span class="co_gray_6">' . $row['exception'] . '</span>';
            echo '</p>';
            echo '</div>';
            echo '</div>';
          }
        }
        ?>
      </div>
      <div class="feature-modal-pagination swiper-pagination"></div>
      <div class="feature-modal-button-prev swiper-button-prev"></div>
      <div class="feature-modal-button-next swiper-button-next"></div>
    </div>
    <a class="modal__close" href="#">닫기</a>
  </section>
<?php endif; ?>
<!-- //feature-modal -->

<!-- chair-related -->
<section class="section chair-related">
  <div class="section__inner">
    <h3 class="section__title">연관 제품</h3>
    <div class="section__cont">
      <ul class="chair-related__list row">
        <?php
        if ($chair_related) {
          foreach ($chair_related as $post) {
            setup_postdata($post);
            $terms = get_the_terms(false, 'tax_chair');
            echo '<li class="chair-related__item col-12 col-md-6">';
            echo '<figure class="chair-related__figure">';
            echo '<img class="img-fluid" src="' . get_the_post_thumbnail_url() . '" alt="' . get_the_title() . ' Series">';
            echo '</figure>';
            echo '<div class="chair-related__info">';
            echo '<p class="cat">' . $terms[0]->name . '</p>';
            echo '<p class="tit">' . get_the_title() . ' Series</p>';
            echo '<a href="' . get_the_permalink() . '" class="btn_more">MORE</a>';
            echo '</div>';
            echo '</li>';
          }
          wp_reset_postdata();
        }
        ?>
      </ul>
    </div>
  </div>
</section>
<!-- //chair-related -->

<!-- chair-script -->
<script>
  jQuery(document).ready(function($) {

    // chair thumbs slider
    var chairThumbsSlider = new Swiper(".chair-thumbs__slider", {
      speed: 500,
      grabCursor: true,
      slidesPerView: 'auto',
      navigation: {
        nextEl: ".chair-thumbs-button-next",
        prevEl: ".chair-thumbs-button-prev"
      }
    });

    // chair model scrolltop
    <?php if (isset($_GET['model'])) : ?>
      $("html, body").scrollTop($(".chair-thumbs").offset().top - <?php echo (wp_is_mobile()) ? "85" : "96"; ?>);
      var activeIndex = $(chairThumbsSlider.el).find('.swiper-slide.active').index();
      chairThumbsSlider.slideTo(activeIndex - 2);
    <?php endif; ?>

    // load changer
    $(window).on('load', function() {
      var frameValue = $(".frame_color").find(".color_chip_radio:checked").val(),
        backValue = $(".back_color.back").find(".color_chip_radio:checked").val(),
        angleValue = $(".angle_image").find(".angle_chip_radio:checked").val(),
        seatValue = $(".seat_color").find(".color_chip_radio:checked").val();
      // frameback
      if ($('.frameback_changer').length) {
        var $framebackChanger = $('.frameback_changer:checked'),
          $backColor = $('.back_color');
        var framebackChangerIndex = $framebackChanger.index('.frameback_changer');
        var backValue = $backColor.eq(framebackChangerIndex).find(".color_chip_radio:checked").val();
        var mixValue = frameValue + "_" + backValue;
        $backColor.eq(framebackChangerIndex).show();
      } else {
        if ($('.back_color').length) {
          var mixValue = frameValue + "_" + backValue;
        } else {
          var mixValue = frameValue;
        }
      }
      // freameseat
      if ($('.frameseat_changer').length) {
        var $frameseatChanger = $('.frameseat_changer:checked'),
          $seatColor = $('.seat_color');
        var frameseatChangerIndex = $frameseatChanger.index('.frameseat_changer');
        var seatValue = $seatColor.eq(frameseatChangerIndex).find(".color_chip_radio:checked").val();
        $seatColor.eq(frameseatChangerIndex).show();
      }
      // chair
      var chairSrc = '<?php echo project_image_uri('product/' . $series . '/' . $model . '/' . $model . '_'); ?>';
      var chairAlt = '<?php echo $model; ?>';
      var chairImg = '<img id="chairImage" class="animated fadeIn" src="' + chairSrc + mixValue + "_" + angleValue + "_" + seatValue + '.jpg" alt="' + chairAlt + '">';
      $('#chairFigure').append(chairImg);
      // angle
      $('.angle_chip').each(function(index) {
        var angleSrc = '<?php echo project_image_uri('product/' . $series . '/' . $model . '/' . $model . '_'); ?>';
        var angleAlt = ['Front', 'Front45', 'Side', 'Back45', 'Back'];
        var angleImg = '<img src="' + angleSrc + mixValue + "_0" + (index + 1) + "_" + seatValue + '.jpg" alt="' + angleAlt[index] + '">';
        $(this).append(angleImg);
      });
      console.log(mixValue + "_" + angleValue + "_" + seatValue);
    });

    // frameback & frameseat changer
    $('.frameback_changer').on('click', function() {
      var $this = $(this),
        $backColor = $('.back_color');
      var thisIndex = $this.index('.frameback_changer');
      $backColor.hide();
      $backColor.eq(thisIndex).show();
      $backColor.eq(thisIndex).find(".color_chip_radio").eq(0).attr('checked', true);
    });
    $('.frameseat_changer').on('click', function() {
      var $this = $(this),
        $seatColor = $('.seat_color');
      var thisIndex = $this.index('.frameseat_changer');
      $seatColor.hide();
      $seatColor.eq(thisIndex).show();
      $seatColor.eq(thisIndex).find(".color_chip_radio").eq(0).attr('checked', true);
    });

    // click changer
    $(".chair_image_changer").on("click", function() {
      var frameValue = $(".frame_color").find(".color_chip_radio:checked").val(),
        backValue = $(".back_color.back").find(".color_chip_radio:checked").val(),
        seatValue = $(".seat_color").find(".color_chip_radio:checked").val(),
        angleValue = $(".angle_image").find(".angle_chip_radio:checked").val();
      // frameback
      if ($('.frameback_changer').length) {
        var $framebackChanger = $('.frameback_changer:checked'),
          $backColor = $('.back_color');
        var framebackChangerIndex = $framebackChanger.index('.frameback_changer');
        var backValue = $backColor.eq(framebackChangerIndex).find(".color_chip_radio:checked").val();
        var mixValue = frameValue + "_" + backValue;
      } else {
        if ($('.back_color').length) {
          var mixValue = frameValue + "_" + backValue;
        } else {
          var mixValue = frameValue;
        }
      }
      // freameseat
      if ($('.frameseat_changer').length) {
        var $frameseatChanger = $('.frameseat_changer:checked'),
          $seatColor = $('.seat_color');
        var frameseatChangerIndex = $frameseatChanger.index('.frameseat_changer');
        var seatValue = $seatColor.eq(frameseatChangerIndex).find(".color_chip_radio:checked").val();
      }
      // chair
      var $chairImage = $("#chairImage");
      var chairOldSrc = $chairImage.attr("src");
      if (chairOldSrc) {
        var chairPath = chairOldSrc.substring(0, chairOldSrc.indexOf("_"));
      }
      var chairNewSrc = chairPath + "_" + mixValue + "_" + angleValue + "_" + seatValue + ".jpg";
      $chairImage.attr("src", chairNewSrc);
      // angle
      $('.angle_chip').each(function(index) {
        var $angleImage = $(this).find('img');
        var angleOldSrc = $angleImage.attr("src");
        if (angleOldSrc) {
          var anglePath = angleOldSrc.substring(0, angleOldSrc.indexOf("_"));
        }
        var angleNewSrc = anglePath + "_" + mixValue + "_0" + (index + 1) + "_" + seatValue + ".jpg";
        $angleImage.attr("src", angleNewSrc);
      });
      console.log(mixValue + "_" + angleValue + "_" + seatValue);
    });

    // inactive color chip
    <?php if ($model_click == false) : ?>
      // frame chip
      var $frameColor = $(".frame_color");
      $frameColor.find('.color_chip').each(function() {
        $(this).addClass('inactive');
      });
      $frameColor.on('click', function(event) {
        event.preventDefault();
      })
      // back chip
      $backColor = $(".back_color");
      $backColor.find('.color_chip').each(function() {
        $(this).addClass('inactive');
      });
      $backColor.on('click', function(event) {
        event.preventDefault();
      })
    <?php endif; ?>

  });
</script>
<!-- //chair-script -->

<?php get_footer(); ?>