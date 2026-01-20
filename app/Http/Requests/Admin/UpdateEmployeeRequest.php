<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($employeeId),
            ],
            'phone_number' => ['nullable', 'string', 'max:30'],
            // اختياري بالتعديل
            'password' => ['nullable', 'string', 'min:8'],
        ];
    }
}
