<?php

namespace App\Http\Requests\Back;

use App\Rules\Slug;
use Illuminate\Foundation\Http\FormRequest;

class FormationRequest extends FormRequest
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
        $id = $this->method() === 'PUT' ? ',' . basename($this->url()) : '';

        return $rules = [
            'libelle'       => 'required|max:255|unique:cactus_formations',
            'description'   => 'required',
            'photo'         => 'mimes:jpeg,jpg,png,gif|max:10000'
            # 'photo'     => 'required',
            # 'slug'        => ['required', 'max:255', new Slug, 'unique:cactus_formations,slug' . $id],
        ];
    }
}
