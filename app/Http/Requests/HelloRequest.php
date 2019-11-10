<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HelloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->path() == "hello"){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required",
            "mail" => "email",
            "age"  => "integer|hello",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "名前を入力してください",
            "mail.email"    => "メールアドレス形式で入力してください",
            "age.integer"   => "年齢は整数で入力してください",
            "age.hello"     => "Hello! 入力は偶数のみ受け付けるゾ",
        ];
    }
}
