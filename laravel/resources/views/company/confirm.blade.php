@extends('common.layout')

@section('title', 'セットアップ')

@section('content')

    <div class="form company">
      <h1>入力内容を確認し、「登録する」を押してください</h1>
      {!! Form::open(['url' => 'company/add/complete', 'method' => 'POST']) !!}
        {!!  Form::hidden('company', $company) !!}
        {!!  Form::hidden('address', $address) !!}
        <dl>
          <dd>{!! Form::label('name', '会社名', ['class' => 'required']) !!}</dd>
          <dd class="form-company-name"><p>{{ $company }}</p></dd>
        </dl>
        <dl>
          <dd>{!! Form::label('name', '住所', ['class' => 'required']) !!}</dd>
          <dd class="form-company-address"><p>{{ $address }}</p></dd>
        </dl>
        <div class="btn-area">
          <button type="button" onclick="history.back()" class="btn back">戻 る</button>
          <button class="btn submit">登録する</button>
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
