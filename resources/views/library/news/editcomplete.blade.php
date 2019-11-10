@extends ("layouts.app")

@section ("title", "新着情報修正完了")

@section ("content")
<div class="container">
  <h1>新着情報修正完了</h1>
  <p class="text">新着情報を修正しました</p>
  <div class="button_area_center">
    <a class="btn btn-primary" href="/news/detail/{{$id}}">新着情報詳細に戻る</a>
  </div>
</div>
@endsection
