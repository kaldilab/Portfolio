<?php get_header(); ?>

<div class="container-fluid dashboard-content">

  <?php get_template_part('templates/content', 'breadcrumb'); ?>

  <?php
  $args_project = array(
    'post_type' => array(
      'project',
    ),
    'posts_per_page' => -1,
    'p' => $_GET['id'],
  );
  $query_project = new WP_Query($args_project);
  ?>

  <?php if ($query_project->have_posts()) : ?>
    <?php while ($query_project->have_posts()) : $query_project->the_post(); ?>

      <?php
          // contract
          $contract_date = get_field('contract_date');

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
          $schedule_open_title = $schedule_open['title'];
          $schedule_open_date = $schedule_open['date'];
          ?>

      <div class="row">
        <div class="col-xl-12">
          <h2 class="text-center"><?php echo get_the_title(); ?></h2>
          <p class="text-center"><i class="fas fa-clock"></i> <?php echo date("Y-m-d"); ?></p>
        </div>
      </div>

      <!-- timeline -->
      <section class="cd-timeline js-cd-timeline">
        <div class="cd-timeline__container">
          <div class="cd-timeline__block js-cd-block <?php process_contract_checker($schedule_plan_start); ?>">
            <div class="cd-timeline__img js-cd-img bg-dark">
              <span class="process-icon fas fa-handshake"></span>
            </div>
            <div class="cd-timeline__content js-cd-content">
              <h3>계약</h3>
              <p>계약 기간에 프로젝트 상품을 선택하고 기본적인 기획을 논의해요.</p>
              <a href="javascript:alert('개발 중입니다...');" class="btn btn-light btn-sm">문의하기</a>
              <span class="cd-timeline__date"><?php echo $contract_date; ?></span>
            </div>
          </div>
          <div class="cd-timeline__block js-cd-block <?php process_period_checker($schedule_contents_start, $schedule_contents_end); ?>">
            <div class="cd-timeline__img js-cd-img bg-light">
              <span class="process-icon fas fa-archive text-muted"></span>
            </div>
            <div class="cd-timeline__content js-cd-content">
              <h3>콘텐츠준비</h3>
              <p>고객이 콘텐츠를 준비 중이에요. 정해진 기간 안에 콘텐츠가 준비되어야 전체 일정에 차질이 없어요.</p>
              <a href="javascript:alert('개발 중입니다...');" class="btn btn-light btn-sm">문의하기</a>
              <span class="cd-timeline__date"><?php echo $schedule_contents_start . ' ~ ' . $schedule_contents_end; ?></span>
            </div>
          </div>
          <div class="cd-timeline__block js-cd-block <?php process_period_checker($schedule_plan_start, $schedule_plan_end); ?>">
            <div class="cd-timeline__img js-cd-img bg-warning">
              <span class="process-icon fas fa-map-signs"></span>
            </div>
            <div class="cd-timeline__content js-cd-content">
              <h3>기획</h3>
              <p>기획안을 작성하고 있어요. 기획이 확정된 후에는 기획을 변경할 수 없어요.</p>
              <a href="javascript:alert('개발 중입니다...');" class="btn btn-light btn-sm">문의하기</a>
              <span class="cd-timeline__date"><?php echo $schedule_plan_start . ' ~ ' . $schedule_plan_end; ?></span>
            </div>
          </div>
          <div class="cd-timeline__block js-cd-block <?php process_period_checker($schedule_design_start, $schedule_design_end); ?>">
            <div class="cd-timeline__img js-cd-img bg-secondary">
              <span class="process-icon fas fa-paint-brush"></span>
            </div>
            <div class="cd-timeline__content js-cd-content">
              <h3>디자인</h3>
              <p>디자인을 제작하고 있어요. 디자인이 완료된 후에는 디자인을 변경할 수 없어요.</p>
              <a href="javascript:alert('개발 중입니다...');" class="btn btn-light btn-sm">문의하기</a>
              <span class="cd-timeline__date"><?php echo $schedule_design_start . ' ~ ' . $schedule_design_end; ?></span>
            </div>
          </div>
          <div class="cd-timeline__block js-cd-block <?php process_period_checker($schedule_develop_frontend_start, $schedule_develop_frontend_end); ?>">
            <div class="cd-timeline__img js-cd-img bg-success">
              <span class="process-icon fas fa-code"></span>
            </div>
            <div class="cd-timeline__content js-cd-content">
              <h3>프론트엔드개발</h3>
              <p>프론트 단의 개발을 진행하고 있어요. 기능 추가나 변경을 할 수 없어요.</p>
              <a href="javascript:alert('개발 중입니다...');" class="btn btn-light btn-sm">문의하기</a>
              <span class="cd-timeline__date"><?php echo $schedule_develop_frontend_start . ' ~ ' . $schedule_develop_frontend_end; ?></span>
            </div>
          </div>
          <div class="cd-timeline__block js-cd-block <?php process_period_checker($schedule_develop_backend_start, $schedule_develop_backend_end); ?>">
            <div class="cd-timeline__img js-cd-img bg-primary">
              <span class="process-icon fas fa-terminal"></span>
            </div>
            <div class="cd-timeline__content js-cd-content">
              <h3>백엔드개발</h3>
              <p>백 단의 개발을 진행하고 있어요. 기능 추가나 변경을 할 수 없어요.</p>
              <a href="javascript:alert('개발 중입니다...');" class="btn btn-light btn-sm">문의하기</a>
              <span class="cd-timeline__date"><?php echo $schedule_develop_backend_start . ' ~ ' . $schedule_develop_backend_end; ?></span>
            </div>
          </div>
          <div class="cd-timeline__block js-cd-block <?php process_period_checker($schedule_test_inside_start, $schedule_test_inside_end); ?>">
            <div class="cd-timeline__img js-cd-img bg-danger">
              <span class="process-icon fas fa-laptop"></span>
            </div>
            <div class="cd-timeline__content js-cd-content">
              <h3>내부테스트</h3>
              <p>자체 테스트 중이에요. 이후에 고객 테스트가 진행돼요.</p>
              <a href="javascript:alert('개발 중입니다...');" class="btn btn-light btn-sm">문의하기</a>
              <span class="cd-timeline__date"><?php echo $schedule_test_inside_start . ' ~ ' . $schedule_test_inside_end; ?></span>
            </div>
          </div>
          <div class="cd-timeline__block js-cd-block <?php process_period_checker($schedule_test_outside_start, $schedule_test_outside_end); ?>">
            <div class="cd-timeline__img js-cd-img bg-test">
              <span class="process-icon fas fa-desktop"></span>
            </div>
            <div class="cd-timeline__content js-cd-content">
              <h3>외부테스트</h3>
              <p>고객 테스트 중이에요. 계약된 개발 사항을 확인해요.</p>
              <a href="javascript:alert('개발 중입니다...');" class="btn btn-light btn-sm">문의하기</a>
              <span class="cd-timeline__date"><?php echo $schedule_test_outside_start . ' ~ ' . $schedule_test_outside_end; ?></span>
            </div>
          </div>
          <div class="cd-timeline__block js-cd-block <?php process_open_checker($schedule_open_date); ?>">
            <div class="cd-timeline__img js-cd-img bg-info">
              <span class="process-icon fas fa-box-open"></span>
            </div>
            <div class="cd-timeline__content js-cd-content">
              <h3><?php echo $schedule_open_title; ?></h3>
              <p>사이트를 <?php echo $schedule_open_title; ?>했어요.</p>
              <span class="cd-timeline__date"><?php echo $schedule_open_date; ?></span>
            </div>
          </div>
        </div>
      </section>
      <!-- //timeline -->

    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>

  <?php get_template_part('templates/content', 'prevnext'); ?>

</div>

<?php get_footer(); ?>