@extends('common.layout')

@section('title', 'マップ')

@section('nav')

@include('common.nav')

@endsection

@section('content')

  <div id="map-canvas"></div>

@endsection

@section('append_css')

@endsection

@section('append_js')

  <!--  Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key={{ Config::get('googleapikey') }}"></script>

@endsection

@section('append_lower_js')
  <!-- SCRIPTS -->
  <script src="/flatui/dist/js/vendor/jquery.min.js"></script>
  <script type="text/javascript">
    var marker = [];
    var infoWindow = [];
    var restaurants = JSON.parse('{!! $restaurants !!}');
    var bounds = new google.maps.LatLngBounds();

    var company_latlng = new google.maps.LatLng({{ $company->lat }}, {{ $company->lng }});
    var map = new google.maps.Map(document.getElementById("map-canvas"));
    function initialize() {
      var companyMarker;

      companyMarker = new google.maps.Marker({
        position : company_latlng,
        map : map,
        icon : '/assets/img/googlemap/home.png'
      });
      bounds.extend(company_latlng);


      // マーカー毎の処理
      for (var i = 0; i < restaurants.length; i++) {
        restaurantLatLng = new google.maps.LatLng({lat: restaurants[i]['lat'], lng: restaurants[i]['lng']}); // 緯度経度のデータ作成
        marker[i] = new google.maps.Marker({ // マーカーの追加
          position: restaurantLatLng, // マーカーを立てる位置を指定
          map: map
        });

        bounds.extend(restaurantLatLng);

        // 吹き出し
        infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
          content: '<div class="sample"><a href="/restaurants/detail?id=' + restaurants[i]['id'] + '">' + restaurants[i]['name'] + '</a></div>'
        });

        // マーカーにマウスオーバーイベントを追加
        markerMouseOver(i);
        // マーカーにクリックイベントを追加
        markerClick(i);
      }

      map.fitBounds(bounds);

    }

    // マウスオーバー時吹き出しを表示
    function markerMouseOver(i) {
      marker[i].addListener('mouseover', function() {
        infoWindow[i].open(map, marker[i]);
      });
    }

    // マーカークリック時
    function markerClick(i) {
      marker[i].addListener('click', function() { // マーカーをクリックしたとき
        window.location.href = '/restaurants/detail?id='+ restaurants[i]['id'];
      });
    }
  </script>
  <script>
    var name = $(".address-line").text();
    console.log(name);
  </script>

@endsection
