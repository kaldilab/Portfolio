<?php get_header(); ?>

<div class="sub__top">
  <h2 class="sub__title"><?php the_title(); ?></h2>
  <?php get_template_part('templates/content', 'breadcrumb'); ?>
</div>

<?php
// get field
$favorite_cooperation_set = get_field('favorite_cooperation_set', 'option');
$favorite_sponsor_set = get_field('favorite_sponsor_set', 'option');
$favorite_cooperation = get_field('favorite_cooperation', 'option');
$favorite_cooperation_list = $favorite_cooperation['list'];
$favorite_sponsor = get_field('favorite_sponsor', 'option');
$favorite_sponsor_list_logo_set = $favorite_sponsor['list_logo_set'];
$favorite_sponsor_list_logo = $favorite_sponsor['list_logo'];
$favorite_sponsor_list_name_set = $favorite_sponsor['list_name_set'];
$favorite_sponsor_list_name = $favorite_sponsor['list_name'];
?>

<!-- 협력단체 -->
<?php if ($favorite_cooperation_set) : ?>
  <section class="section favorite cooperation">
    <div class="favorite__head">
      <span class="stit"><?php echo $favorite_cooperation['subtitle']; ?></span>
      <h3 class="h3"><?php echo $favorite_cooperation['title']; ?></h3>
      <p class="desc"><?php echo $favorite_cooperation['description']; ?></p>
    </div>

    <!-- 리스트 -->
    <ul class="favorite__list row">
      <?php
      if ($favorite_cooperation_list) {
        foreach ($favorite_cooperation_list as $row) {
          $thumb = $row['image'];
          echo '<li class="favorite__item col-6 col-sm-3">';
          echo '<a class="favorite__link" href="' . $row['link'] . '" target="_blank">';
          echo '<figure class="thumb">';
          echo '<span class="logo">';
          echo '<img src="' . (($thumb) ? $thumb : project_image_uri('img_default_wide.png')) . '" alt="' . $row['title'] . '">';
          echo '</span>';
          echo '</figure>';
          echo '<h6 class="h6">' . $row['title'] . '</h6>';
          echo '</a>';
          echo '</li>';
        }
      }
      ?>
    </ul>
    <!-- //리스트 -->

  </section>
<?php endif; ?>
<!-- //협력단체 -->

<!-- 후원기업 -->
<?php if ($favorite_sponsor_set) : ?>
  <section class="section favorite sponsor">
    <div class="favorite__head">
      <span class="stit"><?php echo $favorite_sponsor['subtitle']; ?></span>
      <h3 class="h3"><?php echo $favorite_sponsor['title']; ?></h3>
      <p class="desc"><?php echo $favorite_sponsor['description']; ?></p>
    </div>

    <!-- 리스트 -->
    <?php if ($favorite_sponsor_list_logo_set) : ?>
      <ul class="favorite__list type_list row">
        <?php
        if ($favorite_sponsor_list_logo) {
          foreach ($favorite_sponsor_list_logo as $row) {
            $thumb = $row['image'];
            echo '<li class="favorite__item col-6 col-sm-3">';
            echo '<a class="favorite__link" href="' . $row['link'] . '" target="_blank">';
            echo '<figure class="thumb">';
            echo '<span class="logo">';
            echo '<img src="' . (($thumb) ? $thumb : project_image_uri('img_default_wide.png')) . '" alt="' . $row['title'] . '">';
            echo '</span>';
            echo '</figure>';
            echo '<h6 class="h6">' . $row['title'] . '</h6>';
            echo '</a>';
            echo '</li>';
          }
        }
        ?>
      </ul>
    <?php endif; ?>
    <!-- //리스트 -->

    <!-- 리스트 -->
    <?php if ($favorite_sponsor_list_name_set) : ?>
      <ul class="favorite__list type_name row">
        <?php
        if ($favorite_sponsor_list_name) {
          foreach ($favorite_sponsor_list_name as $row) {
            echo '<li class="favorite__item col-6 col-sm-3">';
            echo '<a class="favorite__link" href="' . $row['link'] . '" target="_blank">';
            echo '<h6 class="tit">' . $row['title'] . '</h6>';
            echo '</a>';
            echo '</li>';
          }
        }
        ?>
      </ul>
    <?php endif; ?>
    <!-- //리스트 -->

  </section>
<?php endif; ?>
<!-- //후원기업 -->

<?php get_footer(); ?>