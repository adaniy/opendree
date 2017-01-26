<?php
namespace App\Classes;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Service;
use App\Dashboard;
use App\DashboardAgent;
use App\DashboardHoliday;
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
        $this->dashboardAgent = new DashboardAgent;
        $this->dashboardHoliday = new DashboardHoliday;
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

    public function addAgent($request)
    {
        $idService = $request->get('service_id');
        $name = $request->get('name');

        $this->dashboardAgent->name = $name;
        $this->dashboardAgent->service_id = $idService;
        
        if($this->dashboardAgent->save()) {
            $response = [
                "status" => "success",
                "name" => $name,
                "idService" => $idService,
                'id' => $this->dashboardAgent->id
            ];
        } else {
            $response = [
                "status" => "error"
            ];
        }

        return json_encode($response);
    }

    public function deleteAgent($id)
    {
        if($this->dashboardAgent->find($id)) {
            $this->dashboardAgent->where('id', $id)->delete();

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

    public function addCategory()
    {
        $default = [
            'name' => 'nouvelle catégorie',
            'type' => 'amount'
        ];

        $this->dashboardCategories->name = $default['name'];
        $this->dashboardCategories->type = $default['type'];

        if($this->dashboardCategories->save()) {
            $response = [
                "status" => "success",
                "name" => $default['name'],
                "type" => $default['type']
            ];
        } else {
            $response = [
                "status" => "error"
            ];
        }

        return json_encode($response);
    }

    public function editCategory($request)
    {
        $id = $request->get("id");
        $name = $request->get("name");
        $type = $request->get("type");

        if($this->dashboardCategories->find($id)) {
            $this->dashboardCategories->where('id', $id)->update([
                'name' => $name,
                'type' => $type
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

     public function deleteCategory($id)
     {
         $this->dashboardCategories->where('id', $id)->delete();
         
         $response = [
             "status" => "success"
         ];

         return json_encode($response);
     }

    public function addHoliday($request)
    {
        $idAgent = $request->get('idAgent');
        $debut = $request->get('debut');
        $fin = $request->get('fin');
        
        $this->dashboardHoliday->agent_id = $idAgent;
        $this->dashboardHoliday->debut = $debut;
        $this->dashboardHoliday->fin = $fin;

        // TERMINER LA VERIFICATION \\
        // pour vérifier, on fait une liste des congés de l'agent
        if($this->dashboardHoliday->where('agent_id', $idAgent)->count() > 0) {
            if($this->dashboardHoliday->where('agent_id', $idAgent)
               ->where('fin', '>', $debut)
               ->count() == 0) {
                if($this->dashboardHoliday->save()) {
                    $response = [
                        "status" => "success"
                    ];
                } else {
                    $response = [
                        "status" => "error",
                        "error" => "La requête n'a pas pu être executée."
                    ];
                }
            } else {
                $response = [
                        "status" => "error",
                        "error" => "Cet agent possède déjà un jour de congé dans la période choisie."
                    ];
            }
        } else {
            if($this->dashboardHoliday->save()) {
                $response = [
                    "status" => "success"
                ];
            } else {
                $response = [
                    "status" => "error",
                    "error" => "La requête n'a pas pu être executée."
                ];
            }
        }
        
        return json_encode($response);
    }
    
    public function editAmount($request)
    {
        $dashboardId = $request->get('dashboard_id');
        $categoryId = $request->get('category_id');
        $amount = $request->get('amount');
        $type = $this->dashboardCategories->find($categoryId)->type;

        if($this->dashboardCategories->find($categoryId)->type == 'money') {
            $amountDisplay = number_format($request->get('amount'), 2).' €';
        } else {
            $amountDisplay = $request->get('amount');
        }
        
        if($this->dashboardAmount->where([
            ['dashboard_id', $dashboardId],
            ['category_id', $categoryId]
        ])->count() > 0) {
               // si il existe déjà, on le modifie
            
               $this->dashboardAmount->where([
                   ['dashboard_id', $dashboardId],
                   ['category_id', $categoryId]
               ])->update([
                   "amount" => $amount
               ]);

               $response = [
                   "status" => "success",
                   "category_id" => $categoryId,
                   "dashboard_id" => $dashboardId,
                   "amount" => $amount,
                   "amountDisplay" => $amountDisplay,
                   "type" => $type
               ];
           } else { // sinon on le créé
               $this->dashboardAmount->dashboard_id = $dashboardId;
               $this->dashboardAmount->category_id = $categoryId;
               $this->dashboardAmount->amount = $amount;
               $this->dashboardAmount->date = Carbon::now();

               if($this->dashboardAmount->save()) {
                   $response = [
                       "status" => "success",
                       "category_id" => $categoryId,
                       "dashboard_id" => $dashboardId,
                       "amount" => $amount,
                       "amountDisplay" => $amountDisplay,
                       "type" => $type
                   ];
               } else {
                   $response = [
                       "status" => "error"
                   ];
               }
           }

        return json_encode($response);
    }

    public function editAmountService($request)
    {
        $dashboardId = $request->get('dashboard_id');
        $serviceId = $request->get('service_id');
        $agents = $request->get('agents');
        $holidays = $request->get('holidays');
        $hours = $request->get('hours');
        
        if($this->dashboardService->where([
            ['dashboard_id', $dashboardId],
            ['service_id', $serviceId]
        ])->count() > 0) {
               // si il existe déjà, on le modifie
            
               $this->dashboardService->where([
                   ['dashboard_id', $dashboardId],
                   ['service_id', $serviceId]
               ])->update([
                   "amount" => $amount
               ]);

               $response = [
                   "status" => "success",
                   "service_id" => $serviceId,
                   "dashboard_id" => $dashboardId,
                   "agents" => $agents,
                   "holidays" => $holidays,
                   "hours" => $hours
               ];
           } else { // sinon on le créé
               $this->dashboardService->dashboard_id = $dashboardId;
               $this->dashboardService->service_id = $serviceId;
               $this->dashboardService->amount = $amount;
               $this->dashboardService->date = Carbon::now();

               if($this->dashboardAmount->save()) {
                   $response = [
                       "status" => "success",
                       "service_id" => $serviceId,
                       "dashboard_id" => $dashboardId,
                       "amount" => $amount,
                   ];
               } else {
                   $response = [
                       "status" => "error"
                   ];
               }
           }

        return json_encode($response);
    }
    
    public function getDate($year, $month)
    {
        $mois = $this->temps->parseMois($month);

        return $mois.' '.$year;
    }

    public function getIdMonth($year, $month)
    {
        return $this->dashboard->whereYear('date', $year)->whereMonth('date', $month)->first()->id;
    }

    public function getIdYear($year)
    {
        return false;
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

    public function getAmountRaw($idCategory)
    {
        if($this->dashboardAmount->where('category_id', $idCategory)->count() > 0) {
            $amount = $this->dashboardAmount->where('category_id', $idCategory)->first()->amount;

            return $amount;
        } else {
            return 0;
        }
    }

    public function holidayCalendar($year, $idService)
    {
        $debut = Carbon::create($year, 01, 01);
        $fin = Carbon::create($year, 12, 31);

        for($x = $debut; $x < $fin; $x->addDay()) {
            $calendar[] = $x->format('Y-m-d');
        }

        return $calendar;
    }

    public function getPlurality($test, $idCorS, $year, $month)
    {
        
        
    }
}