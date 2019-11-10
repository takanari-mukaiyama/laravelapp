@extends ("layouts.app")

@section ("title", "新着情報追加")

@section ("content")
<div class="container">
  <h1>新着情報追加</h1>
  @if (count($errors) > 0)
    <p class="caution">入力に問題があります。再入力してください</p>
  @endif
  <form action="/news/add/confirm" method="post">
    @csrf
    <table class="card form_table">
      <tr>
        <th class="card-header">タイトル</th>
        <td class="card-body">
          @isset ($back_flag)
            <input class="form-control" name="news_title" value="{{$news_title}}" maxlength=255 required>
          @else
            @if ($errors->has("news_title"))
              <input class="form-control is-invalid" name="news_title" value="{{old('news_title')}}" maxlength=255 required>
              <p class="errors">{{$errors->first("news_title")}}</p>
            @else
              <input class="form-control" name="news_title" value="{{old('news_title')}}" maxlength=255 required>
            @endif
          @endisset
        </td>
      </tr>
      <tr>
        <th class="card-header">詳細</th>
        <td class="card-body">
          @isset ($back_flag)
            <textarea class="form-control" name="section" maxlength=1000 required>{{$section}}</textarea>
          @else
            @if ($errors->has("section"))
              <textarea class="form-control is-invalid" name="section" maxlength=1000 required>{{old('section')}}</textarea>
              <p class="errors">{{$errors->first("section")}}</p>
            @else
              <textarea class="form-control" name="section" maxlength=1000 required>{{old('section')}}</textarea>
            @endif
          @endisset
        </td>
      </tr>
    </table>
    <div class="button_area_center">
      <input type="submit" class="btn btn-primary" value="確認">
      <a class="btn btn-secondary" href="/news">新着情報一覧に戻る</a>
    </div>
  </form>
</div>
@endsection
