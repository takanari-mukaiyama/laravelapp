@extends("layouts.app")

@section("title", "図書情報修正")

@section("content")
<div class="container">
  <h1>図書情報修正確認</h1>
  <form action="/book/edit/complete" method="post" name="complete">
    @csrf
    <input type="hidden" name="book_id" value="{{$book_id}}">
    <p class="caution">以下の通り図書情報を修正します
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
        <th class="card-header">書籍数追加</th>
        <td class="card-body">{{$add_book_number}}
        ※図書IDは自動的に割り振られます</td>
        <input type="hidden" name="add_book_number" value="{{$add_book_number}}">
      </tr>
      <tr>
        <th class="card-header">画像</th>
        @if (isset($read_temp_path))
          <td class="card-body thumbnail"><img src="/{{$read_temp_path}}">
            <input type="hidden" name="temp_path" value="{{$temp_path}}">
            <input type="hidden" name="read_temp_path" value="{{$read_temp_path}}">
          </td>
        @elseif (isset($current_image_file))
          <td class="card-body thumbnail"><img src="/{{$current_image_file}}"></td>
        @else
          <td class="card-body thumbnail"></td>
        @endif
      </tr>
    </table>
  </form>
  <div class="button_area_center">
    <input class="btn btn-primary" type="submit" value="登録" onclick="document.complete.submit()">
    <input class="btn btn-secondary" type="submit" value="入力画面に戻る" onclick="document.back.submit()"></a>
  </div>
</div>
<form action="/book/edit/{{$book_id}}" method="post" name="back">
  @csrf
  <input type="hidden" name="back_flag" value="1">
  <input type="hidden" name="book_title" value="{{$book_title}}">
  <input type="hidden" name="book_detail" value="{{$book_detail}}">
  <input type="hidden" name="add_book_number" value="{{$add_book_number}}">
  @isset ($read_temp_path)
  <input type="hidden" name="read_temp_path" value="{{$read_temp_path}}">
  @endisset
  @isset ($current_image_file)
  <input type="hidden" name="current_image_file" value="{{$current_image_file}}">
  @endisset
</form>
@endsection
