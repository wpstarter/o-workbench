<?php

namespace Orchestra\Workbench\Http\Requests;

use WpStarter\Contracts\Validation\ValidationRule;
use WpStarter\Foundation\Auth\User;
use WpStarter\Foundation\Http\FormRequest;
use WpStarter\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}
