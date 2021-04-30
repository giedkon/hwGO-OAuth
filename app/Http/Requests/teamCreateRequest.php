<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class teamCreateRequest extends FormRequest
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
            'instance_id' => 'required|exists:instances,id',
            'name' => 'required|max:255|string',
            'tag' => 'required|max:32|string',
            'flag' => 'nullable|max:2|string',
            'logo' => 'nullable',
        ];
    }
}
