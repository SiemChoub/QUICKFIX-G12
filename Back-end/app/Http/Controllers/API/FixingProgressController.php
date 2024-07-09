<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FixingProgress;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FixingProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $fixingProgress = FixingProgress::all();
        return response()->json([
            'fixingProgress' => $fixingProgress
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
    }

    // Add other CRUD methods as needed...
    public function update(Request $request, string $id)
    {
        //
        $fixingProgress = FixingProgress::find($id);
        $fixingProgress->action = $request->action;

        $fixingProgress->save();

        return response()->json($fixingProgress);
    }
}