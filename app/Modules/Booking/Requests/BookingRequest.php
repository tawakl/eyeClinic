<?php

declare(strict_types = 1);
namespace App\Modules\Booking\Requests;
use App\Modules\BaseApp\Api\Requests\BaseApiParserRequest;

class BookingRequest extends BaseApiParserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'attributes.name' => 'required|string|max:255',
            'attributes.phone' => [
                'required',
                'regex:/^(\+?\d{10,15})$/'
            ],
            'attributes.email' => 'nullable|email|max:255',
            'attributes.insurance_number' => 'nullable|string|max:50',
            'attributes.booking_date' => 'required|date|after_or_equal:today',
            'attributes.booking_time' => 'nullable|date_format:H:i',
            'attributes.notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => trans('booking.name is required'),
            'phone.required' => trans('booking.phone number is required'),
            'phone.regex' => trans('booking.invalid phone number format'),
            'date.required' => trans('booking.date is required'),
            'date.after_or_equal' => trans('booking.date cannot be in the past'),
            'time.required' => trans('booking.time is required'),
        ];
    }
}
