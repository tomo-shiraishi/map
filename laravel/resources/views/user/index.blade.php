@extends('common.layout')

@section('title', 'プロフィール')

@section('nav')

@include('common.nav')

@endsection

@section('content')

<div class="container user-create">
  <div class="row">
    <h3>ユーザーを作成してください。</h3>
  </div>
  <div class="inner-form row">
    <label>ユーザ名</label>
    <input type="text" class="form-control" placeholder="xxxx xxxx" readonly />
    <label>メールアドレス</label>
    <input type="email" class="form-control" placeholder="" readonly />
    <button class="btn btn-wide btn-primary mrm mt-4">編集する</button>
  </div>
</div>

@endsection

@section('append_css')

@endsection

@section('append_js')

@endsection

@section('append_lower_js')

<script src="/flatui/docs/assets/js/application.js"></script>

@endsection
