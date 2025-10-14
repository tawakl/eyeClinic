<?php

declare(strict_types = 1);

namespace App\Modules\Users\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['language'] = 'nullable';


        $rules['first_name'] = 'required|regex:/^[\pL\s\d]+$/u|max:191|min:3';
        $rules['last_name'] = 'required|regex:/^[\pL\s\d]+$/u|max:191|min:3';


        $rules['email'] = [
            'required',
            'email',
            Rule::unique('users')->ignore(auth()->user()->id)->where(
                function ($query) {
                    return $query->where('deleted_at', null);
                }
            )->ignore(auth()->id()),
        ];
        $rules['password'] = 'nullable|min:8|confirmed';
        $rules['old_password'] = 'required_with:password';


        if (auth()->user()->email != $this->email) {
            $rules['old_password'] = 'required|min:8';
        }

        return $rules;
    }
}
