@extends("layouts.app")

@section("title", "ユーザー一覧")

@section("content")
<div class="container">
  <h1>ユーザー一覧</h1>
  <div class="flex-center">
    <form class="search_form" method="get" action="/users/list">
      <input class="search_input form-control" type="text" name="search" value="{{$search}}">
      <input class="search_btn btn btn-primary" type="submit" value="検索">
    </form>
  </div>
  <table class="card list_format">
    <tr>
      <th class="card-header">社員ID</th>
      <th class="card-header">社員名</th>
      <th class="card-header">権限</th>
      <th class="card-header">ペナルティ期限</th>
      <th class="card-header"></th>
      <th class="card-header"></th>
    </tr>
    @foreach ($users as $user)
    <tr>
      <td class="card-body">{{$user->user_id}}</td>
      <td class="card-body">{{$user->name}}</td>
      <td class="card-body">{{$user->getRoleName->role_name}}</td>
      @isset ($user->getPenalty->penalty_end)
      <td class="card-body">{{$user->getPenalty->penalty_end}}</td>
      @else
      <td class="card-body">-</td>
      @endisset
      <td class="card-body">
        <a class="btn btn-primary" href="/users/penalty/edit/{{$user->user_id}}">ペナルティ情報変更</a>
      </td>
      <td class="card-body">
        <a class="btn btn-primary" href="/users/role/change/{{$user->user_id}}">権限変更</a>
      </td>
    </tr>
    @endforeach
  </table>
  @isset ($search)
  {{$users->appends(["search" => $search])->links()}}
  @else
  {{$users->links()}}
  @endisset
</div>
@endsection
