@extends('common.layout')

@section('title', 'マップ')

@section('nav')

@include('common.nav')

@endsection

@section('content')

    <div class="form restaurant">
      {!! Form::open(['url' => 'restaurants/add/confirm', 'method' => 'POST']) !!}
        <dl>
          <dt>{!! Form::label('name', '店名', ['class' => 'required']) !!}</dt>
          <dd class="form-restaurant-name">{!! Form::text('restaurant', '', ['placeholder' => '松屋']) !!}</dd>
        @if ($errors->has('restaurant'))
          <dd class="text-danger"><p class="text-danger">{{ $errors->first('restaurant') }}</p></dd>
        @endif
        </dl>
        <dl>
          <dt>{!! Form::label('name', '住所', ['class' => 'required']) !!}</dt>
          <dd class="form-restaurant-address">{!! Form::text('address', '', ['placeholder' => '東京都千代田区xxx-xxxx']) !!}</dd>
        @if ($errors->has('address'))
          <dd class="text-danger"><p>{{ $errors->first('address') }}</p></dd>
        @endif
        </dl>
        <dl>
          <dt>{!! Form::label('name', '料金') !!}</dt>
          <dd class="form-restaurant-price">{!! Form::text('price', '', ['placeholder' => '900']) !!}<span class="unit">円</span></dd>
        @if ($errors->has('price'))
          <dd class="text-danger"><p>{{ $errors->first('price') }}</p></dd>
        @endif
        </dl>
        <dl>
          <dt>{!! Form::label('name', '営業時間') !!}</dt>
          <dd class="form-restaurant-time">{!! Form::select('open_time_h', Config::get('selecthour'), Input::old('open_time_h')) !!}：{!! Form::select('open_time_m', Config::get('selectminutes'), Input::old('open_time_m')) !!} ~ {!! Form::select('close_time_h', Config::get('selecthour'), Input::old('close_time_h')) !!}：{!! Form::select('close_time_m', Config::get('selectminutes'), Input::old('close_time_m')) !!}</dd>
        @if ($errors->has('open_time_h'))
          <dd class="text-danger"><p>{{ $errors->first('open_time_h') }}</p></dd>
        @endif
        @if ($errors->has('close_time_h'))
          <dd class="text-danger"><p>{{ $errors->first('close_time_h') }}</p></dd>
        @endif
        @if ($errors->has('open_close_time'))
          <dd class="text-danger"><p>{{ $errors->first('open_close_time') }}</p></dd>
        @endif
        @if ($errors->has('open_lo_time'))
          <dd class="text-danger"><p>{{ $errors->first('open_lo_time') }}</p></dd>
        @endif
        @if ($errors->has('close_lo_time'))
          <dd class="text-danger"><p>{{ $errors->first('close_lo_time') }}</p></dd>
        @endif
        </dl>
        <dl>
          <dt>{!! Form::label('name', 'ラストオーダー') !!}</dt>
          <dd class="form-restaurant-lo">{!! Form::select('last_order_h', Config::get('selecthour'), Input::old('last_order_h')) !!}：{!! Form::select('last_order_m', Config::get('selectminutes'), Input::old('last_order_m')) !!}</dd>
        @if ($errors->has('last_order_h'))
          <dd class="text-danger"><p>{{ $errors->first('open_time') }}</p></dd>
        @endif
        </dl>
        <dl>
          <dt>{!! Form::label('name', 'カテゴリ', ['class' => 'required']) !!}</dt>
          <dd class="form-restaurant-category">{!! Form::select('category_id', $categories, Input::old('category_id')) !!}</dd>
        </dl>
        <dl>
          <dt>{!! Form::label('name', '備考') !!}</dt>
          <dd class="form-restaurant-remarks">{!! Form::textarea('remarks', '', ['placeholder' => '備考です']) !!}
        @if ($errors->has('restaurant'))
        <p class="text-danger">{{ $errors->first('remarks') }}</p>
        @endif
        <div class="btn-area">
          <button type="button" onclick="history.back()" class="btn back">戻 る</button>
          <button class="btn submit">追加する</button>
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
