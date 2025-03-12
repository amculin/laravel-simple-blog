<?php

namespace App\Http\Requests;

use App\Models\Articles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:60',
            'content' => 'required|string',
        ];
    }

    public function convertStatus(): int
    {
        if ($this->publish_at) {
            return Article::IS_SCHEDULED;
        }

        if ($this->is_draft == 1) {
            return Articles::IS_DRAFT;
        }

        return Article::IS_ACTIVE;
    }
}
