<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'category_id' => ['required', 'integer', Rule::exists((new Category())->getTable(), 'id')],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название товара обязательно.',
            'price.required' => 'Цена обязательна.',
            'price.min' => 'Цена должна быть больше 0.',
            'category_id.required' => 'Категория обязательна.',
            'category_id.exists' => 'Выбранная категория не существует.',
        ];
    }
}