<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'first_name' => 'required|string|min:4|max:39',
            'last_name' => 'required|string|min:4|max:39',
            'phone_number' => 'required|string|unique:users,phone_number|regex:/^\+7[0-9]{10}$/',
            'avatar' => 'required|image|mimes:jpg,png|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Имя обязательно для заполнения.',
            'first_name.string' => 'Имя должно быть строкой.',
            'first_name.min' => 'Имя должно состоять более чем из 3 символов.',
            'first_name.max' => 'Имя должно состоять менее чем из 40 символов.',

            'last_name.required' => 'Фамилия обязательна для заполнения.',
            'last_name.string' => 'Фамилия должна быть строкой.',
            'last_name.min' => 'Фамилия должна состоять более чем из 3 символов.',
            'last_name.max' => 'Фамилия должна состоять менее чем из 40 символов.',

            'phone_number.required' => 'Номер телефона обязателен для заполнения.',
            'phone_number.string' => 'Номер телефона должен быть строкой.',
            'phone_number.unique' => 'Такой номер телефона уже используется другим пользователем.',
            'phone_number.regex' => 'Номер телефона должен иметь формат +7XXXXXXXXXX.',
            
            'image.required' => 'Изображение обязательно для загрузки.',
            'image.image' => 'Файл должен быть изображением.',
            'image.mimes' => 'Поддерживаются только форматы PNG и JPG.',
            'image.max' => 'Максимальный размер изображения должен быть 2 МБ.',
        ];
    }
}
