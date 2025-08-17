<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
        'title' => ['required', 'string', 'max:255'],
        'text' => ['required', 'string', 'min:10', 'max:1000'],
    ];
    }
}
