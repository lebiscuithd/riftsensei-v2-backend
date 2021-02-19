<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\AdResource;

class AdController extends Controller
{
    /**
     * @OA\Get(
     *      path="/ads",
     *      operationId="getAdsList",
     *      summary="Get list of ads",
     *      description="Returns list of ads",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function index()
    {
        $ads = Ad::paginate(8);
        return AdResource::collection($ads);
    }


    /**
     * @OA\Post (
     *      path="/ads",
     *      operationId="postAdsList",
     *      summary="Creates a new ad",
     *      description="Creates a new ad",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
            'duration' => 'required|integer|between:1,8',
            'coaching_date' => 'required|date',
            'hourly_rate' => 'required|integer|min:100',
            'coach_id' => 'required|integer'
        ]);

        if($validator->fails()){
            return response($validator->errors(), 422);
        }

        $ad = Ad::create([
            'coach_id' => $request->coach_id,
            'coaching_date' => $request->coaching_date,
            'description' => $request->description,
            'duration' => $request->duration,
            'hourly_rate' => $request->hourly_rate,
            'total_price' => (($request->hourly_rate) * ($request->duration)),
        ]);

        return new AdResource($ad);
    }

    /**
     * @OA\Get(
     *      path="/ads/{id}",
     *      operationId="getAd",
     *      summary="Get a specific ad",
     *      description="Get a specific ad",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function show(Ad $ad)
    {
        // return Ad::user_id($ad);
        return new AdResource($ad);
    }

    /**
     * @OA\Get(
     *      path="/ads/{orderBy}/{type}",
     *      operationId="sortAds",
     *      summary="Sort Ads",
     *      description="Sort Ads",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */

    public function orderBy($orderBy, $type)
    {
        $ads = Ad::orderBy($orderBy, $type)->paginate(8);
        return AdResource::collection($ads);
    }
    /**
     * @OA\Put(
     *      path="/ads/{id}",
     *      operationId="updateAds",
     *      summary="Update Ads",
     *      description="Update Ads",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function update(Request $request, Ad $ad)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'string',
            'duration' => 'integer|between:1,8',
            'coaching_date' => 'date',
            'hourly_rate' => 'integer|min:100'
        ]);

        if($validator->fails()){
            return response($validator->errors(), 422);
        }

        if ($ad->update($request->all())) {
        $ad->total_price = ($ad->duration * $ad->hourly_rate);
        $ad->save();
        return response()->json([
            'success' => 'Ad Updated'
        ], 200);
    }
    }

    /**
     * @OA\Delete(
     *      path="/ads/{id}",
     *      operationId="deleteAds",
     *      summary="Delete Ads",
     *      description="Delete Ads",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function destroy(Ad $ad)
    {
        if ($ad->delete()) {
        return response()->json([
            'success' => 'Ad Delete'
        ], 200);
    }
    }
    // public function showProfile($id)
    // {
    //     $user = Ad::where('id', $id);
    //     return view('show',['user_id'=>$user]);
    // }
    // }
}
