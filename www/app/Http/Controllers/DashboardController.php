<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes\DashboardClass;

use App\Dashboard;

class DashboardController extends Controller
{
    public function index(Dashboard $dashboard, DashboardClass $dashboardClass)
    {
        return view('dashboard.index');
    }
}
