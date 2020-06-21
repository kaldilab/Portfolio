<?php get_header(); ?>

<?php
// CPT
$post_name = $post->post_name;
$custom_post_type = 'cpt_' . $post_name;
$custom_taxonomy = 'tax_' . $post_name;
?>

<div class="sub__top">
  <h2 class="sub__title"><?php the_title(); ?></h2>
  <?php get_template_part('templates/content', 'breadcrumb'); ?>
</div>

<!-- 신청하기 -->
<div class="text-right">
  <!-- <a class="btn btn-danger" href="#">외부신청</a> -->
  <!-- <a class="btn btn-dark" href="<?php echo project_homeurl('rental-add/?return=') . $post->post_name; ?>">신청하기</a> -->
</div>
<!-- //신청하기 -->

<section class="section">

  <!-- 공간 -->
  <div class="pt-2 text-right">
    <?php
    $terms_rental = get_terms([
      'taxonomy' => $custom_taxonomy,
      'hide_empty' => false,
    ]);
    foreach ($terms_rental as $term) {
      echo '<span class="btn btn-light space-' . $term->term_id . '">' . $term->name . '</span>';
    }
    ?>
  </div>
  <!-- //공간 -->

  <?php
  // post rental
  $args_rental = array(
    'post_type' => $custom_post_type,
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'meta_query' => array(
      'relation' => 'OR',
      array(
        'key' => 'rental_status',
        'value' => '승인',
      ),
      array(
        'key' => 'rental_limit',
        'value' => '1',
      ),
    ),
  );
  $query_rental = new WP_Query($args_rental);

  // array rental
  $result_rental = array();

  if ($query_rental->have_posts()) :
    while ($query_rental->have_posts()) : $query_rental->the_post();

      $id = get_the_id();
      $title = get_the_title();
      $date = get_field('rental_date');
      $time_start = get_field('rental_time')['start'];
      $time_end = get_field('rental_time')['end'];
      if (!empty(get_field('rental_space'))) {
        $space_id = get_term_by('id', get_field('rental_space'), $custom_taxonomy)->term_id;
        $space_name = get_term_by('id', get_field('rental_space'), $custom_taxonomy)->name;
      }

      // array event
      if (get_field('rental_limit')) {
        // 지정일
        $array_event = array(
          'id' => $id,
          'title' => $title,
          'start' => $date . 'T' . '00:00',
          'end' => $date . 'T' . '23:59',
          'start_time' => '00:00',
          'end_time' => '23:59',
          'description' => '',
          'classNames' => 'fc-limit',
        );
      } else {
        // 대관일
        $array_event = array(
          'id' => $id,
          'title' => $title,
          'start' => $date . 'T' . $time_start,
          'end' => $date . 'T' . $time_end,
          'start_time' => $time_start,
          'end_time' => $time_end,
          'description' => $space_name,
          'classNames' => 'fc-space-' . $space_id,
        );
      }

      array_push($result_rental, $array_event);

    endwhile;
  endif;

  // json rental
  $json_rental = json_encode($result_rental);
  ?>

  <div id="rentCalendar"></div>

</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('rentCalendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['dayGrid'],
      events: <?php echo $json_rental; ?>,
      height: 'auto',
      contentHeight: 'auto',
      locale: 'ko',
      timeZone: 'local',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: ''
      },
      eventOrder: 'start_time',
      eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false,
      },
      eventRender: function(info) {
        var title = info.event.title;
        var time = info.event.extendedProps.start_time + ' ~ ' + info.event.extendedProps.end_time;
        var space = info.event.extendedProps.description;
        info.el.innerHTML = '<div class="fc-title">' + title + '</div>' + '<div class="fc-time">' + time + '</div>' + '<div class="fc-space">' + space + '</div>';
      },
    });

    calendar.render();

    // '일'자 제거
    remove_string();
    var elements = document.querySelectorAll('.fc-button');
    for (var i = 0; i < elements.length; i++) {
      elements[i].addEventListener("click", function() {
        remove_string();
      });
    }

    function remove_string() {
      document.querySelectorAll('.fc-day-number').forEach(function(el) {
        el.innerHTML = el.innerHTML.replace(/일/g, '');
      });
    }

  });
</script>

<?php get_footer(); ?>