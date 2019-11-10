@extends ("layouts.app")

@section ("title", "パスワード更新")

@section ("content")
<div class="container">
  <h1>パスワード更新</h1>
  <form method="post" action="/users/update/password">
    <input type="hidden" name="id" value="{{Auth::id()}}">
    @csrf
    @if (count($errors) > 0)
      <p class="caution">入力に問題が有ります。再入力してください</p>
    @endif
    <table class="card form_table">
      <tr>
        <th class="card-header">現在のパスワード</th>
        <td class="card-body">
          @if ($errors->has("now_pass"))
            <input class="form-control is-invalid" type="password" name="now_pass" value="" required maxlength=30>
            <p class="errors">{{$errors->first("now_pass")}}</p>
          @else
            <input class="form-control" type="password" name="now_pass" value="" required maxlength=30>
          @endif
        </td>
      </tr>
      <tr>
        <th class="card-header">新しいパスワード</th>
        <td class="card-body">
          @if ($errors->has("new_pass"))
            <input class="form-control is-invalid" type="password" name="new_pass" value="" required maxlength=30>
            <p class="errors">{{$errors->first("new_pass")}}</p>
          @else
            <input class="form-control" type="password" name="new_pass" value="" required maxlength=30>
          @endif
        </td>
      </tr>
      <tr>
        <th class="card-header">新しいパスワード(確認)</th>
        <td class="card-body">
          <input class="form-control" type="password" name="new_pass_confirmation" value="" required maxlength=30>
        </td>
      </tr>
    </table>
    <div class="button_area_center">
      <input type="submit" class="btn btn-primary" value="更新">
      <a class="btn btn-secondary" href="/users/info">ユーザー情報に戻る</a>
    </div>
  </form>
</div>
@endsection
