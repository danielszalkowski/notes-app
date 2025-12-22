<?php

namespace App\CRM\Properties\Controllers;

use App\Http\Controllers\Controller;
use App\CRM\Properties\Queries\AvailableForOperationsQuery;
use App\CRM\Properties\Requests\AvailableForOperationsRequest;
use App\CRM\Properties\Resources\AvailablePropertyResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AvailablePropertiesController extends Controller
{
    public function index(AvailableForOperationsRequest $request): AnonymousResourceCollection
    {
        $query = AvailableForOperationsQuery::get($request);

        $perPage = min($request->get('per_page', 20), 50);
        $properties = $query->paginate($perPage);

        return AvailablePropertyResource::collection($properties);
    }
}