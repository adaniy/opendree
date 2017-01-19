<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BudgetRequest;

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

    public function getTotal($id, BudgetClass $budgetClass)
    {
        return $budgetClass->getTotal($id);
    }
    
    public function getDepense($id, BudgetClass $budgetClass)
    {
        return $budgetClass->getDepense($id);
    }

    public function addDepense($id, BudgetClass $budgetClass)
    {
        return $budgetClass->addDepense($id);
    }

    public function editDepense(BudgetRequest $request, BudgetClass $budgetClass)
    {
        return $budgetClass->editDepense($request);
    }

    public function deleteDepense($id, BudgetClass $budgetClass)
    {
        return $budgetClass->deleteDepense($id);
    }
}
