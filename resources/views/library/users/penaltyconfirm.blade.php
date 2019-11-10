@extends ("layouts.app")

@section ("title", "ペナルティ情報修正確認")

@section ("content")
<div class="container">
  <h1>ペナルティ情報修正確認</h1>
  <p class="caution">以下の通りペナルティ情報を修正します</p>
  <form method="post" action="/users/penalty/edit/complete" name="complete">
    @csrf
    <input type="hidden" name="user_id" value="{{$user_id}}">
    <table class="card form_table">
      <tr>
        <th class="card-header">ペナルティ終了時刻</th>
        <td class="card-body">
          {{$penalty_end}}
          <input type="hidden" name="penalty_end" value="{{$penalty_end}}">
        </td>
      </tr>
    </table>
  </form>
  <div class="button_area_center">
    <input class="btn btn-primary" type="submit" value="登録" onclick="document.complete.submit()">
    <input class="btn btn-secondary" type="submit" value="入力画面に戻る" onclick="document.back.submit()"></a>
  </div>
</div>
<form action="/users/penalty/edit" method="post" name="back">
  @csrf
  <input type="hidden" name="penalty_end" value="{{$penalty_end}}">
  <input type="hidden" name="user_id" value="{{$user_id}}">
</form>
@endsection
