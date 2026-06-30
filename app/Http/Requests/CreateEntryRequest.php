<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateEntryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'duration' => 'required|string',
            'logDate' => 'required|date',
            'book_id' => 'nullable|string',
            'subtitle' => 'nullable|string|max:255',
            'cover_edition_key' => 'nullable|string',
        ];

        if (empty($this->book_id)) {
            $rules['title'] = 'required|string|max:255';
            $rules['author'] = 'required|string|max:255';
        } else {
            $rules['title'] = 'nullable|string|max:255';
            $rules['author'] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
