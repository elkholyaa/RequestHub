<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * The StoreRequestRequest validates request form submissions.
 * 
 * This class defines the validation rules and authorization logic
 * for creating and updating requests.
 */
class StoreRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Users are authorized via middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:service,maintenance',
            'priority' => 'required|in:low,medium,high',
            'status' => 'nullable|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ];
    }
}
