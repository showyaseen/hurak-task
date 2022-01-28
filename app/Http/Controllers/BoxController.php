<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    public function store(Request $request) {

        $this->validate($request, [
            'boxes' => 'array',
            'boxes.*.color' => 'required|string',
            'boxes.*.width' => 'required|integer',
            'boxes.*.height' => 'required|integer'
        ]);

        return response()->json(Box::insert($request->boxes), 200);
    }
}
