<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Ad;
use Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'show_ads']]);
    }
    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="getUsersList",
     *      summary="Get list of users",
     *      description="Get list of users",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function index()
    {
        return User::all();
    }

    /**
     * @OA\Get(
     *      path="/users/{id}",
     *      operationId="getUser",
     *      summary="Get profile of user",
     *      description="Get profile of user",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }
    /**
     * @OA\Get(
     *      path="/users/{id}/ads",
     *      operationId="getUserAds",
     *      summary="Get ads of user",
     *      description="Get ads of user",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
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

    /**
     * @OA\Put(
     *      path="/users/{id}",
     *      operationId="putUser",
     *      summary="Update profile of user",
     *      description="Update profile of user",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'unique:users|string|between:2,20',
            'email' => 'string|email|max:100|unique:users',
            'password' => 'string|confirmed|min:6',
            'rank_id' => 'integer|between:1,10',
            'lane_id' => 'array'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        if ($user->id !== auth()->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        if ($request->lane_id) {
            $user->lanes()->detach();
            foreach ($request->lane_id as $lane_Id) {
                $user->lanes()->attach($lane_Id);
                }
        }

        if ($request->password) {
            $crypt = bcrypt($request->password);
            $user->password = $crypt;
            $user->save();
        }

         if ($user->update($request->except(['wallet', 'password', 'remember_token', 'id', 'admin', 'verified_coach', 'coaching_hours', 'coach_rating', 'coaching_hours_spent']))) {
                    return response()->json([
                        'success' => 'User successfully updated',
                        'user' => new UserResource($user)
                    ], 200);
               }
    }

    /**
     * @OA\Delete(
     *      path="/users/{id}",
     *      operationId="deleteUser",
     *      summary="Delete user",
     *      description="Delete user",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
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

