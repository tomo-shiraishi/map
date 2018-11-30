@extends('common.layout')

@section('title', 'カテゴリ確認')

@section('nav')

@include('common.nav')

@endsection

@section('content')

    <div class="form category">
      {!! Form::open(['url' => 'category/add/complete', 'method' => 'POST']) !!}
        {!!  Form::hidden('category', $category) !!}
        {!!  Form::hidden('color', $color) !!}
        {!! Form::label('name', 'カテゴリ名', ['class' => 'required']) !!}
        <p>{{ $category }}</p>
        {!! Form::label('name', 'カラーコード', ['class' => 'required']) !!}
        <p style="background:{{ $color }}; height:50px;"></p>
        <div class="btn-area">
          <button type="button" onclick="history.back()" class="btn back">戻 る</button>
          <button type="submit" class="btn submit">登録する</button>
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
