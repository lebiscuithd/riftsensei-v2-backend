<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /**
     * Display a listing of theads = Ad::all();
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ad::whereHas('coach', function ($query) {
            $query->where('username');
        })->get();
        return $ads;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => ['required'],
            'duration' => ['required'],
            'coaching_date' => ['required'],
            'hourly_rate' => ['required']
        ]);

        $ad = Ad::create([
            'coach_id' => $request->coach_id,
            'coaching_date' => $request->coaching_date,
            'description' => $request->description,
            'duration' => $request->duration,
            'hourly_rate' => $request->hourly_rate,
            'total_price' => (($request->hourly_rate) * ($request->duration)),
        ]);
        $coach = $ad->coach;
        return $ad;
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
        return $ad;
    }

    public function show_user(Ad $ad)
    {
        $user = $ad->user;
            return response()->json(['message'=>'Success','data'=>$user], 200);
            // return response()->json(['message'=>'Nope','data'=>null], 200);
    }

    public function orderBy($orderBy, $type)
    {
        return Ad::orderBy($orderBy, $type)->get();
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
        if ($ad->update($request->all())) {
        return response()->json([
            'success' => 'Ad Update'
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
