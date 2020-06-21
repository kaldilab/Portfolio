<!-- popup -->
<section id="popup" class="popup">
  <div class="popup__slider swiper-container">
    <div class="swiper-wrapper">
      <?php
      if (have_rows('main_popup', 'option')) {
        while (have_rows('main_popup', 'option')) {
          the_row();
          $today = date_i18n('Y-m-d');
          $end = get_sub_field('date');
          if ($today <= $end) {
            echo '<div class="swiper-slide">';
            echo '<span class="position-absolute">' . get_sub_field('text') . '</span>';
            if (wp_is_mobile()) {
              echo '<a href="' . get_sub_field('link') . '"><img class="img-fluid" src="' . get_sub_field('image_mo') . '" alt="슬라이더 모바일 이미지"></a>';
            } else {
              echo '<a href="' . get_sub_field('link') . '"><img class="img-fluid" src="' . get_sub_field('image_pc') . '" alt="슬라이더 피씨 이미지"></a>';
            }
            echo '</div>';
          }
        }
      }
      ?>
    </div>
    <div class="popup__control popup__prev">이전</div>
    <div class="popup__control popup__next">다음</div>
  </div>
  <ul class="popup__button m-0 p-0">
    <li>
      <a class="btn btn_light" href="javascript:closePopupToday()">오늘 하루 보지 않기</a>
    </li>
    <li>
      <a href="#" class="btn btn_light mfp-close">닫기</a>
    </li>
  </ul>
</section>

<style>
  .popup {
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
    background: #fff
  }

  .popup__slider {
    height: 400px
  }

  .popup__slider .swiper-slide {
    width: 100%;
    height: 100%;
    background: #eee;
  }

  .popup__slider .swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover
  }

  .popup__control {
    position: absolute;
    top: 50%;
    z-index: 2;
    margin-top: -20px;
    width: 40px;
    height: 40px;
    cursor: pointer
  }

  .popup__prev {
    left: 10px
  }

  .popup__next {
    right: 10px
  }

  .popup__button {
    background: #fff;
    list-style: none;
    overflow: hidden;
  }

  .popup__button li {
    position: relative;
    float: left;
    width: 50%;
    height: 40px;
    text-align: center
  }

  .popup__button li a {
    display: block;
    width: 100%;
    height: 100%;
    line-height: 40px;
    padding: 0;
    opacity: 1;
    font-size: 1rem;
    color: black;
  }
</style>

<script>
  jQuery(document).ready(function($) {

    // popup slider
    if ($(".popup__slider").length) {
      var popupSlider = new Swiper(".popup__slider", {
        loop: false,
        centeredSlides: true,
        slidesPerView: "auto",
        speed: 1000,
        autoplay: {
          delay: 4000,
          disableOnInteraction: false
        },
        navigation: {
          nextEl: ".popup__next",
          prevEl: ".popup__prev"
        },
        on: {
          init: function() {
            var slideCount = this.slides.length;
            if (slideCount < 2) {
              $(".popup__prev,.popup__next").remove();
            }
          }
        }
      });
    }

    // magnificPopup
    if ($("#popup").length) {
      $.magnificPopup.open({
        items: {
          src: "#popup"
        },
        type: "inline",
        closeBtnInside: false
      });
      if (!$("#popup").find(".swiper-slide").length) {
        $.magnificPopup.close();
      }
    }

  });

  // close popup today
  function closePopupToday() {
    setCookie('dbnpoTodayClose', 'Y', 1);
    jQuery(document).ready(function($) {
      $.magnificPopup.close();
    });
  }
  cookiedata = document.cookie;
  if (cookiedata.indexOf("dbnpoTodayClose=Y") > 0) {
    jQuery(document).ready(function($) {
      $.magnificPopup.close();
    });
  }
</script>
<!-- //popup -->