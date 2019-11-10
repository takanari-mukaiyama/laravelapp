@extends("layouts.libraryapp")

@section("title", "ログイン")

@section("content")
  <form method="post" action="/login">
    {{ csrf_field() }}
    @isset($msg)
    <p class="error_mes">{{$msg}}</p>
    @endisset
    @if ($errors->has("emp_id"))
    <p class="error_mes">{{$errors->first("emp_id")}}</p>
    @endif
    <div>
      @isset($emp_id)
      <span>社員ID</span><input type="text" name="emp_id" value="{{$emp_id}}">
      @else
      <span>社員ID</span><input type="text" name="emp_id" value="{{old('emp_id')}}">
      @endisset
    </div>
    @if ($errors->has("password"))
    <p class="error_mes">{{$errors->first("password")}}</p>
    @endif
    <div>
      <span>パスワード</span><input type="password" name="password" value="">
    </div>
    <div>
      <input type="submit" value="ログイン">
  </form>
    
@endsection
