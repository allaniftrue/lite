<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Requests\SubscriberRequest;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        if ($request->filled('raw')) {
            return response()->json([
                'data' => Subscriber::with('fields')->get(),
            ]);
        }

        return Subscriber::with('fields')->paginate($limit);
    }

    public function show(Request $request)
    {
        return response()->json([
            'data' => Subscriber::where('id', $request->id)->with('fields')->first(),
        ]);
    }

    /**
     * Store the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Subscriber          $subscriber
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriberRequest $request, Subscriber $subscriber)
    {
        return response()->json([
            'data' => $subscriber->create($request->all()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Subscriber          $subscriber
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SubscriberRequest $request, Subscriber $subscriber)
    {
        return response()->json([
            'data' => $subscriber->find($request->id)
                        ->update($request->except(['id'])),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Subscriber $subscriber
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Subscriber $subscriber)
    {
        $subscriber->where('id', $request->id)->delete();

        return response()->json([
            'data' => 'Subscriber successfully removed',
        ]);
    }
}
