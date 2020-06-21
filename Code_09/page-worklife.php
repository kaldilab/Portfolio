<?php get_header(); ?>

<div class="container-fluid dashboard-content" id="backtoptop">

  <?php get_template_part('templates/content', 'breadcrumb'); ?>

  <?php
  // workers
  $workers = get_terms(array(
    'taxonomy' => 'worker',
    'hide_empty' => false,
  ));
  $workers_plan = get_terms(array(
    'taxonomy' => 'worker',
    'hide_empty' => false,
    'description__like' => '기획/PM',
  ));
  $workers_design = get_terms(array(
    'taxonomy' => 'worker',
    'hide_empty' => false,
    'description__like' => 'UI/UX',
  ));
  $workers_frontend_develop = get_terms(array(
    'taxonomy' => 'worker',
    'hide_empty' => false,
    'description__like' => '프론트엔드',
  ));
  $workers_backend_develop = get_terms(array(
    'taxonomy' => 'worker',
    'hide_empty' => false,
    'description__like' => '백엔드',
  ));
  $workers_executive = get_terms(array(
    'taxonomy' => 'worker',
    'hide_empty' => false,
    'description__like' => '경영진',
  ));

  // project all
  $args_project_all = array(
    'post_type' => array(
      'project',
      'running',
      'onlyone',
      'tf',
    ),
    'posts_per_page' => -1,
    'meta_key' => 'project_finish',
    'meta_value' => '0',
  );
  $query_project_all = new WP_Query($args_project_all);
  ?>

  <div class="section-block pb-3">
    <h2 class="section-title"><i class="fa fa-fw fa-heartbeat"></i> 일과 삶의 균형을 찾아서...</h2>
  </div>

  <!-- 개요 -->
  <div class="row">

    <!-- 검색 -->
    <?php if (!empty($_GET['love'])) : ?>
      <?php
      foreach ($workers as $worker) {
        if ($worker->slug == $_GET['love']) {
          $worker_name = $worker->name;
        }
      }
      ?>
      <div class="col-xl-12">
        <div class="section-block">
          <h3 class="section-title">'<strong class="text-secondary"><?php echo $worker_name; ?></strong>' 님의 일과 삶은? <a href="<?php echo esc_url(home_url('/worklife')); ?>" class="btn btn-outline-dark btn-sm float-right"><i class="fas fa-times"></i></a></h3>
        </div>
      </div>
      <?php
      if ($query_project_all->have_posts()) {
        while ($query_project_all->have_posts()) {
          $query_project_all->the_post();

          $time_ago = date("Y-m-d", strtotime("-3 month", time()));
          $time_later = date("Y-m-d", strtotime("+3 month", time()));
          $period = new DatePeriod(
            new DateTime($time_ago),
            new DateInterval('P1D'),
            new DateTime($time_later)
          );

          foreach ($period as $key => $value) {
            $get_day = $value->format('Y-m-d');
            $array_period[] = '"' . $get_day . '"';

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
                if ($row['worker']->slug == $_GET['love']) {
                  if ($post->post_type == 'onlyone') {
                    $schedule_start = $contract_period_start;
                    $schedule_end = $contract_period_end;
                  } else if ($post->post_type == 'tf') {
                    $schedule_start = $tf_period_start;
                    $schedule_end = $tf_period_end;
                  } else {
                    $schedule_start = $row['start'];
                    $schedule_end = $row['end'];
                  }
                  if ($schedule_start <= $get_day && $schedule_end >= $get_day) {
                    $get_work = '1';
                    $get_energy = $row['energy'];
                  } else if ($schedule_start >= $get_day) {
                    $get_work = '0';
                    $get_energy = '0';
                  } else if ($schedule_end < $get_day) {
                    $get_work = '0';
                    $get_energy = '0';
                  }
                  $array_manager = array(
                    'day' => $get_day,
                    'work' => $get_work,
                    'energy' => $get_energy,
                  );
                  $array_work_energy[] = $array_manager;
                }
              }
            }
            if ($work_planner) {
              foreach ($work_planner as $row) {
                if ($row['worker']->slug == $_GET['love']) {
                  if ($post->post_type == 'onlyone') {
                    $schedule_start = $contract_period_start;
                    $schedule_end = $contract_period_end;
                  } else if ($post->post_type == 'tf') {
                    $schedule_start = $tf_period_start;
                    $schedule_end = $tf_period_end;
                  } else {
                    $schedule_start = $row['start'];
                    $schedule_end = $row['end'];
                  }
                  if ($schedule_start <= $get_day && $schedule_end >= $get_day) {
                    $get_work = '1';
                    $get_energy = $row['energy'];
                  } else if ($schedule_start >= $get_day) {
                    $get_work = '0';
                    $get_energy = '0';
                  } else if ($schedule_end < $get_day) {
                    $get_work = '0';
                    $get_energy = '0';
                  }
                  $array_planner = array(
                    'day' => $get_day,
                    'work' => $get_work,
                    'energy' => $get_energy,
                  );
                  $array_work_energy[] = $array_planner;
                }
              }
            }
            if ($work_designer) {
              foreach ($work_designer as $row) {
                if ($row['worker']->slug == $_GET['love']) {
                  if ($post->post_type == 'onlyone') {
                    $schedule_start = $contract_period_start;
                    $schedule_end = $contract_period_end;
                  } else if ($post->post_type == 'tf') {
                    $schedule_start = $tf_period_start;
                    $schedule_end = $tf_period_end;
                  } else {
                    $schedule_start = $row['start'];
                    $schedule_end = $row['end'];
                  }
                  if ($schedule_start <= $get_day && $schedule_end >= $get_day) {
                    $get_work = '1';
                    $get_energy = $row['energy'];
                  } else if ($schedule_start >= $get_day) {
                    $get_work = '0';
                    $get_energy = '0';
                  } else if ($schedule_end < $get_day) {
                    $get_work = '0';
                    $get_energy = '0';
                  }
                  $array_designer = array(
                    'day' => $get_day,
                    'work' => $get_work,
                    'energy' => $get_energy,
                  );
                  $array_work_energy[] = $array_designer;
                }
              }
            }
            if ($work_frontend_developer) {
              foreach ($work_frontend_developer as $row) {
                if ($row['worker']->slug == $_GET['love']) {
                  if ($post->post_type == 'onlyone') {
                    $schedule_start = $contract_period_start;
                    $schedule_end = $contract_period_end;
                  } else if ($post->post_type == 'tf') {
                    $schedule_start = $tf_period_start;
                    $schedule_end = $tf_period_end;
                  } else {
                    $schedule_start = $row['start'];
                    $schedule_end = $row['end'];
                  }
                  if ($schedule_start <= $get_day && $schedule_end >= $get_day) {
                    $get_work = '1';
                    $get_energy = $row['energy'];
                  } else if ($schedule_start >= $get_day) {
                    $get_work = '0';
                    $get_energy = '0';
                  } else if ($schedule_end < $get_day) {
                    $get_work = '0';
                    $get_energy = '0';
                  }
                  $array_frontend_developer = array(
                    'day' => $get_day,
                    'work' => $get_work,
                    'energy' => $get_energy,
                  );
                  $array_work_energy[] = $array_frontend_developer;
                }
              }
            }
            if ($work_backend_developer) {
              foreach ($work_backend_developer as $row) {
                if ($row['worker']->slug == $_GET['love']) {
                  if ($post->post_type == 'onlyone') {
                    $schedule_start = $contract_period_start;
                    $schedule_end = $contract_period_end;
                  } else if ($post->post_type == 'tf') {
                    $schedule_start = $tf_period_start;
                    $schedule_end = $tf_period_end;
                  } else {
                    $schedule_start = $row['start'];
                    $schedule_end = $row['end'];
                  }
                  if ($schedule_start <= $get_day && $schedule_end >= $get_day) {
                    $get_work = '1';
                    $get_energy = $row['energy'];
                  } else if ($schedule_start >= $get_day) {
                    $get_work = '0';
                    $get_energy = '0';
                  } else if ($schedule_end < $get_day) {
                    $get_work = '0';
                    $get_energy = '0';
                  }
                  $array_backend_developer = array(
                    'day' => $get_day,
                    'work' => $get_work,
                    'energy' => $get_energy,
                  );
                  $array_work_energy[] = $array_backend_developer;
                }
              }
            }
            if ($work_assistant) {
              foreach ($work_assistant as $row) {
                if ($row['worker']->slug == $_GET['love']) {
                  if ($post->post_type == 'onlyone') {
                    $schedule_start = $contract_period_start;
                    $schedule_end = $contract_period_end;
                  } else if ($post->post_type == 'tf') {
                    $schedule_start = $tf_period_start;
                    $schedule_end = $tf_period_end;
                  } else {
                    $schedule_start = $row['start'];
                    $schedule_end = $row['end'];
                  }
                  if ($schedule_start <= $get_day && $schedule_end >= $get_day) {
                    $get_work = '1';
                    $get_energy = $row['energy'];
                  } else if ($schedule_start >= $get_day) {
                    $get_work = '0';
                    $get_energy = '0';
                  } else if ($schedule_end < $get_day) {
                    $get_work = '0';
                    $get_energy = '0';
                  }
                  $array_assistant = array(
                    'day' => $get_day,
                    'work' => $get_work,
                    'energy' => $get_energy,
                  );
                  $array_work_energy[] = $array_assistant;
                }
              }
            }
          }
        }
      }
      // period
      $result_period = implode(', ', $array_period);

      // work
      if (isset($array_work_energy)) {
        $count_work = array();
        foreach ($array_work_energy as $key) {
          if (!isset($count_work[$key['day']])) {
            $count_work[$key['day']] = 0;
          }
          $count_work[$key['day']] += $key['work'];
        }
        // pp($count_work);
        foreach ($count_work as $key => $value) {
          $array_count_work[] = $value;
        }
        $result_count_work = implode(', ', $array_count_work);
      }

      // energy
      if (isset($array_work_energy)) {
        $sum_energy = array();
        foreach ($array_work_energy as $key) {
          if (!isset($sum_energy[$key['day']])) {
            $sum_energy[$key['day']] = 0;
          }
          $sum_energy[$key['day']] += $key['energy'];
        }
        foreach ($sum_energy as $key => $value) {
          $array_sum_energy[] = $value;
        }
        $result_sum_energy = implode(', ', $array_sum_energy);
      }
      ?>

      <!-- c3chart -->
      <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/_source/assets/vendor/charts/c3charts/c3.css">
      <script src="<?php echo get_template_directory_uri(); ?>/_source/assets/vendor/charts/c3charts/c3.min.js"></script>
      <script src="<?php echo get_template_directory_uri(); ?>/_source/assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
      <!-- //c3chart -->

      <div class="col-xl-12">
        <div class="card animated fadeInUp">
          <h5 class="card-header">
            <strong class="text-secondary"><?php echo $worker_name; ?></strong>님 일별 작업 건수 [건]
            <span class="text-muted font-12 ml-3">(범위 : 6개월)</span>
          </h5>
          <div class="card-body">

            <!-- c3chart -->
            <div id="workerWork"></div>

            <script>
              var chart = c3.generate({
                bindto: "#workerWork",
                data: {
                  x: 'x',
                  columns: [
                    ['x', <?php echo $result_period; ?>],
                    ['Work', <?php echo $result_count_work; ?>],
                  ],
                  types: {
                    Work: 'area',
                  },
                },
                axis: {
                  x: {
                    type: 'timeseries',
                    tick: {
                      format: '%Y-%m-%d'
                    }
                  },
                }
              });
            </script>

          </div>
        </div>
      </div>
      <div class="col-xl-12">
        <div class="card animated fadeInUp">
          <h5 class="card-header">
            <strong class="text-secondary"><?php echo $worker_name; ?></strong>님 일별 에너지 [%]
            <span class="text-muted font-12 ml-3">(범위 : 6개월)</span>
          </h5>
          <div class="card-body">

            <!-- c3chart -->
            <div id="workerEnergy"></div>

            <script>
              var chart = c3.generate({
                bindto: "#workerEnergy",
                data: {
                  x: 'x',
                  columns: [
                    ['x', <?php echo $result_period; ?>],
                    ['Energy', <?php echo $result_sum_energy; ?>],
                  ],
                  types: {
                    Energy: 'area',
                  },
                },
                axis: {
                  x: {
                    type: 'timeseries',
                    tick: {
                      format: '%Y-%m-%d'
                    }
                  },
                }
              });
            </script>
            <!-- //c3chart -->

          </div>
        </div>
      </div>
    <?php endif; ?>
    <!-- //검색 -->

    <!-- 리스트 -->
    <div class="col-xl-12">
      <div class="card animated fadeInUp">
        <div class="campaign-table table-responsive">
          <table class="table table-worker">
            <colgroup>
              <col style="width:200px;">
              <col style="width:*;">
              <col style="width:150px;">
            </colgroup>
            <thead>
              <tr>
                <th>Group</th>
                <th>Name</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="social-sales-icon-circle bg-warning text-white mr-4"><i class="font-12 fas fa-fw fa-map-signs"></i></span><strong>기획/PM</span></td>
                <td>
                  <?php
                  if ($query_project_all->have_posts()) {
                    foreach ($workers_plan as $worker) {
                      $worker_work = 0;
                      while ($query_project_all->have_posts()) {
                        $query_project_all->the_post();
                      }
                      echo '<a href="' . esc_url(home_url('/worklife/?love=')) . $worker->slug . '" class="btn btn-light btn-xs mt-1 mb-1 mr-3">' . $worker->name . '</strong></a>';
                    }
                  }
                  wp_reset_postdata();
                  ?>
                </td>
              </tr>
              <tr>
                <td><span class="social-sales-icon-circle bg-secondary mr-4"><i class="font-12 fas fa-fw fa-paint-brush"></i></span><strong>UI/UX</span></td>
                <td>
                  <?php
                  if ($query_project_all->have_posts()) {
                    foreach ($workers_design as $worker) {
                      $worker_work = 0;
                      while ($query_project_all->have_posts()) {
                        $query_project_all->the_post();
                      }
                      echo '<a href="' . esc_url(home_url('/worklife/?love=')) . $worker->slug . '" class="btn btn-light btn-xs mt-1 mb-1 mr-3">' . $worker->name . '</strong></a>';
                    }
                  }
                  wp_reset_postdata();
                  ?>
                </td>
              </tr>
              <tr>
                <td><span class="social-sales-icon-circle bg-success text-white mr-4"><i class="font-12 fas fa-fw fa-code"></i></span><strong>프론트엔드</span></td>
                <td>
                  <?php
                  if ($query_project_all->have_posts()) {
                    foreach ($workers_frontend_develop as $worker) {
                      $worker_work = 0;
                      while ($query_project_all->have_posts()) {
                        $query_project_all->the_post();
                      }
                      echo '<a href="' . esc_url(home_url('/worklife/?love=')) . $worker->slug . '" class="btn btn-light btn-xs mt-1 mb-1 mr-3">' . $worker->name . '</strong></a>';
                    }
                  }
                  wp_reset_postdata();
                  ?>
                </td>
              </tr>
              <tr>
                <td><span class="social-sales-icon-circle bg-primary mr-4"><i class="font-12 fas fa-fw fa-terminal"></i></span><strong>백엔드</span></td>
                <td>
                  <?php
                  if ($query_project_all->have_posts()) {
                    foreach ($workers_backend_develop as $worker) {
                      $worker_work = 0;
                      while ($query_project_all->have_posts()) {
                        $query_project_all->the_post();
                      }
                      echo '<a href="' . esc_url(home_url('/worklife/?love=')) . $worker->slug . '" class="btn btn-light btn-xs mt-1 mb-1 mr-3">' . $worker->name . '</strong></a>';
                    }
                  }
                  wp_reset_postdata();
                  ?>
                </td>
              </tr>
              <tr>
                <td><span class="social-sales-icon-circle bg-light mr-4"><i class="font-12 fas fa-fw fa-seedling"></i></span><strong>경영진</strong></td>
                <td>
                  <?php
                  if ($query_project_all->have_posts()) {
                    foreach ($workers_executive as $worker) {
                      $worker_work = 0;
                      while ($query_project_all->have_posts()) {
                        $query_project_all->the_post();
                      }
                      echo '<a href="' . esc_url(home_url('/worklife/?love=')) . $worker->slug . '" class="btn btn-light btn-xs mt-1 mb-1 mr-3">' . $worker->name . '</strong></a>';
                    }
                  }
                  wp_reset_postdata();
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- //리스트 -->

  </div>
  <!-- //개요 -->

  <!-- 에너지 -->
  <div class="row">

    <div class="col-xl-12">
      <div class="section-block">
        <h3 class="section-title">슬로워커 에너지</h3>
      </div>
    </div>

    <div class="col-xl-12">
      <div class="card animated fadeInUp">
        <h5 class="card-header">전체 작업 건수 & 작업 에너지</h5>
        <div class="card-body">

          <!-- 슬로워커 에너지 -->
          <?php
          if ($query_project_all->have_posts()) {
            foreach ($workers as $worker) {
              $worker_list[] = $worker->name;
            }
            foreach ($workers as $worker) {
              $worker_work = 0;
              while ($query_project_all->have_posts()) {
                $query_project_all->the_post();
                worker_work_repeater();
              }
              $worker_work_count[] = $worker_work;
            }
            foreach ($workers as $worker) {
              $worker_energy = 0;
              while ($query_project_all->have_posts()) {
                $query_project_all->the_post();
                worker_work_repeater();
              }
              $worker_work_energy[] = $worker_energy;
            }
          }
          $json_worker_list = json_encode($worker_list);
          $json_worker_work_count = json_encode($worker_work_count);
          $json_worker_work_energy = json_encode($worker_work_energy);
          ?>

          <!-- chartjs -->
          <script src="<?php echo get_template_directory_uri(); ?>/_source/assets/vendor/charts/charts-bundle/Chart.bundle.js"></script>
          <script src="<?php echo get_template_directory_uri(); ?>/assets/chartjs-plugin-annotation-0.5.7/chartjs-plugin-annotation.min.js"></script>

          <canvas id="workerWorkEnergy"></canvas>

          <script>
            var workerEnergyChart = document.getElementById("workerWorkEnergy").getContext('2d');

            // chart
            var myChart = new Chart(workerEnergyChart, {
              type: 'bar',
              order: 'data',
              data: {
                labels: <?php echo $json_worker_list; ?>,
                datasets: [{
                  label: 'Work(건)',
                  yAxisID: 'y-axis-1',
                  data: <?php echo $json_worker_work_count; ?>,
                  backgroundColor: "rgba(241,90,34,.5)",
                  borderWidth: 0
                }, {
                  type: 'line',
                  label: 'Energy(%)',
                  yAxisID: 'y-axis-2',
                  data: <?php echo $json_worker_work_energy; ?>,
                  backgroundColor: "rgba(0,0,0,.1)",
                  borderColor: "rgba(0,0,0,.5)",
                  borderWidth: 1,
                  pointBorderColor: "transparent",
                  pointBackgroundColor: "transparent",
                }]
              },
              options: {
                lineaHorizontal: 100,
                legend: {
                  display: true,
                  position: 'top',
                  labels: {
                    fontColor: '#71748d',
                    fontSize: 14,
                  }
                },
                tooltips: {
                  mode: 'index',
                  intersect: true
                },
                scales: {
                  xAxes: [{
                    ticks: {
                      fontSize: 14,
                      fontColor: '#71748d',
                    }
                  }],
                  yAxes: [{
                    id: 'y-axis-1',
                    display: true,
                    position: 'left',
                    ticks: {
                      fontSize: 14,
                      fontColor: 'rgba(241,90,34,1)',
                    }
                  }, {
                    id: 'y-axis-2',
                    display: true,
                    position: 'right',
                    ticks: {
                      fontSize: 14,
                      fontColor: 'rgba(0,0,0,1)',
                    }
                  }]
                },
                annotation: {
                  annotations: [{
                    drawTime: 'afterDraw',
                    type: 'line',
                    mode: 'horizontal',
                    scaleID: 'y-axis-2',
                    value: '110',
                    borderColor: 'red',
                    borderWidth: 2,
                    label: {
                      enabled: true,
                      position: 'right',
                      content: '생명선 (110%)',
                      yAdjust: 20,
                    }
                  }],
                }
              }
            });
          </script>
          <!-- //chartjs -->

        </div>
      </div>
    </div>

  </div>
  <!-- 에너지 -->

</div>

<?php get_footer(); ?>