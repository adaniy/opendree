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
            $total = $vote + $dm;
            
            // si il y a des dépenses dans ce budget, alors on peut les soustraire aux votes et DM
            if($this->budgetDepense->where('budget_id', $id)->count() > 0) {
                foreach($this->budgetDepense->where('budget_id', $id)->get() as $depenses) {
                    $total -= $depenses->amount;
                }
            } 

            $response = [
                "status" => "success",
                "total" => number_format($total, 2, '.', ' ')
            ];
        } else {
            $response = [
                "status" => "error"
            ];
        }
        
        return json_encode($response);
    }

    public function getTotalRaw($id)
    {
        if($this->budget->find($id)) {
            $vote = $this->budget->find($id)->vote;
            $dm = $this->budget->find($id)->dm;

            $total = $vote + $dm;
        } 

        
        return $total;
    }

    public function getSpentPercentage($total, $spent)
    {
        if($total == 0 || $spent == 0) {
            return 0;
        }
        
        return number_format(($spent / $total) * 100, 2);
    }

    public function getSpent($id)
    {
        if($this->budget->find($id)) {
            $spent = 0;
            if($this->budgetDepense->where('budget_id', $id)->count() > 0) {
                foreach($this->budgetDepense->where('budget_id', $id)->get() as $depenses) {
                    $spent += $depenses->amount;
                }
            }
        }

        return $spent;
    }

    public function getRemaining($total, $spent)
    {
        return $total - $spent;
    }

    public function getVariation($vote, $dm)
    {
        if($vote == 0 || $dm == 0) {
            return 0;
        } else {
            return $vote / $dm;
        }
    }

    public function addYear($year)
    {
        $default = [
            "name" => "Nouveau budget",
            "vote" => 0,
            "dm" => 0
        ];

        $this->budget->service_id = $this->service->first()->id;
        $this->budget->name = $default['name'];
        $this->budget->dm = $default['dm'];
        $this->budget->vote = $default['vote'];
        $this->budget->date = $year;

        if($this->budget->save()) {
            $response = [
                "status" => "success",
                "name" => $default['name'],
                "vote" => $default['vote'],
                "id" => $this->budget->id,
                "year" => $year
            ];
        } else {
            $response = [
                "status" => "success"
            ];
        }

        return json_encode($response);
    }

    public function add($id, $year)
    {
        $default = [
            "name" => "Nouveau budget",
            "vote" => 0,
            "dm" => 0
        ];

        $this->budget->service_id = $id;
        $this->budget->name = $default['name'];
        $this->budget->dm = $default['dm'];
        $this->budget->vote = $default['vote'];
        $this->budget->date = $year;

        if($this->budget->save()) {
            $response = [
                "status" => "success",
                "name" => $default['name'],
                "vote" => $default['vote'],
                "dm" => $default['dm'],
                "id" => $this->budget->id,
                "year" => $year
            ];
        } else {
            $response = [
                "status" => "error"
            ];
        }

        return json_encode($response);
    }

    public function deleteService($id)
    {
        $this->service->where('id', $id)->delete();

        $response = [
            "status" => "success"
        ];

        return json_encode($response);
    }

    public function edit($request)
    {
        $id = $request->get("id");
        $name = $request->get("name");
        $vote = $request->get("vote");
        $dm = $request->get("dm");

        if($this->budget->find($id)) {
            $this->budget->where('id', $id)->update([
                'name' => $name,
                'vote' => $vote,
                'dm' => $dm
            ]);

            $response = [
                "status" => "success",
                "name" => $name,
                "vote" => number_format($vote, 2, '.', ' '),
                "dm" => number_format($dm, 2, '.', ' ')
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

    // fonctions obtenant les informations pour le tableau \\

    // on obtiens la liste des budgets, et le premier budget d'un service possède le header du service
    public function rowSpan($id, $idService, $year)
    {
        $count = $this->budget->where([
            ['service_id', $idService],
            ['date', $year]
        ])->count();
        
        if($this->budget->where([
            ['service_id', $idService],
            ['date', $year]
        ])->orderBy('id', 'ASC')->first()->id == $id
        && $count > 1) {
            $column = '<th class="service-side" rowspan="'.$count.'">'.$this->service->find($idService)->name.'</th>';
        } elseif($this->budget->where([
            ['service_id', $idService],
            ['date', $year]
        ])->orderBy('id', 'ASC')->first()->id == $id
        && $count == 1) {
            $column = '<th>'.$this->service->find($idService)->name.'</th>';
        } else {
            $column = '';
        }
        
        return $column;
    }
}