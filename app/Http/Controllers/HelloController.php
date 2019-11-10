<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\HelloRequest;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Person;
use Illuminate\Support\Facades\Auth;
class HelloController extends Controller{
    public function getAuth(Request $request){
        $param = ["message" => "ログインしてください"];
        return view("hello.auth", $param);
    }

    public function postAuth(Request $request){
        $email = $request->email;
        $password = $request->password;
        if(Auth::attempt(["email" => $email, "password" => $password])){
            $msg = "ログインしました (".Auth::user()->name.")";
        }else{
            $msg = "ログインに失敗しました";
        }
        return view("hello.auth", ["message" => $msg]);
    }

    public function rest(Request $request){
        return view("hello.rest");
    }

    public function index(Request $request){
        $user = Auth::user();
        $sort = $request->sort;
        if(is_null($sort)){
            $sort = "name";
        }
        $items = Person::orderBy($sort, "asc")
            ->paginate(5);
        return view("hello.index", ["items" => $items, "sort" => $sort, "user" => $user]);
    }


    public function post(Request $request){
        $items = DB::select("select * from people");
        return view("hello.index", ["items" => $items]);
    }

    public function add(Request $request){
        return view("hello.add");
    }

    public function create(Request $request){
        $param = [
            "name" => $request->name,
            "mail" => $request->mail,
            "age"  => $request->age,
        ];
        DB::table("people")->insert($param);
        return redirect("/hello");
    }

    public function edit(Request $request){
        $item = DB::table("people")
            ->where("id", $request->id)
            ->first();
        return view("hello.edit", ["form" => $item]);
    }

    public function update(Request $request){
        $param = [
            "name" => $request->name,
            "mail" => $request->mail,
            "age"  => $request->age,
        ];
        DB::table("people")
            ->where("id", $request->id)
            ->update($param);
        return redirect("/hello");
    }

    public function del(Request $request){
        $item = DB::table("people")
            ->where("id", $request->id)
            ->first();
        return view("hello.del", ["form" => $item]);
    }

    public function remove(Request $request){
        DB::table("people")
            ->where("id", $request->id)
            ->delete();
        return redirect("/hello");
    }

    public function show(Request $request){
        $page = $request->page;
        $items = DB::table("people")
               ->offset($page * 2)
               ->limit(2)
               ->get();
        return view("hello.show", ["items" => $items]);
    }

    public function ses_get(Request $request){
        $sesdata = $request->session()->get("msg");
        return view("hello.session", ["session_data" => $sesdata]);
    }

    public function ses_put(Request $request){
        $msg = $request->input;
        $request->session()->put("msg", $msg);
        return redirect("hello/session");
    }

}
