<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => $this->isMethod('post')
                ? ['required', 'string', 'max:255']
                : ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['sometimes', 'required', Rule::enum(TaskStatus::class)],
        ];
    }
}
