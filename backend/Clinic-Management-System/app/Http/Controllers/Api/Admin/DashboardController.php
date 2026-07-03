<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Resources\DashboardResource;
use App\Services\DashboardService;

class DashboardController extends ApiController
{
    public function index(DashboardService $dashboardService)
    {
        $dashboard = $dashboardService->getStatistics();

        return $this->successResponse(
            new DashboardResource($dashboard),
            200,
            'اطلاعات داشبورد دریافت شد.'
        );
    }
}
