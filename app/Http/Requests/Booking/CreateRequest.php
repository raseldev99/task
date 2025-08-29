<?php

namespace App\Http\Requests\Booking;

use App\Enums\ServiceStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'service_id' => ['required', Rule::exists('services', 'id')->where(function ($query) {
                return $query->where('status', ServiceStatus::Published());
            })],
            'booking_date' => 'required|date:Y-m-d|after_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            'booking_date.after_or_equal' => 'You cannot book a service on a past date.',
        ];
    }
}
