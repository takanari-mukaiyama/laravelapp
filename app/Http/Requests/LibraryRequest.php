<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibraryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "user_id"         => "sometimes|integer|required|max:11",
            "name"            => "sometimes|required|string|max:255",
            "email"           => "sometimes|required|email|max:255|unique:users",
            "book_title"      => "sometimes|required|max:255",
            "book_detail"     => "max:1000",
            "book_number"     => "sometimes|required|integer|between:0,99",
            "add_book_number" => "sometimes|required|integer|between:0,99",
            "news_title"      => "sometimes|required|max:255",
            "section"         => "sometimes|required|max:1000",
            "new_pass"        => "sometimes|required|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|min:8|max:30|confirmed",
            "penalty_end"     => "sometimes|date_format:Y-m-d H:i:s",
            "role_id"         => "sometimes|required|in:5,10",
        ];
    }

    public function messages()
    {
        return [
        "user_id.required"         => "社員IDを入力してください。",
        "user_id.integer"          => "社員IDは数字で入力してください。",
        "user_id.max"              => "社員IDは11字以内で入力してください。",
        "user_id.unique"           => "既に登録済みのユーザーと社員IDが重複しています",
        "name.required"            => "社員名を入力してください。",
        "name.string"              => "社員名には文字列を入力してください。",
        "name.max"                 => "社員名は255字以内で入力してください。",
        "email.required"           => "メールアドレスを入力してください。",
        "email.email"              => "メールアドレス形式で入力してください。",
        "email.max"                => "メールアドレスは255字以内で入力してください。",
        "email.unique"             => "そのメールアドレスは既に使用されています。",
        "book_title.required"      => "タイトルを入力してください。",
        "book_title.max"           => "タイトルは255字以内で入力してください。",
        "book_detail.max"          => "詳細は1000字以内で入力してください。",
        "book_number.required"     => "書籍数を入力してください。",
        "book_number.integer"      => "書籍数は整数で入力してください。",
        "book_number.between"      => "書籍数は0～99の間で入力してください。",
        "add_book_number.required" => "書籍数を入力してください。",
        "add_book_number.integer"  => "書籍数は整数で入力してください。",
        "add_book_number.between"  => "書籍数は0～99の間で入力してください。",
        "news_title.required"      => "タイトルを入力してください。",
        "news_title.max"           => "タイトルは255字以内入力してください。",
        "section.required"         => "詳細を入力してください。",
        "section.max"              => "詳細は1000字以内で入力してください。",
        "new_pass.required"        => "新しいパスワードを入力してください。",
        "new_pass.regex"           => "パスワードは大文字、小文字、数字、記号を使用してください。",
        "new_pass.min"             => "新しいパスワードは8字以上で入力してください。",
        "new_pass.max"             => "新しいパスワードは30字以内で入力してください。",
        "new_pass.confirmed"       => "パスワードが一致しません。",
        "penalty_end.date_format"  => "正しいフォーマットで入力してください。",
        "role_id.required"         => "権限を選択してください",
        "role_id.in"               => "権限の値が不正です",
        ];
    }
}
