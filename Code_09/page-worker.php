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
  $count_workers = count($workers);
  $count_workers_plan = count($workers_plan);
  $count_workers_design = count($workers_design);
  $count_workers_frontend_develop = count($workers_frontend_develop);
  $count_workers_backend_develop = count($workers_backend_develop);
  $count_workers_executive = count($workers_executive);
  $ratio_workers_plan = floor(($count_workers_plan / $count_workers) * 100);
  $ratio_workers_design = floor(($count_workers_design / $count_workers) * 100);
  $ratio_workers_frontend_develop = floor(($count_workers_frontend_develop / $count_workers) * 100);
  $ratio_workers_backend_develop = floor(($count_workers_backend_develop / $count_workers) * 100);
  $ratio_workers_executive = floor(($count_workers_executive / $count_workers) * 100);
  ?>

  <?php
  // project all
  $args_project_all = array(
    'post_type' => array(
      'project',
      'running',
      'onlyone',
      'tf',
    ),
    'posts_per_page' => -1,
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key' => 'project_finish',
        'value' => '0',
      ),
    ),
  );
  $query_project_all = new WP_Query($args_project_all);
  ?>

  <div class="section-block pb-3">
    <h2 class="section-title"><i class="fa fa-fw fa-blind"></i> 슬로워커 <strong class="text-secondary"><?php echo $count_workers; ?></strong>인, 어딜 걷고 있나요?</h2>
  </div>

  <!-- inner -->
  <div class="row">

    <!-- content -->
    <div class="col-xl-10">

      <!-- 검색 -->
      <?php if (!empty($_GET['love'])) : ?>
        <?php
        foreach ($workers as $worker) {
          if ($worker->slug == $_GET['love']) {
            $worker_name = $worker->name;
          }
        }
        ?>
        <div class="row">
          <div class="col-xl-12">
            <div class="section-block">
              <h3 class="section-title">'<strong class="text-secondary"><?php echo $worker_name; ?></strong>' 님은 어디에... <a href="<?php echo esc_url(home_url('/worker')); ?>" class="btn btn-outline-dark btn-sm float-right"><i class="fas fa-times"></i></a></h3>
            </div>
          </div>
          <div class="col-xl-12">
            <div class="card animated fadeInUp">
              <div class="campaign-table table-responsive">
                <table class="table table-hover table-search-worker">
                  <thead>
                    <tr>
                      <th>Project</th>
                      <th>Work</th>
                      <th>Group</th>
                      <th>Energy</th>
                      <th>Period</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($query_project_all->have_posts()) : ?>
                      <?php while ($query_project_all->have_posts()) : $query_project_all->the_post(); ?>
                        <?php

                        $id = get_the_ID();
                        $title = get_the_title();

                        // work
                        $work_manager = get_field('work_manager');
                        $work_planner = get_field('work_planner');
                        $work_designer = get_field('work_designer');
                        $work_frontend_developer = get_field('work_frontend_developer');
                        $work_backend_developer = get_field('work_backend_developer');
                        $work_assistant = get_field('work_assistant');

                        // work label
                        $work_manager_label = get_field_object('work_manager')['label'];
                        $work_planner_label = get_field_object('work_planner')['label'];
                        $work_designer_label = get_field_object('work_designer')['label'];
                        $work_frontend_developer_label = get_field_object('work_frontend_developer')['label'];
                        $work_backend_developer_label = get_field_object('work_backend_developer')['label'];
                        $work_assistant_label = get_field_object('work_assistant')['label'];

                        // contract period
                        $contract_period = get_field('contract_period');
                        $contract_period_start = $contract_period['start'];
                        $contract_period_end = $contract_period['end'];

                        // tf period
                        $tf_period = get_field('tf_period');
                        $tf_period_start = $tf_period['start'];
                        $tf_period_end = $tf_period['end'];
                        ?>

                        <?php
                        if ($work_manager) {
                          $index_search_worker = 1;
                          foreach ($work_manager as $row) {
                            if ($row['worker']->name == $worker_name) {
                              if ($post->post_type == 'onlyone') {
                                echo '<tr class="' . project_end_checker($contract_period['end']) . '">';
                              } else if ($post->post_type == 'tf') {
                                echo '<tr class="' . project_end_checker($tf_period['end']) . '">';
                              } else {
                                echo '<tr class="' . project_end_checker($row['end']) . '">';
                              }
                              echo '<td><a href="' . esc_url(home_url('/present/?id=')) . $id . '">' . $title . '</a></td>';
                              if ($post->post_type == "onlyone") {
                                echo '<td>[단건] ' . $work_manager_label . '</td>';
                              } else if ($post->post_type == 'tf') {
                                echo '<td>[TF] ' . $work_manager_label . '</td>';
                              } else {
                                echo '<td>' . (($post->post_type == 'running') ? '[운영] ' : '') . $work_manager_label . '</td>';
                              }
                              echo '<td>' . $row['worker']->description . '</td>';
                              echo '<td>' . $row['energy'] . '%</td>';
                              if ($post->post_type == "onlyone") {
                                echo '<td>' . $contract_period_start . ' ~ ' . $contract_period_end . '</td>';
                                echo '<td><i class="text-muted fa fa-lightbulb"></i><span class="invisible">단건</span></td>';
                              } else if ($post->post_type == "tf") {
                                echo '<td>' . $tf_period_start . ' ~ ' . $tf_period_end . '</td>';
                                echo '<td><i class="text-muted fa fa-flag"></i><span class="invisible">TF</span></td>';
                              } else if ($post->post_type == "running") {
                                echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                                echo '<td><i class="text-muted fa fa-umbrella"></i><span class="invisible">운영</span></td>';
                              } else {
                                echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                                echo '<td>' . worker_status_checker($row['start'], $row['end']) . '</td>';
                              }
                              echo '</tr>';
                              $index_search_worker++;
                            }
                          }
                        }
                        if ($work_planner) {
                          $index_search_worker = 1;
                          foreach ($work_planner as $row) {
                            if ($row['worker']->name == $worker_name) {
                              if ($post->post_type == 'onlyone') {
                                echo '<tr class="' . project_end_checker($contract_period['end']) . '">';
                              } else if ($post->post_type == 'tf') {
                                echo '<tr class="' . project_end_checker($tf_period['end']) . '">';
                              } else {
                                echo '<tr class="' . project_end_checker($row['end']) . '">';
                              }
                              echo '<td><a href="' . esc_url(home_url('/present/?id=')) . $id . '">' . $title . '</a></td>';
                              if ($post->post_type == "onlyone") {
                                echo '<td>[단건] ' . $work_planner_label . '</td>';
                              } else if ($post->post_type == 'tf') {
                                echo '<td>[TF] ' . $work_planner_label . '</td>';
                              } else {
                                echo '<td>' . (($post->post_type == 'running') ? '[운영] ' : '') . $work_planner_label . '</td>';
                              }
                              echo '<td>' . $row['worker']->description . '</td>';
                              echo '<td>' . $row['energy'] . '%</td>';
                              if ($post->post_type == "onlyone") {
                                echo '<td>' . $contract_period_start . ' ~ ' . $contract_period_end . '</td>';
                                echo '<td><i class="text-muted fa fa-lightbulb"></i><span class="invisible">단건</span></td>';
                              } else if ($post->post_type == "tf") {
                                echo '<td>' . $tf_period_start . ' ~ ' . $tf_period_end . '</td>';
                                echo '<td><i class="text-muted fa fa-flag"></i><span class="invisible">TF</span></td>';
                              } else if ($post->post_type == "running") {
                                echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                                echo '<td><i class="text-muted fa fa-umbrella"></i><span class="invisible">운영</span></td>';
                              } else {
                                echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                                echo '<td>' . worker_status_checker($row['start'], $row['end']) . '</td>';
                              }
                              echo '</tr>';
                              $index_search_worker++;
                            }
                          }
                        }
                        if ($work_designer) {
                          $index_search_worker = 1;
                          foreach ($work_designer as $row) {
                            if ($row['worker']->name == $worker_name) {
                              if ($post->post_type == 'onlyone') {
                                echo '<tr class="' . project_end_checker($contract_period['end']) . '">';
                              } else if ($post->post_type == 'tf') {
                                echo '<tr class="' . project_end_checker($tf_period['end']) . '">';
                              } else {
                                echo '<tr class="' . project_end_checker($row['end']) . '">';
                              }
                              echo '<td><a href="' . esc_url(home_url('/present/?id=')) . $id . '">' . $title . '</a></td>';
                              if ($post->post_type == "onlyone") {
                                echo '<td>[단건] ' . $work_designer_label . '</td>';
                              } else if ($post->post_type == 'tf') {
                                echo '<td>[TF] ' . $work_designer_label . '</td>';
                              } else {
                                echo '<td>' . (($post->post_type == 'running') ? '[운영] ' : '') . $work_designer_label . '</td>';
                              }
                              echo '<td>' . $row['worker']->description . '</td>';
                              echo '<td>' . $row['energy'] . '%</td>';
                              if ($post->post_type == "onlyone") {
                                echo '<td>' . $contract_period_start . ' ~ ' . $contract_period_end . '</td>';
                                echo '<td><i class="text-muted fa fa-lightbulb"></i><span class="invisible">단건</span></td>';
                              } else if ($post->post_type == "tf") {
                                echo '<td>' . $tf_period_start . ' ~ ' . $tf_period_end . '</td>';
                                echo '<td><i class="text-muted fa fa-flag"></i><span class="invisible">TF</span></td>';
                              } else if ($post->post_type == "running") {
                                echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                                echo '<td><i class="text-muted fa fa-umbrella"></i><span class="invisible">운영</span></td>';
                              } else {
                                echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                                echo '<td>' . worker_status_checker($row['start'], $row['end']) . '</td>';
                              }
                              echo '</tr>';
                              $index_search_worker++;
                            }
                          }
                        }
                        if ($work_frontend_developer) {
                          $index_search_worker = 1;
                          foreach ($work_frontend_developer as $row) {
                            if ($row['worker']->name == $worker_name) {
                              if ($post->post_type == 'onlyone') {
                                echo '<tr class="' . project_end_checker($contract_period['end']) . '">';
                              } else if ($post->post_type == 'tf') {
                                echo '<tr class="' . project_end_checker($tf_period['end']) . '">';
                              } else {
                                echo '<tr class="' . project_end_checker($row['end']) . '">';
                              }
                              echo '<td><a href="' . esc_url(home_url('/present/?id=')) . $id . '">' . $title . '</a></td>';
                              if ($post->post_type == "onlyone") {
                                echo '<td>[단건] ' . $work_frontend_developer_label . '</td>';
                              } else if ($post->post_type == 'tf') {
                                echo '<td>[TF] ' . $work_frontend_developer_label . '</td>';
                              } else {
                                echo '<td>' . (($post->post_type == 'running') ? '[운영] ' : '') . $work_frontend_developer_label . '</td>';
                              }
                              echo '<td>' . $row['worker']->description . '</td>';
                              echo '<td>' . $row['energy'] . '%</td>';
                              if ($post->post_type == "onlyone") {
                                echo '<td>' . $contract_period_start . ' ~ ' . $contract_period_end . '</td>';
                                echo '<td><i class="text-muted fa fa-lightbulb"></i><span class="invisible">단건</span></td>';
                              } else if ($post->post_type == "tf") {
                                echo '<td>' . $tf_period_start . ' ~ ' . $tf_period_end . '</td>';
                                echo '<td><i class="text-muted fa fa-flag"></i><span class="invisible">TF</span></td>';
                              } else if ($post->post_type == "running") {
                                echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                                echo '<td><i class="text-muted fa fa-umbrella"></i><span class="invisible">운영</span></td>';
                              } else {
                                echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                                echo '<td>' . worker_status_checker($row['start'], $row['end']) . '</td>';
                              }
                              echo '</tr>';
                              $index_search_worker++;
                            }
                          }
                        }
                        if ($work_backend_developer) {
                          $index_search_worker = 1;
                          foreach ($work_backend_developer as $row) {
                            if ($row['worker']->name == $worker_name) {
                              if ($post->post_type == 'onlyone') {
                                echo '<tr class="' . project_end_checker($contract_period['end']) . '">';
                              } else if ($post->post_type == 'tf') {
                                echo '<tr class="' . project_end_checker($tf_period['end']) . '">';
                              } else {
                                echo '<tr class="' . project_end_checker($row['end']) . '">';
                              }
                              echo '<td><a href="' . esc_url(home_url('/present/?id=')) . $id . '">' . $title . '</a></td>';
                              if ($post->post_type == "onlyone") {
                                echo '<td>[단건] ' . $work_backend_developer_label . '</td>';
                              } else if ($post->post_type == 'tf') {
                                echo '<td>[TF] ' . $work_backend_developer_label . '</td>';
                              } else {
                                echo '<td>' . (($post->post_type == 'running') ? '[운영] ' : '') . $work_backend_developer_label . '</td>';
                              }
                              echo '<td>' . $row['worker']->description . '</td>';
                              echo '<td>' . $row['energy'] . '%</td>';
                              if ($post->post_type == "onlyone") {
                                echo '<td>' . $contract_period_start . ' ~ ' . $contract_period_end . '</td>';
                                echo '<td><i class="text-muted fa fa-lightbulb"></i><span class="invisible">단건</span></td>';
                              } else if ($post->post_type == "tf") {
                                echo '<td>' . $tf_period_start . ' ~ ' . $tf_period_end . '</td>';
                                echo '<td><i class="text-muted fa fa-flag"></i><span class="invisible">TF</span></td>';
                              } else if ($post->post_type == "running") {
                                echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                                echo '<td><i class="text-muted fa fa-umbrella"></i><span class="invisible">운영</span></td>';
                              } else {
                                echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                                echo '<td>' . worker_status_checker($row['start'], $row['end']) . '</td>';
                              }
                              echo '</tr>';
                              $index_search_worker++;
                            }
                          }
                        }
                        if ($work_assistant) {
                          $index_search_worker = 1;
                          foreach ($work_assistant as $row) {
                            if ($row['worker']->name == $worker_name) {
                              if ($post->post_type == 'onlyone') {
                                echo '<tr class="' . project_end_checker($contract_period['end']) . '">';
                              } else if ($post->post_type == 'tf') {
                                echo '<tr class="' . project_end_checker($tf_period['end']) . '">';
                              } else {
                                echo '<tr class="' . project_end_checker($row['end']) . '">';
                              }
                              echo '<td><a href="' . esc_url(home_url('/present/?id=')) . $id . '">' . $title . '</a></td>';
                              if ($post->post_type == "onlyone") {
                                echo '<td>[단건] ' . $work_assistant_label . '</td>';
                              } else if ($post->post_type == 'tf') {
                                echo '<td>[TF] ' . $work_assistant_label . '</td>';
                              } else {
                                echo '<td>' . (($post->post_type == 'running') ? '[운영] ' : '') . $work_assistant_label . '</td>';
                              }
                              echo '<td>' . $row['worker']->description . '</td>';
                              echo '<td>' . $row['energy'] . '%</td>';
                              if ($post->post_type == "onlyone") {
                                echo '<td>' . $contract_period_start . ' ~ ' . $contract_period_end . '</td>';
                                echo '<td><i class="text-muted fa fa-lightbulb"></i><span class="invisible">단건</span></td>';
                              } else if ($post->post_type == "tf") {
                                echo '<td>' . $tf_period_start . ' ~ ' . $tf_period_end . '</td>';
                                echo '<td><i class="text-muted fa fa-flag"></i><span class="invisible">TF</span></td>';
                              } else if ($post->post_type == "running") {
                                echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                                echo '<td><i class="text-muted fa fa-umbrella"></i><span class="invisible">운영</span></td>';
                              } else {
                                echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                                echo '<td>' . worker_status_checker($row['start'], $row['end']) . '</td>';
                              }
                              echo '</tr>';
                              $index_search_worker++;
                            }
                          }
                        }
                        ?>

                        <?php
                        if ($work_manager) {
                          foreach ($work_manager as $row) {
                            if ($row['worker']->name == $worker_name) {
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
                                $schedule_start = $row['start'];
                                $schedule_end = $row['end'];
                                $task = (($post->post_type == 'running') ? '(운영) ' : '') . '#' . $title . ' @매니저';
                              }
                              $array_manager = array(
                                'name' => $worker,
                                'category' => $title,
                                'start' => $schedule_start,
                                'end' => $schedule_end,
                                'task' => $task,
                                "color" => 'rgba(241,90,34,.5)',
                              );
                              $result_schedule[] = $array_manager;
                            }
                          }
                        }
                        if ($work_planner) {
                          foreach ($work_planner as $row) {
                            if ($row['worker']->name == $worker_name) {
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
                                $schedule_start = $row['start'];
                                $schedule_end = $row['end'];
                                $task = (($post->post_type == 'running') ? '(운영) ' : '') . '#' . $title . ' @기획자';
                              }
                              $array_planner = array(
                                'name' => $worker,
                                'category' => $title,
                                'start' => $schedule_start,
                                'end' => $schedule_end,
                                'task' => $task,
                                "color" => 'rgba(255,193,8,.5)',
                              );
                              $result_schedule[] = $array_planner;
                            }
                          }
                        }
                        if ($work_designer) {
                          foreach ($work_designer as $row) {
                            if ($row['worker']->name == $worker_name) {
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
                                $schedule_start = $row['start'];
                                $schedule_end = $row['end'];
                                $task = (($post->post_type == 'running') ? '(운영) ' : '') . '#' . $title . ' @디자이너';
                              }
                              $array_designer = array(
                                'name' => $worker,
                                'category' => $title,
                                'start' => $schedule_start,
                                'end' => $schedule_end,
                                'task' => $task,
                                "color" => 'rgba(255,64,123,.5)',
                              );
                              $result_schedule[] = $array_designer;
                            }
                          }
                        }
                        if ($work_frontend_developer) {
                          foreach ($work_frontend_developer as $row) {
                            if ($row['worker']->name == $worker_name) {
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
                                $schedule_start = $row['start'];
                                $schedule_end = $row['end'];
                                $task = (($post->post_type == 'running') ? '(운영) ' : '') . '#' . $title . ' @프론트엔드개발자';
                              }
                              $array_frontend_developer = array(
                                'name' => $worker,
                                'category' => $title,
                                'start' => $schedule_start,
                                'end' => $schedule_end,
                                'task' => $task,
                                "color" => 'rgba(46,197,81,.5)',
                              );
                              $result_schedule[] = $array_frontend_developer;
                            }
                          }
                        }
                        if ($work_backend_developer) {
                          foreach ($work_backend_developer as $row) {
                            if ($row['worker']->name == $worker_name) {
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
                                $schedule_start = $row['start'];
                                $schedule_end = $row['end'];
                                $task = (($post->post_type == 'running') ? '(운영) ' : '') . '#' . $title . ' @백엔드개발자';
                              }
                              $array_backend_developer = array(
                                'name' => $worker,
                                'category' => $title,
                                'start' => $schedule_start,
                                'end' => $schedule_end,
                                'task' => $task,
                                "color" => 'rgba(89,105,255,.5)',
                              );
                              $result_schedule[] = $array_backend_developer;
                            }
                          }
                        }
                        if ($work_assistant) {
                          foreach ($work_assistant as $row) {
                            if ($row['worker']->name == $worker_name) {
                              $worker = $row['worker']->name . '(' . $row['worker']->description . ')';
                              if ($post->post_type == 'onlyone') {
                                $schedule_start = $contract_period_start;
                                $schedule_end = $contract_period_end;
                                $task = '(단건) #' . $title . ' @어시스턴트';
                              } else {
                                $schedule_start = $row['start'];
                                $schedule_end = $row['end'];
                                $task = (($post->post_type == 'running') ? '(운영) ' : '') . '#' . $title . ' @어시스턴트';
                              }
                              $array_assistant = array(
                                'name' => $worker,
                                'category' => $title,
                                'start' => $schedule_start,
                                'end' => $schedule_end,
                                'task' => $task,
                                "color" => 'rgba(204,204,204,.5)',
                              );
                              $result_schedule[] = $array_assistant;
                            }
                          }
                        }
                        ?>
                      <?php endwhile; ?>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                    <?php if ($index_search_worker < 1) {
                      echo '<tr>';
                      echo '<td colspan="7" class="text-center"><strong>' . $worker_name . '</strong>님은 고 있어요...</td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-xl-12">
            <div class="card animated fadeInUp">
              <h5 class="card-header">
                <strong class="text-secondary"><?php echo $worker_name; ?></strong>님 쥴
                <div class="float-right">
                  <span class="badge" style="background-color:rgba(241,90,34,.7);color:#fff;font-size:12px">매니저</span>
                  <span class="badge" style="background-color:rgba(255,193,8,.7);color:#fff;font-size:12px">기획자</span>
                  <span class="badge" style="background-color:rgba(255,64,123,.7);color:#fff;font-size:12px">디자이너</span>
                  <span class="badge" style="background-color:rgba(46,197,81,.7);color:#fff;font-size:12px">프론트엔드개발자</span>
                  <span class="badge" style="background-color:rgba(89,105,255,.7);color:#fff;font-size:12px">백엔드개발자</span>
                  <span class="badge" style="background-color:rgba(170,170,170,.7);color:#fff;font-size:12px">어시스턴트</span>
                </div>
              </h5>
              <div class="card-body">

                <!-- json schedule -->
                <?php $json_schedule = json_encode(isset($result_schedule)); ?>

                <!-- amcharts -->
                <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/core.js"></script>
                <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/charts.js"></script>
                <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/themes/animated.js"></script>
                <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/lang/ko_KR.js"></script>

                <div id="slowakerGantt"></div>

                <script>
                  // animated
                  am4core.useTheme(am4themes_animated);

                  // chart
                  var chart = am4core.create("slowakerGantt", am4charts.XYChart);
                  chart.data = <?php echo $json_schedule; ?>;
                  chart.hiddenState.properties.opacity = 0;
                  chart.paddingRight = 30;
                  chart.dateFormatter.dateFormat = "yyyy-MM-dd";
                  chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";
                  chart.scrollbarX = new am4core.Scrollbar();
                  chart.language.locale = am4lang_ko_KR;
                  chart.language.locale["_date_day"] = "MM월 dd일";

                  // colorset
                  var colorSet = new am4core.ColorSet();
                  colorSet.saturation = 0.5;

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
                  series.columns.template.tooltipHTML = '<span>{task} : <b>{openDateX} ~ {dateX}</b></span>';
                  series.dataFields.openDateX = "start";
                  series.dataFields.dateX = "end";
                  series.dataFields.categoryY = "category";

                  // cursor
                  chart.cursor = new am4charts.XYCursor();

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
                  var cellSize = 50;
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
      <?php endif; ?>
      <!-- //검색 -->

      <?php
      // project
      $args_project = array(
        'post_type' => 'project',
        'posts_per_page' => -1,
        'meta_key' => 'schedule_open_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'meta_query' => array(
          'relation' => 'AND',
          array(
            'key' => 'project_finish',
            'value' => '0',
          ),
          array(
            'key' => 'schedule_open_date',
            'type' => 'DATE',
          ),
        ),
      );
      $query_project = new WP_Query($args_project);

      // running
      $args_running = array(
        'post_type' => 'running',
        'posts_per_page' => -1,
        'meta_key' => 'contract_period_end',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'meta_query' => array(
          'relation' => 'AND',
          array(
            'key' => 'project_finish',
            'value' => '0',
          ),
          array(
            'key' => 'contract_period_end',
            'type' => 'DATE',
          ),
        ),
      );
      $query_running = new WP_Query($args_running);

      // onlyone
      $args_onlyone = array(
        'post_type' => 'onlyone',
        'posts_per_page' => -1,
        'meta_key' => 'contract_period_end',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'meta_query' => array(
          'relation' => 'AND',
          array(
            'key' => 'project_finish',
            'value' => '0',
          ),
          array(
            'key' => 'contract_period_end',
            'type' => 'DATE',
          ),
        ),
      );
      $query_onlyone = new WP_Query($args_onlyone);

      // tf
      $args_tf = array(
        'post_type' => 'tf',
        'posts_per_page' => -1,
        'meta_key' => 'tf_period_end',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'meta_query' => array(
          'relation' => 'AND',
          array(
            'key' => 'project_finish',
            'value' => '0',
          ),
          array(
            'key' => 'tf_period_end',
            'type' => 'DATE',
          ),
        ),
      );
      $query_tf = new WP_Query($args_tf);
      ?>

      <!-- 개요 -->
      <div class="row" id="overview">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">개요</h3>
          </div>
        </div>
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
                    <th>Count (명)</th>
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
                            worker_work_repeater();
                          }
                          echo '<a href="' . esc_url(home_url('/worker/?love=')) . $worker->slug . '" class="btn btn-light btn-xs mt-1 mb-1 mr-3">' . $worker->name . ' <strong>[' . $worker_work . ']</strong></a>';
                        }
                      }
                      wp_reset_postdata();
                      ?>
                    </td>
                    <td><?php echo $count_workers_plan; ?></td>
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
                            worker_work_repeater();
                          }
                          echo '<a href="' . esc_url(home_url('/worker/?love=')) . $worker->slug . '" class="btn btn-light btn-xs mt-1 mb-1 mr-3">' . $worker->name . ' <strong>[' . $worker_work . ']</strong></a>';
                        }
                      }
                      wp_reset_postdata();
                      ?>
                    </td>
                    <td><?php echo $count_workers_design; ?></td>
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
                            worker_work_repeater();
                          }
                          echo '<a href="' . esc_url(home_url('/worker/?love=')) . $worker->slug . '" class="btn btn-light btn-xs mt-1 mb-1 mr-3">' . $worker->name . ' <strong>[' . $worker_work . ']</strong></a>';
                        }
                      }
                      wp_reset_postdata();
                      ?>
                    </td>
                    <td><?php echo $count_workers_frontend_develop; ?></td>
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
                            worker_work_repeater();
                          }
                          echo '<a href="' . esc_url(home_url('/worker/?love=')) . $worker->slug . '" class="btn btn-light btn-xs mt-1 mb-1 mr-3">' . $worker->name . ' <strong>[' . $worker_work . ']</strong></a>';
                        }
                      }
                      wp_reset_postdata();
                      ?>
                    </td>
                    <td><?php echo $count_workers_backend_develop; ?></td>
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
                            worker_work_repeater();
                          }
                          echo '<a href="' . esc_url(home_url('/worker/?love=')) . $worker->slug . '" class="btn btn-light btn-xs mt-1 mb-1 mr-3">' . $worker->name . ' <strong>[' . $worker_work . ']</strong></a>';
                        }
                      }
                      wp_reset_postdata();
                      ?>
                    </td>
                    <td><?php echo $count_workers_executive; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- //개요 -->

      <!-- 매니저 -->
      <div class="row" id="manager">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">
              매니저
              <div class="float-right font-12 mt-2">
                <span><i class="fa fa-blind"></i> : 진행</span>
                <span class="ml-4"><i class="fas fa-street-view"></i> : 대기</span>
                <span class="ml-4"><i class="fas fa-bed"></i> : 종료</span>
                <span class="ml-4"><i class="fas fa-umbrella"></i> : 운영</span>
                <span class="ml-4"><i class="fas fa-lightbulb"></i> : 단건</span>
                <span class="ml-4"><i class="fas fa-flag"></i> : TF</span>
              </div>
            </h3>
          </div>
        </div>
        <div class="col-xl-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-dark">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>Group</th>
                    <th>Period</th>
                    <th>Energy</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_project->have_posts()) : ?>
                    <?php while ($query_project->have_posts()) : $query_project->the_post(); ?>
                      <?php
                      $work_manager = get_field('work_manager');
                      if ($work_manager) {
                        foreach ($work_manager as $row) {
                          echo '<tr class="' . project_end_checker($row['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/process/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td>' . worker_status_checker($row['start'], $row['end']) . '</td>';
                          echo '</tr>';
                        }
                      }
                      ?>
                    <?php endwhile; ?>
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- //매니저 -->

      <!-- 기획자 -->
      <div class="row" id="planner">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">기획자</h3>
          </div>
        </div>
        <div class="col-xl-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-warning">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>Group</th>
                    <th>Period</th>
                    <th>Energy</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_project->have_posts()) : ?>
                    <?php while ($query_project->have_posts()) : $query_project->the_post(); ?>
                      <?php
                      $work_planner = get_field('work_planner');
                      ?>
                      <?php
                      if ($work_planner) {
                        foreach ($work_planner as $row) {
                          echo '<tr class="' . project_end_checker($row['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/process/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td>' . worker_status_checker($row['start'], $row['end']) . '</td>';
                          echo '</tr>';
                        }
                      }
                      ?>
                    <?php endwhile; ?>
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- //기획자 -->

      <!-- 디자이너 -->
      <div class="row" id="designer">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">디자이너</h3>
          </div>
        </div>
        <div class="col-xl-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-secondary">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>Group</th>
                    <th>Period</th>
                    <th>Energy</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_project->have_posts()) : ?>
                    <?php while ($query_project->have_posts()) : $query_project->the_post(); ?>
                      <?php
                      $work_designer = get_field('work_designer');
                      ?>
                      <?php
                      if ($work_designer) {
                        foreach ($work_designer as $row) {
                          echo '<tr class="' . project_end_checker($row['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/process/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td>' . worker_status_checker($row['start'], $row['end']) . '</td>';
                          echo '</tr>';
                        }
                      }
                      ?>
                    <?php endwhile; ?>
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- //디자이너 -->

      <!-- 프론트엔드개발자 -->
      <div class="row" id="frontend_developer">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">프론트엔드개발자</h3>
          </div>
        </div>
        <div class="col-xl-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-success">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>Group</th>
                    <th>Period</th>
                    <th>Energy</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_project->have_posts()) : ?>
                    <?php while ($query_project->have_posts()) : $query_project->the_post(); ?>
                      <?php
                      $work_frontend_developer = get_field('work_frontend_developer');
                      ?>
                      <?php
                      if ($work_frontend_developer) {
                        foreach ($work_frontend_developer as $row) {
                          echo '<tr class="' . project_end_checker($row['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/process/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td>' . worker_status_checker($row['start'], $row['end']) . '</td>';
                          echo '</tr>';
                        }
                      }
                      ?>
                    <?php endwhile; ?>
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- //프론트엔드개발자 -->

      <!-- 백엔드개발자 -->
      <div class="row" id="backend_developer">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">백엔드개발자</h3>
          </div>
        </div>
        <div class="col-xl-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-primary">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>Group</th>
                    <th>Period</th>
                    <th>Energy</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_project->have_posts()) : ?>
                    <?php while ($query_project->have_posts()) : $query_project->the_post(); ?>
                      <?php
                      $work_backend_developer = get_field('work_backend_developer');
                      ?>
                      <?php
                      if ($work_backend_developer) {
                        foreach ($work_backend_developer as $row) {
                          echo '<tr class="' . project_end_checker($row['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/process/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td>' . worker_status_checker($row['start'], $row['end']) . '</td>';
                          echo '</tr>';
                        }
                      }
                      ?>
                    <?php endwhile; ?>
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- //백엔드개발자 -->

      <!-- 어시스턴트 -->
      <div class="row" id="assistant">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">어시스턴트</h3>
          </div>
        </div>
        <div class="col-xl-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-light">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>Group</th>
                    <th>Period</th>
                    <th>Energy</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_project->have_posts()) : ?>
                    <?php while ($query_project->have_posts()) : $query_project->the_post(); ?>
                      <?php
                      $work_assistant = get_field('work_assistant');
                      ?>
                      <?php
                      if ($work_assistant) {
                        foreach ($work_assistant as $row) {
                          echo '<tr class="' . project_end_checker($row['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/process/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td>' . worker_status_checker($row['start'], $row['end']) . '</td>';
                          echo '</tr>';
                        }
                      }
                      ?>
                    <?php endwhile; ?>
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- //어시스턴트 -->

      <!-- 운영 -->
      <div class="row" id="running">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">운영</h3>
          </div>
        </div>
        <div class="col-xl-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-dark">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>Work</th>
                    <th>Group</th>
                    <th>Period</th>
                    <th>Energy</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_running->have_posts()) : ?>
                    <?php while ($query_running->have_posts()) : $query_running->the_post(); ?>
                      <?php
                      // work
                      $work_manager = get_field('work_manager');
                      $work_planner = get_field('work_planner');
                      $work_designer = get_field('work_designer');
                      $work_frontend_developer = get_field('work_frontend_developer');
                      $work_backend_developer = get_field('work_backend_developer');
                      $work_assistant = get_field('work_assistant');

                      // work label
                      $work_manager_label = get_field_object('work_manager')['label'];
                      $work_planner_label = get_field_object('work_planner')['label'];
                      $work_designer_label = get_field_object('work_designer')['label'];
                      $work_frontend_developer_label = get_field_object('work_frontend_developer')['label'];
                      $work_backend_developer_label = get_field_object('work_backend_developer')['label'];
                      $work_assistant_label = get_field_object('work_assistant')['label'];
                      ?>
                      <?php
                      if ($work_manager) {
                        foreach ($work_manager as $row) {
                          echo '<tr class="' . project_end_checker($row['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[운영] ' . $work_manager_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-umbrella"></i><span class="invisible">운영</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_planner) {
                        foreach ($work_planner as $row) {
                          echo '<tr class="' . project_end_checker($row['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[운영] ' . $work_planner_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-umbrella"></i><span class="invisible">운영</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_designer) {
                        foreach ($work_designer as $row) {
                          echo '<tr class="' . project_end_checker($row['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[운영] ' . $work_designer_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-umbrella"></i><span class="invisible">운영</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_frontend_developer) {
                        foreach ($work_frontend_developer as $row) {
                          echo '<tr class="' . project_end_checker($row['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[운영] ' . $work_frontend_developer_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-umbrella"></i><span class="invisible">운영</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_backend_developer) {
                        foreach ($work_backend_developer as $row) {
                          echo '<tr class="' . project_end_checker($row['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[운영] ' . $work_backend_developer_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-umbrella"></i><span class="invisible">운영</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_assistant) {
                        foreach ($work_assistant as $row) {
                          echo '<tr class="' . project_end_checker($row['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[운영] ' . $work_assistant_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $row['start'] . ' ~ ' . $row['end'] . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-umbrella"></i><span class="invisible">운영</span></td>';
                          echo '</tr>';
                        }
                      }
                      ?>
                    <?php endwhile; ?>
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- //운영 -->

      <!-- 단건 -->
      <div class="row" id="onlyone">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">단건</h3>
          </div>
        </div>
        <div class="col-xl-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-dark">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>Work</th>
                    <th>Group</th>
                    <th>Period</th>
                    <th>Energy</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_onlyone->have_posts()) : ?>
                    <?php while ($query_onlyone->have_posts()) : $query_onlyone->the_post(); ?>
                      <?php
                      // work
                      $work_manager = get_field('work_manager');
                      $work_planner = get_field('work_planner');
                      $work_designer = get_field('work_designer');
                      $work_frontend_developer = get_field('work_frontend_developer');
                      $work_backend_developer = get_field('work_backend_developer');
                      $work_assistant = get_field('work_assistant');

                      // work label
                      $work_manager_label = get_field_object('work_manager')['label'];
                      $work_planner_label = get_field_object('work_planner')['label'];
                      $work_designer_label = get_field_object('work_designer')['label'];
                      $work_frontend_developer_label = get_field_object('work_frontend_developer')['label'];
                      $work_backend_developer_label = get_field_object('work_backend_developer')['label'];
                      $work_assistant_label = get_field_object('work_assistant')['label'];

                      // contract period
                      $contract_period = get_field('contract_period');
                      $contract_period_start = project_date_format_converter($contract_period['start']);
                      $contract_period_end = project_date_format_converter($contract_period['end']);
                      ?>
                      <?php
                      if ($work_manager) {
                        foreach ($work_manager as $row) {
                          echo '<tr class="' . project_end_checker($contract_period['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[단건] ' . $work_manager_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $contract_period_start . ' ~ ' . $contract_period_end . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-lightbulb"></i><span class="invisible">단건</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_planner) {
                        foreach ($work_planner as $row) {
                          echo '<tr class="' . project_end_checker($contract_period['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[단건] ' . $work_planner_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $contract_period_start . ' ~ ' . $contract_period_end . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-lightbulb"></i><span class="invisible">단건</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_designer) {
                        foreach ($work_designer as $row) {
                          echo '<tr class="' . project_end_checker($contract_period['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[단건] ' . $work_designer_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $contract_period_start . ' ~ ' . $contract_period_end . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-lightbulb"></i><span class="invisible">단건</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_frontend_developer) {
                        foreach ($work_frontend_developer as $row) {
                          echo '<tr class="' . project_end_checker($contract_period['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[단건] ' . $work_frontend_developer_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $contract_period_start . ' ~ ' . $contract_period_end . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-lightbulb"></i><span class="invisible">단건</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_backend_developer) {
                        foreach ($work_backend_developer as $row) {
                          echo '<tr class="' . project_end_checker($contract_period['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[단건] ' . $work_backend_developer_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $contract_period_start . ' ~ ' . $contract_period_end . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-lightbulb"></i><span class="invisible">단건</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_assistant) {
                        foreach ($work_assistant as $row) {
                          echo '<tr class="' . project_end_checker($contract_period['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[단건] ' . $work_assistant_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $contract_period_start . ' ~ ' . $contract_period_end . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-lightbulb"></i><span class="invisible">단건</span></td>';
                          echo '</tr>';
                        }
                      }
                      ?>
                    <?php endwhile; ?>
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- //단건 -->

      <!-- TF -->
      <div class="row" id="tf">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">TF</h3>
          </div>
        </div>
        <div class="col-xl-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-dark">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>Work</th>
                    <th>Group</th>
                    <th>Period</th>
                    <th>Energy</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_tf->have_posts()) : ?>
                    <?php while ($query_tf->have_posts()) : $query_tf->the_post(); ?>
                      <?php
                      // work
                      $work_manager = get_field('work_manager');
                      $work_planner = get_field('work_planner');
                      $work_designer = get_field('work_designer');
                      $work_frontend_developer = get_field('work_frontend_developer');
                      $work_backend_developer = get_field('work_backend_developer');
                      $work_assistant = get_field('work_assistant');

                      // work label
                      $work_manager_label = get_field_object('work_manager')['label'];
                      $work_planner_label = get_field_object('work_planner')['label'];
                      $work_designer_label = get_field_object('work_designer')['label'];
                      $work_frontend_developer_label = get_field_object('work_frontend_developer')['label'];
                      $work_backend_developer_label = get_field_object('work_backend_developer')['label'];
                      $work_assistant_label = get_field_object('work_assistant')['label'];

                      // tf period
                      $tf_period = get_field('tf_period');
                      $tf_period_start = project_date_format_converter($tf_period['start']);
                      $tf_period_end = project_date_format_converter($tf_period['end']);
                      ?>
                      <?php
                      if ($work_manager) {
                        foreach ($work_manager as $row) {
                          echo '<tr class="' . project_end_checker($tf_period['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[TF] ' . $work_manager_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $tf_period_start . ' ~ ' . $tf_period_end . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-flag"></i><span class="invisible">TF</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_planner) {
                        foreach ($work_planner as $row) {
                          echo '<tr class="' . project_end_checker($tf_period['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[TF] ' . $work_planner_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $tf_period_start . ' ~ ' . $tf_period_end . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-flag"></i><span class="invisible">TF</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_designer) {
                        foreach ($work_designer as $row) {
                          echo '<tr class="' . project_end_checker($tf_period['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[TF] ' . $work_designer_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $tf_period_start . ' ~ ' . $tf_period_end . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-flag"></i><span class="invisible">TF</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_frontend_developer) {
                        foreach ($work_frontend_developer as $row) {
                          echo '<tr class="' . project_end_checker($tf_period['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[TF] ' . $work_frontend_developer_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $tf_period_start . ' ~ ' . $tf_period_end . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-flag"></i><span class="invisible">TF</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_backend_developer) {
                        foreach ($work_backend_developer as $row) {
                          echo '<tr class="' . project_end_checker($tf_period['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[TF] ' . $work_backend_developer_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $tf_period_start . ' ~ ' . $tf_period_end . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-flag"></i><span class="invisible">TF</span></td>';
                          echo '</tr>';
                        }
                      }
                      if ($work_assistant) {
                        foreach ($work_assistant as $row) {
                          echo '<tr class="' . project_end_checker($tf_period['end']) . '">';
                          echo '<td><a href="' . esc_url(home_url('/worker/?love=')) . $row['worker']->slug . '"><strong>' . $row['worker']->name . '</strong></a></td>';
                          echo '<td>';
                          project_logo_image();
                          echo '</td>';
                          echo '<td><a href="' . esc_url(home_url('/present/?id=')) . get_the_ID() . '">' . get_the_title() . '</a></td>';
                          echo '<td>[TF] ' . $work_assistant_label . '</td>';
                          echo '<td>' . $row['worker']->description . '</td>';
                          echo '<td>' . $tf_period_start . ' ~ ' . $tf_period_end . '</td>';
                          echo '<td>' . $row['energy'] . '%</td>';
                          echo '<td><i class="text-muted fa fa-flag"></i><span class="invisible">TF</span></td>';
                          echo '</tr>';
                        }
                      }
                      ?>
                    <?php endwhile; ?>
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- //TF -->

      <!-- 차트로 볼까요? -->
      <div class="row" id="gochart">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">차트로 볼까요?</h3>
          </div>
        </div>

        <!-- 직군별 비율 -->
        <div class="col-xl-12">
          <div class="card animated fadeInUp">
            <h5 class="card-header">직군별 비율은? [%]</h5>
            <div class="card-body">

              <!-- chartjs -->
              <script src="<?php echo get_template_directory_uri(); ?>/_source/assets/vendor/charts/charts-bundle/Chart.bundle.js"></script>

              <canvas id="workerGroup"></canvas>

              <script>
                var chart = document.getElementById("workerGroup").getContext("2d");
                var myChart = new Chart(chart, {
                  type: "doughnut",
                  data: {
                    labels: ["기획/PM", "UI/UX", "프론트엔드", "백엔드", "경영진"],
                    datasets: [{
                      backgroundColor: [
                        "#ffc108",
                        "#ff407b",
                        "#2ec551",
                        "#5969ff",
                        "#f0f0f8",
                      ],
                      data: [<?php echo $ratio_workers_plan; ?>, <?php echo $ratio_workers_design; ?>, <?php echo $ratio_workers_frontend_develop; ?>, <?php echo $ratio_workers_backend_develop; ?>, <?php echo $ratio_workers_executive; ?>]
                    }]
                  },
                  options: {
                    legend: {
                      display: true,
                      position: "bottom",
                      labels: {
                        fontColor: "#71748d",
                        fontSize: 14
                      }
                    }
                  }
                });
              </script>
              <!-- //chartjs -->

            </div>
          </div>
        </div>
        <!-- //직군별 비율 -->

      </div>
      <!-- //차트로 볼까요? -->

    </div>
    <!-- //content -->

    <!-- sidebar -->
    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
      <div class="sidebar-nav-fixed">
        <ul class="list-unstyled">
          <li><a href="#overview">개요</a></li>
          <li><a href="#manager">매니저</a></li>
          <li><a href="#planner">기획자</a></li>
          <li><a href="#designer">디자이너</a></li>
          <li><a href="#frontend_developer">프론트엔드개발자</a></li>
          <li><a href="#backend_developer">백엔드개발자</a></li>
          <li><a href="#assistant">어시스턴트</a></li>
          <li><a href="#running">운영</a></li>
          <li><a href="#onlyone">단건</a></li>
          <li><a href="#tf">TF</a></li>
          <li><a href="#gochart">차트로 볼까요?</a></li>
          <li><a href="#backtoptop"><i class="fas fa-arrow-up"></i> TOP</a></li>
        </ul>
      </div>
    </div>
    <!-- //sidebar -->

  </div>
  <!-- inner -->

</div>

<?php get_footer(); ?>