<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TourController extends Controller
{
    public function complete(Request $request)
    {
        $request->user()->update(['tour_completed' => true]);

        return response()->json(['success' => true]);
    }
}
