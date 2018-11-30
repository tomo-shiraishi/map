@extends('common.layout')

@section('title', 'カテゴリ一覧')

@section('nav')

@include('common.nav')

@endsection

@section('content')

@if (session()->has('message'))
    <p class="message">{{ session('message') }}</p>
@endif

    <div class="categories">
      <ul>
        @foreach ($categories as $category)
        <li class="tag category{{ $category->id }}"><a href="/category/detail?id={{ $category->id }}">{{ $category->name }}</li>
        @endforeach
      </ul>
    </div>

@endsection

@section('append_css')
<style type="text/css">
@foreach ($categories as $category)
.tag.category{{ $category->id }} {
  background-color:{{ $category->color }} !important;
}
@endforeach
</style>
@endsection

@section('append_js')

@endsection

@section('append_lower_js')

@endsection
