@extends ("layouts.app")

@section ("title", "ユーザー情報")

@section ("content")
<div class="container">
  <h1>ユーザー情報</h1>
  @isset ($penalty)
    <p class="errors text">あなたは以下のペナルティを受けています</p>
    <p class="caution">・{{$penalty}}まで図書の借受禁止</p>
  @else
    <p class="text">現在ペナルティは適用されていません</p>
  @endisset
  <table class="card form_table">
    <tr>
      <th class="card-header">社員ID</th>
      <td class="card-body flex-center">{{$user->user_id}}
        <a class="btn btn-primary right" href="/users/edit/user_id">変更する</a>
      </td>
    </tr>
    <tr>
      <th class="card-header">社員名</th>
      <td class="card-body flex-center">{{$user->name}}
        <a class="btn btn-primary right" href="/users/edit/name">変更する</a>
      </td>
    </tr>
    <tr>
      <th class="card-header">メールアドレス</th>
      <td class="card-body flex-center">{{$user->email}}
        <a class="btn btn-primary right" href="/users/edit/email">変更する</a>
      </td>
    </tr>
    <tr>
      <th class="card-header">パスワード</th>
      <td class="card-body flex-center">●●●●●●●●●●●●
        <a class="btn btn-primary right" href="/users/edit/password">変更する</a>
      </td>
  </table>
  <h2>現在借りている本</h2>
  @if (count($renting) > 0)
    <table class="card list_format">
      <tr>
        <th class="card-header"></th>
        <th class="card-header">タイトル</th>
        <th class="card-header">借受日</th>
        <th class="card-header">返却期限</th>
      </tr>
      @foreach ($renting as $one_rent)
        <tr class="tr_link" data-href="/book/detail/{{$one_rent->book_id}}">
          @isset ($one_rent->image_path)
            <td class="card-body"><img class="small_thumbnail" src="/{{$one_rent->image_path}}"></td>
          @else
            <td class="card-body"><img class="small_thumbnail" src="/storage/no_image.png"></td>
          @endisset
          <td class="card-body">{{$one_rent->book_title}}</td>
          <td class="card-body">{{$one_rent->rent_date}}</td>
          <td class="card-body">{{$one_rent->deadline}}</td>
        </tr>
      @endforeach
    </table>
  @else
    <p>現在借りている図書はありません</p>
  @endif
  <h2>過去に借りた本</h2>
  @if (count($rented) > 0)
    <table class="card list_format">
      <tr>
        <th class="card-header"></th>
        <th class="card-header">タイトル</th>
        <th class="card-header">借受日</th>
        <th class="card-header">返却日</th>
      </tr>
      @foreach ($rented as $one_rent)
        <tr class="tr_link" data-href="/book/detail/{{$one_rent->book_id}}">
          @isset ($one_rent->image_path)
            <td class="card-body"><img class="small_thumbnail" src="/{{$one_rent->image_path}}"></td>
          @else
            <td class="card-body"><a href=""><img class="small_thumbnail" src="/storage/no_image.png"></a></td>
          @endisset
          <td class="card-body">{{$one_rent->book_title}}</td>
          <td class="card-body">{{$one_rent->rent_date}}</td>
          <td class="card-body">{{$one_rent->return_date}}</td>
        </tr>
      @endforeach
    </table>
  @else
    <p>現在借りている図書はありません</p>
  @endif
</div>
<script type="application/javascript"
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous">
</script>
<script type="application/javascript">
jQuery( function($) {
    $('tbody tr[data-href]').addClass('clickable').click( function() {
        window.location = $(this).attr('data-href');
    }).find('a').hover( function() {
        $(this).parents('tr').unbind('click');
    }, function() {
        $(this).parents('tr').click( function() {
            window.location = $(this).attr('data-href');
        });
    });
});
</script>
</script>
@endsection
