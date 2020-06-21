<?php get_header(); ?>

<div class="sub__top">
  <h2 class="sub__title"><?php the_title(); ?></h2>
  <?php get_template_part('templates/content', 'breadcrumb'); ?>
</div>

<?php
// get field
$about_greeting_set = get_field('about_greeting_set', 'option');
$about_greeting = get_field('about_greeting', 'option');
$about_greeting_tabmenu = $about_greeting['tabmenu'];
$about_greeting_tabmenu_encode = urlencode($about_greeting['tabmenu']);
$about_greeting_list = $about_greeting['list'];
$about_intro_set = get_field('about_intro_set', 'option');
$about_intro = get_field('about_intro', 'option');
$about_intro_tabmenu = $about_intro['tabmenu'];
$about_intro_tabmenu_encode = urlencode($about_intro['tabmenu']);
$about_intro_list = $about_intro['list'];
$about_logo_set = get_field('about_logo_set', 'option');
$about_logo = get_field('about_logo', 'option');
$about_logo_tabmenu = $about_logo['tabmenu'];
$about_logo_tabmenu_encode = urlencode($about_logo['tabmenu']);

// get tabmenu
if (!empty($_GET['tabmenu'])) {
  $tabmenu = urlencode($_GET['tabmenu']);
} else {
  $check_first_tabmenu = array();
  if ($about_greeting_set) {
    $check_first_tabmenu[] = $about_greeting_tabmenu_encode;
  }
  if ($about_intro_set) {
    $check_first_tabmenu[] = $about_intro_tabmenu_encode;
  }
  if ($about_logo_set) {
    $check_first_tabmenu[] = $about_logo_tabmenu_encode;
  }
  $tabmenu = $check_first_tabmenu[0];
}
?>

<!-- 카테고리 -->
<div class="sub__tabs tabs-about">
  <ul class="nav nav-tabs">
    <?php
    if ($about_greeting_set) {
      $active = ($tabmenu == $about_greeting_tabmenu_encode) ? 'active' : '';
      echo '<li class="nav-item"><a class="nav-link ' . $active . '" href="' . project_permalink() . '?tabmenu=' . $about_greeting_tabmenu . '">' . $about_greeting_tabmenu . '</a></li>';
    }
    if ($about_intro_set) {
      $active = ($tabmenu == $about_intro_tabmenu_encode) ? 'active' : '';
      echo '<li class="nav-item"><a class="nav-link ' . $active . '" href="' . project_permalink() . '?tabmenu=' . $about_intro_tabmenu . '">' . $about_intro_tabmenu . '</a></li>';
    }
    if ($about_logo_set) {
      $active = ($tabmenu == $about_logo_tabmenu_encode) ? 'active' : '';
      echo '<li class="nav-item"><a class="nav-link ' . $active . '" href="' . project_permalink() . '?tabmenu=' . $about_logo_tabmenu . '">' . $about_logo_tabmenu . '</a></li>';
    }
    ?>
  </ul>
</div>
<!-- //카테고리 -->

