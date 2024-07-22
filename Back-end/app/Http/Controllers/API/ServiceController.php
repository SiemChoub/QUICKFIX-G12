<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
{
    $services = Service::all();
<<<<<<< HEAD
    $services = ServiceResource::Collection($services);
=======
    $serviceCount = $services->count();
>>>>>>> b19eb38ff361c44e7f5883fd6b8534771c1c8c0f
    $topService = $services->sortByDesc('rating')->take(3);

    return response()->json([
        'services' => $services,
<<<<<<< HEAD
=======
        'service_count' => $serviceCount,
>>>>>>> b19eb38ff361c44e7f5883fd6b8534771c1c8c0f
        'topService' => $topService,
    ]);
}
}
