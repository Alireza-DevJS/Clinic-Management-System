<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\ApiController;
use App\Http\Resources\AvailableSlotResource;
use App\Services\SlotService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvailableSlotController extends ApiController
{
   public function index(Request $request, SlotService $slotService)
{
    $request->validate([
        'date' => 'required|date',
    ]);

    $date = Carbon::parse($request->date);

    $slots = $slotService->availableSlots($date);

    return $this->successResponse(
    new AvailableSlotResource([
        'date' => $date,
        'slots' => $slots,
    ]),
    200,
    'ساعت‌های آزاد دریافت شد.'
);
}
}
