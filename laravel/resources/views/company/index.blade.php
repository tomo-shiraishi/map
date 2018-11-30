@extends('common.layout')

@section('title', 'セットアップ')

@section('nav')

@include('common.nav')

@endsection

@section('content')

@if (session()->has('message'))
    <p class="message">{{ session('message') }}</p>
@endif

    <div class="form company">
      {!! Form::open(['url' => 'company/edit', 'method' => 'POST']) !!}
        <dl>
          <dd>{!! Form::label('name', '拠点名') !!}</dd>
          <dd class="form=company-name"><p>{{ $company->name }}</p></dd>
        </dl>
        <dl>
          <dd>{!! Form::label('name', '住所') !!}</dd>
          <dd class="form-category-address"><p>{{ $company->address }}</p></dd>
        </dl>
        <div class="btn-area">
          <button type="button" onclick="history.back()" class="btn back">戻 る</button>
          <button type="submit" class="btn submit">編集する</button>
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
