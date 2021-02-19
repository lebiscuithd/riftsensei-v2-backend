<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\AdResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;

class AdController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'orderBy', 'getAdsByStatus']]);
    }

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
         $ads = Ad::orderBy('id', 'desc')->paginate(8);
            return AdResource::collection($ads);
    }

    public function getAdsByStatus($status)
    {

        $ads = Ad::orderBy('id', 'desc')->where('status', $status)->paginate(8);
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

    /**
     * Update the booked ad status to pending.
     *
     * @param  \App\Models\Ad  $ad
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    public function bookAd(User $user, Ad $ad) {

        if ($ad->coach_id === auth()->user()->id || $user->id !== auth()->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        } elseif ($ad->status !== 'available') {
            return response()->json([
                'message' => 'Booking pre-processed, you cannot book it anymore'
            ], 422);
        }

        if ($user->wallet >= $ad->total_price) {
            $money = $user->wallet;
            $cost = $ad->total_price;
            $user->wallet = ($money - $cost);
            $user->coaching_hours_spent = $user->coaching_hours_spent +$ad->duration;
            $user->save();
        } else {
            return response()->json([
                'message' => 'You do not have enough money to book'
            ], 422);
        }

        $ad->status = 'pending';
        $ad->student_id = $user->id;
        $ad->save();


        return response()->json([
            'success' => 'Pre-booking processed',
            'ad' => new AdResource($ad),
            'user' => new UserResource($user)
        ], 200);
    }

    /**
     * Update the booked ad status to finished.
     *
     * @param  \App\Models\Ad  $ad
     * @param  \App\Models\User  $coach
     * @return \Illuminate\Http\Response
     */

    public function validateAd(User $coach, Ad $ad) {

        if ($ad->coach_id !== auth()->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        if ($ad->status === 'finished') {
            return response()->json([
                'message' => 'This coaching session has already been completed'
            ], 422);
        }

        $ad->status = 'finished';
        $coach->wallet = $coach->wallet + $ad->total_price;
        $coach->coaching_hours = $coach->coaching_hours + $ad->duration;
        $ad->save();
        $coach->save();

        return response()->json([
            'success' => 'Booking completed',
            'ad' => new AdResource($ad),
            'user' => new UserResource($coach)
        ], 200);

    }

    /**
     * Allow the user to rate the coaching session
     *
     * @param  \App\Models\Ad  $ad
     * @param  \App\Models\User  $student
     * @return \Illuminate\Http\Response
     */

    public function rateAd(Request $request, Ad $ad) {

        $validator = Validator::make($request->all(), [
            'comments' => 'string|max:255',
            'ad_rating' => 'required|integer|between:0,5'
        ]);

        if($validator->fails()){
            return response($validator->errors(), 422);
        }

        if ($ad->student_id !== auth()->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        if ($ad->status !== 'finished') {
            return response()->json([
                'message' => 'Please wait for the session to be finished to rate it'
            ], 422);
        }

        $ad->status = 'rated';
        $ad->comments = $request->comments;
        $ad->ad_rating = $request->ad_rating;
        $ad->save();

        $coach = User::find($ad->coach_id);
        $coachAds =  DB::table('ads')->where('coach_id', $coach->id)->get();
        $rate = 0;
        $count = 0;
        foreach ($coachAds as $coach_ad) {
            $rate += $coach_ad->ad_rating;
            $count += 1;
        }
        $note = ($rate / $count);
        $coach->coach_rating = $note;
        $coach->save();

        return response()->json([
            'success' => 'Booking rated successfully',
            'ad' => new AdResource($ad),
            'coach' => $coach
        ], 200);
    }
}
