@extends("layouts.app")

@section("title", "図書貸出確認")

@section("content")
<div class="container">
  <h1>図書貸出確認</h1>
  <form action="/book/rent/complete" method="post" name="complete">
    @csrf
    <p class="caution">以下の通り図書を貸出します</p>
    <table class="card form_table">
      <tr>
        <th class="card-header">図書ID</th>
        <td class="card-body">{{$book_id}}-{{$book_number}}</td>
      </tr>
      <tr>
        <th class="card-header">本のタイトル</th>
        <td class="card-body">{{$book_title}}</td>
      </tr>
      <tr>
        <th class="card-header">社員ID</th>
        <td class="card-body">{{$user_id}}</td>
      </tr>
      <tr>
        <th class="card-header">社員名</th>
        <td class="card-body">{{$name}}</td>
      </tr>
      <tr>
        <th class="card-header">返却期限</th>
        <td class="card-body">貸出登録完了から1週間後</td>
      </tr>
    </table>
  <input type="hidden" name="user_id" value="{{$user_id}}">
  <input type="hidden" name="book_id" value="{{$book_id}}">
  <input type="hidden" name="book_number" value="{{$book_number}}">
  </form>
  <div class="button_area_center">
    <input class="btn btn-primary" type="submit" value="貸出登録" onclick="document.complete.submit()">
    <input class="btn btn-secondary" type="submit" value="入力画面に戻る" onclick="document.back.submit()">
  </div>
</div>
<form action="/book/rent/{{$book_id}}/{{$book_number}}" method="post" name="back">
    @csrf
    <input type="hidden" name="back_flag" value="1">
    <input type="hidden" name="user_id" value="{{$user_id}}">
    <input type="hidden" name="book_title" value="{{$book_title}}">
</form>
@endsection
