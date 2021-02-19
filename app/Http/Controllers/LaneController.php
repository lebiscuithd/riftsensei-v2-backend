<?php

namespace App\Http\Controllers;

use App\Models\Lane;
use Illuminate\Http\Request;

class LaneController extends Controller
{
    /**
     * @OA\Get(
     *      path="/lanes",
     *      operationId="getLanesList",
     *      summary="Get lanes",
     *      description="Get all lanes",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function index()
    {
        return Lane::all();
    }

    /**
     * @OA\Post (
     *      path="/addLane/{user}/{lane}",
     *      operationId="addLane",
     *      summary="Add a Lane to a user",
     *      description="Add a Lane to a user",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lane  $lane
     * @return \Illuminate\Http\Response
     */
    public function show(Lane $lane)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lane  $lane
     * @return \Illuminate\Http\Response
     */
    public function edit(Lane $lane)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lane  $lane
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lane $lane)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lane  $lane
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lane $lane)
    {
        //
    }
}
