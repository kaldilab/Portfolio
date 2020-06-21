<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$post_kakaomap = array(
  'post_type' => 'kakaomap',
  'posts_per_page' => 3,
  'paged' => $paged,
);
isset($g) ? $g = $g : $g = null;
isset($_GET['t']) ? $t = $_tET['t'] : $t = null;
if ($g != '서울시 전체') {
  $post_kakaomap['meta_key'] = 'kakaomap_gu';
  $post_kakaomap['meta_value'] = $g;
}
if (!empty($_GET['q'])) {
  $q = $_GET['q'];
  $post_kakaomap['s'] = $_GET['q'];
} else {
  $q = null;
}
$query_kakaomap = new WP_Query($post_kakaomap);
$count_kakaomap = $query_kakaomap->found_posts;
?>

<style>
  .kakaomap_overlay {
    background-color: white;
  }
</style>

<!-- 검색 -->
<div>
  <form role="search" action=<?php echo project_permalink(); ?>>
    <input type="hidden" name="t" value="<?php echo !($t == 'list') ? 'map' : 'list'; ?>">
    <select class="homeTown__search--select" name="g">
      <option <?php echo (!isset($g)) ? 'selected' : ''; ?>>서울시 전체</option>
      <!-- 25개 자치구 -->
      <option value="강남구" <?php echo ($g == '강남구') ? 'selected' : ''; ?>>강남구</option>
      <option value="강동구" <?php echo ($g == '강동구') ? 'selected' : ''; ?>>강동구</option>
      <option value="강북구" <?php echo ($g == '강북구') ? 'selected' : ''; ?>>강북구</option>
      <option value="강서구" <?php echo ($g == '강서구') ? 'selected' : ''; ?>>강서구</option>
      <option value="관악구" <?php echo ($g == '관악구') ? 'selected' : ''; ?>>관악구</option>
      <option value="광진구" <?php echo ($g == '광진구') ? 'selected' : ''; ?>>광진구</option>
      <option value="구로구" <?php echo ($g == '구로구') ? 'selected' : ''; ?>>구로구</option>
      <option value="금천구" <?php echo ($g == '금천구') ? 'selected' : ''; ?>>금천구</option>
      <option value="노원구" <?php echo ($g == '노원구') ? 'selected' : ''; ?>>노원구</option>
      <option value="도봉구" <?php echo ($g == '도봉구') ? 'selected' : ''; ?>>도봉구</option>
      <option value="동대문구" <?php echo ($g == '동대문구') ? 'selected' : ''; ?>>동대문구</option>
      <option value="동작구" <?php echo ($g == '동작구') ? 'selected' : ''; ?>>동작구</option>
      <option value="마포구" <?php echo ($g == '마포구') ? 'selected' : ''; ?>>마포구</option>
      <option value="서대문구" <?php echo ($g == '서대문구') ? 'selected' : ''; ?>>서대문구</option>
      <option value="서초구" <?php echo ($g == '서초구') ? 'selected' : ''; ?>>서초구</option>
      <option value="성동구" <?php echo ($g == '성동구') ? 'selected' : ''; ?>>성동구</option>
      <option value="성북구" <?php echo ($g == '성북구') ? 'selected' : ''; ?>>성북구</option>
      <option value="송파구" <?php echo ($g == '송파구') ? 'selected' : ''; ?>>송파구</option>
      <option value="양천구" <?php echo ($g == '양천구') ? 'selected' : ''; ?>>양천구</option>
      <option value="영등포구" <?php echo ($g == '영등포구') ? 'selected' : ''; ?>>영등포구</option>
      <option value="용산구" <?php echo ($g == '용산구') ? 'selected' : ''; ?>>용산구</option>
      <option value="은평구" <?php echo ($g == '은평구') ? 'selected' : ''; ?>>은평구</option>
      <option value="종로구" <?php echo ($g == '종로구') ? 'selected' : ''; ?>>종로구</option>
      <option value="중구" <?php echo ($g == '중구') ? 'selected' : ''; ?>>중구</option>
      <option value="중랑구" <?php echo ($g == '중랑구') ? 'selected' : ''; ?>>중랑구</option>
    </select>
    <input type="search" placeholder="<?php echo esc_attr_x('검색어를 입력하세요', 'placeholder'); ?>" value="<?php echo $q; ?>" name="q" title="<?php echo esc_attr_x('검색어 입력', 'label'); ?>">
    <input type="submit" value="<?php echo esc_attr_x('검색', 'submit button'); ?>">
  </form>
