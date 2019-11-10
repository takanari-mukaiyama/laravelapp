@extends ("layouts.app")

@section ("title", $title."更新")

@section ("content")
<div class="container">
  <h1>{{$title}}更新</h1>
  <form method="post" action="/users/update">
    <input type="hidden" name="id" value="{{Auth::id()}}">
    @csrf
    @if (count($errors) > 0)
      <p class="caution">入力に問題が有ります。再入力してください</p>
    @endif
    <table class="card form_table">
      <tr>
        <th class="card-header">{{$title}}</th>
        <td class="card-body">
          @if ($errors->has($column_name))
            <input class="form-control is-invalid" type="text" name="{{$column_name}}" value="{{old($column_name)}}" maxlength=255 required>
            <p class="errors">{{$errors->first($column_name)}}</p>
          @else
            <input class="form-control" type="text" name="{{$column_name}}" value="{{$column_value}}" maxlength=255 required>
          @endif
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
