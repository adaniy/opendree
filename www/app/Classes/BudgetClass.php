<?php
namespace App\Classes;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Action;
use App\Budget;
use App\BudgetDepense;
use App\BudgetCategory;

use App\Classes\TempsClass;

class BudgetClass extends TempsClass
{
    // récupère le total d'un budget
    public function total($id)
    {
        $budget = new Budget;
        $budgetDepense = new BudgetDepense;
        $budgetCategory = new BudgetCategory;

        $arrayBudget = [];
        $arrayDepense = [];

        // on récupère un array représentant les budgets
        foreach($budget->get() as $budgets) {
            $arrayBudget[] = $budgets->vote;
        }

        // on retrouve la position dans l'array de l'id
        $key = array_search($id, $arrayBudget);

        return $arrayBudget[0];
    }
}