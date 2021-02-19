<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;
use App\Http\Resources\ReceiptResource;

class ReceiptController extends Controller
{
    /**
     * @OA\Get(
     *      path="/receipts",
     *      operationId="getReceiptsList",
     *      summary="Get list of receipts",
     *      description="Get list of receipts",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function index()
    {
       $receipts = Receipt::all();
       return ReceiptResource::collection($receipts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * @OA\Post (
     *      path="/receipts",
     *      operationId="postReceiptsList",
     *      summary="Creates a new receipt",
     *      description="Creates a new receipt",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function store(Request $request)
    {
        $receipt = Receipt::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receipt $receipt)
    {
        //
    }

    /**
     * @OA\Delete(
     *      path="/receipts/{id}",
     *      operationId="deleteReceipt",
     *      summary="Delete Receipts",
     *      description="Delete Receipts",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function destroy(Receipt $receipt)
    {
        if ($receipt->delete()) {
            return response()->json([
                'success' => 'Receipt successfully deleted'
            ], 200);
        }
    }
}
