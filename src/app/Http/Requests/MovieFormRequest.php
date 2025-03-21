<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class MovieFormRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:movies,title',
            'age_rating' => 'required|int|max:18',
            'language' => 'required|string|max:40',
            'cover_image' => ['file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'projections' => 'required|array|min:1',
            'projections.*.start_time' => 'required|date_format:Y-m-d H:i:s',
            'projections.*.available_seats' => 'required|integer|min:0|max:300',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);

        throw new ValidationException($validator, $response);
    }

}
