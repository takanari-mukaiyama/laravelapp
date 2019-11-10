@extends("layouts.app")

@section("title", "図書貸出完了")

@section("content")
<div class="container">
<h1>図書貸出登録完了</h1>
<p class="text">図書の貸出登録が完了しました</p>
<div class="button_area_center">
  <a class="btn btn-primary" href="/book/detail/{{$book_id}}">図書詳細に戻る</a>
</div>
</div>
@endsection
