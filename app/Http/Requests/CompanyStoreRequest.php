<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
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
            'name' => 'required|string|min:4|max:39',
            'description' => 'required|string|min:150|max:400', 
            'logo' => 'required|image|mimes:png|max:3072',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Название компании обязательно для заполнения.',
            'name.string' => 'Название компании должно быть строкой.',
            'name.min' => 'Название компании должно состоять более чем из 3 символов.',
            'name.max' => 'Название компании должно состоять менее чем из 40 символов.',

            'description.required' => 'Описание обязательно для заполнения.',
            'description.string' => 'Описание должно быть строкой.',
            'description.min' => 'Описание должно состоять не менее чем из 150 символов.',
            'description.max' => 'Описание должно состоять не более чем из 400 символов.',

            'logo.required' => 'Изображение обязательно для загрузки.',
            'logo.image' => 'Файл должен быть изображением.',
            'logo.mimes' => 'Поддерживается только формат PNG.',
            'logo.max' => 'Максимальный размер изображения должен быть 3 МБ.',
        ];
    }
}
