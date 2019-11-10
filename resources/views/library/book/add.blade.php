@extends("layouts.app")

@section("title", "新規図書追加")

@section("content")
<div class="container">
  <h1>新規図書追加</h1>
  <form action="/book/add" method="post" enctype="multipart/form-data">
    @csrf
    @if(count($errors) > 0)
    <p class="caution">入力に問題があります。再入力してください</p>
    @endif
    <table class="card form_table">
      <tr>
        <th class="card-header">タイトル</th>
        <td class="card-body">
          @if(isset($back_flag))
          <input class="form-control" type="text" name="book_title" value="{{$book_title}}" maxlength=255 required>
          @else
            @if($errors->has("book_title"))
              <input class="form-control is-invalid" type="text" name="book_title" value="{{old('book_title')}}" maxlength=255 required>
              <p class="errors">{{$errors->first("book_title")}}</p>
            @else
              <input class="form-control" type="text" name="book_title" value="{{old('book_title')}}" maxlength=255 required>
            @endif
          @endif
        </td>
      </tr>
      <tr>
        <th class="card-header">詳細</th>
        <td class="card-body">
          @if(isset($back_flag))
          <textarea class="form-control" name="book_detail" maxlength=1000 required>{{$book_detail}}</textarea>
          @else
            @if($errors->has("book_detail"))
              <textarea class="form-control is-invalid" name="book_detail" maxlength=1000 required>{{old('book_detail')}}</textarea>
            <p class="errors">{{$errors->first("book_detail")}}</p>
            @else
              <textarea class="form-control" name="book_detail" maxlength=1000 required>{{old('book_detail')}}</textarea>
            @endif
          @endif
        </td>
      </tr>
      <tr>
        <th class="card-header">書籍数</th>
        <td class="card-body">
          @if(isset($back_flag))
          <input class="form-control" type="number" name="book_number" value="{{$book_number}}" required >
          @else
            @if($errors->has("book_number"))
              <input class="form-control is-invalid" type="number" name="book_number" value="{{old('book_number')}}" required >
            <p class="errors">{{$errors->first("book_number")}}</p>
            @else
              <input class="form-control" type="number" name="book_number" value="{{old('book_number')}}" required >
            @endif
          @endif
        </td>
      </tr>
      <tr>
        <th class="card-header">画像</th>
        <td class="card-body">
          @if (isset($back_flag))
            <input type="file" name="image_file" value="">
            @isset ($read_temp_path)
              <div class="thumbnail"><img src="/{{$read_temp_path}}"></div>
              <input type="hidden" name="before_image_file" value="{{$read_temp_path}}">
            @endisset
          @else
            <input type="file" name="image_file" value="">
            <div class="thumbnail"></div>
          @endif
        </td>
      </tr>
    </table>
    <div class="button_area_center">
      <input class="btn btn-primary" type="submit" value="確認">
      <a class="btn btn-secondary" href="/book">図書一覧に戻る</a>
    </div>
  </form>
</div>
<script type="application/javascript"
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous">
</script>
<script type="application/javascript">
$(function() {
  // アップロードするファイルを選択
  $('input[type=file]').change(function() {
    var file = $(this).prop('files')[0];

    // 画像以外は処理を停止
    if (! file.type.match('image.*')) {
      // クリア
      $(this).val('');
      $('.thumbnail').html('');
      return;
    }

    // 画像表示
    var reader = new FileReader();
    reader.onload = function() {
      var img_src = $('<img>').attr('src', reader.result);
      $('.thumbnail').html(img_src);
    }
    reader.readAsDataURL(file);
  });
});
</script>
@endsection
