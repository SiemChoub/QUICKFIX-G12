<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        // dd(1);
        // Retrieve all services
        $services = Service::all();

        // Return services as a JSON response
        return response()->json($services);
    }
}
