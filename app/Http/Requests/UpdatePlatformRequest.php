<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlatformRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:platforms,name,' . $this->platform->id . '|max:255',
            'type' => 'required|string|unique:platforms,type,' . $this->platform->id . '|max:255',
            'max_post_words_count' => 'nullable|integer|min:0',
            'allow_post_without_image' => 'nullable',
        ];
    }
}
