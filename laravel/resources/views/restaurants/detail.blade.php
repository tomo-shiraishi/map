@extends('common.layout')

@section('title', 'マップ')

@section('nav')

@include('common.nav')

@endsection

@section('content')
    <div class="detail">
      <section class="info">
        <div class="name_category">
          <h3>{{ $restaurant->name }}</h3>
          <div class="tag category{{ $restaurant->category->id }}">{{ $restaurant->category->name }}</div>
        </div>
        <div class="distance">
        </div>
        @if (is_null($restaurant->second_close_time))
          @if (((!is_null($restaurant->open_time)) && date('H:i') < date('H:i', strtotime($restaurant->open_time))) || ((!is_null($restaurant->close_time)) && date('H:i', strtotime($restaurant->close_time)) < date('H:i')))
        <div class="alert">
          <p>営業時間外の可能性があります</p>
        </div>
          @endif
        @else
          @if (date('H:i', strtotime($restaurant->second_close_time)) < date('H:i') && date('H:i') < date('H:i', strtotime($restaurant->open_time)))
          <div class="alert">
            <p>営業時間外の可能性があります</p>
          </div>
          @endif
        @endif
        <div class="time">
          <h4>営業時間</h4>
          @if (!is_null($restaurant->open_time) || !is_null($restaurant->close_time) || !is_null($restaurant->second_close_time))
          <p>@if (!is_null($restaurant->open_time)) {{ date('H:i', strtotime($restaurant->open_time)) }} @endif ~ @if (!is_null($restaurant->second_close_time)) {{ date('H:i', strtotime($restaurant->second_close_time)) }} @elseif (!is_null($restaurant->close_time)) {{ date('H:i', strtotime($restaurant->close_time)) }}  @endif</p>
          @endif
          @if (!is_null($restaurant->lo_time))
          <p>LO {{ date('H:i', strtotime($restaurant->lo_time)) }}</p>
          @endif
        </div>
        <div class="remarks">
          <h4>備考</h4>
          <p>{{ $restaurant->remarks }}</p>
        </div>
        {!! Form::open(['url' => 'restaurants/delete', 'method' => 'POST']) !!}
          {!!  Form::hidden('id', $restaurant->id) !!}
          <div class="btn-area">
            <button type="button" class="btn edit" onclick="location.href='/restaurants/edit?id={{ $restaurant->id }}'">編集する</button>
            <button type="submit" class="btn delete" onclick="return confirm('削除を行うと戻すことはできません。よろしいですか？')">削除する</button>
          </div>
        {!! Form::close() !!}
      </section>
      <section id="map" style="height:500px;"></section>
    </div>

@endsection

@section('append_css')
  <style type="text/css">
  .category{{ $restaurant->category->id }}.tag {
    background-color: {{ $restaurant->category->color }};
  }
  </style>
@endsection

@section('append_js')

  <script src="https://maps.googleapis.com/maps/api/js?key={{ Config::get('googleapikey') }}"></script>

@endsection

@section('append_lower_js')

  <script type="text/javascript">
    $(function() {
      var from = new google.maps.LatLng({{ $company->lat }}, {{ $company->lng }});
      var to = new google.maps.LatLng({{ $restaurant->lat }}, {{ $restaurant->lng }});
      var map;
      var rendererOptions = {
        // suppressMarkers: true,
        polylineOptions: {
          strokeColor:"#48c9b0",
          strokeWeight:5
        }
      };
      var directionsService = new google.maps.DirectionsService();
      var directionsRenderer = new google.maps.DirectionsRenderer(rendererOptions);

      // 地図を表示
      map = new google.maps.Map(document.getElementById("map"));

      // var fromMarker = new google.maps.Marker({
      //   position : from,
      //   map: map//,
      //   // icon: '/assets/img/googlemap/company_icon.png'
      // });
      //
      // var fromMarker = new google.maps.Marker({
      //   position : to,
      //   map: map//,
      //   // icon: '/assets/img/googlemap/restaurant_icon.png'
      // });

      // ルートを取得
      var request = {
        origin: from,        // 出発地点の緯度、経度
        destination: to,   // 到着地点の緯度、経度
        travelMode: google.maps.DirectionsTravelMode.WALKING, // ルートの種類
      };
      directionsService.route(request, function(result, status) {
        $('.distance').html('<p>'+result['routes'][0]['legs'][0]['distance']['value']+'m、約'+result['routes'][0]['legs'][0]['duration']['text']+'で到着します');
        directionsRenderer.setDirections(result); // 取得したルートをセット
        directionsRenderer.setMap(map); // ルートを地図に表示
      });
    });
  </script>

@endsection
