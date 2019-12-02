<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Field;

class FieldController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 15;

        if ($request->filled('raw')) {
            return response()->json([
                'data' => Field::select('id', 'title', 'type')->get(),
            ]);
        }

        return Field::select('id', 'title', 'type')->paginate($limit);
    }
}
