<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'content' => 'required|string|min:150|max:550',
            'rating' => 'required|integer|between:1,10',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'ID пользователя обязательно для заполнения.',
            'user_id.exists' => 'Пользователь с указанным ID не существует.',

            'company_id.required' => 'ID компании обязательно для заполнения.',
            'company_id.exists' => 'Компания с указанным ID не существует.',

            
            'content.required' => 'Содержание обязательно для заполнения.',
            'content.string' => 'Содержание должно быть строкой.',
            'content.min' => 'Содержание должно состоять не менее чем из 150 символов.',
            'content.max' => 'Содержание должно состоять не более чем из 400 символов.',

            
            'rating.required' => 'Оценка обязательно для заполнения.',
            'rating.integer' => 'Оценка должна быть целым числом.',
            'rating.between' => 'Оценка должна находиться в диапазоне от 1 до 10.',
        ];
    }
}
