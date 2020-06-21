<?php get_header(); ?>

<?php echo project_apply_message(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<!-- 유형 -->
<div class="pt-2 text-right">
  <?php
  $terms_program = get_terms([
    'taxonomy' => 'tax_program',
    'hide_empty' => false,
  ]);
  foreach ($terms_program as $term) {
    echo '<span class="btn btn-light type-' . $term->term_id . '">' . $term->name . '</span>';
  }
  ?>
</div>
<!-- //유형 -->

<?php
// post program
$args_program = array(
  'post_type' => 'program',
  'posts_per_page' => -1,
  'meta_query' => array(
    'relation' => 'AND',
    array(
      'key' => 'program_status',
      'value' => '0',
    ),
    array(
      'key' => 'program_date_end',
      'value' => date_i18n('Y-m-d'),
      'compare' => '>=',
      'type' => 'DATE',
    ),
  ),
);
$query_program = new WP_Query($args_program);

// array program
$result_program = array();

if ($query_program->have_posts()) :
  while ($query_program->have_posts()) : $query_program->the_post();

    $id = get_the_id();
    $url = project_permalink();
    $title = get_the_title();
    $date_start = get_field('program_date')['start'];
    $date_end = get_field('program_date')['end'];
    $time_start = get_field('program_time')['start'];
    $time_end = get_field('program_time')['end'];
    $category = wp_get_post_terms($post->ID, 'tax_program', array("fields" => "all"))[0];
    $category_name = $category->name;
    $category_id = $category->term_id;
    $get_today = date_i18n('Y-m-d');
    $finish_number = get_field('program_number');

    // post program apply
    $args_program_apply = array(
      'post_type' => 'program_apply',
      'post_status' => 'pending, publish',
      'posts_per_page' => -1,
      'meta_query' => array(
        'relation' => 'AND',
        array(
          'key' => 'program_apply_id',
          'value' => $id,
        ),
      ),
    );
    $query_program_apply = new WP_Query($args_program_apply);
    $count_program_apply = $query_program_apply->found_posts;

    if ($count_program_apply < $finish_number) {
      // array event
      $array_event = array(
        'id' => $id,
        'url' => $url,
        'title' => $title,
        'start' => $date_start . 'T' . $time_start,
        'end' => $date_end . 'T' . $time_start,
        'start_time' => $time_start,
        'end_time' => $time_end,
        'description' => $category_name,
        'classNames' => 'fc-type-' . $category_id,
      );
      array_push($result_program, $array_event);
    } else {
      // array event
      $array_event = array(
        'id' => $id,
        'title' => $title . '(마감)',
        'start' => $date_start . 'T' . $time_start,
        'end' => $date_end . 'T' . $time_start,
        'start_time' => $time_start,
        'end_time' => $time_end,
        'description' => $category_name,
        'classNames' => 'fc-type-' . $category_id,
      );
      array_push($result_program, $array_event);
    }

  endwhile;
endif;

// json program
$json_program = json_encode($result_program);
?>

<div id="programCalendar"></div>

<script>
  document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('programCalendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['dayGrid'],
      events: <?php echo $json_program; ?>,
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
        var category = info.event.extendedProps.description;
        info.el.innerHTML = '<div class="fc-title">' + title + '</div>' + '<div class="fc-time">' + time + '</div>' + '<div class="fc-category">' + category + '</div>';
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