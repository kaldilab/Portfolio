<?php get_header(); ?>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php $search = (isset($_GET['s'])) ? $_GET['s'] : null; ?>

<div class="text-center"><?php get_search_form(); ?></div>

<!-- 전체페이지 검색결과 -->
<?php
$num_search = 3;
if (!empty($_GET['load_search'])) {
  $load_search = $_GET['load_search'];
  $paging_search = $num_search * $load_search;
  $load_more_search = $load_search + 1;
} else {
  $paging_search = $num_search;
  $load_more_search = 2;
}
$args_search = array(
  'post_type' => array(
    'board_admin',
    'board_user',
    'board_approval',
    'post',
  ),
  'posts_per_page' => $paging_search,
  's' => $search,
);
$query_search = new WP_Query($args_search);
$count_search = $query_search->found_posts;
?>

<p>전체 : <strong><?php echo $count_search; ?></strong>개의 검색 결과를 찾았습니다.</p>

<ul class="list-group">
  <?php
  if ($query_search->have_posts()) {
    while ($query_search->have_posts()) {
      $query_search->the_post();
      $order_number_search = $query_search->current_post + 1;
      $terms_board_admin = wp_get_post_terms($post->ID, 'tax_board_admin', array('fields' => 'names'));
      $terms_board_user = wp_get_post_terms($post->ID, 'tax_board_user', array('fields' => 'names'));
      $terms_board_approval = wp_get_post_terms($post->ID, 'tax_board_approval', array('fields' => 'names'));
      if ($terms_board_admin) {
        $terms = $terms_board_admin;
      } else if ($terms_board_user) {
        $terms = $terms_board_user;
      } else if ($terms_board_approval) {
        $terms = $terms_board_approval;
      } else {
        $terms = null;
      }
      $term = ($terms) ? ('[' . $terms[0] . ']') : '';

      //검색어 하이라이트
      $title = preg_replace('/(' . $search . ')/iu', '<strong class="highlight">' . $search . '</strong>', get_the_title());
      $excerpt = preg_replace('/(' . $search . ')/iu', '<strong class="highlight">' . $search . '</strong>', get_the_excerpt());

      echo '<li class="list-group-item">';
      echo '<p><span>' . $order_number_search . '</span> <strong>' . $term . '</strong> <a href="' . project_permalink() . '">' . $title . '</a></p>';
      echo '<p class="text-truncate">' . $excerpt . '</p>';
      echo '<p>' . get_the_author() . ' | ' . get_the_date() . ' ' . get_the_time() . '</p>';
      get_template_part('templates/content', 'tags');
      echo '</li>';
    }
  } else {
    echo '<li class="list-group-item">';
    echo '<p class="none">검색 결과가 없습니다.</p>';
    echo '</li>';
  }
  wp_reset_postdata();
  ?>
</ul>

<div id="scrollToSearch">
  <?php
  if ($paging_search < $count_search) {
    echo '<form action="#scrollToSearch">';
    echo '<input type="hidden" name="load_search" value="' . $load_more_search . '">';
    echo '<input type="hidden" name="s" value="' . $search . '">';
    echo '<input class="btn btn-dark" type="submit" value="더보기">';
    echo '</form>';
  } else {
    echo ($num_search < $count_search) ? '<p>게시물이 없습니다.</p>' : null;
  }
  ?>
</div>
<!-- //전체페이지 검색결과 -->

<!-- 특정페이지 검색 -->
<?php
$board_admin = get_post_type_object('board_admin');
$board_admin_label = $board_admin->label;
$num_board_admin = 3;
if (!empty($_GET['load_board_admin'])) {
  $load_board_admin = $_GET['load_board_admin'];
  $paging_board_admin = $num_board_admin * $load_board_admin;
  $load_more_board_admin = $load_board_admin + 1;
} else {
  $paging_board_admin = $num_board_admin;
  $load_more_board_admin = 2;
}
$args_board_admin = array(
  'post_type' => 'board_admin',
  'posts_per_page' => $paging_board_admin,
  's' => $search,
);
$query_board_admin = new WP_Query($args_board_admin);
$count_board_admin = $query_board_admin->found_posts;
?>

<p class="mt-4"><?php echo $board_admin_label; ?> : <strong><?php echo $count_board_admin; ?></strong>개의 검색 결과</p>

