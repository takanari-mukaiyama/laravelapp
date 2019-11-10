@extends("layouts.app")

@section("title", "新規登録追加確認")

@section("content")
<div class="container">
  <h1>新規図書追加確認</h1>
  <form action="/book/add/complete" method="post" name="complete">
    @csrf
    <p class="caution">以下の図書を新規登録します</p>
    <table class="card form_table">
      <tr>
        <th class="card-header">タイトル</th>
        <td class="card-body">{{$book_title}}</td>
        <input type="hidden" name="book_title" value="{{$book_title}}">
      </tr>
      <tr>
        <th class="card-header">詳細</th>
        <td class="card-body">{!! nl2br(e($book_detail)) !!}</td>
        <input type="hidden" name="book_detail" value="{{$book_detail}}">
      </tr>
      <tr>
        <th class="card-header">書籍数</th>
        <td class="card-body">{{$book_number}}</td>
        <input type="hidden" name="book_number" value="{{$book_number}}">
      </tr>
      <tr>
        <th class="card-header">画像</th>
        @if (isset($read_temp_path))
        <td class="card-body thumbnail"><img src="/{{$read_temp_path}}"></td>
        <input type="hidden" name="temp_path" value="{{$temp_path}}">
        <input type="hidden" name="read_temp_path" value="{{$read_temp_path}}">
        @else
        <td class="card-body"></td>
        @endif
      </tr>
    </table>
  </form>
  <div class="button_area_center">
    <input class="btn btn-primary" type="submit" value="登録" onclick="document.complete.submit()">
    <input class="btn btn-secondary" type="submit" value="入力画面に戻る" onclick="document.back.submit()"></a>
  </div>
</div>
<form action="/book/add" method="post" name="back">
  @csrf
  <input type="hidden" name="back_flag" value="1">
  <input type="hidden" name="book_title" value="{{$book_title}}">
  <input type="hidden" name="book_detail" value="{{$book_detail}}">
  <input type="hidden" name="book_number" value="{{$book_number}}">
  @isset ($read_temp_path)
  <input type="hidden" name="read_temp_path" value="{{$read_temp_path}}">
  @endisset
</form>
@endsection
