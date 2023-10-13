<?php

namespace App\Http\Requests\Tasks;

use App\Enums\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->type == UserTypeEnum::ADMIN->value;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'assignee' => ['required', Rule::exists('users', 'id')->where('type', UserTypeEnum::USER->value)],
        ];
    }
}
