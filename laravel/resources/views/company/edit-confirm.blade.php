@extends('common.layout')

@section('title', 'セットアップ')

@section('nav')

@include('common.nav')

@endsection

@section('content')

    <div class="form company">
      {!! Form::open(['url' => 'company/edit/complete', 'method' => 'POST']) !!}
        {!!  Form::hidden('id', $id) !!}
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
          <button class="btn submit">更新する</button>
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
