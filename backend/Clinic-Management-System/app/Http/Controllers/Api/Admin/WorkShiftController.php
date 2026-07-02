<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreWorkShiftRequest;
use App\Http\Requests\UpdateWorkShiftRequest;
use App\Http\Resources\WorkShiftResource;
use App\Models\WorkShift;

class WorkShiftController extends ApiController
{
    public function index()
{
    $workShifts = WorkShift::latest('start_time')->paginate(20);
    return $this->successResponse(
    WorkShiftResource::collection($workShifts),
    200,
    'لیست تایم‌های کاری دریافت شد.'
);
}
    public function store(StoreWorkShiftRequest $request)
{
    $workShift = WorkShift::create($request->validated());
    return $this->successResponse(
    new WorkShiftResource($workShift),
    201,
    'تایم کاری با موفقیت ایجاد شد.'
);
}
public function update(UpdateWorkShiftRequest $request, WorkShift $workShift)
{
    $workShift->update($request->validated());

   return $this->successResponse(
    new WorkShiftResource($workShift),
    200,
    'تایم کاری با موفقیت بروزرسانی شد.'
);
}
public function destroy(WorkShift $workShift)
{
    $workShift->delete();

   return $this->successResponse(
        null,
        200,
        'تایم کاری با موفقیت حذف شد.'
    );
}
}
