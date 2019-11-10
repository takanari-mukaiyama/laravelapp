<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register/complete';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $custom_error_msg = [
            "user_id.required"   => "社員IDを入力してください。",
            "user_id.integer"    => "社員IDは数字で入力してください。",
            "user_id.max"        => "社員IDは11字以内で入力してください。",
            "user_id.unique"     => "その社員IDは既に使用されています。",
            "name.required"      => "社員名を入力してください。",
            "name.string"        => "社員名には文字列を入力してください。",
            "name.max"           => "社員名は255字以内で入力してください。",
            "email.required"     => "メールアドレスを入力してください。",
            "email.email"        => "メールアドレス形式で入力してください。",
            "email.max"          => "メールアドレスは255字以内で入力してください。",
            "email.unique"       => "そのメールアドレスは既に使用されています。",
            "password.required"  => "パスワードを入力してください。",
            "password.regex"     => "パスワードは大文字、小文字、数字、記号を使用してください。",
            "password.min"       => "パスワードは8字以上で入力してください。",
            "password.max"       => "パスワードは30字以内で入力してください。",
            "password.confirmed" => "パスワードが一致しません",
        ];
        return Validator::make($data, [
            'user_id' => ['required', 'integer', 'max:11', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/', 'min:8', 'max:30', 'confirmed'],
        ], $custom_error_msg);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_id' => $data['user_id'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
