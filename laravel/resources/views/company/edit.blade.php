@extends('common.layout')

@section('title', 'セットアップ')

@section('nav')

@include('common.nav')

@endsection

@section('content')

    <div class="form company">
      {!! Form::open(['url' => 'company/edit/confirm', 'method' => 'POST']) !!}
        {!! Form::hidden('id', $company->id) !!}
        <dl>
          <dd>{!! Form::label('name', '会社名', ['class' => 'required']) !!}</dd>
          <dd class="form-company-name">{!! Form::text('company', $company->name, ['class' => 'form-control']) !!}</dd>
        @if ($errors->has('company'))
          <dd class="text-danger"><p>{{ $errors->first('company') }}</p></dd>
        @endif
        </dl>
        <dl>
          <dd>{!! Form::label('name', '住所', ['class' => 'required']) !!}</dd>
          <dd class="form-company-address">{!! Form::text('address', $company->address, ['class' => 'form-control']) !!}</dd>
        @if ($errors->has('address'))
          <dd class="text-danger"><p>{{ $errors->first('address') }}</p></dd>
        @endif
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
