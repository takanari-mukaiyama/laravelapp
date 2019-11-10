<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LibraryRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Book;
use App\User;
use Validator;
use App\Rental;
use App\Penalty;
use Carbon\Carbon;

class LibraryBookController extends Controller
{
    public function index(Request $request){
        $search = "";
        if(!is_null($request->input("search"))){
            $search = $request->input("search");
            $books = Book::searchBooks($search)->paginate(10);
        }else{
            $books = Book::orderBy("book_id", "desc")->paginate(10);
        }
        $data = [
            "books"  => $books,
            "search" => $search,
        ];
        return view("library.book.list", $data);
    }

    public function add(){
        return view("library.book.add");
    }

    public function addConfirm(LibraryRequest $request){
        $data = [
            "book_title"     => $request->book_title,
            "book_detail"    => $request->book_detail,
            "book_number"    => $request->book_number,
        ];

        if(isset($request->back_flag)){ // 確認画面からの戻りだったら
            $additional_data = [
                "back_flag"      => $request->back_flag,
                "read_temp_path" => $request->read_temp_path,
            ];
            $data = array_merge($data, $additional_data);
            return view("library.book.add", $data);
        }

        $image_file = $request->file("image_file");
        if(!is_null($image_file)){
            $temp_path = $image_file->store("public/temp");
            $read_temp_path = str_replace("public/", "storage/", $temp_path);
            $path_arr = [
            "temp_path"      => $temp_path,
            "read_temp_path" => $read_temp_path,
            ];
            $data = array_merge($data, $path_arr);
        }else if(isset($request->before_image_file)){
            $read_temp_path = $request->before_image_file;
            $temp_path = str_replace("storage/", "public/", $read_temp_path);
            $path_arr = [
            "temp_path"      => $temp_path,
            "read_temp_path" => $read_temp_path,
            ];
            $data = array_merge($data, $path_arr);
        }
        return view("library.book.addcheck", $data);
    }

    public function create(LibraryRequest $request){
        $book = new Book;
        $book->book_title = $request->book_title;
        $book->book_detail = $request->book_detail;
        if(isset($request->temp_path)){
            $temp_path = $request->temp_path;
            $imgfilename = str_replace("public/temp/", "", $temp_path);
            $storage_path = "public/bookimage/".$imgfilename;
            Storage::move($temp_path, $storage_path);
            $read_path = str_replace("public/", "storage/", $storage_path);
            $book->image_path = $read_path;
        }
        $book->save();
        $book_data = Book::where("book_title", $request->book_title)->first();
        for($i=0; $i<$request->book_number*1; $i++){
            $param = [
                "book_id"     => $book_data["book_id"],
                "book_number" => $i,
            ];
            DB::table("books")->insert($param);
        }
        $request->session()->regenerateToken();
        return view("library.book.addcomplete");
    }

    public function detail(Request $request){
        $book_info = Book::find($request->id);
        if(is_null($book_info)){
            return redirect("/book/detail");
        }
        //HACK : DB設計を見直してLEFT JOINに頼らない形にし、モデルでやりたい 
        $rental_history = DB::table("books") 
            ->leftjoin("rental", function($join){
                $join->on("books.book_id", "=", "rental.book_id");
                $join->on("books.book_number", "=", "rental.book_number");
            })
            ->where("books.book_id", "=", $request->id)
            ->get(["books.book_number", "rental.deadline", "rental.return_date"]);
        $rental_info = [];
        foreach($rental_history as $rental){
            $rental_info[$rental->book_number] = [
                "deadline"    => $rental->deadline,
                "return_date" => $rental->return_date,
            ];   
        }
        $data = [
            "book_info" => $book_info,
            "rental_info" => $rental_info,
        ];
        return view("library.book.detail", $data);
    }

    public function rent(Request $request){
        $book_exists = DB::table("books")
            ->where("book_id", "=", $request->book_id)
            ->where("book_number", "=", $request->book_number)
            ->exists();
        if(!$book_exists){
            return redirect("library/book/rent");
        }
        $book_info = Book::find($request->book_id);
        if(is_null($book_info)){
            return redirect("library/book/rent");
        }
        $data = [
            "book_id"     => $request->book_id,
            "book_number" => $request->book_number,
            "book_title"  => $book_info->book_title,
        ];
        return view("library.book.rent", $data);
    }

