<?php
namespace App\Classes;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Service;
use App\Dashboard;
use App\DashboardCategories;
use App\DashboardService;
use App\DashboardAmount;

use App\Classes\TempsClass;

class DashboardClass extends TempsClass
{
    public function __construct()
    {
        $this->temps = new TempsClass;
        $this->service = new Service;
        $this->dashboard = new Dashboard;
        $this->dashboardCategories = new DashboardCategories;
        $this->dashboardService = new DashboardService;
        $this->dashboardAmount = new DashboardAmount;

        $this->carbon = new Carbon;
    }

    public function add($year)
    {
        $day = 1;
        $month = 1; // le mois de janvier est créé comme premier mois
        $date = $this->carbon->now();

        $date->year($year);
        $date->month($month);
        $date->day($day);

        $this->dashboard->date = $date;

        if($this->dashboard->whereYear('date', $year)->count() == 0) {
            if($this->dashboard->save()) {
                $response = [
                    "status" => "success",
                    "year" => $year
                ];
            } else {
                $response = [
                    "status" => "error"
                ];
            }
        } else {
            $response = [
                "status" => "error",
                "error" => "L'année entrée existe déjà."
            ];
        }

        return json_encode($response);
    }

    public function addMonth($year)
    {
        $month = $this->carbon->parse($this->dashboard->whereYear('date', $year)->orderBy('date', 'DESC')->first()->date);

        if($this->carbon->parse($month)->month < 12) {
            $month->addMonth();

            $this->dashboard->date = $month;
            if($this->dashboard->save()) {
                $response = [
                    "status" => "success",
                    "year" => $year,
                    "month" => $this->temps->parseMois($this->carbon->parse($month)->month),
                    "monthNumber" => $this->carbon->parse($month)->format('m')
                ];
            } else {
                $response = [
                    "status" => "error",
                    "error" => "Il y a une erreur dans le traitement de cette requête."
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'error' => "Il n'est pas possible d'ajouter un mois à cette année."
            ];
        }

        return json_encode($response);
    }

    public function addService()
    {
        $default = [
            'name' => 'nouveau service',
        ];

        $this->service->name = $default['name'];

        if($this->service->save()) {
            $response = [
                "status" => "success",
                "name" => $default['name']
            ];
        } else {
            $response = [
                "status" => "error"
            ];
        }

        return json_encode($response);
    }

    public function editService($request)
    {
        $id = $request->get("id");
        $name = $request->get("name");

        if($this->service->find($id)) {
            $this->service->where('id', $id)->update([
                'name' => $name
            ]);
            
            $response = [
                "status" => "success"
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
    
    public function getDate($year, $month)
    {
        $mois = $this->temps->parseMois($month);

        return $mois.' '.$year;
    }

    public function getYear($date)
    {
        return $this->carbon->parse($this->dashboard->where('date', $date)->first()->date)->year;
    }

    public function getMonth($date)
    {
        return $this->temps->parseMois($this->carbon->parse($this->dashboard->where('date', $date)->first()->date)->month);
    }

    public function getMonthNumber($date)
    {
        return $this->carbon->parse($this->dashboard->where('date', $date)->first()->date)->format('m');;
    }

    public function getAmount($idCategory)
    {
        if($this->dashboardAmount->where('category_id', $idCategory)->count() > 0) {
            $amount = $this->dashboardAmount->where('category_id', $idCategory)->first()->amount;

            if($this->dashboardCategories->find($idCategory)->type == 'money') {
                return number_format($amount, 2).' €';
            } else {
                return $amount;
            }
        } else {
            return 0;
        }
    }

    public function getPlurality($test, $idCorS, $year, $month)
    {
        
        
    }
}