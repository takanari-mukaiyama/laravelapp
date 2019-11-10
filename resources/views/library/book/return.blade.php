@extends("layouts.app")

@section("title", "図書返却確認")

@section("content")
<div class="container">
  <h1>図書返却確認</h1>
  <form action="/book/return/complete" method="post">
    <input type="hidden" name="user_id" value="{{$user_id}}">
    <input type="hidden" name="book_id" value="{{$book_id}}">
    <input type="hidden" name="book_number" value="{{$book_number}}">
    @csrf
    <p class="caution">以下の通り図書を返却します。</p>
    <table class="card form_table">
      <tr>
        <th class="card-header">貸し出している本</th>
        <td class="card-body">{{$book_title}}</td>
      </tr>
      <tr>
        <th class="card-header">図書ID</th>
        <td class="card-body">{{$book_id}}-{{$book_number}}</td>
      </tr>
      <tr>
        <th class="card-header">社員ID</th>
        <td class="card-body">{{$user_id}}</td>
      </tr>
      <tr>
        <th class="card-header">社員名</th>
        <td class="card-body">{{$name}}</td>
      </tr>
      <tr>
        <th class="card-header">返却期限</th>
        <td class="card-body">{{$deadline}}
          @if ($over_deadline_flag === 1)
            <p class="errors">返却期限を超過しています</p>
          @endif
        </td>
      </tr>
    </table>
    <div class="button_area_center">
      <input class="btn btn-success" type="submit" value="返却">
      <a class="btn btn-secondary" href="/book/detail/{{$book_id}}">図書詳細に戻る</a>
    </div>
  </form>
</div>
@endsection
