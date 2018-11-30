@extends('common.layout')

@section('title', 'カテゴリ詳細')

@section('nav')

@include('common.nav')

@endsection

@section('content')

    <div class="form category">
      {!! Form::open(['url' => 'category/delete', 'method' => 'POST']) !!}
        {!!  Form::hidden('id', $category->id) !!}
        {!! Form::label('name', 'カテゴリ名') !!}
        <p>{{ $category->name }}</p>
        {!! Form::label('name', 'カラーコード') !!}
        <p style="background:{{ $category->color }}; height:50px;"></p>
        <div class="btn-area">
          <button type="button" onclick="history.back()" class="btn back">戻 る</button>
          <button type="submit" name="edit" data-action="edit" class="submit btn submit-btn">編集する</button>
          <button type="submit" name="delete"　data-action="delete" class="btn delete submit-btn" onclick="return confirm('削除を行うと戻すことはできません。よろしいですか？')">削除する</button>
        </div>
      {!! Form::close() !!}
    </div>

@endsection

@section('append_css')

@endsection

@section('append_js')

@endsection

@section('append_lower_js')
<script>
  $('.submit-btn').click(function() {
    $(this).parents().parents('form').attr('action', $(this).data('action'));
    $(this).parents().parents('form').submit();
  });
</script>

@endsection
