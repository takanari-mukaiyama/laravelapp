@extends("layouts.app")

@section("title", "図書詳細")

@section("content")
<div class="container">
  <h1>図書詳細</h1>
  <div class="flex">
    @if (isset($book_info->image_path))
    <img class="big_thumbnail" src="/{{$book_info->image_path}}">
    @else
    <img class="big_thumbnail" src="/storage/no_image.png">
    @endif
    <div class="card list_format">
      <div class="card-header">タイトル</div>
      <div class="card-body">{{$book_info->book_title}}</div>
      <div class="card-header">詳細</div>
      <div class="card-body">{!! nl2br(e($book_info->book_detail)) !!}</div>
    </div>
  </div>
  <div class="button_area">
  @can ("admin-higher")
  <a class="btn btn-primary" href="/book/edit/{{$book_info->book_id}}/">図書情報修正</a>
  <a class="btn btn-secondary" href="/book/delete/{{$book_info->book_id}}/">削除</a>
  @endcan
  </div>
  <h2>貸出リスト</h2>
  <table class="card list_format">
    <tr>
      <th class="card-header">図書ID</th>
      <th class="card-header">状態</th>
      <th class="card-header">返却期限日</th>
      <th class="card-header btn_column"></th>
      <th class="card-header btn_column"></th>
    </tr>
    @foreach ($rental_info as $book_number => $rental)
    <tr>
      <td class="card-body">{{$book_info->book_id}}-{{$book_number}}</td>
      @if (isset($rental["deadline"]) && is_null($rental["return_date"]))
      <td class="card-body">貸出中</td>
      <td class="card-body">{{$rental["deadline"]}}</td>
      <td class="card-body btn_column">
        @can ("admin-higher")
        <a class="btn btn-success" href="/book/return/{{$book_info->book_id}}/{{$book_number}}/">返却</a>
        @endcan
      </td>
      @else
      <td class="card-body">在庫あり</td>
      <td class="card-body">-</td>
      <td class="card-body btn_column">
        @can ("admin-higher")
        <a class="btn btn-primary" href="/book/rent/{{$book_info->book_id}}/{{$book_number}}/">貸出</a>
        @endcan
      </td>
      @endif
      <td class="card-body btn_column">
        @can ("admin-higher")
        <a class="btn btn-secondary" href="/book/delete/{{$book_info->book_id}}/{{$book_number}}/">削除</a>
        @endcan
      </td>
    </tr>
    @endforeach
  </table>
  <div class="button_area_center">
    <a class="btn btn-primary" href="/book">図書一覧に戻る</a>
  </div>
</div>
@endsection
