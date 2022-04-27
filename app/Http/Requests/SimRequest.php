<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimRequest extends FormRequest
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
            'sim' => 'required|min:60|max:63|starts_with:https://www.raidbots.com/simbot/report/'
        ];
    }
}
