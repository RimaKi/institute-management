<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEnrollmentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'openCourseId'=>['required','exists:open_courses,id'],
            'studentId'=>['required','exists:students,id'],
            'paidAt'=>['date']
        ];
    }
}
