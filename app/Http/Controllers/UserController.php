<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Role;
use Validator;
use App\Penalty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LibraryRequest;

class UserController extends Controller
{
    public function index(){
        $user = Auth::user();
        $rental_history = DB::table("book_detail")
            ->leftjoin("rental", "book_detail.book_id", "=", "rental.book_id")
            ->where("rental.user_id", "=", $user->user_id)
            ->orderBy("rental.rent_date", "desc")
            ->get([ //長いけど引数無しだと上手くいかないので仕方ない
                "book_detail.book_id",
                "book_detail.image_path",
                "book_detail.book_title",
                "rental.rent_date",
                "rental.deadline",
                "rental.return_date"
                ]);   
        $renting = array();
        $rented  = array();
        foreach($rental_history as $one_rent){
            if(is_null($one_rent->return_date)){
                $renting[] = $one_rent;
            }else{
                $rented[] = $one_rent;
            }
        }
        $data = [
            "user"    => $user,
            "renting" => $renting,
            "rented"  => $rented,
        ];
        $penalty = Penalty::nowPenaltyData($user->user_id)->first();
        if(!is_null($penalty)){
            $data = array_merge($data, ["penalty" => $penalty->penalty_end]);
        }
        return view("library.users.userinfo", $data);
    }

    public function list(Request $request){
        $search = "";
        if(is_null($request->input("search"))){
            $users = User::orderBy("created_at", "desc")->paginate(10);
        }else{
            $search = $request->input("search");
            $users = User::userSearch($search)->paginate(10);
        }

        $data = [
            "users"  => $users,
            "search" => $search,
        ];
        return view("library.users.list", $data);
    }

    public function edit(Request $request){
        $item_name = $request->item_name;
        $user = Auth::user();
        if($item_name === "user_id"){
            $data = [
                "title" => "社員ID",   
                "column_value" => $user->user_id,
            ];
        }else if($item_name === "name"){
            $data = [
                "title" => "社員名",   
                "column_value" => $user->name,
            ];
        }else if($item_name === "email"){
            $data = [
                "title" => "メールアドレス",   
                "column_value" => $user->email,
            ];
        }else{
            return;
        }
        $additional_data = [
            "column_name" => $item_name,
        ];
        $data = array_merge($data, $additional_data);
        return view("library.users.edit", $data);
    }

    public function update(LibraryRequest $request){
        $validator = Validator::make(
            ["user_id" => $request->user_id],
            ["user_id" => "unique:users"], 
            ["その社員IDは既に使用されています。"]
        );
        if($validator->fails()){
            return redirect("users/edit/user_id")
            ->withErrors($validator) 
            ->withInput();
        }
        $auth = User::find($request->id);
        $form = $request->all();
        unset($form["_token"]);
        $auth->fill($form)->save();
        return redirect("/users/info");
    }

    public function passEdit(){
        return view("library.users.passedit");
    }

    public function passUpdate(LibraryRequest $request){
        $user = Auth::user();
        $passcheck = Hash::check($request->now_pass, $user->password);
        $validator = Validator::make(["now_pass" => $passcheck],
            ["now_pass" => "accepted"], ["現在のパスワードが正しくありません。"]);
        if($validator->fails()){
            return redirect("users/edit/password")
            ->withErrors($validator) 
            ->withInput();
        }

        $new_pass = Hash::make($request->new_pass);
        $auth = User::find($request->id);
        $form = ["password" => $new_pass];
        $auth->fill($form)->save();
        return redirect("/users/info");
    }

    public function penaltyEdit(Request $request){
        $user_id = $request->user_id;
        $penalty_data = Penalty::allPenaltyData($user_id)->first();
        if(is_null($penalty_data)){
            $penalty_end = "";
        }else{
            $penalty_end = $penalty_data->penalty_end;
        }
        $data = [
            "user_id"     => $user_id,
            "penalty_end" => $penalty_end,
        ];
        return view("library.users.penaltyedit", $data);
    }

    public function penaltyConfirm(LibraryRequest $request){
        $data = [
            "user_id"     => $request->user_id,
            "penalty_end" => $request->penalty_end,
        ];
        return view("library.users.penaltyconfirm", $data);
    }

    public function backFromPenaltyConfirm(LibraryRequest $request){
        $data = [
            "user_id"     => $request->user_id,
            "penalty_end" => $request->penalty_end,
        ];
        return view("library.users.penaltyedit", $data);
    }

    public function penaltyComplete(LibraryRequest $request){
        $user_id = $request->user_id;
        $penalty_id = Penalty::penaltyData($user_id)->first()->id;
        $form = ["penalty_end" => $request->penalty_end];
        Penalty::find($penalty_id)->fill($form)->save();
        return view("library.users.penaltycomplete");
    }

    public function roleChange(Request $request){
        $user_id = $request->user_id;
        $user_role = User::getUserInfo($user_id)->first()->role;
        $roles = Role::get();
        $role_rule = [];
        foreach($roles as $role){
            $role_rule[$role->role_id] = $role->role_name;
        }
        unset($role_rule[1]); // システム管理者は選択不可

        $data = [
            "user_id"   => $user_id,
            "user_role" => $user_role,
            "role_rule" => $role_rule,
        ];
        return view("library.users.rolechange", $data);
    }

    public function roleConfirm(LibraryRequest $request){
        $data = [
            "user_id" => $request->user_id,
            "role"    => Role::getRoleDataByRoleId($request->role_id)->first()->role_name,
            "role_id" => $request->role_id,
        ];
        return view("library.users.roleconfirm", $data);
    }

    public function backFromRoleConfirm(LibraryRequest $request){
        $user_id = $request->user_id;
        $roles = Role::get();
        $role_rule = [];
        foreach($roles as $role){
            $role_rule[$role->role_id] = $role->role_name;
        }
        unset($role_rule[1]); // システム管理者は選択不可

        $data = [
            "user_id"   => $user_id,
            "user_role" => $request->role_id,
            "role_rule" => $role_rule,
        ];
        return view("library.users.rolechange", $data);
    }
 
    public function roleComplete(LibraryRequest $request){
        $data = ["role" => $request->role_id];
        User::find($request->user_id)->fill($data)->save();
        return view("library.users.rolecomplete");
    }
}
