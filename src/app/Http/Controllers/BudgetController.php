<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BudgetRequest;
use App\Http\Requests\BudgetServiceRequest;

use App\Classes\BudgetClass;

use App\Budget;
use App\Service;
use App\BudgetDepense;
use App\BudgetCategory;

class BudgetController extends Controller
{
    public function index(Service $service, Budget $budget, BudgetCategory $budgetCategory, BudgetDepense $budgetDepense, BudgetClass $budgetClass)
    {
        return view('budget.index')->with([
            'service' => $service,
            'budget' => $budget,
            'budgetDepense' => $budgetDepense,
            'budgetCategory' => $budgetCategory,
            'budgetClass' => $budgetClass
        ]);
    }
}
