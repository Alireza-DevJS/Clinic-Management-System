<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends ApiController
{
     public function index()
    {
       $holiday =  Holiday::orderBy('date')->get();
        return $this->successResponse($holiday);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|unique:holidays,date',
            'title' => 'nullable|string'
        ]);

        $holiday = Holiday::create([
            'date' => $request->date,
            'title' => $request->title,
        ]);

        return $this->successResponse($holiday);
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();

        return response()->json([
            'message' => 'حذف شد'
        ]);
    }
}
