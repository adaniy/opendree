<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

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
    
    public function index(Dashboard $dashboard, DashboardAmount $dashboardAmount, DashboardService $dashboardService, Service $service, DashboardCategories $dashboardCategories, Carbon $carbon, DashboardClass $dashboardClass)
    {
        return view('dashboard.index')->with([
            "dashboard" => $dashboard,
            "dashboardAmount" => $dashboardAmount,
            "dashboardService" => $dashboardService,
            "dashboardCategories" => $dashboardCategories,
            "dashboardClass" => $dashboardClass,
            "carbon" => $carbon,
            "service" => $service
        ]);
    }

    public function indexCategories(Dashboard $dashboard, DashboardAmount $dashboardAmount, DashboardService $dashboardService, Service $service, DashboardCategories $dashboardCategories, Carbon $carbon, DashboardClass $dashboardClass)
    {
        return view('dashboard.index-categories')->with([
            "dashboard" => $dashboard,
            "dashboardAmount" => $dashboardAmount,
            "dashboardService" => $dashboardService,
            "dashboardCategories" => $dashboardCategories,
            "dashboardClass" => $dashboardClass,
            "carbon" => $carbon,
            "service" => $service
        ]);
    }

    public function indexServices(Dashboard $dashboard, DashboardAmount $dashboardAmount, DashboardService $dashboardService, Service $service, DashboardCategories $dashboardCategories, Carbon $carbon, DashboardClass $dashboardClass)
    {
        return view('dashboard.index-services')->with([
            "dashboard" => $dashboard,
            "dashboardAmount" => $dashboardAmount,
            "dashboardService" => $dashboardService,
            "dashboardCategories" => $dashboardCategories,
            "dashboardClass" => $dashboardClass,
            "carbon" => $carbon,
            "service" => $service
        ]);
    }

    public function access($year, $month, Dashboard $dashboard, DashboardAmount $dashboardAmount, DashboardService $dashboardService, Service $service, DashboardCategories $dashboardCategories, Carbon $carbon, DashboardClass $dashboardClass)
    {
        return view('dashboard.get')->with([
            "dashboard" => $dashboard,
            "dashboardAmount" => $dashboardAmount,
            "dashboardService" => $dashboardService,
            "dashboardCategories" => $dashboardCategories,
            "dashboardClass" => $dashboardClass,
            "service" => $service,
            "carbon" => $carbon,
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

    public function addService(DashboardClass $dashboardClass)
    {
        return $dashboardClass->addService();
    }

    public function editService(DashboardRequest $request, DashboardClass $dashboardClass)
    {
        return $dashboardClass->editService($request);
    }

    public function deleteService($id, DashboardClass $dashboardClass)
    {
        return $dashboardClass->deleteService($id);
    }
}
