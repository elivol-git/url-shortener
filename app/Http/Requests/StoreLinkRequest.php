<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreLinkRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => $this->slug? Str::slug($this->slug) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'target_url' => ['required', 'url'],
            'slug' => ['unique:links','max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'target_url' => 'Target URL',
            'slug' => 'Slug'
        ];
    }
}
