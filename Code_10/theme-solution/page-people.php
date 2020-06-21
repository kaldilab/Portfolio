<?php get_header(); ?>

<div class="sub__top">
  <h2 class="sub__title"><?php the_title(); ?></h2>
  <?php get_template_part('templates/content', 'breadcrumb'); ?>
</div>

<?php
// get field
$people_image_set = get_field('people_image_set', 'option');
$people_division_set = get_field('people_division_set', 'option');
$people_content = get_field('people_content', 'option');

// get div
$people_content_filter = array();
if (!empty($_GET['div'])) {
  $div = urlencode($_GET['div']);
  foreach ($people_content as $item) {
    if ($div == urlencode($item['division'])) {
      $people_content_filter[] = $item;
    }
  }
} else {
  $div = null;
  $people_content_filter = $people_content;
}
?>

<!-- 카테고리 -->
<?php if ($people_division_set) : ?>
  <div class="sub__tabs tabs-people">
    <ul class="nav nav-tabs">
      <?php
      // get division
      $division_list = array();
      foreach ($people_content as $item) {
        $division_list[] = $item['division'];
      }
      $division_sort = array_unique($division_list);

      // active
      $active_all = (empty($div)) ? 'active' : '';
      echo '<li class="nav-item"><a class="nav-link ' . $active_all . '" href="' . project_permalink() . '">전체</a></li>';
      foreach ($division_sort as $item) {
        $active_row = ($div == urlencode($item)) ? 'active' : '';
        echo '<li class="nav-item"><a class="nav-link ' . $active_row . '" href="' . project_permalink() . '?div=' . $item . '">' . $item . '</a></li>';
      }
      ?>
    </ul>
  </div>
<?php endif; ?>
<!-- //카테고리 -->

<section class="section people">

  <h3 class="sr-only">리스트</h3>

  <!-- 리스트 -->
  <ul class="people__list row">
    <?php
    if ($people_content_filter) {
      foreach ($people_content_filter as $row) {
        echo '<li class="people__item col-sm-3">';
        echo '<div class="people__body">';
        echo '<span class="pos">' . $row['position'] . '</span>';
        echo '<h5>' . $row['name'] . '</h5>';
        echo '<span class="work">' . $row['work'] . '</span>';
        if ($people_image_set) {
          $thumb = $row['image'];
          echo '<figure class="thumb">';
          echo '<img src="' . (($thumb) ? $thumb : project_image_uri('img_default_people.png')) . '" alt="' . $row['name'] . '">';
          echo '</figure>';
        }
        echo '</div>';
        echo '<div class="people__foot">';
        echo '<span class="tel">' . $row['tel'] . '</span>';
        echo '<span class="email">' . $row['email'] . '</span>';
        echo '</div>';
        echo '</li>';
      }
    }
    ?>
  </ul>
  <!-- //리스트 -->

</section>

<?php get_footer(); ?>