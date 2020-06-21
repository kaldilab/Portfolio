<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php
// post calendar
$args_calendar = array(
  'post_type' => 'calendar',
  'posts_per_page' => -1,
);
$query_calendar = new WP_Query($args_calendar);

// array calendar
$result_calendar = array();

if ($query_calendar->have_posts()) :
  while ($query_calendar->have_posts()) : $query_calendar->the_post();

    $id = get_the_id();
    $title = get_the_title();
    $date_start = get_field('calendar_date')['start'];
    $date_end = get_field('calendar_date')['end'];
    $time_start = get_field('calendar_time')['start'];
    $time_end = get_field('calendar_time')['end'];

    $array_event = array(
      'id' => $id,
      'title' => $title,
      'start' => $date_start . 'T' . $time_start,
      'end' => $date_end . 'T' . $time_end,
      'start_time' => $time_start,
      'end_time' => $time_end,
    );

    array_push($result_calendar, $array_event);

  endwhile;
endif;

// json calendar
$json_calendar = json_encode($result_calendar);
?>

<div id="combiCalendar"></div>

<script>
  document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('combiCalendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['dayGrid', 'googleCalendar'],

      // kaldi's google API
      googleCalendarApiKey: '',

      // post
      /* events: <?php echo $json_calendar; ?>, */

      // google
      /* events: {
        googleCalendarId: 'ko.south_korea#holiday@group.v.calendar.google.com',
        className: 'fc-google',
      }, */

      // post & google
      eventSources: [{
          googleCalendarId: '',
          className: 'fc-google',
        },
        <?php echo $json_calendar; ?>
      ],
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
        if (info.event.extendedProps.start_time && info.event.extendedProps.end_time) {
          var fc_time = '<div class="fc-time">' + time + '</div>';
        } else {
          var fc_time = '';
        }
        info.el.innerHTML = '<div class="fc-title">' + title + '</div>' + fc_time;
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