@extends('common.layout')

@section('title', 'ユーザ作成')

@section('nav')

@include('common.nav')

@endsection

@section('content')

  <div class="container user-create">
    <div class="row">
      <h3>ユーザーを作成してください。</h3>
    </div>
    {!! Form::open(['url' => 'user/create/confirm', 'method' => 'POST']) !!}
    <div class="inner-form row">
      {!! Form::label('name', 'ユーザー名') !!}
      {!! Form::text('user_name', '', ['class' => 'form-control', 'placeholder' => '東京　太郎']) !!}
      @if ($errors->has('user_name'))
      <p class="text-danger">{{ $errors->first('user_name') }}</p>
      @endif
      {!! Form::label('name', 'パスワード') !!}
      {!! Form::password('password', ['class' => 'form-control']) !!}
      @if ($errors->has('password'))
      <p class="text-danger">{{ $errors->first('password') }}</p>
      @endif
      {!! Form::label('name', 'パスワード確認') !!}
      {!! Form::password('password_confirm', ['class' => 'form-control']) !!}
      @if ($errors->has('password_confirm'))
      <p class="text-danger">{{ $errors->first('password_confirm') }}</p>
      @endif
      {!! Form::label('name', 'メールアドレス') !!}
      {!! Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'aasaaasa@google.com']) !!}
      @if ($errors->has('email'))
      <p class="text-danger">{{ $errors->first('email') }}</p>
      @endif
      <button class="btn btn-wide btn-primary mrm mt-4">確 認</button>
    </div>
    {!! Form::close() !!}
  </div>

@endsection

@section('append_css')

@endsection

@section('append_js')

@endsection

@section('append_lower_js')

<script src="/flatui/docs/assets/js/application.js"></script>

@endsection
