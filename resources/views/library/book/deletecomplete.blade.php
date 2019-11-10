@extends("layouts.app")

@section("title", "図書情報削除完了")

@section("content")
<div class="container">
<h1>図書情報削除完了</h1>
<p>図書を削除しました</p>
<div class="button_area_center">
@if ($all_delete_flag === 1)
<a class="btn btn-primary" href="/book">図書一覧に戻る</a>
@else
<a class="btn btn-primary" href="/book/detail/{{$book_id}}">図書詳細に戻る</a>
@endif
</div>
</div>
@endsection