<ul class="list-group">
  <?php
  if ($query_board_admin->have_posts()) {
    while ($query_board_admin->have_posts()) {
      $query_board_admin->the_post();
      $order_number_board_admin = $query_board_admin->current_post + 1;
      $terms = wp_get_post_terms($post->ID, 'tax_board_admin', array('fields' => 'names'));
      $term = ($terms) ? ('[' . $terms[0] . ']') : '';

      //검색어 하이라이트
      $title = preg_replace('/(' . $search . ')/iu', '<strong class="highlight">' . $search . '</strong>', get_the_title());
      $excerpt = preg_replace('/(' . $search . ')/iu', '<strong class="highlight">' . $search . '</strong>', get_the_excerpt());

      echo '<li class="list-group-item">';
      echo '<p><span>' . $order_number_board_admin . '</span> <strong>' . $term . '</strong> <a href="' . project_permalink() . '">' . $title . '</a></p>';
      echo '<p class="text-truncate">' . $excerpt . '</p>';
      echo '<p>' . get_the_author() . ' | ' . get_the_date() . ' ' . get_the_time() . '</p>';
      echo '</li>';
    }
  } else {
    echo '<li class="list-group-item">';
    echo '<p class="none">검색 결과가 없습니다.</p>';
    echo '</li>';
  }
  wp_reset_postdata();
  ?>
</ul>

<div id="scrollToBoardAdmin">
  <?php
  if ($paging_board_admin < $count_board_admin) {
    echo '<form action="#scrollToBoardAdmin">';
    echo '<input type="hidden" name="load_board_admin" value="' . $load_more_board_admin . '">';
    echo '<input type="hidden" name="s" value="' . $search . '">';
    echo '<input class="btn btn-dark" type="submit" value="더보기">';
    echo '</form>';
  } else {
    echo ($num_board_admin < $count_board_admin) ? '<p>게시물이 없습니다.</p>' : null;
  }
  ?>
</div>
<!-- //특정페이지 검색 -->

<!-- 특정카테고리 검색 -->
<?php
$category_card = get_category_by_slug('card');
$category_card_id = $category_card->term_id;
$category_card_name = $category_card->name;
$num_category_card = 3;
if (!empty($_GET['load_category_card'])) {
  $load_category_card = $_GET['load_category_card'];
  $paging_category_card = $num_category_card * $load_category_card;
  $load_more_category_card = $load_category_card + 1;
} else {
  $paging_category_card = $num_category_card;
  $load_more_category_card = 2;
}
$args_category_card = array(
  'cat' => $category_card_id,
  'posts_per_page' => $paging_category_card,
  's' => $search,
);
$query_category_card = new WP_Query($args_category_card);
$count_category_card = $query_category_card->found_posts;
?>

<p class="mt-4"><?php echo $category_card_name; ?> 카테고리 : <strong><?php echo $count_category_card; ?></strong>개의 검색 결과</p>

<ul class="list-group">
  <?php
  if ($query_category_card->have_posts()) {
    while ($query_category_card->have_posts()) {
      $query_category_card->the_post();
      $order_number_category_card = $query_category_card->current_post + 1;

      //검색어 하이라이트
      $title = preg_replace('/(' . $search . ')/iu', '<strong class="highlight">' . $search . '</strong>', get_the_title());
      $excerpt = preg_replace('/(' . $search . ')/iu', '<strong class="highlight">' . $search . '</strong>', get_the_excerpt());

      echo '<li class="list-group-item">';
      echo '<p><span>' . $order_number_category_card . '</span> <a href="' . project_permalink() . '">' . $title . '</a></p>';
      echo '<p class="text-truncate">' . $excerpt . '</p>';
      echo '<p>' . get_the_author() . ' | ' . get_the_date() . ' ' . get_the_time() . '</p>';
      echo '</li>';
    }
  } else {
    echo '<li class="list-group-item">';
    echo '<p class="none">검색 결과가 없습니다.</p>';
    echo '</li>';
  }
  wp_reset_postdata();
  ?>
</ul>

<div id="scrollToCategoryCard">
  <?php
  if ($paging_category_card < $count_category_card) {
    echo '<form action="#scrollToCategoryCard">';
    echo '<input type="hidden" name="load_category_card" value="' . $load_more_category_card . '">';
    echo '<input type="hidden" name="s" value="' . $search . '">';
    echo '<input class="btn btn-dark" type="submit" value="더보기">';
    echo '</form>';
  } else {
    echo ($num_category_card < $count_category_card) ? '<p>게시물이 없습니다.</p>' : null;
  }
  ?>
