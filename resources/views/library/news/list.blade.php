@extends ("layouts.app")

@section ("title", "新着情報一覧")

@section ("content")
<div class="container">
  <h1>新着情報一覧</h1>
  @can ("admin-higher")
  <div class="button_area">
    <a class="btn btn-primary" href="/news/add">新規登録</a>
  </div>
  @endcan
  <div class="card list_format">
    @foreach ($news_list as $news)
      <a href="/news/detail/{{$news->id}}">
        <div class="card-body tr_link flex">
          <span style="min-width:115px">{{$news->created_at->format('Y年m月d日')}}</span>
          <span class="news_title">{{$news->news_title}}</span>
        </div>
      </a>
    @endforeach
  </div>
  {{$news_list->links()}}
  <div class="button_area_center">
    <a class="btn btn-primary" href="/">トップへ戻る</a>
  </div>
</div>
@endsection
