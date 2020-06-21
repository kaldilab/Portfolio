<?php get_header(); ?>

<div class="container-fluid dashboard-content">

  <?php get_template_part('templates/content', 'breadcrumb'); ?>

  <?php
  // post timetable
  $args_timetable = array(
    'post_type' => 'project',
    'posts_per_page' => -1,
    'meta_key' => 'project_finish',
    'meta_value' => '0',
  );
  $query_timetable = new WP_Query($args_timetable);
  ?>

  <?php
  if ($query_timetable->have_posts()) :
    while ($query_timetable->have_posts()) : $query_timetable->the_post();

      $id = get_the_ID();
      $title = get_the_title();

      // schedule
      $schedule_plan = get_field('schedule_plan');
      $schedule_design = get_field('schedule_design');
      $schedule_develop_frontend = get_field('schedule_develop_frontend');
      $schedule_develop_backend = get_field('schedule_develop_backend');
      $schedule_test_inside = get_field('schedule_test_inside');
      $schedule_test_outside = get_field('schedule_test_outside');

      // schedule start
      $schedule_plan_start = $schedule_plan['start'];
      $schedule_design_start = $schedule_design['start'];
      $schedule_develop_frontend_start = $schedule_develop_frontend['start'];
      $schedule_develop_backend_start = $schedule_develop_backend['start'];
      $schedule_test_inside_start = $schedule_test_inside['start'];
      $schedule_test_outside_start = $schedule_test_outside['start'];

      // schedule end
      $schedule_plan_end = $schedule_plan['end'];
      $schedule_design_end = $schedule_design['end'];
      $schedule_develop_frontend_end = $schedule_develop_frontend['end'];
      $schedule_develop_backend_end = $schedule_develop_backend['end'];
      $schedule_test_inside_end = $schedule_test_inside['end'];
      $schedule_test_outside_end = $schedule_test_outside['end'];

      // open
      $schedule_open = get_field('schedule_open');
      $schedule_open_date = $schedule_open['date'];

      // array
      $array_schedule = array(
        'id' => $id,
        'category' => $title,
        'start' => $schedule_plan_start,
        'end' => $schedule_open_date,
        'task' => '#' . $title . '(기획~오픈)',
        "color" => 'rgba(170,170,170,.7)',
      );
      $array_plan = array(
        'id' => $id,
        'category' => '기획 : ' . $title,
        'start' => $schedule_plan_start,
        'end' => $schedule_plan_end,
        'task' => '#' . $title . '(기획)',
        "color" => 'rgba(255,193,8,.4)',
      );
      $array_design = array(
        'id' => $id,
        'category' => '디자인 : ' . $title,
        'start' => $schedule_design_start,
        'end' => $schedule_design_end,
        'task' => '#' . $title . '(디자인)',
        "color" => 'rgba(255,64,123,.4)',
      );
      $array_frontend = array(
        'id' => $id,
        'category' => '프론트엔드 : ' . $title,
        'start' => $schedule_develop_frontend_start,
        'end' => $schedule_develop_frontend_end,
        'task' => '#' . $title . '(프론트엔드)',
        "color" => 'rgba(46,197,81,.4)',
      );
      $array_backend = array(
        'id' => $id,
        'category' => '백엔드 : ' . $title,
        'start' => $schedule_develop_backend_start,
        'end' => $schedule_develop_backend_end,
        'task' => '#' . $title . '(백엔드)',
        "color" => 'rgba(89,105,255,.4)',
      );
      $array_test_inside = array(
        'id' => $id,
        'category' => '내부테스트 : ' . $title,
        'start' => $schedule_test_inside_start,
        'end' => $schedule_test_inside_end,
        'task' => '#' . $title . '(내부테스트)',
        "color" => 'rgba(239,23,44,.4)',
      );
      $array_test_outside = array(
        'id' => $id,
        'category' => '외부테스트 : ' . $title,
        'start' => $schedule_test_outside_start,
        'end' => $schedule_test_outside_end,
        'task' => '#' . $title . '(외부테스트)',
        "color" => 'rgba(128,0,0,.4)',
      );
      $array_open = array(
        'id' => $id,
        'category' => '오픈 : ' . $title,
        'start' => $schedule_open_date,
        'end' => $schedule_open_date,
        'task' => '#' . $title . '(오픈)',
        "color" => 'rgba(37,213,242,.4)',
      );

      if ($schedule_plan_start && $schedule_plan_end) {
        $result_timetable[] = $array_schedule;
      }
      if ($schedule_plan_start && $schedule_plan_end) {
        $result_timetable[] = $array_plan;
      }
      if ($schedule_design_start && $schedule_design_end) {
        $result_timetable[] = $array_design;
      }
      if ($schedule_develop_frontend_start && $schedule_develop_frontend_end) {
        $result_timetable[] = $array_frontend;
      }
      if ($schedule_develop_backend_start && $schedule_develop_backend_end) {
        $result_timetable[] = $array_backend;
      }
      if ($schedule_test_inside_start && $schedule_test_inside_end) {
        $result_timetable[] = $array_test_inside;
      }
      if ($schedule_test_outside_start && $schedule_test_outside_end) {
        $result_timetable[] = $array_test_outside;
      }
      if ($schedule_open_date) {
        $result_timetable[] = $array_open;
      }

    endwhile;
  endif;

  // json timetable
  $json_timetable = json_encode($result_timetable);
  ?>

  <div class="section-block pb-3">
    <h2><i class="fa fa-fw fa-align-left"></i> 프로젝트 일정을 볼까요?</h2>
  </div>

  <div class="row">
    <div class="col-xl-12">
      <div class="card animated fadeIn">

        <?php get_template_part('templates/content', 'colorindex'); ?>

        <div class="card-body">

          <!-- amcharts -->
          <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/core.js"></script>
          <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/charts.js"></script>
          <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/themes/animated.js"></script>
          <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/lang/ko_KR.js"></script>

          <div id="timetableGantt"></div>

          <script>
            // animated
            am4core.useTheme(am4themes_animated);

            // chart
            var chart = am4core.create("timetableGantt", am4charts.XYChart);
            chart.data = <?php echo $json_timetable; ?>;
            chart.hiddenState.properties.opacity = 0;
            chart.paddingRight = 30;
            chart.dateFormatter.dateFormat = "yyyy-MM-dd";
            chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";
            chart.scrollbarX = new am4core.Scrollbar();
            chart.scrollbarY = new am4core.Scrollbar();
            chart.language.locale = am4lang_ko_KR;
            chart.language.locale["_date_day"] = "MM월 dd일";

            // colorset
            var colorSet = new am4core.ColorSet();
            colorSet.saturation = 0.5;

            // title
            var title = chart.titles.create();
            title.text = new Date().toISOString().substring(0, 10);
            title.fontSize = 25;
            title.marginBottom = 20;

            // categoryAxis
            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "category";
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.inversed = true;

            // dateAxis
            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.minGridDistance = 70;
            dateAxis.renderer.tooltipLocation = 0;
            dateAxis.baseInterval = {
              count: 1,
              timeUnit: "day"
            };

            // series
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.tooltip.label.interactionsEnabled = true;
            series.tooltip.keepTargetHover = true;
            series.columns.template.width = am4core.percent(100);
            series.columns.template.propertyFields.fill = "color";
            series.columns.template.propertyFields.stroke = "color";
            series.columns.template.strokeOpacity = 1;
            series.columns.template.tooltipHTML = '<a class="text-dark" href="<?php echo esc_url(home_url('present/?id=')); ?>{id}"><span>{task} : <b>{openDateX} ~ {dateX}</b></span></a>';
            series.dataFields.openDateX = "start";
            series.dataFields.dateX = "end";
            series.dataFields.categoryY = "category";

            // cursor
            chart.cursor = new am4charts.XYCursor();
            chart.cursor.behavior = "zoomXY";

            // today guide
            var today = new Date();
            var tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            var event = dateAxis.axisRanges.create();
            event.date = today;
            event.endDate = tomorrow;
            event.grid.disabled = true;
            event.axisFill.fill = am4core.color("black");
            event.axisFill.fillOpacity = 0.5;
            event.bullet = new am4core.Triangle();
            event.bullet.width = 15;
            event.bullet.height = 11;
            event.bullet.fill = am4core.color("red");
            event.bullet.horizontalCenter = "middle";
            event.label.text = "오늘";
            event.label.inside = true;
            event.label.valign = "top";
            event.label.location = -1;

            // cell size
            var cellSize = 20;
            chart.events.on("datavalidated", function(ev) {
              var chart = ev.target;
              var categoryAxis = chart.yAxes.getIndex(0);
              var adjustHeight = chart.data.length * cellSize - categoryAxis.pixelHeight;
              var targetHeight = chart.pixelHeight + adjustHeight;
              chart.svgContainer.htmlElement.style.height = targetHeight + "px";
            });
          </script>
          <!-- //amcharts -->

        </div>
      </div>
    </div>
  </div>

</div>

<?php get_footer(); ?>