@extends('common.layout')

@section('title', 'マップ')

@section('nav')

@include('common.nav')

@endsection

@section('content')

    <div class="form restaurant">
      {!! Form::open(['url' => 'restaurants/edit/complete', 'method' => 'POST']) !!}
        {!!  Form::hidden('id', $input_data['id']) !!}
        {!!  Form::hidden('restaurant', $input_data['restaurant']) !!}
        {!!  Form::hidden('address', $input_data['address']) !!}
        {!!  Form::hidden('price', $input_data['price']) !!}
        {!!  Form::hidden('open_time_h', $input_data['open_time_h']) !!}
        {!!  Form::hidden('open_time_m', $input_data['open_time_m']) !!}
        {!!  Form::hidden('close_time_h', $input_data['close_time_h']) !!}
        {!!  Form::hidden('close_time_m', $input_data['close_time_m']) !!}
        {!!  Form::hidden('last_order_h', $input_data['last_order_h']) !!}
        {!!  Form::hidden('last_order_m', $input_data['last_order_m']) !!}
        {!!  Form::hidden('category_id', $input_data['category_id']) !!}
        {!!  Form::hidden('remarks', $input_data['remarks']) !!}

        <dl>
          <dd>{!! Form::label('name', '店名') !!}</dd>
          <dd class="form-restaurant-name"><p>{{ $input_data['restaurant'] }}</p></dd>
        </dl>
        <dl>
          <dd>{!! Form::label('name', '住所') !!}</dd>
          <dd class="form-restaurant-address"><p>{{ $input_data['address'] }}</p></dd>
        </dl>
        <dl>
          <dd>{!! Form::label('name', '料金') !!}</dd>
          <dd class="form-restaurant-price"><p>{{ $input_data['price'] }}</p></dd>
        </dl>
        <dl>
          <dd>{!! Form::label('name', '営業時間') !!}</dd>
          <dd class="form-restaurant-time"><p>{{ $input_data['open_time_h'] }}:{{ $input_data['open_time_m'] }} ~ {{ $input_data['close_time_h'] }}:{{ $input_data['close_time_m'] }}</p></dd>
        </dl>
        <dl>
          <dd>{!! Form::label('name', 'ラストオーダー') !!}</dd>
          <dd class="form-restaurant-lo"><p>{{ $input_data['last_order_h'] }}:{{ $input_data['last_order_m'] }}</p></dd>
        </dl>
        <dl>
          <dd>{!! Form::label('name', 'カテゴリ') !!}</dd>
          <dd class="form-restaurant-category"><p>{{ $category->name }}</p></dd>
        </dl>
        <dl>
          <dd>{!! Form::label('name', '備考') !!}</dd>
          <dd class="form-restaurant-remarks"><p>{{ $input_data['remarks'] }}</p></dd>
        </dl>
        <div class="btn-area">
          <button type="button" onclick="history.back()" class="btn back">戻 る</button>
          <button class="btn submit">編集する</button>
        </div>
      {!! Form::close() !!}
    </div>

@endsection

@section('append_css')

@endsection

@section('append_js')

@endsection

@section('append_lower_js')

@endsection
