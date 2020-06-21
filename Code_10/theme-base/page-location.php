<?php get_header(); ?>

<h1><?php the_title(); ?></h1>

<?php get_template_part('templates/content', 'breadcrumb'); ?>

<!--map-->
<div id="map" style="height:500px"></div>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=ba832b22a933254bb46c5b0cc3734978&libraries=services"></script>
<script>
  var mapContainer = document.getElementById('map'),
    mapOption = {
      center: new kakao.maps.LatLng(33.450701, 126.570667),
      level: 3
    };
  var map = new kakao.maps.Map(mapContainer, mapOption);
  var geocoder = new kakao.maps.services.Geocoder();

  geocoder.addressSearch('서울 성동구 왕십리로2길 20 카우앤독 4층', function(result, status) {
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
      infowindow.setContent('<div style="width:150px;padding:5px;font-size:12px;color:#333;font-weight:bold;text-align:center;"><a href="//map.kakao.com/?q=서울 성동구 왕십리로2길 20 카우앤독 4층" target="_blank"><?php echo esc_html(get_bloginfo('description')); ?></a></div>');
      infowindow.open(map, marker);

      // 지도 가운데로
      map.setCenter(coords);
    }
  });
</script>
<!--//map-->

<?php get_footer(); ?>