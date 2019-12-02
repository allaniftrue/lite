<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;

class SubscriberFieldController extends Controller
{
    public function store(Request $request)
    {

        Subscriber::find($request->subscriber)
            ->fields()
            ->attach($request->field);

        return response()->json([
            'success' => true,
            'data' => 'Field successfully added'
        ]);
    }
}
