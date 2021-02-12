<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Ad;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        User::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function show_ads(User $user)
    {
        $ads = $user->ads;
         if (count($ads) > 0){
            return response()->json(['message'=>'Success','data'=>$ads], 200);
        }
        else {
            return response()->json(['message'=>'Nope','data'=>null], 200);
        }
    }

    public function show_rank(User $user)
    {
        $rank = $user->rank;
        if (count((array)$rank) > 0){
            return response()->json(['message'=>'Success','data'=>$rank], 200);
        }
            return response()->json(['message'=>'Nope','data'=>null], 200);
    }

//    public function getUserLanes()
//    {
//        $users = User::whereHas('lanes','>',0)->get();
//        foreach($users as $user){
//
//            $user->lanes;  //we can get trophies of each user
//        }
//
//        return response()->json(['data' => $users]);
//    }

    public function addLane(User $user, $idOfLanes)
    {
        $user->lanes()->attach($idOfLanes);

//        $idOfLanes = $request->lane_id;
//
//        $user->lanes()->attach($idOfLanes);

        return response()->json(['message' => 'Lane has been registered', 'data' => new UserResource($user)]);
    }

    public function deleteUserLane(User $user, $idOfLanes)
    {
        $user->lanes()->detach($idOfLanes);

        return response()->json(['message' => 'Lane has been deleted', 'data' => new UserResource($user)]);

    }

    public function addLanes(Request $request, User $user)
    {
        foreach ($request->lane_id as $lane_Id) {
            $lane = DB::table('user_lanes')->where('lane_id', $lane_Id)->first();
            if ($lane) {
                $user->lanes()->detach($lane_Id);
                $user->lanes()->attach($lane_Id);
            } else {
                $user->lanes()->attach($lane_Id);
            }
        }
        return response()->json(['message' => 'Lanes have been added successfully']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        foreach ($request->lane_id as $lane_Id) {
            $lane = DB::table('user_lanes')->where('lane_id', $lane_Id)->first();
            if ($lane) {
                $user->lanes()->detach($lane_Id);
                $user->lanes()->attach($lane_Id);
            } else {
                $user->lanes()->attach($lane_Id);
            }
            }

         if ($user->update($request->all())) {
                    return response()->json([
                        'success' => 'User successfully updated'
                    ], 200);
               }
    }

    /**
     * Remove the specified resource from storage.

     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            return response()->json([
                'success' => 'User successfully deleted'
            ], 200);
        }
    }
}

