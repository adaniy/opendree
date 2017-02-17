<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DashboardRequest;

use Carbon\Carbon;

use App\Classes\TempsClass;
use App\Classes\DashboardClass;

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

    public function statsYear($year, DashboardClass $dashboardClass)
    {
        return $dashboardClass->statsYear($year);
    }

    public function statsYearComparison($year, DashboardClass $dashboardClass)
    {
        return $dashboardClass->statsYearComparison($year);
    }

    public function statsYearService($id, $year, DashboardClass $dashboardClass)
    {
        return $dashboardClass->statsYearService($id, $year);
    }

    public function stats(DashboardClass $dashboardClass)
    {
        return $dashboardClass->stats();
    }

    public function statsService($id, DashboardClass $dashboardClass)
    {
        return $dashboardClass->statsService($id);
    }

    public function statsRaw(DashboardClass $dashboardClass)
    {
        return $dashboardClass->statsRaw();
    }

    public function statsComparison(DashboardClass $dashboardClass)
    {
        return $dashboardClass->statsComparison();
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

    public function indexAgents(Dashboard $dashboard, DashboardAgent $dashboardAgent, DashboardAmount $dashboardAmount, DashboardService $dashboardService, Service $service, DashboardCategories $dashboardCategories, Carbon $carbon, DashboardClass $dashboardClass)
    {
        return view('dashboard.index-agents')->with([
            "dashboard" => $dashboard,
            "dashboardAgent" => $dashboardAgent,
            "dashboardAmount" => $dashboardAmount,
            "dashboardService" => $dashboardService,
            "dashboardCategories" => $dashboardCategories,
            "dashboardClass" => $dashboardClass,
            "carbon" => $carbon,
            "service" => $service
        ]);
    }

    public function indexHolidays(Dashboard $dashboard, DashboardAgent $dashboardAgent, DashboardHoliday $dashboardHoliday, DashboardAmount $dashboardAmount, DashboardService $dashboardService, Service $service, DashboardCategories $dashboardCategories, Carbon $carbon, DashboardClass $dashboardClass)
    {
        return view('dashboard.index-holidays')->with([
            "dashboard" => $dashboard,
            "dashboardAgent" => $dashboardAgent,
            "dashboardHoliday" => $dashboardHoliday,
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

    public function accessYear($year, Dashboard $dashboard, DashboardAgent $dashboardAgent, DashboardHoliday $dashboardHoliday, DashboardAmount $dashboardAmount, DashboardService $dashboardService, Service $service, DashboardCategories $dashboardCategories, Carbon $carbon, TempsClass $temps, DashboardClass $dashboardClass)
    {
        return view('dashboard.get-year')->with([
            "dashboard" => $dashboard,
            "dashboardAgent" => $dashboardAgent,
            "dashboardHoliday" => $dashboardHoliday,
            "dashboardAmount" => $dashboardAmount,
            "dashboardService" => $dashboardService,
            "dashboardCategories" => $dashboardCategories,
            "dashboardClass" => $dashboardClass,
            "service" => $service,
            "carbon" => $carbon,
            "temps" => $temps,
            "year" => $year
        ]);
    }

    public function accessYearService($year, $id, Dashboard $dashboard, DashboardAgent $dashboardAgent, DashboardHoliday $dashboardHoliday, DashboardAmount $dashboardAmount, DashboardService $dashboardService, Service $service, DashboardCategories $dashboardCategories, Carbon $carbon, TempsClass $temps, DashboardClass $dashboardClass)
    {
        return view('dashboard.get-year-service')->with([
            "dashboard" => $dashboard,
            "dashboardAgent" => $dashboardAgent,
            "dashboardHoliday" => $dashboardHoliday,
            "dashboardAmount" => $dashboardAmount,
            "dashboardService" => $dashboardService,
            "dashboardCategories" => $dashboardCategories,
            "dashboardClass" => $dashboardClass,
            "services" => $service->find($id),
            "carbon" => $carbon,
            "temps" => $temps,
            "id" => $id,
            "year" => $year
        ]);
    }

    public function accessService($id, Dashboard $dashboard, DashboardAgent $dashboardAgent, DashboardHoliday $dashboardHoliday, DashboardAmount $dashboardAmount, DashboardService $dashboardService, Service $service, DashboardCategories $dashboardCategories, Carbon $carbon, TempsClass $temps, DashboardClass $dashboardClass)
    {
        return view('dashboard.get-service')->with([
            "id" => $id,
            "dashboard" => $dashboard,
            "dashboardAgent" => $dashboardAgent,
            "dashboardHoliday" => $dashboardHoliday,
            "dashboardAmount" => $dashboardAmount,
            "dashboardService" => $dashboardService,
            "dashboardCategories" => $dashboardCategories,
            "dashboardClass" => $dashboardClass,
            "services" => $service->find($id),
            "carbon" => $carbon,
            "temps" => $temps
        ]);
    }

    public function accessYearPrint($year, Dashboard $dashboard, DashboardAgent $dashboardAgent, DashboardHoliday $dashboardHoliday, DashboardAmount $dashboardAmount, DashboardService $dashboardService, Service $service, DashboardCategories $dashboardCategories, Carbon $carbon, TempsClass $temps, DashboardClass $dashboardClass)
    {
        return view('dashboard.get-year-print')->with([
            "dashboard" => $dashboard,
            "dashboardAgent" => $dashboardAgent,
            "dashboardHoliday" => $dashboardHoliday,
            "dashboardAmount" => $dashboardAmount,
            "dashboardService" => $dashboardService,
            "dashboardCategories" => $dashboardCategories,
            "dashboardClass" => $dashboardClass,
            "service" => $service,
            "carbon" => $carbon,
            "temps" => $temps,
            "year" => $year
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

    public function addAgent(DashboardRequest $request, DashboardClass $dashboardClass)
    {
        return $dashboardClass->addAgent($request);
    }

    public function deleteAgent($id, DashboardClass $dashboardClass)
    {
        return $dashboardClass->deleteAgent($id);
    }

    public function editService(DashboardRequest $request, DashboardClass $dashboardClass)
    {
        return $dashboardClass->editService($request);
    }

    public function deleteService($id, DashboardClass $dashboardClass)
    {
        return $dashboardClass->deleteService($id);
    }

    public function addCategory(DashboardRequest $request)
    {
        $id = $request->get("id");
        $type = $request->get("type");
        $name = $request->get("name");
        $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);

        $category = new DashboardCategories;

        $category->service_id = $id;
        $category->type = $type;
        $category->name = $name;
        $category->color = $color;

        if($category->save()) {
            return json_encode([
                "status" => "success"
            ]);
        } else {
            return json_encode([]);
        }
    }

    public function deleteCategory($id)
    {
        $category = DashboardCategories::find($id);

        if($category) {
            $category->delete();

            return json_encode([
                "status" => "success"
            ]);
        } else {
            return json_encode([]);
        }
    }

    public function editAmount(DashboardRequest $request, DashboardClass $dashboardClass)
    {
        return $dashboardClass->editAmount($request);
    }

    public function editAmountService(DashboardRequest $request, DashboardClass $dashboardClass)
    {
        return $dashboardClass->editAmountService($request);
    }

    public function addHoliday(DashboardRequest $request, DashboardClass $dashboardClass)
    {
        return $dashboardClass->addHoliday($request);
    }

    public function deleteHoliday($id, DashboardClass $dashboardClass)
    {
        return $dashboardClass->deleteHoliday($id);
    }
}
