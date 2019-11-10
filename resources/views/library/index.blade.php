@extends("layouts.app")

@section("title", "Top")

@section("content")
<div class="container">
  <h1>Top</h1>
  <div class="card list_format">
    <div class="card-header">新着情報</div>
    @foreach ($news_list as $news)
      <a href="/news/detail/{{$news->id}}">
        <div class="card-body tr_link">
          <span>{{$news->created_at}}</span>
          <span class="news_title">{{$news->news_title}}</span>
        </div>
      </a>
    @endforeach
  </div>
  <div class="more">
    <a href="/news">>>もっとみる</a>
  </div>

  <div class="card list_format">
    <div class="card-header">図書検索</div>
    <div class="card-body">
      <form class="search_form_long" method="get" action="/book">
        <input class="search_input form-control" type="text" name="search" value="">
        <input class="search_btn btn btn-primary" type="submit" value="検索">
      </form>
      <span>※文字を入力せずに検索すると全ての図書を表示します</span>
    </div>
  </div>
</div>
@endsection
