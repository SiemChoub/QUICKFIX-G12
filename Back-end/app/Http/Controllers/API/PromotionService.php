<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiscountResource;
use App\Http\Resources\PromotionResource;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionService extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // dd("Loading");
     $promotion = Promotion::list();
     $promotion = PromotionResource::collection($promotion);
     return $promotion;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        Promotion::store($request);
        return ["success" => true, "Message" => "Promotion created successfully"];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $promontion = Promotion::find($id);
        if (!$promontion) {
            return response()->json(['message' => 'Promotion not found'], 404);
        }

        return response()->json(new PromotionResource($promontion));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the promotion by id
        $promotion = Promotion::find($id);
        if (!$promotion) {
            return response()->json(['message' => 'Promotion not found'], 404);
        }
    
        // Update the promotion with the request data
        $promotion->update($request->all());
    
        // Return a success response
        return response()->json([
            "success" => true,
            "message" => "Promotion updated successfully",
            "data" => new PromotionResource($promotion)
        ], 200);
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $promotion = Promotion::find($id);
        if (!$promotion) {
            return response()->json(['message' => 'Promotion not found'], 404);
        }

        $promotion->delete();

        return response()->json(['message' => 'Promotion deleted'], 204);
    }
}
