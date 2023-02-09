<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'name' => 'required|string',
            'description' => 'nullable',
            'start_date' => 'required|date',
            'end_date'=>'nullable|date|after:start_date',
            'recurrence_type' => 'required',
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'recurrence_type.required' => 'Please select recurrence type.',
            'start_date.required'=> 'The Start date field is required.',
            'end_date.after'=>'The End date must be after Start date.'
        ];
    }
}
