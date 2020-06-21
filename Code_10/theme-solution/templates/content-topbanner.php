<?php
$cookie_check = isset($_COOKIE['slofTopbannerCloseToday']);
$tb = get_field('topbanner', 'option');
$tb_bgcolor = $tb['bgcolor'];
$tb_type = $tb['type'];
$tb_text = $tb['type_text'];
$tb_text_link = $tb_text['link'];
$tb_image = $tb['type_image'];
$tb_image_link = $tb_image['link'];
$tb_date_start = $tb['date_start'];
$tb_date_end = $tb['date_end'];
$today = date_i18n('Y-m-d');

if ($tb) {
  if ($today >= $tb_date_start && $today <= $tb_date_end) {
    $tb_check = true;
  } else {
    $tb_check = false;
  }
} else {
  $tb_check = false;
}
?>

<?php if (!$cookie_check && $tb_check) : ?>

  <!-- topbanner -->
  <section id="topbanner" class="topbanner" style="background-color: <?php echo $tb_bgcolor ?>;">
    <h4 class="sr-only">탑배너</h4>
    <div class="topbanner-inner">

      <?php if ($tb_type == 'text') : ?>

        <!-- type-text -->
        <div class="topbanner-text">
          <?php
          if ($tb_text['link_set']) {
            $tb_text_outlink = ($tb_text_link['outlink']) ? 'target="_blank"' : '';
            echo '<a class="txt" href="' . $tb_text_link['url'] . '" ' . $tb_text_outlink . ' style="color:' . $tb_text['color_title'] . ';">' . $tb_text['title'] . '</a>';
          } else {
            echo '<span class="txt" style="color:' . $tb_text['color_title'] . ';">' . $tb_text['title'] . '</span>';
          }
          ?>
          <button type="button" id="topbannerClose" class="close" onClick="topbannerCloseToday();" aria-label="오늘 하루 열지 않음" style="color: <?php echo $tb_text['color_close']; ?>;"><i class="xi-close-circle"></i></button>
        </div>
        <!-- //type-text -->

      <?php elseif ($tb_type == 'image') : ?>

        <!-- type-image -->
        <?php $image = (wp_is_mobile()) ? $tb_image['image_mo'] : $tb_image['image_pc']; ?>
        <div class="topbanner-image" style="background-image: url(<?php echo $image; ?>);">
          <div class="txt">
            <?php
            echo '<span style="color: ' . $tb_image['color_title'] . ';">' . $tb_image['title'] . '</span>';
            if ($tb_image['link_set']) {
              $tb_image_outlink = ($tb_image_link['outlink']) ? 'target="_blank"' : '';
              echo '<a href="' . $tb_image_link['url'] . '" ' . $tb_image_outlink . ' style="border-color: ' . $tb_image_link['color'] . '; color: ' . $tb_image_link['color'] . ';">' . $tb_image_link['text'] . '</a>';
            }
            ?>
          </div>
          <button type="button" id="topbannerClose" class="close" onClick="topbannerCloseToday();" aria-label="오늘 하루 열지 않음" style="color: <?php echo $tb_image['color_close']; ?>;"><i class="xi-close-thin"></i></button>
        </div>
        <!-- //type-image -->

      <?php endif; ?>

    </div>
  </section>

  <script>
    // topbanner close today
    function topbannerCloseToday() {
      setCookie('slofTopbannerCloseToday', 'Y', 1);
      jQuery(document).ready(function($) {
        $('#topbanner').slideUp(100);
      });
    }
  </script>
  <!-- //topbanner -->

<?php endif; ?>