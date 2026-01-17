<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnimalUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $animal = $this->route('animal');
        return $this->user() && $this->user()->can('update', $animal);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'species' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:Lost,In Adoption'],
            'city' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'image' => ['nullable', 'image', 'max:4096', 'mimes:jpeg,jpg,png,gif'],
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
            'name.required' => 'El nombre es obligatorio.',
            'species.required' => 'La especie es obligatoria.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado debe ser "Perdido" o "En Adopción".',
            'city.required' => 'La ciudad es obligatoria.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.max' => 'La imagen no puede superar 4MB.',
            'latitude.between' => 'La latitud debe estar entre -90 y 90.',
            'longitude.between' => 'La longitud debe estar entre -180 y 180.',
        ];
    }
}
