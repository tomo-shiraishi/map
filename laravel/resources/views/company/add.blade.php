@extends('common.layout')

@section('title', 'セットアップ')

@section('content')

    <div class="form company">
      <h1>拠点となる住所と名称を入力し、「確認する」を押してください</h1>
      {!! Form::open(['url' => 'company/add/confirm', 'method' => 'POST']) !!}
        <dl>
          <dd>{!! Form::label('name', '拠点名', ['class' => 'required']) !!}<dd>
          <dd class="form-company-name">{!! Form::text('company', '', ['class' => 'form-control', 'placeholder' => '家, ○○株式会社']) !!}</dd>
        @if ($errors->has('company'))
          <dd class="text-danger"><p>{{ $errors->first('company') }}</p></dd>
        @endif
        </dl>
        <dl>
          <dd>{!! Form::label('name', '住所', ['class' => 'required']) !!}</dd>
          <dd class="form-company-address">{!! Form::text('address', '', ['class' => 'form-control', 'placeholder' => '東京都千代田区xxx-xxxx']) !!}</dd>
        </dl>
        @if ($errors->has('address'))
          <dd class="text-danger"><p>{{ $errors->first('address') }}</p></dd>
        @endif
        <div class="btn-area">
        @if (!is_null(App\Models\Company::first()))
          <button type="button" onclick="history.back()" class="btn back">戻 る</button>
        @endif
          <button class="btn submit">確認する</button>
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
