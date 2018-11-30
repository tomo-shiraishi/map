@extends('common.layout')

@section('title', 'ユーザ作成確認')

@section('content')

  <div class="container user-create">
    <div class="row">
      <h3>ユーザーを作成してください。</h3>
    </div>
    {!! Form::open(['url' => 'user/create/complete', 'method' => 'POST']) !!}
    <div class="inner-form row">
      {!! Form::label('name', 'ユーザー名') !!}
      <p>{{ $user_name}}</p>
      {!! Form::label('name', 'パスワード') !!}
      {!! Form::text('password', 'aaaaaaaa', ['class' => 'form-control', 'readonly' => 'true']) !!}
      {!! Form::label('name', 'メールアドレス') !!}
      {!! Form::text('email', $email, ['class' => 'form-control', 'readonly' => 'true']) !!}
      <button class="btn btn-wide btn-primary mrm mt-4">完了</button>
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