    public function rentConfirm(LibraryRequest $request){
        $already_rent = Rental::nowRentalData($request)->exists();
        if($already_rent){
            $can_rent = false;
        }
        $now_penalty = Penalty::nowPenaltyData($request->user_id)->exists();
        if($now_penalty){
            $no_penalty = false;
        }
        $validator = Validator::make(
            ["can_rent"    => !$already_rent,
             "no_penalty"  => !$now_penalty,
            ],
            ["can_rent"    => "accepted",
             "no_penalty"  => "accepted",
            ],
            ["can_rent.accepted" => "この本は既に貸し出されています",
             "no_penalty.accepted" => "この社員は現在ペナルティ期間中の為、本を貸し出せません",
            ]
        );
        if($validator->fails()){
            return redirect("/book/rent/$request->book_id/$request->book_number")
            ->withErrors($validator)
            ->withInput();
        }
        $data = [
            "user_id"     => $request->user_id,
            "book_id"     => $request->book_id,
            "book_title"  => $request->book_title,
            "book_number" => $request->book_number,
        ];
        if(isset($request->back_flag)){ // 確認画面からの戻りだったら
            $data = array_merge($data, ["back_flag" => $request->back_flag]);
            return view("library.book.rent", $data);
        }
        $user = User::where("user_id", $request->user_id)->first();
        $data = array_merge($data, array("name" => $user["name"]));
        return view("library.book.rentcheck", $data);
    }

    public function rentUpdate(LibraryRequest $request){
        $data = [
            "user_id"     => $request->user_id,
            "book_id"     => $request->book_id,
            "book_number" => $request->book_number,
            "rent_date"   => date("Y-m-d H:i:s"),
            "deadline"    => date("Y-m-d H:i:s", strtotime("+7 day")),
        ];
        $rental = new Rental;
        $rental->fill($data)->save();
        $request->session()->regenerateToken();
        return view("library.book.rentcomplete", $data);
    }

    public function returnBook(Request $request){
        $rental_info = Rental::nowRentalData($request)->first();
        if(is_null($rental_info)){ //本が存在しないか返却済み
            return redirect("library/book/detail");
        }
        $book_info = Book::find($request->book_id);
        if(is_null($book_info)){ //本が存在しない
            return redirect("library/book/detail");
        }
        $name = User::getUserName($rental_info->user_id);
        $deadline = new Carbon($rental_info->deadline);
        $current_time = new Carbon(date("Y-m-d H:i:s"));
        $over_deadline_flag = 0;
        if($current_time > $deadline){
            $over_deadline_flag = 1;
        }
        $data = [
            "user_id"            => $rental_info->user_id,
            "name"               => $name,
            "book_id"            => $rental_info->book_id,
            "book_number"        => $rental_info->book_number,
            "book_title"         => $book_info->book_title,
            "deadline"           => $deadline,
            "over_deadline_flag" => $over_deadline_flag,
        ];
        return view("library.book.return", $data);
    }

    public function returnUpdate(Request $request){
        $return_date = ["return_date" => date("Y-m-d H:i:s")];
        $rent_data = Rental::nowRentalData($request)->first();
        $id = $rent_data->id;
        $rental = Rental::find($id);
        $rental->fill($return_date)->save();    

        $deadline = new Carbon($rent_data->deadline);
        $current_time = new Carbon(date("Y-m-d H:i:s"));
        if($current_time <= $deadline){
            return view("library.book.returncomplete", ["book_id" => $request->book_id]);
        }
        
        $now_penalty = Penalty::nowPenaltyData($rent_data->user_id)->first();
        if(is_null($now_penalty)){
            Penalty::oldPenaltyData($rent_data->user_id)->delete();
            $new_penalty = new Penalty;
            $penalty_end = new Carbon(date("Y-m-d H:i:s"));
        }else{
            $new_penalty = Penalty::find($now_penalty->id);
            $penalty_end = new Carbon($now_penalty->penalty_end);
        }

        $penalty_end->addSeconds($current_time->diffInSeconds($deadline));

        $data = [
            "user_id"     => $rent_data->user_id,
            "penalty_end" => $penalty_end->format("Y-m-d H:i:s"),
        ]; 
        $new_penalty->fill($data)->save();
        return view("library.book.returncomplete", ["book_id" => $request->book_id]);
    }
  
