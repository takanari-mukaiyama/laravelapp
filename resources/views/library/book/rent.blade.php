@extends("layouts.app")

@section("title", "図書貸出")

@section("content")
<div class="container">
  <h1>図書貸出</h1>
  <form action="/book/rent/{{$book_id}}/{{$book_number}}" method="post">
    <input type="hidden" name="book_id" value="{{$book_id}}">
    <input type="hidden" name="book_title" value="{{$book_title}}">
    <input type="hidden" name="book_number" value="{{$book_number}}">
    @csrf
    @if (count($errors) > 0)
    <p class="errors">入力に問題が有ります。再入力してください</p>
    @endif
    <table class="card form_table">
      <tr>
        <th class="card-header">本のタイトル</th>
        <td class="card-body">{{$book_title}}</td>
      </td>
      <tr>
        <th class="card-header">図書ID</th>
        <td class="card-body">{{$book_id}}-{{$book_number}}</td>
      </td>
      <tr>
        <th class="card-header">社員ID</th>
        @if (isset($back_flag))
        <td class="card-body"><input class="form-control" type="number" name="user_id" value="{{$user_id}}" required></td>
        @else
          @if (count($errors) > 0)
            <td class="card-body"><input class="form-control is-invalid" type="number" name="user_id" value="{{old('user_id')}}" required>
            @foreach ($errors->all() as $error)
              <p class="errors">{{$error}}</p>
            @endforeach
          @else
            <td class="card-body"><input class="form-control" type="number" name="user_id" value="{{old('user_id')}}" required>
          @endif
        </td>
        @endif
      </tr>
      <tr>
        <th class="card-header">返却期限</th>
        <td class="card-body">貸出登録完了から1週間後</td>
      </tr>
    </table>
    <div class="button_area_center">
      <input class="btn btn-primary" type="submit" value="確認">
      <a class="btn btn-secondary" href="/book/detail/{{$book_id}}">図書詳細に戻る</a>
    </div>
  </form>
</div>
@endsection
