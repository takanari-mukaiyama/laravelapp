@extends ("layouts.app")

@section ("title", "ペナルティ情報修正")

@section ("content")
<div class="container">
  <h1>ペナルティ情報修正</h1>
  <form method="post" action="/users/penalty/edit/confirm">
    @csrf
    <input type="hidden" name="user_id" value="{{$user_id}}">
    @if (count($errors) > 0)
      <p class="caution">入力に問題が有ります。再入力してください</p>
    @endif
    <table class="card form_table">
      <tr>
        <th class="card-header">ペナルティ終了時刻<br>
          例：2020-01-01 09:05:00
        </th>
        <td class="card-body">
          @if ($errors->has("penalty_end"))
            <input class="form-control is-invalid" type="text" name="penalty_end" value="{{old('penalty_end')}}" required>
            <p class="errors">{{$errors->first("penalty_end")}}</p>
          @else
            <input class="form-control" type="text" name="penalty_end" value="{{$penalty_end}}" required>
          @endif
        </td>
      </tr>
    </table>
    <div class="button_area_center">
      <input type="submit" class="btn btn-primary" value="更新">
      <a class="btn btn-secondary" href="/users/list">社員一覧に戻る</a>
    </div>
  </form>
</div>
@endsection
