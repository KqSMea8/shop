<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\validation\Rule;

class StoreUserPost extends FormRequest
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
            'name'=>[
                'required',
                'max:15',
                'min:2',
                'regex:/^[A-za-z0-9_\x{4e00}-\x{9fa5}]+$/u',
                // Rule::unique('user')->ignore(Request()->id,id),
            ],
            'pwd'=>'required|min:6|max:12|alpha_dash',
            'repwd'=>'required|same:pwd',
            'age'=>'required|max:2',
        ];
    }
    public function messages()
    {
        return  [
            'name.required'=>'用户名不能为空',
            'name.max'=>'用户名最大长度15位',
            'name.min'=>'用户名最小长度为2位',
            'name.regex'=>'用户名的格式为数字字母下滑线',
            'pwd.required'=>'密码不能为空',
            'pwd.min'=>'密码长度最少6位',
            'pwd.max'=>'密码长度最大12位',
            'pwd.alpha_dash'=>'密码可以是字母和数字，以及破折号和下划线。',
            'age.required'=>'年龄不能为空',
            'repwd.required'=>'确认密码不能为空',
            'repwd.same'=>'确认密码和密码不一致',
            'age.max'=>'年龄最大不能超过两位',

        ];


    }
}
