<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PhpParser\Node\NullableType;

class PostRequest extends FormRequest
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
     * 新規投稿のバリデーション
     */
    public function rules()
    {
        return [
            'title' =>['required', 'string', 'max:'. config('validation.title.MAX')],
            'content' => ['required', 'string', 'max:'.config('validation.content.MAX')],
            'images[]' => ['max:'. config('validation.images.MAX'), 'nullable' ],
        ];
    }

    /**
     * 新規投稿のエラーメッセージ
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'タイトルは必ず入力してください。',
            'title.string' => 'タイトルは必ず文字列で入力してください',
            'title.max' => 'タイトルは50文字以下にしてください',
            'content.required' => '本文は必ず入力してください。',
            'content.string' => '本文は必ず文字列で入力してください',
            'content.max' => '本文は5000文字以下にして下さい',
            'images[].max' => '画像は10GBにしてください',
        ];
    }
}
