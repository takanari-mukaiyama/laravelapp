@extends ("layouts.app")

@section ("title", "権限変更確認")

@section ("content")
<div class="container">
  <h1>権限変更確認</h1>
  <p class="text">以下の通り権限を変更します</p>
  <form method="post" action="/users/role/complete" name="complete">
    @csrf
    <input type="hidden" name="user_id" value="{{$user_id}}">
    <table class="card form_table">
      <tr>
        <th class="card-header">権限</th>
        <td class="card-body">{{$role}}</td>
      </tr>
    </table>
    <input type="hidden" name="role_id" value="{{$role_id}}">
  </form>
</div>
<div class="button_area_center">
  <input class="btn btn-primary" type="submit" value="登録" onclick="document.complete.submit()">
  <input class="btn btn-secondary" type="submit" value="入力画面に戻る" onclick="document.back.submit()"></a>
</div>
<form action="/users/role/change/{{$user_id}}" method="post" name="back">
  @csrf
  <input type="hidden" name="user_id" value="{{$user_id}}">
  <input type="hidden" name="role_id" value="{{$role_id}}">
</form>

@endsection
