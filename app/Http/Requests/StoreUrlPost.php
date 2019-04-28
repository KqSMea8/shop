<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\validation\Rule;
class StoreUrlPost extends FormRequest
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
            'url_name'=>[
                'required',
                'regex:/^[A-za-z0-9_\x{4e00}-\x{9fa5}]+$/u',
                Rule::unique('url')->ignore(Request()->id,'id'),
            ],
            'url'=>[
                'required',
                'regex:/^www+(\.)+\w+(\.)+com$/',
            ],

        ];
    }
    public function messages()
    {
        return  [
            'url_name.required'=>'网址名称不能为空',
            'url_name.regex'=>'中文字母数字下划线',
            'url_name.unique'=>'网站名称已存在',
            'url.required'=>'网址不能为空',
            'url.regex'=>'例如www.ai.com',
        ];


    }
}
