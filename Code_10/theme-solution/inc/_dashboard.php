<?php
// remove welcome panel
remove_action('welcome_panel', 'wp_welcome_panel');

// remove dashboard
function project_remove_dashboard()
{
  // 워드프레스 뉴스
  remove_meta_box('dashboard_primary', 'dashboard', 'normal');
  // 빠른 임시글
  remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
  // 사이트 현황
  remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
  // 활동
  remove_meta_box('dashboard_activity', 'dashboard', 'normal');
  // 사이트 건강 상태
  remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
}
add_action('admin_init', 'project_remove_dashboard');

// custom welcome panel
function project_custom_welcom_panel()
{
?>
  <style>
    .welcome-panel-inner {
      padding: 40px;
    }

    .welcome-panel-inner .logo {
      width: 200px;
    }

    .welcome-panel-inner .title {
      margin-top: 20px;
    }
  </style>
  <div class="welcome-panel-inner">
    <img class="logo" src="<?php echo get_template_directory_uri() . '/images/logo.png'; ?>" alt="dev">
    <h1 class="title">홈페이지에 오신 것을 환영합니다. [Ver. 0.9]</h1>
    <p class="about-description">최신 현황을 확인할 수 있습니다.</p>
    <div class="welcome-panel-column-container">
      <div class="welcome-panel-column"></div>
      <div class="welcome-panel-column"></div>
      <div class="welcome-panel-column"></div>
    </div>
  </div>
  <?php
}
add_action('welcome_panel', 'project_custom_welcom_panel');

// add footer
function project_custom_dashboard_style()
{
  global $pagenow;
  if ($pagenow === 'index.php') {
  ?>
    <style type="text/css">
      .custom_dashboard_table {
        width: 100%;
      }

      .custom_dashboard_table td a {
        max-width: 270px;
        display: inline-block;
        vertical-align: middle;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;

      }

      .custom_dashboard_table td sup {
        color: red;
        display: inline-block;
        vertical-align: middle;
      }

      .custom_dashboard_table.table_board td::after {
        display: table;
        clear: both;
      }

      .custom_dashboard_table.table_board td .thumb {
        display: block;
        float: left;
        width: 50px;
        height: 50px;
      }

      .custom_dashboard_table.table_board td .text {
        display: block;
        float: left;
        width: calc(100% - 70px);
        padding: 0 10px;
      }

      .custom_dashboard_table.table_board td a {
        display: inline-block;
        max-width: 250px;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
      }

      .custom_dashboard_table.table_board td .text p {
        display: block;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 38px;
      }

      .custom_dashboard_table.table_board td:last-child {
        vertical-align: top;
      }
    </style>
<?php
  }
}
add_action('admin_footer', 'project_custom_dashboard_style');

// custom dashboard
function project_custom_dashboard()
{
  $args_cpt = array(
    'public'   => true,
    '_builtin' => false,
  );
  $all_post_types = get_post_types($args_cpt, 'objects');
  foreach ($all_post_types as $post_type) {
    $post_type_name = $post_type->name;
    $post_type_label = $post_type->label;
    wp_add_dashboard_widget('custom_dashboard_' . $post_type_name, $post_type_label . ' 최신글', function () use ($post_type_name) {
      $args_post_type = array(
        'post_type' => $post_type_name,
        'posts_per_page' => 5,
      );
      $board_check = (strpos($post_type_name, 'board') !== false) ? 'table_board' : '';
      echo '<table class="custom_dashboard_table ' . $board_check . '">';
      echo '<colgroup>';
      echo '<col style="width: 80%;>';
      echo '<col style="width: 20%;>';
      echo '</colgroup>';
      echo '<tbody>';
      $query_post_type = new WP_Query($args_post_type);
      if ($query_post_type->have_posts()) {
        while ($query_post_type->have_posts()) {
          $query_post_type->the_post();
          $the_date = get_the_date();
          $today = date('Y-m-d');
          $yesterday = date('Y-m-d', strtotime(' -1 day'));
          $new_post = ($today == $the_date || $yesterday == $the_date) ? '<sup>New</sup> ' : '';
          echo '<tr>';
          echo '<td>';
          $title = '<a href="' . get_edit_post_link() . '">' . get_the_title() . '</a>' . $new_post;
          if (strpos(get_post_type(), 'board') !== false) {
            echo project_featured_image('img_default.png');
            echo '<div class="text">';
            echo $title;
            echo '<p>' . get_the_excerpt() . '</p>';
            echo '</div>';
          } else {
            echo $title;
          }
          echo '</td>';
          echo '<td>' . get_the_date() . '</td>';
          echo '</tr>';
        }
      } else {
        echo '<tr>';
        echo '<td>게시글이 없습니다.</td>';
        echo '</tr>';
      }
      wp_reset_postdata();
      echo '</tbody>';
      echo '</table>';
    });
  }
}
add_action('wp_dashboard_setup', 'project_custom_dashboard');
