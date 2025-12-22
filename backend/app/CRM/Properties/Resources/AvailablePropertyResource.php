<?php

namespace App\CRM\Properties\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailablePropertyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $type = $request->operation_type ?? ($this->is_sell ? 'sale' : 'rent');

        $price = ($type === 'rent') ? $this->rental_price : $this->sell_price;

        return [
            'id'                => $this->ulid,
            'intern_reference'  => $this->intern_reference,
            'title'             => $this->title,
            'address'           => trim("{$this->street} {$this->number}, {$this->zip_code}") ?: 'Dirección no disponible',
            'property_type'     => [
                'id'   => $this->propertyType->id,
                'name' => $this->propertyType->name,
            ],
            'surface_m2'        => $this->built_m2,
            'price'             => $price,
            'operation_type'    => $type,
            'is_sell'           => (bool) $this->is_sell,
            'is_rent'           => (bool) $this->is_rent,
            'office'            => [
                'id'   => $this->office->id,
                'name' => $this->office->name,
            ],
            'zone' => [
                'neighborhood' => $this->neighborhood?->name,
                'municipality' => $this->municipality?->name,
            ],
            'created_at'        => $this->created_at->toISOString(),
        ];
    }
}
