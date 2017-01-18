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
    public function __construct()
    {
        $this->budget = new Budget;
        $this->budgetDepense = new BudgetDepense;
        $this->budgetCategory = new BudgetCategory;
    }
    
    // récupère le total d'un budget
    public function total($id)
    {
        $budget = new Budget;
        $budgetDepense = new BudgetDepense;

        $vote = $budget->find($id)->vote;

        foreach($budgetDepense->where('budget_id', $id)->get() as $depenses) {
            $vote = $vote - $depenses->amount;
        }
        
        return $vote;
    }

    public function getDepense($id)
    {
        $resultat = ['status' => 'success'];

        foreach($this->budgetDepense->where('budget_id', $id)->get() as $depenses) {
            $resultat[]['category'] = $depenses->category;
            $resultat[]['amount'] = $depenses->amount;
        }

        return json_encode($resultat);
    }

    public function addDepense($id)
    {
        $budget = new Budget;
        $budgetDepense = new BudgetDepense;

        $amount = 0;
        $category = "Nouvelle dépense";

        $budgetDepense->budget_id = $id;
        $budgetDepense->category = $category;
        $budgetDepense->amount = $amount;

        if($budgetDepense->save()) {
            $resultat = array(
                'status' => 'success',
                'category' => $category,
                'amount' => $amount
            );
        } else {
            $resultat = array(
                "status" => "error"
            );
        }
        
        return json_encode($resultat);
    }
}