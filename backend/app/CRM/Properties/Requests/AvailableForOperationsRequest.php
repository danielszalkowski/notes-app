<?php

namespace App\CRM\Properties\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AvailableForOperationsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'property_type_id' => 'nullable|integer|exists:property_types,id',
            'office_id'        => 'nullable|integer|exists:offices,id',
            'zone_type'        => ['nullable', 'string', Rule::in(['neighborhood', 'district', 'municipality', 'region', 'location'])],
            'zone_id'          => 'required_with:zone_type|integer',
            'operation_type'   => ['nullable', 'string', Rule::in(['sale', 'rent'])],
            'min_price'        => 'nullable|numeric|min:0',
            'max_price'        => 'nullable|numeric|min:0',
            'min_surface_m2'   => 'nullable|integer|min:0',
            'max_surface_m2'   => 'nullable|integer|min:0',
            'search'           => 'nullable|string|max:255',
            'page'             => 'nullable|integer|min:1',
            'per_page'         => 'nullable|integer|min:1|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'zone_id.required_with' => 'ID de la zona requerido.',
            'per_page.max' => 'El máximo de resultados por página es 50.',
        ];
    }
}