</div>
<!-- //특정카테고리 검색 -->

<!-- 복수 페이지네이션 검색 -->
<?php
// 페이지네비 리스트가 4개 일 때
$paged1 = isset($_GET['paged1']) ? (int) $_GET['paged1'] : 1;
$paged2 = isset($_GET['paged2']) ? (int) $_GET['paged2'] : 1;
$paged3 = isset($_GET['paged3']) ? (int) $_GET['paged3'] : 1;
$paging = 5;
?>

<!-- 관리자게시판 -->
<?php
$board_admin_navi = get_post_type_object('board_admin');
$board_admin_navi_label = $board_admin_navi->label;
$args_board_admin_navi = array(
  'post_type' => 'board_admin',
  'posts_per_page' => $paging,
  'paged' => $paged1,
  's' => $search,
);
$query_board_admin_navi = new WP_Query($args_board_admin_navi);
$count_board_admin_navi = $query_board_admin_navi->found_posts;
$order_board_admin_navi = ($paged1 == 1) ? '1' : ((($paged1 - 1) * $paging) + 1);
?>

<p class="mt-4"><?php echo $board_admin_navi_label; ?> : <strong><?php echo $count_board_admin_navi; ?></strong>개의 검색 결과</p>

<ul class="list-group">
  <?php
  if ($query_board_admin_navi->have_posts()) {
    while ($query_board_admin_navi->have_posts()) {
      $query_board_admin_navi->the_post();
      $terms = wp_get_post_terms($post->ID, 'tax_board_admin', array('fields' => 'names'));
      $term = ($terms) ? ('[' . $terms[0] . ']') : '';

      //검색어 하이라이트
      $title = preg_replace('/(' . $search . ')/iu', '<strong class="highlight">' . $search . '</strong>', get_the_title());
      $excerpt = preg_replace('/(' . $search . ')/iu', '<strong class="highlight">' . $search . '</strong>', get_the_excerpt());

      echo '<li class="list-group-item">';
      echo '<p><span>' . $order_board_admin_navi . '</span> <strong>' . $term . '</strong> <a href="' . project_permalink() . '">' . $title . '</a></p>';
      echo '<p class="text-truncate">' . $excerpt . '</p>';
      echo '<p>' . get_the_author() . ' | ' . get_the_date() . ' ' . get_the_time() . '</p>';
      echo '</li>';
      $order_board_admin_navi++;
    }
  } else {
    echo '<li class="list-group-item">';
    echo '<p class="none">검색 결과가 없습니다.</p>';
    echo '</li>';
  }
  wp_reset_postdata();
  ?>
</ul>

<div id="scrollToBoardAdminNavi">
  <?php
  $page_board_admin_navi = array(
    'format' => '?paged1=%#%#scrollToBoardAdminNavi',
    'total' => $query_board_admin_navi->max_num_pages,
    'current' => $paged1,
    'prev_text' => '이전',
    'next_text' => '다음',
  );
  echo paginate_links($page_board_admin_navi);
  ?>
</div>
<!-- //관리자게시판 -->

<!-- 회원게시판 -->
<?php
$board_user_navi = get_post_type_object('board_user');
$board_user_navi_label = $board_user_navi->label;
$args_board_user_navi = array(
  'post_type' => 'board_user',
  'posts_per_page' => $paging,
  'paged' => $paged2,
  's' => $search,
);
$query_board_user_navi = new WP_Query($args_board_user_navi);
$count_board_user_navi = $query_board_user_navi->found_posts;
$order_board_user_navi = ($paged2 == 1) ? '1' : ((($paged2 - 1) * $paging) + 1);
?>

<p class="mt-4"><?php echo $board_user_navi_label; ?> : <strong><?php echo $count_board_user_navi; ?></strong>개의 검색 결과</p>

