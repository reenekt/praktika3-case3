<?php

namespace App\Http\Requests;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var Task $task */
        $task = $this->route('task');

        return auth()->check() && $task && auth()->user()->can('update', $task);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string'],
            'description_content' => ['sometimes', 'required', 'string'],
            'status' => ['sometimes', 'required', new Enum(TaskStatusEnum::class)],
            'assignee_id' => ['sometimes', 'nullable', Rule::exists(User::class, 'id')],
            'deadline_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
