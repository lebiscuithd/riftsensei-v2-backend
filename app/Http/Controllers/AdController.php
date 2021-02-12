<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\AdResource;

class AdController extends Controller
{
    /**
     * Display a listing of theads = Ad::all();
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ad::paginate(8);
        return AdResource::collection($ads);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        // return Ad::user_id($ad);
        return new AdResource($ad);
    }

    public function orderBy($orderBy, $type)
    {
        $ads = Ad::orderBy($orderBy, $type)->paginate(8);
        return AdResource::collection($ads);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
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
