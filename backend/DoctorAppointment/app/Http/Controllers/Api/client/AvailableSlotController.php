<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\ApiController;
use App\Models\Appointment;
use App\Models\Holiday;
use App\Models\WorkShift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\SlotService;
class AvailableSlotController extends ApiController
{
   public function index(Request $request)
{
    $request->validate([
        'date' => 'required|date'
    ]);

    $slots = SlotService::getAvailableSlots($request->date);

    return response()->json($slots);
}
}
