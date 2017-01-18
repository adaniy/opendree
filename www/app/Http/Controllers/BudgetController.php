<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes\BudgetClass;

use App\Budget;
use App\BudgetDepense;
use App\BudgetCategory;

class BudgetController extends Controller
{
    public function index(Budget $budget, BudgetCategory $budgetCategory, BudgetDepense $budgetDepense, BudgetClass $budgetClass)
    {
        return view('budget.index')->with([
            'budget' => $budget,
            'budgetDepense' => $budgetDepense,
            'budgetCategory' => $budgetCategory,
            'budgetClass' => $budgetClass
        ]);
    }

    public function getDepense($id, BudgetClass $budgetClass)
    {
        return $budgetClass->getDepense($id);
    }

    public function addDepense($id, BudgetClass $budgetClass)
    {
        return $budgetClass->addDepense($id);
    }
}
