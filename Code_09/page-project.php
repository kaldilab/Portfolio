<?php get_header(); ?>

<div class="container-fluid dashboard-content" id="backtoptop">

  <?php get_template_part('templates/content', 'breadcrumb'); ?>

  <?php
  // docking
  $args_docking = array(
    'post_type' => 'docking',
    'posts_per_page' => -1,
    'meta_key' => 'docking_finish',
    'meta_value' => '0',
  );
  $query_docking = new WP_Query($args_docking);
  $count_docking = $query_docking->found_posts;

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
  $count_project = $query_project->found_posts;

  // project ing
  $args_project_ing = array(
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
        'key' => 'schedule_plan_start',
        'compare' => '<=',
        'value' => date('Y-m-d'),
        'type' => 'DATE',
      ),
      array(
        'key' => 'schedule_open_date',
        'compare' => '>',
        'value' => date('Y-m-d'),
        'type' => 'DATE',
      ),
    ),
  );
  $query_project_ing = new WP_Query($args_project_ing);
  $count_project_ing = $query_project_ing->found_posts;

  // project end
  $args_project_end = array(
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
        'compare' => '<=',
        'value' => date('Y-m-d'),
        'type' => 'DATE',
      ),
    ),
  );
  $query_project_end = new WP_Query($args_project_end);
  $count_project_end = $query_project_end->found_posts;

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
  $count_running = $query_running->found_posts;

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
  $count_onlyone = $query_onlyone->found_posts;
  
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
  $count_tf = $query_tf->found_posts;

  // project waiting
  $count_waiting = $count_project - ($count_project_ing + $count_project_end);
  ?>

  <div class="section-block pb-3">
    <h2 class="section-title"><i class="fa fa-fw fa-paper-plane"></i> 무슨 일이 일어나고 있나요?</h2>
  </div>

  <!-- inner -->
  <div class="row">

    <!-- content -->
    <div class="col-xl-10">

      <!-- 도킹 -->
      <div class="row" id="docking">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">도킹 (<?php echo $count_docking; ?>건)</h3>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-light">
                <colgroup>
                  <col style="width:5%">
                  <col style="width:20%">
                  <col style="width:15%">
                  <col style="width:*">
                </colgroup>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Company</th>
                    <th>PM</th>
                    <th>Comment</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($query_docking->have_posts()) {
                    $index_docking = 1;
                    while ($query_docking->have_posts()) {
                      $query_docking->the_post();
                      echo '<tr>';
                      echo '<td>' . $index_docking . '</td>';
                      echo '<td>' . get_the_title() . '</td>';
                      echo '<td>';
                      $docking_manager = get_field('docking_manager');
                      if ($docking_manager) {
                        foreach ($docking_manager as $term) {
                          echo $term->name . ' ';
                        }
                      }
                      echo '</td>';
                      echo '<td>' . get_field('project_summary') . '</td>';
                      echo '<td>' . get_the_date() . '</td>';
                      echo '</tr>';
                      $index_docking++;
                    }
                  }
                  wp_reset_postdata();
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- //도킹 -->

      <!-- 개요 -->
      <div class="row" id="overview">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">개요</h3>
          </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
          <div class="card border-3 border-top border-top-primary animated fadeInUp">
            <div class="card-body">
              <h5 class="text-muted"><i class="fas fa-calendar-alt"></i> 전체 <?php echo ($count_waiting == 0) ? '' : '<span class="font-12">(대기)</span>'; ?></h5>
              <div class="metric-value d-inline-block">
                <h1 class="mb-1"><?php echo $count_project; ?> <?php echo ($count_waiting == 0) ? '' : '<span class="font-20">(' . $count_waiting . ')</span>'; ?></h1>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
          <div class="card border-3 border-top border-top-warning animated fadeInUp">
            <div class="card-body">
              <h5 class="text-muted"><i class="fas fa-calendar-check"></i> 진행 [기획~테스트]</h5>
              <div class="metric-value d-inline-block">
                <h1 class="mb-1"><?php echo $count_project_ing; ?></h1>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
          <div class="card border-3 border-top border-top-success animated fadeInUp">
            <div class="card-body">
              <h5 class="text-muted"><i class="fas fa-calendar-minus"></i> 종료 [오픈]</h5>
              <div class="metric-value d-inline-block">
                <h1 class="mb-1"><?php echo $count_project_end; ?></h1>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
          <div class="card border-3 border-top border-top-dark animated fadeInUp">
            <div class="card-body alert-dark">
              <h5 class="text-muted">운영 / 단건 / TF</h5>
              <div class="metric-value d-inline-block">
                <h1 class="mb-1"><?php echo $count_running; ?> / <?php echo $count_onlyone; ?> / <?php echo $count_tf; ?></h1>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- //개요 -->

      <!-- 전체 -->
      <div class="row" id="contract">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">
              전체 (<?php echo $count_project; ?>건) <?php echo ($count_waiting == 0) ? '' : '<span class="font-16">- 대기 (' . $count_waiting . '건)</span>'; ?>
              <div class="float-right font-12 mt-2">
                <span><i class="fa fa-paper-plane"></i> : 진행</span>
                <span class="ml-4"><i class="fas fa-street-view"></i> : 대기</span>
                <span class="ml-4"><i class="fas fa-bed"></i> : 종료</span>
              </div>
            </h3>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-primary">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>Money (원)</th>
                    <th>PM</th>
                    <th>Platform</th>
                    <th>Open</th>
                    <th>Link</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_project->have_posts()) : ?>
                    <?php $index_project = 1; ?>
                    <?php while ($query_project->have_posts()) : $query_project->the_post(); ?>
                      <?php
                          $contract_date = get_field('contract_date');
                          $schedule_plan_start = get_field('schedule_plan')['start'];
                          $schedule_open_date = get_field('schedule_open')['date'];
                          ?>
                      <tr class="<?php echo project_end_checker($schedule_open_date); ?>">
                        <td><?php echo $index_project; ?></td>
                        <td>
                          <?php project_logo_image(); ?>
                        </td>
                        <td><a href="<?php echo esc_url(home_url('/present/?id=')) . get_the_ID(); ?>"><?php echo get_the_title(); ?></a></td>
                        <td class="numbers"><?php echo get_field('contract_money'); ?></td>
                        <td>
                          <?php
                              $work_manager = get_field('work_manager');
                              if ($work_manager) {
                                foreach ($work_manager as $row) {
                                  echo $row['worker']->name . ' ';
                                }
                              }
                              ?>
                        </td>
                        <td><?php echo get_field('develop_platform'); ?></td>
                        <td><?php echo project_date_format_converter(get_field('schedule_open')['date']); ?></td>
                        <td>
                          <div class="avatar-group">
                            <span><a href="<?php echo get_field('develop_definition'); ?>" title="기능정의서" target="_blank"><i class="fas fa-fw fa-file-excel text-primary"></i></a></span>
                            <span><a href="<?php echo get_field('develop_repository'); ?>" title="Github저장소" target="_blank"><i class="fab fa-fw fa-github text-secondary"></i></a></span>
                            <span><a href="<?php echo get_field('develop_drive'); ?>" title="구글드라이브" target="_blank"><i class="fab fa-fw fa-google-drive text-success"></i></a></span>
                          </div>
                        </td>
                        <td><?php echo project_status_checker($contract_date, $schedule_plan_start, $schedule_open_date); ?></td>
                      </tr>
                      <?php $index_project++; ?>
                    <?php endwhile; ?>
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- //전체 -->

      <!-- 진행 -->
      <div class="row" id="project_ing">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title"> 진행 (<?php echo $count_project_ing; ?>건)</h3>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-warning">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>Money (원)</th>
                    <th>PM</th>
                    <th>Platform</th>
                    <th>Open</th>
                    <th>Link</th>
                    <th>Process</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_project_ing->have_posts()) : ?>
                    <?php $index_project_ing = 1; ?>
                    <?php while ($query_project_ing->have_posts()) : $query_project_ing->the_post(); ?>
                      <tr>
                        <td><?php echo $index_project_ing; ?></td>
                        <td>
                          <?php project_logo_image(); ?>
                        </td>
                        <td><a href="<?php echo esc_url(home_url('/present/?id=')) . get_the_ID(); ?>"><?php echo get_the_title(); ?></a></td>
                        <td class="numbers"><?php echo get_field('contract_money'); ?></td>
                        <td>
                          <?php
                              $work_manager = get_field('work_manager');
                              if ($work_manager) {
                                foreach ($work_manager as $row) {
                                  echo $row['worker']->name . ' ';
                                }
                              }
                              ?>
                        </td>
                        <td><?php echo get_field('develop_platform'); ?></td>
                        <td><?php echo project_date_format_converter(get_field('schedule_open')['date']); ?></td>
                        <td>
                          <div class="avatar-group">
                            <span><a href="<?php echo get_field('develop_definition'); ?>" title="기능정의서" target="_blank"><i class="fas fa-fw fa-file-excel text-primary"></i></a></span>
                            <span><a href="<?php echo get_field('develop_repository'); ?>" title="Github저장소" target="_blank"><i class="fab fa-fw fa-github text-secondary"></i></a></span>
                            <span><a href="<?php echo get_field('develop_drive'); ?>" title="구글드라이브" target="_blank"><i class="fab fa-fw fa-google-drive text-success"></i></a></span>
                          </div>
                        </td>
                        <td><a href="<?php echo esc_url(home_url('/process/?id=')) . get_the_ID(); ?>"><i class="fas fa-stopwatch text-info"></i></a></td>
                      </tr>
                      <?php $index_project_ing++; ?>
                    <?php endwhile; ?>
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- //진행 -->

      <!-- 종료 -->
      <div class="row" id="project_end">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title"> 종료 (<?php echo $count_project_end; ?>건)</h3>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-success">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>Money (원)</th>
                    <th>PM</th>
                    <th>Platform</th>
                    <th>Open</th>
                    <th>Link</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_project_end->have_posts()) : ?>
                    <?php $index_project_end = 1; ?>
                    <?php while ($query_project_end->have_posts()) : $query_project_end->the_post(); ?>
                      <tr>
                        <td><?php echo $index_project_end; ?></td>
                        <td>
                          <?php project_logo_image(); ?>
                        </td>
                        <td><a href="<?php echo esc_url(home_url('/present/?id=')) . get_the_ID(); ?>"><?php echo get_the_title(); ?></a></td>
                        <td class="numbers"><?php echo get_field('contract_money'); ?></td>
                        <td>
                          <?php
                              $work_manager = get_field('work_manager');
                              if ($work_manager) {
                                foreach ($work_manager as $row) {
                                  echo $row['worker']->name . ' ';
                                }
                              }
                              ?>
                        </td>
                        <td><?php echo get_field('develop_platform'); ?></td>
                        <td><?php echo project_date_format_converter(get_field('schedule_open')['date']); ?></td>
                        <td>
                          <div class="avatar-group">
                            <span><a href="<?php echo get_field('develop_definition'); ?>" title="기능정의서" target="_blank"><i class="fas fa-fw fa-file-excel text-primary"></i></a></span>
                            <span><a href="<?php echo get_field('develop_repository'); ?>" title="Github저장소" target="_blank"><i class="fab fa-fw fa-github text-secondary"></i></a></span>
                            <span><a href="<?php echo get_field('develop_drive'); ?>" title="구글드라이브" target="_blank"><i class="fab fa-fw fa-google-drive text-success"></i></a></span>
                          </div>
                        </td>
                      </tr>
                      <?php $index_project_end++; ?>
                    <?php endwhile; ?>
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- //종료 -->

      <!-- 운영 -->
      <div class="row" id="running">
        <div class="col-xl-12">
          <div class="section-block">
            <h3 class="section-title">운영 (<?php echo $count_running; ?>건)</h3>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-dark">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>Money (원)</th>
                    <th>PM</th>
                    <th>Platform</th>
                    <th>Period</th>
                    <th>Link</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_running->have_posts()) : ?>
                    <?php $index_running = 1; ?>
                    <?php while ($query_running->have_posts()) : $query_running->the_post(); ?>
                      <tr class="<?php echo project_end_checker(get_field('contract_period')['end']); ?>">
                        <td><?php echo $index_running; ?></td>
                        <td>
                          <?php project_logo_image(); ?>
                        </td>
                        <td><a href="<?php echo esc_url(home_url('/present/?id=')) . get_the_ID(); ?>"><?php echo get_the_title(); ?></a></td>
                        <td class="numbers"><?php echo get_field('contract_money'); ?></td>
                        <td>
                          <?php
                              $work_manager = get_field('work_manager');
                              if ($work_manager) {
                                foreach ($work_manager as $row) {
                                  echo $row['worker']->name . ' ';
                                }
                              }
                              ?>
                        </td>
                        <td><?php echo get_field('develop_platform'); ?></td>
                        <td><?php echo get_field('contract_period')['start'] . ' ~ ' . get_field('contract_period')['end']; ?></td>
                        <td>
                          <div class="avatar-group">
                            <span><a href="<?php echo get_field('develop_definition'); ?>" title="기능정의서" target="_blank"><i class="fas fa-fw fa-file-excel text-primary"></i></a></span>
                            <span><a href="<?php echo get_field('develop_repository'); ?>" title="Github저장소" target="_blank"><i class="fab fa-fw fa-github text-secondary"></i></a></span>
                            <span><a href="<?php echo get_field('develop_drive'); ?>" title="구글드라이브" target="_blank"><i class="fab fa-fw fa-google-drive text-success"></i></a></span>
                          </div>
                        </td>
                      </tr>
                      <?php $index_running++; ?>
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
            <h3 class="section-title">단건 (<?php echo $count_onlyone; ?>건)</h3>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-dark">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>Money (원)</th>
                    <th>PM</th>
                    <th>Platform</th>
                    <th>Period</th>
                    <th>Link</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_onlyone->have_posts()) : ?>
                    <?php $index_onlyone = 1; ?>
                    <?php while ($query_onlyone->have_posts()) : $query_onlyone->the_post(); ?>
                      <tr class="<?php echo project_end_checker(get_field('contract_period')['end']); ?>">
                        <td><?php echo $index_onlyone; ?></td>
                        <td>
                          <?php project_logo_image(); ?>
                        </td>
                        <td><a href="<?php echo esc_url(home_url('/present/?id=')) . get_the_ID(); ?>"><?php echo get_the_title(); ?></a></td>
                        <td class="numbers"><?php echo get_field('contract_money'); ?></td>
                        <td>
                          <?php
                              $work_manager = get_field('work_manager');
                              if ($work_manager) {
                                foreach ($work_manager as $row) {
                                  echo $row['worker']->name . ' ';
                                }
                              }
                              ?>
                        </td>
                        <td><?php echo get_field('develop_platform'); ?></td>
                        <td><?php echo get_field('contract_period')['start'] . ' ~ ' . get_field('contract_period')['end']; ?></td>
                        <td>
                          <div class="avatar-group">
                            <span><a href="<?php echo get_field('develop_definition'); ?>" title="기능정의서" target="_blank"><i class="fas fa-fw fa-file-excel text-primary"></i></a></span>
                            <span><a href="<?php echo get_field('develop_repository'); ?>" title="Github저장소" target="_blank"><i class="fab fa-fw fa-github text-secondary"></i></a></span>
                            <span><a href="<?php echo get_field('develop_drive'); ?>" title="구글드라이브" target="_blank"><i class="fab fa-fw fa-google-drive text-success"></i></a></span>
                          </div>
                        </td>
                      </tr>
                      <?php $index_onlyone++; ?>
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
            <h3 class="section-title">TF (<?php echo $count_tf; ?>건)</h3>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="card animated fadeInUp">
            <div class="campaign-table table-responsive">
              <table class="table table-hover border-3 border-top border-top-dark">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Logo</th>
                    <th>Project</th>
                    <th>PM</th>
                    <th>Period</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($query_tf->have_posts()) : ?>
                    <?php $index_tf = 1; ?>
                    <?php while ($query_tf->have_posts()) : $query_tf->the_post(); ?>
                      <tr class="<?php echo project_end_checker(get_field('tf_period')['end']); ?>">
                        <td><?php echo $index_tf; ?></td>
                        <td>
                          <?php project_logo_image(); ?>
                        </td>
                        <td><a href="<?php echo esc_url(home_url('/tf/?id=')) . get_the_ID(); ?>"><?php echo get_the_title(); ?></a></td>
                        <td>
                          <?php
                              $work_manager = get_field('work_manager');
                              if ($work_manager) {
                                foreach ($work_manager as $row) {
                                  echo $row['worker']->name . ' ';
                                }
                              }
                              ?>
                        </td>
                        <td><?php echo get_field('tf_period')['start'] . ' ~ ' . get_field('tf_period')['end']; ?></td>
                      </tr>
                      <?php $index_tf++; ?>
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

        <?php
        // post project
        $args_project_diff = array(
          'post_type' => 'project',
          'posts_per_page' => -1,
          'meta_key' => 'project_finish',
          'meta_value' => '0',
        );
        $query_project_diff = new WP_Query($args_project_diff);

        // array project
        $result_project_diff = array();
        ?>

        <?php
        if ($query_project_diff->have_posts()) :
          while ($query_project_diff->have_posts()) : $query_project_diff->the_post();

            $title = get_the_title();

            // schedule
            $schedule_plan = get_field('schedule_plan');
            $schedule_design = get_field('schedule_design');
            $schedule_develop_frontend = get_field('schedule_develop_frontend');
            $schedule_develop_backend = get_field('schedule_develop_backend');

            // schedule start
            $schedule_plan_start = $schedule_plan['start'];
            $schedule_design_start = $schedule_design['start'];
            $schedule_develop_frontend_start = $schedule_develop_frontend['start'];
            $schedule_develop_backend_start = $schedule_develop_backend['start'];

            // schedule end
            $schedule_plan_end = $schedule_plan['end'];
            $schedule_design_end = $schedule_design['end'];
            $schedule_develop_frontend_end = $schedule_develop_frontend['end'];
            $schedule_develop_backend_end = $schedule_develop_backend['end'];

            // open
            $schedule_open = get_field('schedule_open');
            $schedule_open_date = $schedule_open['date'];

            // diff
            $schedule_whole_diff = (date_diff(date_create($schedule_plan_start), date_create($schedule_open_date)))->format('%a');
            $schedule_plan_diff = (date_diff(date_create($schedule_plan_start), date_create($schedule_plan_end)))->format('%a');
            $schedule_design_diff = (date_diff(date_create($schedule_design_start), date_create($schedule_design_end)))->format('%a');
            $schedule_develop_frontend_diff = (date_diff(date_create($schedule_develop_frontend_start), date_create($schedule_develop_frontend_end)))->format('%a');
            $schedule_develop_backend_diff = (date_diff(date_create($schedule_develop_backend_start), date_create($schedule_develop_backend_end)))->format('%a');

            // array
            $array_schedule = array(
              'project' => $title,
              'name' => $title,
              'count' => $schedule_whole_diff,
              "color" => 'rgba(170,170,170,.7)',
            );
            $array_plan = array(
              'project' => $title,
              'name' => '기획 : ' .  $title,
              'count' => $schedule_plan_diff,
              "color" => 'rgba(255,193,8,.7)',
            );
            $array_design = array(
              'project' => $title,
              'name' => '디자인 : ' .  $title,
              'count' => $schedule_design_diff,
              "color" => 'rgba(255,64,123,.7)',
            );
            $array_frontend = array(
              'project' => $title,
              'name' => '프론트엔드 : ' .  $title,
              'count' => $schedule_develop_frontend_diff,
              "color" => 'rgba(46,197,81,.7)',
            );
            $array_backend = array(
              'project' => $title,
              'name' => '백엔드 : ' .  $title,
              'count' => $schedule_develop_backend_diff,
              "color" => 'rgba(89,105,255,.7)',
            );

            if ($schedule_plan_start && $schedule_plan_end) {
              $result_project_diff[] = $array_schedule;
            }
            if ($schedule_plan_start && $schedule_plan_end) {
              $result_project_diff[] = $array_plan;
            }
            if ($schedule_design_start && $schedule_design_end) {
              $result_project_diff[] = $array_design;
            }
            if ($schedule_develop_frontend_start && $schedule_develop_frontend_end) {
              $result_project_diff[] = $array_frontend;
            }
            if ($schedule_develop_backend_start && $schedule_develop_backend_end) {
              $result_project_diff[] = $array_backend;
            }

          endwhile;
        endif;

        // json project diff
        $json_project_diff = json_encode($result_project_diff);
        ?>
        <div class="col-xl-12 mt-2">
          <div class="card animated fadeInUp">
            <h5 class="card-header">프로젝트별 작업일은? [일]</h5>

            <?php get_template_part('templates/content', 'colorindex'); ?>

            <div class="card-body">

              <!-- amcharts -->
              <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/core.js"></script>
              <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/charts.js"></script>
              <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/themes/animated.js"></script>
              <script src="<?php echo get_template_directory_uri(); ?>/assets/amcharts-4.7.10/lang/ko_KR.js"></script>

              <div id="projectGantt"></div>

              <script>
                // animated
                am4core.useTheme(am4themes_animated);

                // chart
                var chart = am4core.create("projectGantt", am4charts.XYChart);
                chart.data = <?php echo $json_project_diff; ?>;

                // axes
                var yAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                yAxis.dataFields.category = "name";
                yAxis.renderer.grid.template.location = 0;
                yAxis.renderer.labels.template.fontSize = 10;
                yAxis.renderer.minGridDistance = 10;
                var xAxis = chart.xAxes.push(new am4charts.ValueAxis());

                // series
                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueX = "count";
                series.dataFields.categoryY = "name";
                series.columns.template.tooltipText = "{categoryY}: [bold]{valueX}[/]";
                series.columns.template.strokeWidth = 0;
                series.columns.template.propertyFields.fill = "color";
                series.columns.template.propertyFields.stroke = "color";
                series.columns.template.strokeOpacity = 1;

                // cursor
                chart.cursor = new am4charts.XYCursor();

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
      <!-- //차트로 볼까요? -->

    </div>
    <!-- //content -->

    <!-- sidebar -->
    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
      <div class="sidebar-nav-fixed">
        <ul class="list-unstyled">
          <li><a href="#docking">도킹</a></li>
          <li><a href="#overview">개요</a></li>
          <li><a href="#contract">전체</a></li>
          <li><a href="#project_ing">진행</a></li>
          <li><a href="#project_end">종료</a></li>
          <li><a href="#running">운영</a></li>
          <li><a href="#onlyone">단건</a></li>
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