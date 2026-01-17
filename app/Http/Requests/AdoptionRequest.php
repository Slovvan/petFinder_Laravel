<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdoptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $animal = $this->route('animal');
        return $this->user() && $this->user()->can('adopt', $animal);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'min:10', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'message.required' => 'El mensaje es requerido.',
            'message.min' => 'El mensaje debe tener al menos 10 caracteres.',
            'message.max' => 'El mensaje no puede exceder 1000 caracteres.',
        ];
    }
}
