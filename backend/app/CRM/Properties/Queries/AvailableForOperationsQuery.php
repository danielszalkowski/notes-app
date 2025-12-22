<?php

namespace App\CRM\Properties\Queries;

use App\Models\Property;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AvailableForOperationsQuery
{
    public static function get(Request $request): Builder
    {
        $user = $request->user();
        
        $query = Property::query()
            ->where('is_active', true)
            
            ->whereDoesntHave('operations', function (Builder $q) {
                $q->whereHas('status', function (Builder $statusQuery) {
                    $statusQuery->where('is_closed', false);
                });
            });

        if (!$user->hasAnyRole(['admin', 'god', 'commercial_director'])) {
            $query->where('office_id', $user->office_id);
        } elseif ($request->has('office_id')) {
            $query->where('office_id', $request->office_id);
        }

        $query->when($request->property_type_id, fn($q, $id) => $q->where('property_type_id', $id))
            ->when($request->min_surface_m2, fn($q, $s) => $q->where('built_m2', '>=', $s))
            ->when($request->max_surface_m2, fn($q, $s) => $q->where('built_m2', '<=', $s));

        if ($request->zone_type && $request->zone_id) {
            $column = "{$request->zone_type}_id";
            $query->where($column, $request->zone_id);
        }

        $query->when($request->operation_type, function ($q, $type) use ($request) {
            $column = ($type === 'sale') ? 'sell_price' : 'rental_price';
            if ($request->min_price) $q->where($column, '>=', $request->min_price);
            if ($request->max_price) $q->where($column, '<=', $request->max_price);
            
            $q->where($type === 'sale' ? 'is_sell' : 'is_rent', true);
        });

        $query->when($request->search, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('title', 'like', "%{$search}%")
                    ->orWhere('street', 'like', "%{$search}%")
                    ->orWhere('intern_reference', 'like', "%{$search}%");
            });
        });

        return $query->orderBy('created_at', 'DESC');
    }
}