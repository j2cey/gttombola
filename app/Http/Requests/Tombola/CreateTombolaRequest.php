<?php

namespace App\Http\Requests\Tombola;

use App\Models\Tombola;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

class CreateTombolaRequest extends FormRequest
{
    use RequestTraits;
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
        return Tombola::createRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return Tombola::messagesRules();
    }
}
