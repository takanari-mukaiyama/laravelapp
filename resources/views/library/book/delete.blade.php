@extends("layouts.app")

@section("title", "図書情報削除")

@section("content")
<div class="container">
<h1>図書情報削除確認</h1>
  <form action="/book/delete/complete" method="post" name="complete">
    @csrf
    <p class="caution">以下の図書を削除します</p>
    <table class="card form_table">
      <tr>
        <th class="card-header">図書ID</th>
        @isset ($book_number)
        <td class="card-body">{{$book_id}}-{{$book_number}}</td>
        <input type="hidden" name="book_number" value="{{$book_number}}">
        @else
        <td class="card-body">{{$book_id}}-***
        ※以下タイトルの図書を全て削除します</td>
        @endisset
        <input type="hidden" name="book_id" value="{{$book_id}}">
      <tr>
        <th class="card-header">タイトル</th>
        <td class="card-body">{{$book_title}}</td>
        <input type="hidden" name="book_title" value="{{$book_title}}">
      </tr>
      <tr>
        <th class="card-header">詳細</th>
        <td class="card-body">{{$book_detail}}</td>
        <input type="hidden" name="book_detail" value="{{$book_detail}}">
      </tr>
    </table>
  </form>
  <div class="button_area_center">
    <input class="btn btn-primary" type="submit" value="削除" onclick="document.complete.submit()">
    <a class="btn btn-secondary" href="/book/detail/{{$book_id}}">図書詳細画面に戻る</a>
  </div>
</div>
@endsection