<!-- greeting -->
<?php if ($about_greeting_set && $tabmenu == $about_greeting_tabmenu_encode) : ?>
  <section class="section about">

    <?php
    if ($about_greeting_list) {
      foreach ($about_greeting_list as $row) {
        echo '<div class="greeting row">';
        echo '<div class="image col-sm-6">';
        echo '<figure class="figure">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['title'] . '">';
        echo '</figure>';
        echo '</div>';
        echo '<div class="text col-sm-6">';
        echo '<h3 class="h3">' . $row['title'] . '</h3>';
        echo '<div class="desc">' . $row['description'] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
    }
    ?>

  </section>
<?php endif; ?>
<!-- //greeting -->

<!-- mission -->
<?php if ($about_intro_set && $tabmenu == $about_intro_tabmenu_encode) : ?>
  <section class="section about">

    <?php
    if ($about_intro_list) {
      foreach ($about_intro_list as $row) {
        $list = ($row['type'] == 'image') ? $row['type_image'] : $row['type_column'];
        $list_title = $list['title'];
        $list_content = $list['content'];
        echo '<h3 class="about__title">' . $list_title . '</h3>';
        if ($row['type'] == 'image') {
          if ($list_content) {
            foreach ($list_content as $item) {
              $image = (wp_is_mobile()) ? $item['image_mo'] : $item['image_pc'];
              echo '<figure class="figure">';
              echo '<img src="' . $image . '" alt="' . $item['title'] . '">';
              echo '</figure>';
            }
          }
        } elseif ($row['type'] == 'column') {
          echo '<ul class="list-circle row">';
          if ($list_content) {
            foreach ($list_content as $item) {
              echo '<li class="circle-item col-sm-4">';
              echo '<figure class="thumb">';
              echo '<img src="' . $item['image'] . '" alt="' . $item['title'] . '">';
              echo '</figure>';
              echo '<h4 class="h4">' . $item['title'] . '</h4>';
              echo '<p class="desc">' . $item['description'] . '</p>';
              echo '</li>';
            }
          }
          echo '</ul>';
        }
      }
    }
    ?>

  </section>
<?php endif; ?>
<!-- //mission -->

<!-- logo -->
<?php if ($about_logo_set && $tabmenu == $about_logo_tabmenu_encode) : ?>
  <section class="section about">

    <h3 class="sr-only"><?php echo $about_logo_tabmenu; ?></h3>

    <ul class="list-table">
      <?php
      $about_logo_space_set = $about_logo['space_set'];
      $about_logo_space = $about_logo['space'];
      $about_logo_space_title = $about_logo_space['title'];
      $about_logo_space_list = $about_logo_space['list'];
      ?>
      <?php if ($about_logo_space_set) : ?>
        <li class="table-item">
          <div class="left">
            <h4 class="h4"><?php echo $about_logo_space_title; ?></h4>
          </div>
          <div class="right">
            <ol class="space row">
              <?php
              if ($about_logo_space_list) {
                foreach ($about_logo_space_list as $row) {
                  echo '<li class="col-sm-6">';
                  echo '<figure class="figure">';
                  echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
                  echo '</figure>';
                  echo '<h5 class="h5_left">' . $row['name'] . '</h5>';
                  echo '<p class="desc">' . $row['description'] . '</p>';
                  echo '</li>';
                }
              }
              ?>
            </ol>
        </li>
      <?php endif; ?>
      <?php
      $about_logo_system_set = $about_logo['system_set'];
      $about_logo_system = $about_logo['system'];
      $about_logo_system_title = $about_logo_system['title'];
      $about_logo_system_list = $about_logo_system['list'];
      ?>
      <?php if ($about_logo_system_set) : ?>
        <li class="table-item">
          <div class="left">
            <h4 class="h4"><?php echo $about_logo_system_title; ?></h4>
          </div>
          <div class="right">
            <ol class="system row">
              <?php
              if ($about_logo_system_list) {
                foreach ($about_logo_system_list as $row) {
                  echo '<li class="col-sm-4">';
                  echo '<span class="chip" style="background-color:' . $row['color'] . ';"></span>';
                  echo '<h5 class="h5_left">' . $row['name'] . '</h5>';
                  echo '<p class="desc">' . $row['description'] . '</p>';
                  echo '</li>';
                }
              }
              ?>
            </ol>
          </div>
        </li>
      <?php endif; ?>
      <?php
      $about_logo_rule_set = $about_logo['rule_set'];
      $about_logo_rule = $about_logo['rule'];
      $about_logo_rule_title = $about_logo_rule['title'];
      $about_logo_rule_list = $about_logo_rule['list'];
      ?>
      <?php if ($about_logo_rule_set) : ?>
        <li class="table-item">
          <div class="left">
            <h4 class="h4"><?php echo $about_logo_rule_title; ?></h4>
          </div>
          <div class="right">
            <?php
            if ($about_logo_rule_list) {
              foreach ($about_logo_rule_list as $row) {
                echo '<figure class="rule figure">';
                echo '<img src="' . $row['image'] . '" alt="' . $row['title'] . '">';
                echo '</figure>';
              }
            }
            ?>
        </li>
      <?php endif; ?>
      <?php
      $about_logo_download_set = $about_logo['download_set'];
      $about_logo_download = $about_logo['download'];
      $about_logo_download_title = $about_logo_download['title'];
      $about_logo_download_list = $about_logo_download['list'];
      ?>
      <?php if ($about_logo_download_set) : ?>
        <li class="table-item">
          <div class="left"></div>
          <div class="right">
            <div class="download">
              <h5 class="h5_left"><?php echo $about_logo_download_title; ?></h5>
              <?php
              if ($about_logo_download_list) {
                foreach ($about_logo_download_list as $row) {
                  echo '<a href="' . $row['name']['url'] . '" class="btn btn-sm btn-ghost" download>' . $row['name']['subtype'] . '</a>';
                }
              }
              ?>
            </div>
          </div>
        </li>
      <?php endif; ?>
    </ul>

  </section>
<?php endif; ?>
<!-- //logo -->

<?php get_footer(); ?>