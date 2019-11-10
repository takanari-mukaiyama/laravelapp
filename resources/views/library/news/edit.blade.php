@extends ("layouts.app")

@section ("title", "新着情報修正")

@section ("content")
<div class="container">
  <h1>新着情報修正</h1>
  <form action="/news/edit/confirm" method="post">
  @if (count($errors) > 0)
    <p class="caution">入力に問題があります。再入力してください</p>
  @endif
    @csrf
    <input type="hidden" name="id" value="{{$id}}">
    <table class="card form_table">
      <tr>
        <th class="card-header">タイトル</th>
        <td class="card-body">
          @if ($errors->has("news_title"))
            <input class="form-control is-invalid" name="news_title" value="{{old('news_title')}}" maxlength=255 required>
            <p class="errors">{{$errors->first("news_title")}}</p>
          @elseif (count($errors) > 0)
            <input class="form-control" name="news_title" value="{{old('news_title')}}" maxlength=255 required>
          @else
            <input class="form-control" name="news_title" value="{{$news_title}}" maxlength=255 required>
          @endif
        </td>
      </tr>
      <tr>
        <th class="card-header">詳細</th>
        <td class="card-body">
          @if ($errors->has("section"))
            <textarea class="form-control is-invalid" name="section" maxlength=1000 required>{{old('section')}}</textarea>
            <p class="errors">{{$errors->first("section")}}</p>
          @elseif (count($errors) > 0)
            <textarea class="form-control" name="section" maxlength=1000 required>{{old('section')}}</textarea>
          @else
            <textarea class="form-control" name="section" maxlength=1000 required>{{$section}}</textarea>
          @endif
        </td>
      </tr>
    </table>
    <div class="button_area_center">
      <input type="submit" class="btn btn-primary" value="確認">
      <a class="btn btn-secondary" href="/news/detail/{{$id}}">新着情報詳細に戻る</a>
    </div>
  </form>
</div>
@endsection
