<?php

namespace App\Http\Requests\Equipment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


class StoreRequest extends FormRequest
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
            'equipment_type'=>'required|integer|exists:equipment_types,id',
            'serial_number'=>'required|string|size:10|unique:equipment,serial_number',
            'desc'=>'required|string',
        ];
    }


    public function messages(): array
    {
        return [
            'equipment_type.required' => 'Id equipment type required!',
            'serial_number.required' => 'Serial number required!',
            'serial_number.size' => 'Serial number must be 10 characters!',
            'serial_number.unique' => 'Serial number must be unique!',
            'desc.required' => 'Desc  required!',
        ];
    }



}
