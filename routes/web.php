<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


#Auth::routes();

//システム管理者のみアクセス可能
Route::group(["middleware" => ["auth", "can:system-only"]], function(){

});

//管理者のみアクセス可能
Route::group(["middleware" => ["auth", "can:admin-higher"]], function(){
    Route::get("/book/add", "LibraryBookController@add")
        ->middleware("auth");
    Route::post("/book/add", "LibraryBookController@addConfirm")
        ->middleware("auth");
    Route::post("/book/add/complete", "LibraryBookController@create")
        ->middleware("auth");
    Route::get("/book/rent/{book_id}/{book_number}", "LibraryBookController@rent")
        ->middleware("auth");
    Route::post("/book/rent/{book_id}/{book_number}", "LibraryBookController@rentConfirm")
        ->middleware("auth");
    Route::post("/book/rent/complete", "LibraryBookController@rentUpdate")
        ->middleware("auth");
    Route::get("/book/return/{book_id}/{book_number}", "LibraryBookController@returnBook")
        ->middleware("auth");
    Route::post("/book/return/complete", "LibraryBookController@returnUpdate")
        ->middleware("auth");
    Route::get("/book/edit/{book_id}", "LibraryBookController@edit")
        ->middleware("auth");
    Route::post("/book/edit/complete", "LibraryBookController@update")
        ->middleware("auth");
    Route::post("/book/edit/{book_id}", "LibraryBookController@editConfirm")
        ->middleware("auth");
    Route::get("/book/delete/{book_id}/{book_number?}", "LibraryBookController@delete")
        ->middleware("auth");
    Route::post("/book/delete/complete", "LibraryBookController@remove")
        ->middleware("auth");
    
    Route::get("news/add", "LibraryNewsController@add")
        ->middleware("auth");
    Route::post("news/add", "LibraryNewsController@backFromAddConfirm")
        ->middleware("auth");
    Route::post("news/add/confirm", "LibraryNewsController@addConfirm")
        ->middleware("auth");
    Route::post("news/add/complete", "LibraryNewsController@addComplete")
        ->middleware("auth");
    Route::get("news/edit/{id}", "LibraryNewsController@edit")
        ->where("id", "[0-9]+")
        ->middleware("auth");
    Route::post("news/edit/{id}", "LibraryNewsController@backFromEditConfirm")
        ->where("id", "[0-9]+")
        ->middleware("auth");
    Route::post("news/edit/confirm", "LibraryNewsController@editConfirm")
        ->middleware("auth");
    Route::post("news/edit/complete", "LibraryNewsController@editComplete")
        ->middleware("auth");
    Route::get("news/delete/{id}", "LibraryNewsController@delete")
        ->where("id", "[0-9]+")
        ->middleware("auth");
    Route::post("news/delete/complete", "LibraryNewsController@remove")
        ->middleware("auth");

    Route::get("users/penalty/edit/{user_id}", "UserController@penaltyEdit")
        ->where("user_id", "[0-9]+")
        ->middleware("auth");
    Route::post("users/penalty/edit", "UserController@backFromPenaltyConfirm")
        ->middleware("auth");
    Route::post("users/penalty/edit/confirm", "UserController@penaltyConfirm")
        ->middleware("auth");
    Route::post("users/penalty/edit/complete", "UserController@penaltyComplete")
        ->middleware("auth");
    Route::get("users/list", "UserController@list")
        ->middleware("auth");
    Route::get("users/role/change/{user_id}", "UserController@roleChange")
        ->where("user_id", "[0-9]+")
        ->middleware("auth");
    Route::post("users/role/change/{user_id}", "UserController@backFromRoleConfirm")
        ->where("user_id", "[0-9]+")
        ->middleware("auth");
    Route::post("users/role/confirm", "UserController@roleConfirm")
        ->middleware("auth");
    Route::post("users/role/complete", "UserController@roleComplete")
        ->middleware("auth");
});

//全権限でアクセス可能
Route::group(["middleware" => ["auth", "can:user-higher"]], function(){
    Route::get("register/complete", "LibraryController@registerComplete")
        ->middleware("auth");
    Route::get("/", "LibraryController@index")
        ->middleware("auth");
    Route::get("users/info", "UserController@index")
        ->middleware("auth");
    Route::get("users/edit/password", "UserController@passEdit")
        ->middleware("auth");
    Route::post("users/update", "UserController@update")
        ->middleware("auth");
    Route::post("users/update/password", "UserController@passUpdate")
        ->middleware("auth");
    Route::get("users/edit/{item_name}", "UserController@edit")
        ->middleware("auth");
    
    Route::get("/book", "LibraryBookController@index")
        ->middleware("auth");
    Route::get("/book/detail/{id}", "LibraryBookController@detail")
        ->middleware("auth");
    
    Route::get("news", "LibraryNewsController@index")
        ->middleware("auth");
    Route::get("news/detail/{id}", "LibraryNewsController@detail")
        ->where("id", "[0-9]+");

});
//Route::get("welcome", function(){return view("welcome");});                            // トップページ

Route::get('users/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('users/login', 'Auth\LoginController@login');
Route::post('users/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('users/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('users/register', 'Auth\RegisterController@register');

//Route::get('users/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//Route::post('users/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::get('users/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//Route::post('users/password/reset', 'Auth\ResetPasswordController@reset');
    

//Route::get("person", "PersonController@index");
//Route::get("person/find", "PersonController@find");
//Route::post("person/find", "PersonController@search");
//Route::get("person/add", "PersonController@add");
//Route::post("person/add", "PersonController@create");
//Route::get("person/edit", "PersonController@edit");
//Route::post("person/edit", "PersonController@update");
//Route::get("person/del", "PersonController@del");
//Route::post("person/del", "PersonController@remove");
//Route::get("board", "BoardController@index");
//Route::get("board/add", "BoardController@add");
//Route::post("board/add", "BoardController@create");
//Route::resource("rest", "RestappController");
//Route::get("hello/rest", "HelloController@rest");
//Route::get("hello", "HelloController@index")
//    ->middleware("auth");
//Route::get("hello/session", "HelloController@ses_get");
//Route::post("hello/session", "HelloController@ses_put");
//Route::get("hello/auth", "HelloController@getAuth");
//Route::post("hello/auth", "HelloController@postAuth");
//Route::get()                                                           // 新着情報追加完了



//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
