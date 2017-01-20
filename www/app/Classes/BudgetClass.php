<?php
namespace App\Classes;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Action;
use App\Budget;
use App\BudgetDepense;
use App\BudgetCategory;
use App\Service;

use App\Classes\TempsClass;

class BudgetClass extends TempsClass
{
    public function __construct()
    {
        $this->budget = new Budget;
        $this->budgetDepense = new BudgetDepense;
        $this->budgetCategory = new BudgetCategory;
        $this->service = new Service;
    }
    
    // récupère le total d'un budget
    public function getTotal($id)
    {
        if($this->budget->find($id)) {
            $vote = $this->budget->find($id)->vote;
            $dm = $this->budget->find($id)->dm;

            foreach($this->budgetDepense->where('budget_id', $id)->get() as $depenses) {
                $vote = $vote + $dm - ($depenses->amount);
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

    public function addYear($idService, $year)
    {
        $default = [
            "name" => "Nouveau budget",
            "vote" => 0,
            "dm" => 0
        ];

        $this->budget->service_id = $idService;
        $this->budget->name = $default['name'];
        $this->budget->dm = $default['dm'];
        $this->budget->vote = $default['vote'];
        $this->budget->date = Carbon::parse($year)->year;

        if($this->budget->save()) {
            $response = [
                "status" => "success",
                "name" => $default['name'],
                "vote" => $default['vote'],
                "id" => $this->budget->id,
                "year" => Carbon::parse($year)->year
            ];
        } else {
            $response = [
                "status" => "success"
            ];
        }

        return json_encode($response);
    }

    public function add()
    {
        $default = [
            "name" => "Nouveau budget",
            "vote" => 0,
            "dm" => 0
        ];

        if($this->budget->count() > 0) { // s'il y a plus d'une année, on choisi la dernière et on ajoute une année
            $last = $this->budget->orderBy("date", "DESC")->first()->date + 1;
        } else { // sinon on met l'année d'aujourd'hui
            $last = Carbon::now()->year;
        }

        $this->budget->service_id = $this->service->first()->id;
        $this->budget->name = $default['name'];
        $this->budget->dm = $default['dm'];
        $this->budget->vote = $default['vote'];
        $this->budget->date = $last;

        if($this->budget->save()) {
            $response = [
                "status" => "success",
                "name" => $default['name'],
                "vote" => $default['vote'],
                "id" => $this->budget->id,
                "last" => $last
            ];
        } else {
            $response = [
                "status" => "error"
            ];
        }

        return json_encode($response);
    }

    public function edit($request)
    {
        $id = $request->get("id");
        $name = $request->get("name");
        $vote = $request->get("vote");

        if($this->budget->find($id)) {
            $this->budget->where('id', $id)->update([
                'name' => $name,
                'vote' => $vote
            ]);

            $response = [
                "status" => "success",
                "name" => $name,
                "vote" => number_format($vote, 2, '.', ' ')
            ];
        } else {
            $response = [
                "status" => "error"
            ];
        }

        return json_encode($response);
    }

    public function delete($id)
    {
        if($this->budget->find($id)) {
            $this->budget->where('id', $id)->delete();

            $response = [
                "status" => "success",
                "id" => $id
            ];
        } else {
            $response = [
                "status" => "error"
            ];
        }

        return json_encode($response);
    }

    public function deleteYear($year)
    {
        if($this->budget->where('date', $year)->count () > 0) {
            $this->budget->where('date', $year)->delete();

            $response = [
                "status" => "success",
                "year" => $year
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