    public function edit(Request $request){
        $book_info = Book::find($request->book_id);
        $data = [
            "book_id"     => $request->book_id,
            "book_title"  => $book_info->book_title,
            "book_detail" => $book_info->book_detail,
            "image_path"  => $book_info->image_path,
        ];
        return view("library.book.edit", $data);
    }

    public function editConfirm(LibraryRequest $request){
        $data = [
            "book_id"         => $request->book_id,
            "book_title"      => $request->book_title,
            "book_detail"     => $request->book_detail,
            "add_book_number" => $request->add_book_number,
        ];

        if(isset($request->back_flag)){ // 確認画面からの戻りだったら
            $additional_data = [
                "back_flag"      => $request->back_flag,
                "read_temp_path" => $request->read_temp_path,
            ];
            if(isset($request->current_image_file)){
                $additional_data = array_merge($additional_data, [
                    "current_image_file" => $request->current_image_file,
                ]);
            }
            $data = array_merge($data, $additional_data);
            return view("library.book.edit", $data);
        }

        $image_file = $request->file("image_file");
        if(!is_null($image_file)){ // 画像選択済 or 画像選択後「戻る」押下
            $temp_path = $image_file->store("public/temp");
            $read_temp_path = str_replace("public/", "storage/", $temp_path);
            $path_arr = [
                "temp_path"      => $temp_path,
                "read_temp_path" => $read_temp_path,
            ];
            $data = array_merge($data, $path_arr);
        }else if(isset($request->before_image_file)){ // 前回画像選択後「戻る」押下＆今回画像未選択
            $read_temp_path = $request->before_image_file;
            $temp_path = str_replace("storage/", "public/", $read_temp_path);
            $path_arr = [
            "temp_path"      => $temp_path,
            "read_temp_path" => $read_temp_path,
            ];
            $data = array_merge($data, $path_arr);
        }else if(isset($request->current_image_file)){ // 画像未選択＆既に登録済みの画像有
            $data = array_merge($data, ["current_image_file" => $request->current_image_file]);
        }
        return view("library.book.editcheck", $data);
    }

    public function update(LibraryRequest $request){
        $book = Book::find($request->book_id);
        $book->book_title = $request->book_title;
        $book->book_detail = $request->book_detail;
        if(isset($request->temp_path)){
            $temp_path = $request->temp_path;
            $imgfilename = str_replace("public/temp/", "", $temp_path);                       
            $storage_path = "public/bookimage/".$imgfilename;                                 
            Storage::move($temp_path, $storage_path);
            $read_path = str_replace("public/", "storage/", $storage_path);                   
            $book->image_path = $read_path;
        }
        $book->save();
        $book_max_number = DB::table("books")
            ->where("book_id", $request->book_id)
            ->max("book_number");
        for($i=0; $i<$request->add_book_number*1; $i++){
            $param = [
                "book_id"     => $request->book_id,
                "book_number" => $book_max_number + $i + 1,
            ];
            DB::table("books")->insert($param);
        }
        $request->session()->regenerateToken();
        return view("library.book.editcomplete", ["book_id" => $request->book_id]);
    }

    public function delete(Request $request){
        $book_info = Book::find($request->book_id);
        $data = [
            "book_id" => $request->book_id,
            "book_title" => $book_info->book_title,
            "book_detail" => $book_info->book_detail,
        ];
        if(isset($request->book_number)){
            $data = array_merge($data, ["book_number" => $request->book_number]);
        }
        return view("library.book.delete", $data);
    }

    public function remove(LibraryRequest $request){
        if(isset($request->book_number)){
            DB::table("books")
                ->where("book_id", $request->book_id)
                ->where("book_number", $request->book_number)
                ->delete();
        $all_delete_flag = 0;
        }else{
            Book::find($request->book_id)->delete();
            DB::table("books")
                ->where("book_id", $request->book_id)
                ->delete();
        $all_delete_flag = 1;
        }
        $request->session()->regenerateToken();
        $data = [
            "all_delete_flag" => $all_delete_flag,
            "book_id"         => $request->book_id,
        ];
        return view("library.book.deletecomplete", $data);
    }
}
