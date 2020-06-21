<?php get_header(); ?>

<div class="sub__top">
  <h2 class="sub__title"><?php the_title(); ?></h2>
  <?php get_template_part('templates/content', 'breadcrumb'); ?>
</div>

<?php
// get field
$location_set = get_field('location_set', 'option');
$location_kakao = get_field('location_kakao', 'option');
$location_marker = get_field('location_marker', 'option');
$location_address = get_field('location_address', 'option');
$location_info = get_field('location_info', 'option');
?>

<?php if ($location_set) : ?>
  <section class="section location">

    <h3 class="sr-only">지도</h3>

    <!--map-->
    <div class="location__map" id="map"></div>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?php echo $location_kakao['api']; ?>&libraries=services"></script>
    <script>
      var mapContainer = document.getElementById('map'),
        mapOption = {
          center: new kakao.maps.LatLng(33.450701, 126.570667),
          level: 3
        };
      var map = new kakao.maps.Map(mapContainer, mapOption);
      var geocoder = new kakao.maps.services.Geocoder();

      geocoder.addressSearch('<?php echo $location_address['address']; ?>', function(result, status) {
        if (status === kakao.maps.services.Status.OK) {

          // 위치
          var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

          // 마커
          var marker = new kakao.maps.Marker({
            map: map,
            position: coords,
          });

          // 인포윈도우
          var infowindow = new kakao.maps.InfoWindow({
            zIndex: 1
          });
          infowindow.setContent('<div style="width:150px;padding:5px;font-size:12px;color:#111;font-weight:bold;text-align:center;"><a href="//map.kakao.com/?q=<?php echo $location_address['address']; ?>" target="_blank"><?php echo $location_kakao['marker']; ?></a></div>');
          infowindow.open(map, marker);

          // 지도 가운데로
          map.setCenter(coords);
        }
      });
    </script>
    <!--//map-->

  </section>
<?php endif; ?>

<section class="section location">

  <h3 class="sr-only">안내</h3>

  <ul class="list-table">
    <li class="table-item">
      <div class="left">
        <h4 class="h4"><?php echo $location_address['title']; ?></h4>
      </div>
      <div class="right">
        <h5 class="h5_left"><?php echo $location_address['address']; ?></h5>
      </div>
    </li>
    <?php
    if ($location_info) {
      foreach ($location_info as $row) {
        $location_content = $row['content'];
        echo '<li class="table-item">';
        echo '<div class="left"><h4 class="h4">' . $row['section'] . '</h4></div>';
        echo '<div class="right">';
        echo '<dl>';
        if ($location_content) {
          foreach ($location_content as $row) {
            echo '<dt class="h5_left">' . $row['title'] . '</dt>';
            echo '<dd class="desc">' . $row['text'] . '</dd>';
          }
        }
        echo '</dl>';
        echo '</div>';
        echo '</li>';
      }
    }
    ?>
  </ul>

</section>

<?php get_footer(); ?>