</div>

<!--map -->
<div id="map" style="height:600px;">
  <?php
  if ($count_kakaomap == '0') {
    echo '<div class="map_none" style="display:flex; justify-content:center; align-items:center; position: absolute; top: 0; left: 0; width: 100%;height:100%;background: rgba(255,255,255,.9);border: 1px solid #eee;font-size: 16px;letter-spacing: -0.14px;color: #6e7175;font-weight: 300;text-align:center;z-index: 9;">검색 결과가 없습니다.</div>';
  }
  ?>
</div>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=****&libraries=services,clusterer"></script>
<script>
  <?php
  // array kakaomap
  $result_kakaomap = array();

  if ($query_kakaomap->have_posts()) {
    while ($query_kakaomap->have_posts()) {
      $query_kakaomap->the_post();
      $title = get_the_title();
      $content = get_the_content();
      $address = get_field('kakaomap_address');

      // array marker
      $array_marker = array(
        'title' => $title,
        'content' => $content,
        'address' => $address,
      );

      array_push($result_kakaomap, $array_marker);
    }
  }

  // json kakaomap
  $json_kakaomap = json_encode($result_kakaomap);
  ?>

  // 지도
  var mapContainer = document.getElementById('map'),
    mapOption = {
      center: new kakao.maps.LatLng(33.450701, 126.570667),
      level: 8
    };
  var map = new kakao.maps.Map(mapContainer, mapOption);
  var geocoder = new kakao.maps.services.Geocoder();

  <?php if ($query_kakaomap->have_posts()) : ?>
    // 검색 결과 있을 때
    // 마커 토글
    var selectedMarker = null;

    // 포스트 데이터
    var kakaomapData = <?php echo $json_kakaomap; ?>;

    // 클러스터 배열 생성
    var arrayClusterer = new Array();

    kakaomapData.forEach(function(data) {
      geocoder.addressSearch(data.address, function(result, status) {
        // 주소->좌표 변환
        if (status === kakao.maps.services.Status.OK) {
          var coords = new kakao.maps.LatLng(result[0].y, result[0].x);
        }

        // 마커
        var normalImageSrc = '<?php echo get_template_directory_uri(); ?>/images/ico_marker_off.svg',
          normalImageSize = new kakao.maps.Size(23, 34),
          normalImageOption = {
            offset: new kakao.maps.Point(12, 34)
          };
        var normalImage = new kakao.maps.MarkerImage(normalImageSrc, normalImageSize, normalImageOption);
        var clickImageSrc = '<?php echo get_template_directory_uri(); ?>/images/ico_marker_on.svg',
          clickImageSize = new kakao.maps.Size(23, 34),
          clickImageOption = {
            offset: new kakao.maps.Point(12, 34)
          };
        var clickImage = new kakao.maps.MarkerImage(clickImageSrc, clickImageSize, clickImageOption);
        var marker = new kakao.maps.Marker({
          map: map,
          position: coords,
          image: normalImage,
          clickable: true,
        });
        marker.normalImage = normalImage;

        // 마커를 클러스터러 배열로
        arrayClusterer.push(marker);

        // 오버레이
        var overlay = new kakao.maps.CustomOverlay({
          content: content,
          map: map,
          position: marker.getPosition(),
          xAnchor: 0,
          yAnchor: 1,
        });
        var content = document.createElement('div');
        content.className = 'kakaomap_overlay';
        content.innerHTML = '<div class="tit">' + data.title + '</div>' +
          '<div class="desc">' + data.content + '</div>' +
          '<div class="address">' + data.address + '</div>';
        var closeOverlay = document.createElement('button');
        closeOverlay.innerHTML = '닫기';
        closeOverlay.onclick = function() {
          overlay.setMap(null);
          marker.setImage(normalImage);
        };
        content.insertBefore(closeOverlay, content.firstChild);
        overlay.setContent(content);
        overlay.setMap(null);

        // 마커/오버레이 클릭 이벤트
        kakao.maps.event.addListener(marker, 'click', function() {
          marker.setImage(clickImage);
          selectedMarker = marker;
          overlay.setMap(map);
        });

        // 지도 가운데로
        map.setCenter(coords);
      });
    });

    // 클러스터러
    var clusterer = new kakao.maps.MarkerClusterer({
      map: map,
      markers: arrayClusterer,
      gridSize: 150,
      averageCenter: true,
      minLevel: 2,
      disableClickZoom: true,
      styles: [{
        width: '120px',
        height: '120px',
        background: 'rgba(27,191,131,.7)',
        color: '#fff',
        fontSize: '32px',
        fontWeight: '100',
        textAlign: 'center',
        lineHeight: '120px',
        borderRadius: '50%',
      }]
    });

    // 클러스터러 마커 생성
    clusterer.addMarkers(arrayClusterer);

    // 클러스터러 클릭 이벤트
    kakao.maps.event.addListener(clusterer, 'clusterclick', function(cluster) {
      var level = map.getLevel() - 1;
      map.setLevel(level, {
        anchor: cluster.getCenter()
      });
    });
  <?php else : ?>
    // 검색 결과 없을 때
    geocoder.addressSearch('서울 용산구 용산동2가 산 1-3', function(result, status) {
      // 주소->좌표 변환
      if (status === kakao.maps.services.Status.OK) {
        var coords = new kakao.maps.LatLng(result[0].y, result[0].x);
      }

      // 마커
      var marker = new kakao.maps.Marker({
        map: map,
        position: coords,
      });

      // 인포윈도우
      var infowindow = new kakao.maps.InfoWindow({
        zIndex: 1
      });
      infowindow.setContent('<div style="padding:5px;font-size:12px;color:#333;font-weight:bold;"><?php echo esc_html(get_bloginfo('name')); ?></div>');
      infowindow.open(map, marker);

      // 지도 가운데로
      map.setCenter(coords);
      console.log(coords);
    });
  <?php endif; ?>
</script>
<!--//map -->

<!--list-->
<div>전체 <span><?php echo $count_kakaomap; ?></span>개의 검색 결과</div>
<table class="table">
  <thead>
    <tr>
      <th>단체명</th>
      <th>단체소개</th>
      <th>주소</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($query_kakaomap->have_posts()) {
      while ($query_kakaomap->have_posts()) {
        $query_kakaomap->the_post();
        $kakaomap_url = get_field('kakaomap_url');
        echo '<tr>';
        echo '<td>' . get_the_title() . '</td>';
        echo '<td>' . get_the_content() . '</td>';
        echo '<td>' . get_field('kakaomap_address') . '</td>';
        echo '</tr>';
      }
    } else {
      echo '<tr>';
      echo '<td colspan="3" class="none">검색 결과가 없습니다.</td>';
      echo '</tr>';
    }
    wp_reset_postdata();
    ?>
  </tbody>
</table>

<div>
  <?php
  $pagenavi = array(
    'total' => $query_kakaomap->max_num_pages,
    'prev_text' => '이전',
    'next_text' => '다음',
  );
  echo paginate_links($pagenavi);
  ?>
</div>
<!--//list-->

<?php get_footer(); ?>