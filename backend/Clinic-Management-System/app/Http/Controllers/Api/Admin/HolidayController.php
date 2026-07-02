<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreHolidayRequest;
use App\Http\Resources\HolidayResource;
use App\Models\Holiday;

class HolidayController extends ApiController
{
    public function index()
    {
       $holidays = Holiday::latest('date')->paginate(20);
         return $this->successResponse(
        HolidayResource::collection($holidays),
        200,
        'لیست تعطیلات دریافت شد.'
    );
    }

    public function store(StoreHolidayRequest $request)
{
    $holiday = Holiday::create(
        $request->validated()
    );

    return $this->successResponse(
        new HolidayResource($holiday),
        201,
        'تعطیلی با موفقیت ثبت شد.'
    );
}

public function destroy(Holiday $holiday)
{
    $holiday->delete();

    return $this->successResponse(
        null,
        200,
        'تعطیلی با موفقیت حذف شد.'
    );
}
}
