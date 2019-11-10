@extends ("layouts.app")

@section ("title", "新着情報詳細")

@section ("content")
<div class="container">
  <h1>新着情報詳細</h1>
  <div class="card">
    <p class="card-header detail_news_title">{{$news->news_title}}</p>
    <p class="card-body">公開日：{{$news->created_at}}</p>
    <p class="card-body">{!! nl2br(e($news->section)) !!}</p>
  </div>
  <div class="button_area">
    @can ("admin-higher")
    <a class="btn btn-primary" href="/news/edit/{{$news->id}}">修正</a>
    <a class="btn btn-secondary" href="/news/delete/{{$news->id}}">削除</a>
    @endcan
  </div>
  <div class="button_area_center">
    <a class="btn btn-primary" href="/news">新着情報一覧に戻る</a>
  </div>
</div>
@endsection
