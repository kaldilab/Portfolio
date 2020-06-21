<?php get_header(); ?>


<div class="container-fluid dashboard-content">

  <?php get_template_part('templates/content', 'breadcrumb'); ?>

  <?php
  // post calendar
  $args_calendar = array(
    'post_type' => 'project',
    'posts_per_page' => -1,
    'p' => $_GET['id'],
  );
  $query_calendar = new WP_Query($args_calendar);

  // array calendar
  $result_calendar = array();
  ?>

  <?php
  if ($query_calendar->have_posts()) :
    while ($query_calendar->have_posts()) : $query_calendar->the_post();

      // schedule
      $schedule_contents = get_field('schedule_contents');
      $schedule_plan = get_field('schedule_plan');
      $schedule_design = get_field('schedule_design');
      $schedule_develop_frontend = get_field('schedule_develop_frontend');
      $schedule_develop_backend = get_field('schedule_develop_backend');
      $schedule_test_inside = get_field('schedule_test_inside');
      $schedule_test_outside = get_field('schedule_test_outside');

      // schedule start
      $schedule_contents_start = $schedule_contents['start'];
      $schedule_plan_start = $schedule_plan['start'];
      $schedule_design_start = $schedule_design['start'];
      $schedule_develop_frontend_start = $schedule_develop_frontend['start'];
      $schedule_develop_backend_start = $schedule_develop_backend['start'];
      $schedule_test_inside_start = $schedule_test_inside['start'];
      $schedule_test_outside_start = $schedule_test_outside['start'];

      // schedule end
      $schedule_contents_end = $schedule_contents['end'];
      $schedule_plan_end = $schedule_plan['end'];
      $schedule_design_end = $schedule_design['end'];
      $schedule_develop_frontend_end = $schedule_develop_frontend['end'];
      $schedule_develop_backend_end = $schedule_develop_backend['end'];
      $schedule_test_inside_end = $schedule_test_inside['end'];
      $schedule_test_outside_end = $schedule_test_outside['end'];

      // open
      $schedule_open = get_field('schedule_open');
      $schedule_open_date = $schedule_open['date'];

      // contract
      $contract_period = get_field('contract_period');
      $contract_period_start = $contract_period['start'];
      $contract_period_end = $contract_period['end'];

      // array
      $array_contract = array(
        'title' => '계약기간',
        'start' => $contract_period_start,
        'end' => $contract_period_end,
        'backgroundColor' => 'rgba(170,170,170,.7)',
        'borderColor' => 'rgba(170,170,170,.7)',
      );
      $array_contents = array(
        'title' => '콘텐츠준비',
        'start' => $schedule_contents_start,
        'end' => $schedule_contents_end,
        'backgroundColor' => 'rgba(128,128,0,.7)',
        'borderColor' => 'rgba(128,128,0,.7)',
      );
      $array_plan = array(
        'title' => '기획',
        'start' => $schedule_plan_start,
        'end' => $schedule_plan_end,
        'backgroundColor' => 'rgba(255,193,8,.7)',
        'borderColor' => 'rgba(255,193,8,.7)',
      );
      $array_design = array(
        'title' => '디자인',
        'start' => $schedule_design_start,
        'end' => $schedule_design_end,
        'backgroundColor' => 'rgba(255,64,123,.7)',
        'borderColor' => 'rgba(255,64,123,.7)',
      );
      $array_frontend = array(
        'title' => '프론트엔드',
        'start' => $schedule_develop_frontend_start,
        'end' => $schedule_develop_frontend_end,
        'backgroundColor' => 'rgba(46,197,81,.7)',
        'borderColor' => 'rgba(46,197,81,.7)',
      );
      $array_backend = array(
        'title' => '백엔드',
        'start' => $schedule_develop_backend_start,
        'end' => $schedule_develop_backend_end,
        'backgroundColor' => 'rgba(89,105,255,.7)',
        'borderColor' => 'rgba(89,105,255,.7)',
      );
      $array_test_inside = array(
        'title' => '내부테스트',
        'start' => $schedule_test_inside_start,
        'end' => $schedule_test_inside_end,
        'backgroundColor' => 'rgba(239,23,44,.7)',
        'borderColor' => 'rgba(239,23,44,.7)',
      );
      $array_test_outside = array(
        'title' => '외부테스트',
        'start' => $schedule_test_outside_start,
        'end' => $schedule_test_outside_end,
        'backgroundColor' => 'rgba(128,0,0,.7)',
        'borderColor' => 'rgba(128,0,0,.7)',
      );
      $array_open = array(
        'title' => '오픈',
        'start' => $schedule_open_date,
        'backgroundColor' => 'rgba(37,213,242,.7)',
        'borderColor' => 'rgba(37,213,242,.7)',
      );
      $result_calendar[] = $array_contract;
      $result_calendar[] = $array_contents;
      $result_calendar[] = $array_plan;
      $result_calendar[] = $array_design;
      $result_calendar[] = $array_frontend;
      $result_calendar[] = $array_backend;
      $result_calendar[] = $array_test_inside;
      $result_calendar[] = $array_test_outside;
      $result_calendar[] = $array_open;

    endwhile;
  endif;

  // json calendar
  $json_calendar = json_encode($result_calendar);
  ?>

  <div class="row">
    <div class="col-xl-12">
      <h2 class="text-center"><?php echo get_the_title(); ?></h2>
      <p class="text-center"><i class="fas fa-clock"></i> <?php echo date("Y-m-d"); ?></p>
    </div>
  </div>

  <!-- calendar -->
  <div class="row">
    <div class="col-xl-12 mt-5">
      <div class="card animated fadeIn">

        <?php get_template_part('templates/content', 'colorindex'); ?>

        <div class="card-body">

          <!-- fullcalendar -->
          <link href='<?php echo get_template_directory_uri(); ?>/_source/assets/vendor/full-calendar/css/fullcalendar.css' rel='stylesheet'>

          <div id="projectCalendar"></div>

          <script>
            document.addEventListener('DOMContentLoaded', function() {

              var calendarEl = document.getElementById('projectCalendar');
              var calendar = new FullCalendar.Calendar(calendarEl, {
                <?php echo "events:" . $json_calendar . ","; ?>
                plugins: ['dayGrid', 'timeGrid', 'list'],
                locale: 'ko',
                timeZone: 'local',
                height: 'auto',
                header: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'dayGridMonth,timeGridWeek,list',
                },
              });

              calendar.render();

              var header_button = document.querySelectorAll('.fc-button');
              for (var i = 0; i < header_button.length; i++) {
                header_button[i].classList.add('fc-state-default');
              }

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
          <!-- //fullcalendar -->

        </div>
      </div>
    </div>
  </div>
  <!-- //calendar -->

  <?php get_template_part('templates/content', 'prevnext'); ?>

</div>

<?php get_footer(); ?>