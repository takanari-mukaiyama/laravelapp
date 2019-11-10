@extends ("layouts.app")

@section ("title", "新着情報削除確認")

@section ("content")
<div class="container">
  <h1>新着情報削除確認</h1>
  <p class="caution">以下の新着情報を削除します</p>
  <form action="/news/delete/complete" method="post" name="complete">
    <input type="hidden" name="id" value="{{$id}}">
    @csrf
    <table class="card form_table">
      <tr>
        <th class="card-header">タイトル</th>
        <td class="card-body">{{$news_title}}</td>
        <input type="hidden" name="news_title" value="{{$news_title}}">
      </tr>
      <tr>
        <th class="card-header">詳細</th>
        <td class="card-body">{{$section}}</td>
        <input type="hidden" name="section" value="{{$section}}">
      </tr>
    </table>
    <div class="button_area_center">
      <input class="btn btn-primary" type="submit" value="削除">
      <a class="btn btn-secondary" href="/news/detail/{{$id}}">新着情報詳細に戻る</a>
    </div>
  </form>
</div>
@endsection
