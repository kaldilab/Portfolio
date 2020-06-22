<?php get_header(); ?>

<div class="container-fluid dashboard-content">

  <?php get_template_part('templates/content', 'breadcrumb'); ?>

  <?php
  $args_schedule = array(
    'post_type' => array(
      'project',
      'running',
      'onlyone',
      'tf',
    ),
    'posts_per_page' => -1,
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key' => 'project_finish',
        'value' => '0',
      ),
    ),
  );
  $query_schedule = new WP_Query($args_schedule);
  ?>

  <?php
  if ($query_schedule->have_posts()) {
    while ($query_schedule->have_posts()) {
      $query_schedule->the_post();

      $title = get_the_title();

      // work
      $work_manager = get_field('work_manager');
      $work_planner = get_field('work_planner');
      $work_designer = get_field('work_designer');
      $work_frontend_developer = get_field('work_frontend_developer');
      $work_backend_developer = get_field('work_backend_developer');
      $work_assistant = get_field('work_assistant');

      // contract period
      $contract_period = get_field('contract_period');
      $contract_period_start = $contract_period['start'];
      $contract_period_end = $contract_period['end'];

      // tf period
      $tf_period = get_field('tf_period');
      $tf_period_start = $tf_period['start'];
      $tf_period_end = $tf_period['end'];

      if ($work_manager) {
        foreach ($work_manager as $row) {
          $start = isset($row['start']) ? $row['start'] : date("Y-m-d", strtotime("-12 month", time()));
          $end = isset($row['end']) ? $row['end'] : date("Y-m-d", strtotime("+12 month", time()));
          if ($row['worker'] && $start && $end) {
            $worker = $row['worker']->name . '(' . $row['worker']->description . ')';
            if ($post->post_type == 'onlyone') {
              $schedule_start = $contract_period_start;
              $schedule_end = $contract_period_end;
              $task = '(단건) #' . $title . ' @매니저';
            } else if ($post->post_type == 'tf') {
              $schedule_start = $tf_period_start;
              $schedule_end = $tf_period_end;
              $task = '(TF) #' . $title . ' @매니저';
            } else {
              $schedule_start = $start;
              $schedule_end = $end;
              $task = (($post->post_type == 'running') ? '(운영) ' : '') . '#' . $title . ' @매니저';
            }
            $array_manager = array(
              'slug' => $row['worker']->slug,
              'category' => $worker,
              'start' => $schedule_start,
              'end' => $schedule_end,
              'task' => $task,
              "color" => 'rgba(241,90,34,.4)',
            );
            $result_manager[] = $array_manager;
          }
        }
      }
      if ($work_planner) {
        foreach ($work_planner as $row) {
          $start = isset($row['start']) ? $row['start'] : date("Y-m-d", strtotime("-12 month", time()));
          $end = isset($row['end']) ? $row['end'] : date("Y-m-d", strtotime("+12 month", time()));
          if ($row['worker'] && $start && $end) {
            $worker = $row['worker']->name . '(' . $row['worker']->description . ')';
            if ($post->post_type == 'onlyone') {
              $schedule_start = $contract_period_start;
              $schedule_end = $contract_period_end;
              $task = '(단건) #' . $title . ' @기획자';
            } else if ($post->post_type == 'tf') {
              $schedule_start = $tf_period_start;
              $schedule_end = $tf_period_end;
              $task = '(TF) #' . $title . ' @기획자';
            } else {
              $schedule_start = $start;
              $schedule_end = $end;
              $task = (($post->post_type == 'running') ? '(운영) ' : '') . '#' . $title . ' @기획자';
            }
            $array_planner = array(
              'slug' => $row['worker']->slug,
              'category' => $worker,
              'start' => $schedule_start,
              'end' => $schedule_end,
              'task' => $task,
              "color" => 'rgba(255,193,8,.4)',
            );
            $result_planner[] = $array_planner;
          }
        }
      }
      if ($work_designer) {
        foreach ($work_designer as $row) {
          $start = isset($row['start']) ? $row['start'] : date("Y-m-d", strtotime("-12 month", time()));
          $end = isset($row['end']) ? $row['end'] : date("Y-m-d", strtotime("+12 month", time()));
          if ($row['worker'] && $start && $end) {
            $worker = $row['worker']->name . '(' . $row['worker']->description . ')';
            if ($post->post_type == 'onlyone') {
              $schedule_start = $contract_period_start;
              $schedule_end = $contract_period_end;
              $task = '(단건) #' . $title . ' @디자이너';
            } else if ($post->post_type == 'tf') {
              $schedule_start = $tf_period_start;
              $schedule_end = $tf_period_end;
              $task = '(TF) #' . $title . ' @디자이너';
            } else {
              $schedule_start = $start;
              $schedule_end = $end;
              $task = (($post->post_type == 'running') ? '(운영) ' : '') . '#' . $title . ' @디자이너';
            }
            $array_designer = array(
              'slug' => $row['worker']->slug,
              'category' => $worker,
              'start' => $schedule_start,
              'end' => $schedule_end,
              'task' => $task,
              "color" => 'rgba(255,64,123,.4)',
            );
            $result_designer[] = $array_designer;
          }
        }
      }
      if ($work_frontend_developer) {
        foreach ($work_frontend_developer as $row) {
          $start = isset($row['start']) ? $row['start'] : date("Y-m-d", strtotime("-12 month", time()));
          $end = isset($row['end']) ? $row['end'] : date("Y-m-d", strtotime("+12 month", time()));
          if ($row['worker'] && $start && $end) {
            $worker = $row['worker']->name . '(' . $row['worker']->description . ')';
            if ($post->post_type == 'onlyone') {
              $schedule_start = $contract_period_start;
              $schedule_end = $contract_period_end;
              $task = '(단건) #' . $title . ' @프론트엔드개발자';
            } else if ($post->post_type == 'tf') {
              $schedule_start = $tf_period_start;
              $schedule_end = $tf_period_end;
              $task = '(TF) #' . $title . ' @프론트엔드개발자';
            } else {
              $schedule_start = $start;
              $schedule_end = $end;
              $task = (($post->post_type == 'running') ? '(운영) ' : '') . '#' . $title . ' @프론트엔드개발자';
            }
            $array_frontend_developer = array(
              'slug' => $row['worker']->slug,
              'category' => $worker,
              'start' => $schedule_start,
              'end' => $schedule_end,
              'task' => $task,
              "color" => 'rgba(46,197,81,.4)',
            );
            $result_frontend_developer[] = $array_frontend_developer;
          }
        }
      }
      if ($work_backend_developer) {
        foreach ($work_backend_developer as $row) {
          $start = isset($row['start']) ? $row['start'] : date("Y-m-d", strtotime("-12 month", time()));
          $end = isset($row['end']) ? $row['end'] : date("Y-m-d", strtotime("+12 month", time()));
          if ($row['worker'] && $start && $end) {
            $worker = $row['worker']->name . '(' . $row['worker']->description . ')';
            if ($post->post_type == 'onlyone') {
              $schedule_start = $contract_period_start;
              $schedule_end = $contract_period_end;
              $task = '(단건) #' . $title . ' @백엔드개발자';
            } else if ($post->post_type == 'tf') {
              $schedule_start = $tf_period_start;
              $schedule_end = $tf_period_end;
              $task = '(TF) #' . $title . ' @백엔드개발자';
            } else {
              $schedule_start = $start;
              $schedule_end = $end;
              $task = (($post->post_type == 'running') ? '(운영) ' : '') . '#' . $title . ' @백엔드개발자';
            }
            $array_backend_developer = array(
              'slug' => $row['worker']->slug,
              'category' => $worker,
              'start' => $schedule_start,
              'end' => $schedule_end,
              'task' => $task,
              "color" => 'rgba(89,105,255,.4)',
            );
            $result_backend_developer[] = $array_backend_developer;
          }
        }
      }
      if ($work_assistant) {
        foreach ($work_assistant as $row) {
          $start = isset($row['start']) ? $row['start'] : date("Y-m-d", strtotime("-12 month", time()));
          $end = isset($row['end']) ? $row['end'] : date("Y-m-d", strtotime("+12 month", time()));
          if ($row['worker'] && $start && $end) {
            $worker = $row['worker']->name . '(' . $row['worker']->description . ')';
            if ($post->post_type == 'onlyone') {
              $schedule_start = $contract_period_start;
              $schedule_end = $contract_period_end;
              $task = '(단건) #' . $title . ' @어시스턴트';
            } else if ($post->post_type == 'tf') {
              $schedule_start = $tf_period_start;
              $schedule_end = $tf_period_end;
              $task = '(TF) #' . $title . ' @어시스턴트';
            } else {
              $schedule_start = $start;
              $schedule_end = $end;
              $task = (($post->post_type == 'running') ? '(운영) ' : '') . '#' . $title . ' @어시스턴트';
            }
            $array_assistant = array(
              'slug' => $row['worker']->slug,
              'category' => $worker,
              'start' => $schedule_start,
              'end' => $schedule_end,
              'task' => $task,
              "color" => 'rgba(170,170,170,.4)',
            );
            $result_assistant[] = $array_assistant;
          }
        }
      }
    }
  }
  ?>

  <?php
  // result schedule
  $result_schedule = array_merge($result_manager, $result_planner, $result_designer, $result_frontend_developer, $result_backend_developer, $result_assistant);

  // json schedule
  $json_schedule = json_encode($result_schedule);
  ?>

  <div class="section-block pb-3">
    <h2><i class="fa fa-fw fa-paw"></i> 슬로워커 스케쥴을 볼까요?</h2>
  </div>


  <div class="row">
    <div class="col-xl-12">
      <div class="card animated fadeIn">
        <div class="card-body p-4">
          <span class="badge" style="background-color:rgba(241,90,34,.7);color:#fff;font-size:12px">매니저</span>
          <span class="badge" style="background-color:rgba(255,193,8,.7);color:#fff;font-size:12px">기획자</span>
          <span class="badge" style="background-color:rgba(255,64,123,.7);color:#fff;font-size:12px">디자이너</span>
          <span class="badge" style="background-color:rgba(46,197,81,.7);color:#fff;font-size:12px">프론트엔드개발자</span>
          <span class="badge" style="background-color:rgba(89,105,255,.7);color:#fff;font-size:12px">백엔드개발자</span>
          <span class="badge" style="background-color:rgba(170,170,170,.7);color:#fff;font-size:12px">어시스턴트</span>
        </div>
        <div class="card-body">

          <!-- amcharts -->
          <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/core.js"></script>
          <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/charts.js"></script>
          <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/themes/animated.js"></script>
          <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/lang/ko_KR.js"></script>

          <div id="workerGantt"></div>

          <script>
            // animated
            am4core.useTheme(am4themes_animated);

            // chart
            var chart = am4core.create("workerGantt", am4charts.XYChart);
            chart.data = <?php echo $json_schedule; ?>;
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
            series.columns.template.tooltipHTML = '<a class="text-dark" href="<?php echo esc_url(home_url('worker/?love=')); ?>{slug}"><span>{task} : <b>{openDateX} ~ {dateX}</b></span></a>';
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
            var cellSize = 15;
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