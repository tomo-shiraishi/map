@extends('common.layout')

@section('title', 'カテゴリ一覧')

@section('nav')

@include('common.nav')

@endsection

@section('content')

    <div class="form category">
      {!! Form::open(['url' => 'category/edit/confirm', 'method' => 'POST']) !!}
        {!!  Form::hidden('id', $category->id) !!}
        <dl>
          <dd>{!! Form::label('name', 'カテゴリ名', ['class' => 'required']) !!}</dd>
          <dd class="form-category-name">{!! Form::text('category', $category->name) !!}</dd>
        @if ($errors->has('category'))
          <dd class="text-danger"><p>{{ $errors->first('category') }}</p></dd>
        @endif
        </dl>
        <dl>
          <dd>{!! Form::label('name', 'カラーコード', ['class' => 'required']) !!}</dd>
          <dd class="form-category-color">{!! Form::color('color', $category->color) !!}</dd>
        @if ($errors->has('color'))
          <dd class="text-danger"><p>{{ $errors->first('color') }}</p></dd>
        @endif
        </dl>
        <div class="btn-area">
          <button type="button" onclick="history.back()" class="btn back">戻 る</button>
          <button type="submit" class="btn submit">確認する</button>
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
