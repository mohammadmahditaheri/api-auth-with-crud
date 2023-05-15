<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'user_id' => 'filled',
            'title' => [
                'required',
                'string',
                'max:100'
            ],
            'body' => [
                'required',
                'string'
            ]
        ];

        if ($this->routeIs('articles.update')) {
            unset($rules['user_id']);
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        if ($this->routeIs('articles.store')) {
            $this->merge([
                'user_id' => $this->user()->id
            ]);
        }
    }
}
