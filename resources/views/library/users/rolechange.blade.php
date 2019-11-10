@extends ("layouts.app")

@section ("title", "権限変更")

@section ("content")
<div class="container">
  <h1>権限変更</h1>
  @if (count($errors) > 0)
    <p class="caution">入力に問題が有ります。再入力してください</p>
  @endif
  <form method="post" action="/users/role/confirm">
    @csrf
    <input type="hidden" name="user_id" value="{{$user_id}}">
    <table class="card form_table">
      <tr>
        <th class="card-header">現在の権限</th>
        <td class="card-body">
          @if ($errors->has("role_id"))
            {{Form::select("role_id", $role_rule, old("role_id"), ['class' => 'form-control'])}}
            <p class="errors">{{$errors->first("role_id")}}</p>
          @else
            {{Form::select("role_id", $role_rule, $user_role, ['class' => 'form-control'])}}
          @endif
        </td>
      </tr>
    </table>
    <div class="button_area_center">
      <input type="submit" class="btn btn-primary" value="確認">
      <a class="btn btn-secondary" href="/users/list">社員一覧に戻る</a>
    </div>
  </form>
</div>
@endsection
