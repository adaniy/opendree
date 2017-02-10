<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DashboardRequest;

use Carbon\Carbon;

use App\Dashboard;
use App\DashboardAgent;
use App\DashboardHoliday;
use App\DashboardAmount;
use App\DashboardCategories;
use App\DashboardService;

use App\Service;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('dashboard')->only([
            "access"
        ]);
    }
}
