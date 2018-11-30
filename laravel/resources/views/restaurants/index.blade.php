@extends('common.layout')

@section('title', 'お店一覧')

@section('nav')

@include('common.nav')

@endsection

@section('content')

@if (session()->has('message'))
  <p class="message">{{ session('message') }}</p>
@endif

    <div class="controls">
      <button type="button" class="control" data-filter="all">All</button>
      <button type="button" class="control" data-filter=".open">Open</button>
      <button type="button" class="control" data-filter=".closed">Closed</button>
      @foreach ($categories as $category)
      <button type="button" class="control" data-filter=".category{{ $category->id }}">{{ $category->name }}</button>
      @endforeach

      {{--<button type="button" class="control" data-sort="default:asc">Asc</button>
      <button type="button" class="control" data-sort="default:desc">Desc</button>--}}
    </div>
    <div class="container">
      @foreach ($restaurants as $restaurant)
      <div class="mix category{{ $restaurant->category->id }} @if (is_null($restaurant->second_close_time))
            @if (((!is_null($restaurant->open_time)) && date('H:i') < date('H:i', strtotime($restaurant->open_time))) || ((!is_null($restaurant->close_time)) && date('H:i', strtotime($restaurant->close_time)) < date('H:i'))) closed @else open @endif
          @else
            @if (date('H:i', strtotime($restaurant->second_close_time)) < date('H:i') && date('H:i') < date('H:i', strtotime($restaurant->open_time))) closed @else open @endif
          @endif">
        <a href="/restaurants/detail?id={{ $restaurant->id }}"><p></p></a>
        <div class="restaurant">
          <div class="restaurant-name"><p class="restaurant-name">{{ $restaurant->name }}</p></div>
          <div class="restaurant-info">
            <section class="time">
              @if (!is_null($restaurant->open_time) || !is_null($restaurant->close_time) || !is_null($restaurant->second_close_time))
              <p>@if (!is_null($restaurant->open_time)) {{ date('H:i', strtotime($restaurant->open_time)) }} @endif ~ @if (!is_null($restaurant->second_close_time)) {{ date('H:i', strtotime($restaurant->second_close_time)) }} @elseif (!is_null($restaurant->close_time)) {{ date('H:i', strtotime($restaurant->close_time)) }}  @endif</p>
              @endif
              @if (!is_null($restaurant->lo_time))
              <p>LO {{ date('H:i', strtotime($restaurant->lo_time)) }}</p>
              @endif
            </section>
            @if (!is_null($restaurant->price))
            <section class="price">
              <p>¥{{ $restaurant->price }}</p>
            </section>
            @endif
          </div>
          <div class="tag">{{ $restaurant->category->name }}</div>
        </div>
      </div>
      @endforeach

      <div class="gap"></div>
      <div class="gap"></div>
      <div class="gap"></div>
    </div>

@endsection

@section('append_css')
  <style type="text/css">
@foreach ($categories as $category)
  .control[data-filter=".category{{ $category->id }}"] {
      color: {{ $category->color }};
  }
  .mix.category{{ $category->id }} {
    border-top: .5rem solid {{ $category->color }};
  }
  .mix.category{{ $category->id }} > .restaurant > .tag {
    background-color: {{ $category->color }};
  }
@endforeach
  </style>
@endsection

@section('append_js')

@endsection

@section('append_lower_js')

    <script src="/js/mixitup.min.js"></script>
    <script>
        var containerEl = document.querySelector('.container');

        var mixer = mixitup(containerEl);
    </script>
@endsection
