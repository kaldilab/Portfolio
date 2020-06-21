<?php
$cookie_check = isset($_COOKIE['slofPopupCloseToday']);
$popup = get_field('popup', 'option');
$popup_check = array();
if ($popup) {
  foreach ($popup as $row) {
    $today = date_i18n('Y-m-d');
    $date_start = $row['date_start'];
    $date_end = $row['date_end'];
    if ($today >= $date_start && $today <= $date_end) {
      $popup_check[] = true;
    } else {
      $popup_check[] = false;
    }
  }
} else {
  $popup_check[] = false;
}
?>

<?php if (!$cookie_check && array_filter($popup_check)) : ?>

  <!-- popup -->
  <section id="popup" class="alert-modal modal fade alert-type5" tabindex="-1" role="dialog" aria-labelledby="popupLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="sr-only" id="popupLabel">팝업</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="xi-close-thin"></span>
          </button>
        </div>
        <div class="modal-body">
          <div class="modal-slider swiper-container">
            <div class="swiper-wrapper">
              <?php
              if ($popup) {
                foreach ($popup as $row) {
                  $today = date_i18n('Y-m-d');
                  $date_start = $row['date_start'];
                  $date_end = $row['date_end'];
                  $image = (wp_is_mobile()) ? $row['image_mo'] : $row['image_pc'];
                  $image_src = '<img src="' . $image . '" alt="' . $row['description'] . '">';
                  $link = $row['link'];
                  $outlink = ($link['outlink']) ? 'target="_blank"' : '';
                  if ($today >= $date_start && $today <= $date_end) {
                    echo '<div class="swiper-slide">';
                    if ($row['link_set']) {
                      echo '<a href="' . $link['url'] . '"' . $outlink . '>' . $image_src . '</a>';
                    } else {
                      echo $image_src;
                    }
                    echo '</div>';
                  }
                }
              }
              ?>
            </div>
          </div>
          <div class="modal-pagination swiper-pagination"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-today" onClick="popupCloseToday();">오늘 하루 열지 않음</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">닫기</button>
        </div>
      </div>
    </div>
  </section>

  <script>
    jQuery(document).ready(function($) {

      // popup modal
      $('#popup').modal('show');

      // modal slider
      if ($(".modal-slider").length) {
        var modalSlider = new Swiper(".modal-slider", {
          loop: false,
          speed: 1000,
          autoplay: {
            delay: 4000,
            disableOnInteraction: false
          },
          pagination: {
            el: '.modal-pagination',
            clickable: true,
          },
          observer: true,
          observeParents: true,
          autoHeight: true,
        });
      }

    });

    // popup close today
    function popupCloseToday() {
      setCookie('slofPopupCloseToday', 'Y', 1);
      jQuery(document).ready(function($) {
        $('#popup').modal('hide');
      });
    }
  </script>
  <!-- //popup -->

<?php endif; ?>