@extends("layouts.app")

@section("title", "図書一覧")

@section("content")
<div class="container">
  <h1>図書一覧</h1>
  <div class="flex-center">
    <form class="search_form" method="get" action="/book">
      <input class="search_input form-control" type="text" name="search" value="{{$search}}">
      <input class="search_btn btn btn-primary" type="submit" value="検索">
    </form>
    @can ("admin-higher")
    <div class="right button_area">
      <a class="btn btn-primary" href="/book/add">新規図書追加</a>
    </div>
    @endcan
  </div>
  <div class="card list_format">
  @foreach ($books as $book)
    <a href="/book/detail/{{$book->book_id}}">
      <div class="card-body books">
        @if (isset($book->image_path))
        <img class="small_thumbnail" src="{{$book->image_path}}">
        @else
        <img class="small_thumbnail" src="/storage/no_image.png">
        @endif
        <span>{{$book->book_title}}</span>
      </div>
    </a>
  @endforeach
  </div>
  @isset ($search)
  {{$books->appends(["search" => $search])->links()}}
  @else
  {{$books->links()}}
  @endisset
</div>
@endsection
