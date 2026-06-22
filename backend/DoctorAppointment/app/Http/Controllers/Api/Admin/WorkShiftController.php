<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkShiftResource;
use App\Models\WorkShift;
use Illuminate\Http\Request;

class WorkShiftController extends ApiController
{
    public function index()
{
    return $this->successResponse(WorkShiftResource::collection(WorkShift::all()));
}
    public function store(Request $request)
{
    $request->validate([
        'day_of_week' => 'required|integer|between:0,6',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'visit_duration' => 'required|integer|min:5'
    ]);

    $shift = WorkShift::create([
        'day_of_week' => $request->day_of_week,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'visit_duration' => $request->visit_duration
    ]);

    return $this->successResponse($shift);
}
public function update(Request $request, WorkShift $workShift)
{
    $request->validate([
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'visit_duration' => 'required|integer|min:5'
    ]);

    $workShift->update($request->only('start_time', 'end_time','visit_duration'));

    return $this->successResponse($workShift);
}
public function destroy(WorkShift $workShift)
{
    $workShift->delete();

    return response()->json(['message' => 'deleted']);
}
}