<ul class="list-group">
  <?php
  if ($query_board_user_navi->have_posts()) {
    while ($query_board_user_navi->have_posts()) {
      $query_board_user_navi->the_post();
      $terms = wp_get_post_terms($post->ID, 'tax_board_user', array('fields' => 'names'));
      $term = ($terms) ? ('[' . $terms[0] . ']') : '';

      //검색어 하이라이트
      $title = preg_replace('/(' . $search . ')/iu', '<strong class="highlight">' . $search . '</strong>', get_the_title());
      $excerpt = preg_replace('/(' . $search . ')/iu', '<strong class="highlight">' . $search . '</strong>', get_the_excerpt());

      echo '<li class="list-group-item">';
      echo '<p><span>' . $order_board_user_navi . '</span> <strong>' . $term . '</strong> <a href="' . project_permalink() . '">' . $title . '</a></p>';
      echo '<p class="text-truncate">' . $excerpt . '</p>';
      echo '<p>' . get_the_author() . ' | ' . get_the_date() . ' ' . get_the_time() . '</p>';
      echo '</li>';
      $order_board_user_navi++;
    }
  } else {
    echo '<li class="list-group-item">';
    echo '<p class="none">검색 결과가 없습니다.</p>';
    echo '</li>';
  }
  wp_reset_postdata();
  ?>
</ul>

<div id="scrollToBoardUserNavi">
  <?php
  $page_board_user_navi = array(
    'format' => '?paged2=%#%#scrollToBoardUserNavi',
    'total' => $query_board_user_navi->max_num_pages,
    'current' => $paged2,
    'prev_text' => '이전',
    'next_text' => '다음',
  );
  echo paginate_links($page_board_user_navi);
  ?>
</div>
<!-- //회원게시판 -->

<!-- 블로그 카테고리 -->
<?php
$category_blog = get_category_by_slug('blog');
$category_blog_id = $category_blog->term_id;
$category_blog_name = $category_blog->name;
$args_category_blog = array(
  'cat' => $category_blog_id,
  'posts_per_page' => $paging,
  'paged' => $paged3,
  's' => $search,
);
$query_category_blog = new WP_Query($args_category_blog);
$count_category_blog = $query_category_blog->found_posts;
$order_category_blog = ($paged3 == 1) ? '1' : ((($paged3 - 1) * $paging) + 1);
?>

<p class="mt-4"><?php echo $category_blog_name; ?> 카테고리 : <strong><?php echo $count_category_blog; ?></strong>개의 검색 결과</p>

<ul class="list-group">
  <?php
  if ($query_category_blog->have_posts()) {
    while ($query_category_blog->have_posts()) {
      $query_category_blog->the_post();

      //검색어 하이라이트
      $title = preg_replace('/(' . $search . ')/iu', '<strong class="highlight">' . $search . '</strong>', get_the_title());
      $excerpt = preg_replace('/(' . $search . ')/iu', '<strong class="highlight">' . $search . '</strong>', get_the_excerpt());

      echo '<li class="list-group-item">';
      echo '<p><span>' . $order_category_blog . '</span> <a href="' . project_permalink() . '">' . $title . '</a></p>';
      echo '<p class="text-truncate">' . $excerpt . '</p>';
      echo '<p>' . get_the_author() . ' | ' . get_the_date() . ' ' . get_the_time() . '</p>';
      echo '</li>';
      $order_category_blog++;
    }
  } else {
    echo '<li class="list-group-item">';
    echo '<p class="none">검색 결과가 없습니다.</p>';
    echo '</li>';
  }
  wp_reset_postdata();
  ?>
</ul>

<div id="scrollToCategoryBlog">
  <?php
  $page_category_blog = array(
    'format' => '?paged3=%#%#scrollToCategoryBlog',
    'total' => $query_category_blog->max_num_pages,
    'current' => $paged3,
    'prev_text' => '이전',
    'next_text' => '다음',
  );
  echo paginate_links($page_category_blog);
  ?>
</div>
<!-- //블로그 카테고리 -->
<!-- //복수 페이지네이션 검색 -->

<!-- scroll to more -->
<script>
  jQuery(document).ready(function($) {
    if (window.location.hash) {
      // hash
      hash = window.location.hash;
      // scrollTo
      check = hash.indexOf('scrollTo');
      $target = $(hash);
      if ($target && check) {
        $('html, body').animate({
          scrollTop: ($target.offset().top + $target.height() - $(window).height()) + 50
        }, 1);
      }
    }
  });
</script>
<!-- //scroll to more -->

<?php get_footer(); ?>