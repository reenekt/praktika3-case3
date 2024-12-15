<?php

namespace App\Http\Requests;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('create', Task::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description_content' => ['required', 'string'],
            'status' => ['required', new Enum(TaskStatusEnum::class)],
            'author_id' => ['required', Rule::exists(User::class, 'id')],
            'assignee_id' => ['nullable', Rule::exists(User::class, 'id')],
            'deadline_at' => ['nullable', 'date'],
        ];
    }
}
