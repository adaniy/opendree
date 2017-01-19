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
    public function getTotal($id)
    {
        if($this->budget->find($id)) {
            $vote = $this->budget->find($id)->vote;

            foreach($this->budgetDepense->where('budget_id', $id)->get() as $depenses) {
                $vote = $vote - $depenses->amount;
            }

            $response = [
                "status" => "success",
                "total" => number_format($vote, 2, '.', ' ')
            ];
        } else {
            $response = [
                "status" => "error"
            ];
        }
        
        return json_encode($response);
    }

    public function getDepense($id)
    {
        $category = $this->budgetDepense->find($id)->category;
        $amount = $this->budgetDepense->find($id)->amount;

        $resultat = [
            "category" => $category,
            "amount" => $amount
        ];

        return json_encode($resultat);
    }

    public function addDepense($id)
    {
        $amount = 0;
        $category = "Nouvelle dépense";

        $this->budgetDepense->budget_id = $id;
        $this->budgetDepense->category = $category;
        $this->budgetDepense->amount = $amount;

        if($this->budgetDepense->save()) {
            $resultat = array(
                'status' => 'success',
                'id' => $this->budgetDepense->id,
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

    public function editDepense($request)
    {
        $id = $request->get("id");

        if($this->budgetDepense->find($id)) {
            if(!empty($request->get("category"))) {
                $category = $request->get("category");
                $amount = $request->get("amount");

                $this->budgetDepense->where('id', $id)->update(["category" => $category, "amount" => $amount]);
                $response = [
                    "status" => "success",
                    "category" => $category,
                    "amount" => number_format($amount, 2, '.', ' '),
                    "budget_id" => $this->budgetDepense->find($id)->budget_id
                ];
            } else {
                $response = [
                    "status" => "error"
                ];
            }
        } else {
            $response = [
                "status" => "unknown"
            ];
        }
            

        return json_encode($response);
    }

    public function deleteDepense($id)
    {
        $budget_id = $this->budgetDepense->find($id)->budget_id;

        if($this->budgetDepense->where('id', $id)->delete()) {
            $response = [
                'status' => 'success',
                'budget_id' => $budget_id
            ];
        } else {
            $response = [
                'status' => 'error'
            ];
        }

        return json_encode($response);
    }
}