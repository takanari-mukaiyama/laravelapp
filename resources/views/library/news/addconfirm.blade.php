@extends ("layouts.app")

@section ("title", "新着情報追加確認")

@section ("content")
<div class="container">
  <h1>新着情報追加確認</h1>
  <p class="caution">以下の通り新着情報を追加します</p>
  <form action="/news/add/complete" method="post" name="complete">
    @csrf
    <table class="card form_table">
      <tr>
        <th class="card-header">タイトル</th>
        <td class="card-body">{{$news_title}}</td>
        <input type="hidden" name="news_title" value="{{$news_title}}">
      </tr>
      <tr>
        <th class="card-header">詳細</th>
        <td class="card-body">{!! nl2br(e($section)) !!}</td>
        <input type="hidden" name="section" value="{{$section}}">
      </tr>
    </table>
  </form>
  <div class="button_area_center">
    <input class="btn btn-primary" type="submit" value="登録" onclick="document.complete.submit()">
    <input class="btn btn-secondary" type="submit" value="入力画面に戻る" onclick="document.back.submit()">
</div>
<form action="/news/add" method="post" name="back">
  @csrf
  <input type="hidden" name="back_flag" value="1">
  <input type="hidden" name="news_title" value="{{$news_title}}">
  <input type="hidden" name="section" value="{{$section}}">
</form>
@endsection
