<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes\DashboardClass;

use App\Dashboard;
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
    
    public function index(Dashboard $dashboard, DashboardAmount $dashboardAmount, DashboardService $dashboardService, Service $service, DashboardCategories $dashboardCategories, DashboardClass $dashboardClass)
    {
        return view('dashboard.index')->with([
            "dashboard" => $dashboard,
            "dashboardAmount" => $dashboardAmount,
            "dashboardService" => $dashboardService,
            "dashboardCategories" => $dashboardCategories,
            "dashboardClass" => $dashboardClass,
            "service" => $service,
        ]);
    }

    public function access($year, $month, Dashboard $dashboard, DashboardAmount $dashboardAmount, DashboardService $dashboardService, Service $service, DashboardCategories $dashboardCategories, DashboardClass $dashboardClass)
    {
        return view('dashboard.get')->with([
            "dashboard" => $dashboard,
            "dashboardAmount" => $dashboardAmount,
            "dashboardService" => $dashboardService,
            "dashboardCategories" => $dashboardCategories,
            "dashboardClass" => $dashboardClass,
            "service" => $service,
            "year" => $year,
            "month" => $month
        ]);
    }

    public function add($year, DashboardClass $dashboardClass)
    {
        return $dashboardClass->add($year);
    }

    public function addMonth($year, DashboardClass $dashboardClass)
    {
        return $dashboardClass->addMonth($year);
    }
}
