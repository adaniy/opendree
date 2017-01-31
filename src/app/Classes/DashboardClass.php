<?php
namespace App\Classes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    /**
     * Retourne les données de manière asynchrone des tableaux de bord, par année
     * @param $year
     * @return json
     * @exception json
     */
    public function statsYear($year)
    {
        // on récupère les mois où des données existent
        $dashboardPeriod = $this->dashboardAmount->whereYear('date', (string) $year)->orderBy('id', 'ASC')->get();
        $dashboardCategories = $this->dashboardCategories->orderBy('name', 'ASC')->get();

        $resultat = array(
            'status' => 'success',
            'line' => array(
                'month' => array(),
                'categories' => array(
                    'id' => array(),
                    'month' => array(),
                    'values' => array()
                ),
                'nbCategory' => array()
            )
        );

        /** Cette boucle doit être identique avec l'autre, dans la boucle des mois */
        foreach($dashboardCategories as $categories) {
            $color = $categories->color;
            /** On fait une liste des mois avec des données à l'intérieur */
            $data = [];

            for($x = 1; $x <= 12; $x++) {
                $month = $this->carbon->create($year, $x, 1)->format("m");

                if($this->dashboardAmount->whereYear('date', (string) $year)->whereMonth('date', $month)->where('category_id', $categories->id)->count() > 0) {
                    $date = $this->carbon->create($year, $month, 1);
                    /** On peut enfin récupérer la pluralité */
                    $data[] = DashboardClass::getPluralityAmount($categories->id, 0, $date, 'month');
                }
            }

            array_push($resultat['line']['categories']['values'], [
                'label' => $categories->name,
                'fill' => false,
                'lineTension' => 0.2,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'borderCapStyle' => 'butt',
                'borderDash' => [],
                'borderDashOffet' => 0.0,
                'borderJoinStyle' => 'miter',
                'pointBorderColor' => $color,
                'pointBackgroundColor' => "#fff",
                'pointBorderWidth' => 1,
                'pointHoverRadius' => 5,
                'pointHoverBackgroundColor' => $color,
                'pointHoverBorderColor' => $color,
                'pointHoverBorderWidth' => 2,
                'pointRadius' => 1,
                'pointHitRadius' => 10,
                'data' => $data,
                'stepSize' => 1,
                'spanGaps' => false
            ]);
        }

        foreach($dashboardPeriod as $dashboardPeriods) {
            // pour chaque mois
            $month = $this->temps->parseMois($this->carbon->parse($dashboardPeriods->date)->month);
            /** Cette variable sert pour la recherche du nombre de donnée par mois. Il est également nécessaire de formater la réponse de Carbon afin d'obtenir la bonne valeur. */
            $monthRaw = $this->carbon->parse($dashboardPeriods->date)->format('m');

            if(!in_array($month, $resultat['line']['month'], true)) {
                /** Faire une boucle pour récupérer toute les catégories */
                array_push($resultat['line']['month'], $month);
            }
        }

        return json_encode($resultat);
    }

    /**
     * Retourne les données de manière asynchrone des tableaux de bord, par année
     * Sert à remplir les données du graphique Pie
     * @param $year
     * @return json
     * @exception json
     */
    public function statsYearComparison($year)
    {
        $resultat = [
            'status' => 'success',
            'pie' => [
                'labels' => [],
                'data' => []
            ]
        ];

        $data = [];
        $colors = [];

        /** On récupère les catégories */
        foreach($this->dashboardCategories->get() as $categories) {
            $color = $categories->color;
            array_push($data, DashboardClass::getPluralityAmount($categories->id, 0, $this->carbon->create($year, 1, 1), 'year'));
            array_push($colors, $color);

            /** On ajoute les catégories */
            array_push($resultat['pie']['labels'], $categories->name);

            /** Pour chaque catégorie, on execute leur pluralité annuelle */

        }

        $resultat['pie']['data'] = $data;
        $resultat['pie']['backgroundColor'] = $colors;
        $resultat['pie']['hoverBackgroundColor'] = $colors;

        return json_encode($resultat);
    }

    /**
     * Retourne les données de manière asynchrone des tableaux de bord, depuis le début des temps
     * Sert à remplir les données du graphique Pie
     * @return json
     */
    public function stats()
    {
        $dashboardPeriod = $this->dashboardAmount->orderBy('id', 'ASC')->groupBy(DB::raw('date(date, "start of year")'))->get();
        $dashboardCategories = $this->dashboardCategories->orderBy('name', 'ASC')->get();

        $resultat = array(
            'status' => 'success',
            'line' => array(
                'year' => array(),
                'categories' => array(
                    'id' => array(),
                    'year' => array(),
                    'values' => array()
                ),
                'nbCategory' => array()
            )
        );

        /** Cette boucle doit être identique avec l'autre, dans la boucle des mois */
        foreach($dashboardCategories as $categories) {
            $color = $categories->color;
            /** On fait une liste des mois avec des données à l'intérieur */
            $data = [];

            foreach($dashboardPeriod as $dashboardPeriods) {
                $year = $this->carbon->parse($dashboardPeriods->date)->year;

                /** On fait une liste des années disponible */
                if($this->dashboardAmount->whereYear('date', (string) $year)->where('category_id', $categories->id)->count() > 0) {
                    $data[] = DashboardClass::getPluralityAmount($categories->id, 0, $dashboardPeriods->date, 'year');
                }

            }

            array_push($resultat['line']['categories']['values'], [
                'label' => $categories->name,
                'fill' => false,
                'lineTension' => 0.2,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'borderCapStyle' => 'butt',
                'borderDash' => [],
                'borderDashOffet' => 0.0,
                'borderJoinStyle' => 'miter',
                'pointBorderColor' => $color,
                'pointBackgroundColor' => "#fff",
                'pointBorderWidth' => 1,
                'pointHoverRadius' => 5,
                'pointHoverBackgroundColor' => $color,
                'pointHoverBorderColor' => $color,
                'pointHoverBorderWidth' => 2,
                'pointRadius' => 1,
                'pointHitRadius' => 10,
                'data' => $data,
                'stepSize' => 1,
                'spanGaps' => false
            ]);
        }

        foreach($dashboardPeriod as $dashboardPeriods) {
            $year = $this->carbon->parse($dashboardPeriods->date)->year;

            if(!in_array($year, $resultat['line']['year'], true)) {
                /** Faire une boucle pour récupérer toute les catégories */
                array_push($resultat['line']['year'], $year);
            }
        }

        return json_encode($resultat);
    }

    /**
     * Retourne les données de manière asynchrone des tableaux de bord, par année
     * Sert à remplir les données du graphique Pie
     * @param $year
     * @return json
     * @exception json
     */
    public function statsComparison()
    {
        $resultat = [
            'status' => 'success',
            'pie' => [
                'labels' => [],
                'data' => []
            ]
        ];

        $data = [];
        $colors = [];

        /** On récupère les catégories */
        foreach($this->dashboardCategories->get() as $categories) {
            $color = $categories->color;
            array_push($data, DashboardClass::getPluralityAmount($categories->id, 0, null, 'all-time'));
            array_push($colors, $color);

            /** On ajoute les catégories */
            array_push($resultat['pie']['labels'], $categories->name);
        }

        $resultat['pie']['data'] = $data;
        $resultat['pie']['backgroundColor'] = $colors;
        $resultat['pie']['hoverBackgroundColor'] = $colors;

        return json_encode($resultat);
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
            'type' => 'amount',
            'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT)
        ];

        $this->dashboardCategories->name = $default['name'];
        $this->dashboardCategories->type = $default['type'];
        $this->dashboardCategories->color = $default['color'];

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
                'type' => $type,
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

    /**
     * Ajout d'un congé.
     * @param $request
     * @return json
     * @exception json
     * @see json_encode ; XHR
     */
    public function addHoliday($request)
    {
        $idAgent = $request->get('idAgent');
        $debut = $request->get('debut');
        $fin = $request->get('fin');

        $this->dashboardHoliday->agent_id = $idAgent;
        $this->dashboardHoliday->debut = $debut;
        $this->dashboardHoliday->fin = $fin;

        /** Pour vérifier, on fait une liste des congés de l'agent ... */
        if($this->dashboardHoliday->where('agent_id', $idAgent)->count() > 0) {
            if($this->dashboardHoliday
               ->where([
                   ['debut', '<', Carbon::parse((string) $fin)],
                   ['fin', '>', Carbon::parse((string) $debut)],
                   ['agent_id', $idAgent]
               ])
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

    /**
     * Suppression d'un congé.
     * @param
     * @return
     * @exception
     * @see
     */
    public function deleteHoliday($id)
    {
        if($this->dashboardHoliday->find($id)) {
            $this->dashboardHoliday->where('id', $id)->delete();

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

    public function editAmount($request)
    {
        $dashboardId = $request->get('dashboard_id');
        $categoryId = $request->get('category_id');
        $amount = $request->get('amount');
        $type = $this->dashboardCategories->find($categoryId)->type;
        $date = $request->get('date');

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
            $this->dashboardAmount->date = $date;

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

    public function getDateRaw($year, $month)
    {
        return Carbon::create($year, $month, 01);
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

    public function getMonthRaw($date)
    {
        return $this->carbon->parse($this->dashboard->where('date', $date)->first()->date)->month;
    }

    public function getMonthNumber($date)
    {
        return $this->carbon->parse($this->dashboard->where('date', $date)->first()->date)->format('m');;
    }

    public function getAmount($idCategory, $idDashboard)
    {
        if($this->dashboardAmount->where('category_id', $idCategory)->where('dashboard_id', $idDashboard)->count() > 0) {
            $amount = $this->dashboardAmount->where('category_id', $idCategory)->where('dashboard_id', $idDashboard)->first()->amount;

            if($this->dashboardCategories->find($idCategory)->type == 'money') {
                return number_format($amount, 2).' €';
            } else {
                return $amount;
            }
        } else {
            return 0;
        }
    }

    public function getAmountRaw($idCategory, $idDashboard)
    {
        if($this->dashboardAmount->where('category_id', $idCategory)->where('dashboard_id', $idDashboard)->count() > 0) {
            $amount = $this->dashboardAmount->where('category_id', $idCategory)->where('dashboard_id', $idDashboard)->first()->amount;
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

    /**
     * Obtiens la pluralité (cumul) du montant d'une catégorie, avec plusieurs choix de type de calcul.
     * @param $idCategory, $amount, $date, $type
     * @return $plurality
     * @exception null
     * @see DashboardAmount() ; Carbon() ; TempsClass()
     */
    public function getPluralityAmount($idCategory, $amount, $date, $type)
    {
        if($this->dashboardAmount->where('category_id', $idCategory)->count() > 0) {
            if($type == 'month-last-year') { // mois année précédente
                $plurality = 0;

                if($this->dashboardAmount->whereYear('date', (string) Carbon::parse($date)->subYear()->year)->whereMonth('date', (string) $date->month)->where('category_id', $idCategory)->count() > 0) {
                    $plurality = $this->dashboardAmount->whereYear('date', (string) Carbon::parse($date)->subYear()->year)->whereMonth('date', (string) $date->month)->where('category_id', $idCategory)->first()->amount;
                }

                return $plurality;
            } elseif($type == 'last-year') { // cumul année précédente
                $plurality = 0;

                foreach($this->dashboardAmount->whereYear('date', (string) Carbon::parse($date)->subYear()->year)
                        ->where('category_id', $idCategory)
                        ->get() as $amounts) {
                    $plurality += $amounts->amount;
                }

                return $plurality;
            } elseif($type == 'year') { // cumul année
                $plurality = 0;

                /** Modifier parse par create($date, 1, 1)->year */
                
                foreach($this->dashboardAmount->whereYear('date', (string) Carbon::parse($date)->year)->where('category_id', $idCategory)->get() as $amounts) {
                    $plurality += $amounts->amount;
                }
                
                /*
                foreach($this->dashboardAmount->whereYear('date', (string) Carbon::create($date, 1, 1)->year)->where('category_id', $idCategory)->get() as $amounts) {
                    $plurality += $amounts->amount;
                }
                */
                return $plurality;
            } elseif($type == 'month') { // cumul mois
                $plurality = 0;
                if($this->dashboardAmount->whereYear('date', (string) $date->year)->whereMonth('date', (string) $date->format("m"))->where('category_id', $idCategory)->count() > 0) {
                    $plurality = $this->dashboardAmount->whereYear('date', (string) $date->year)->whereMonth('date', $date->format("m"))->where('category_id', $idCategory)->first()->amount;
                }

                return $plurality;
            } elseif($type == 'all-time') {
                $plurality = 0;

                foreach($this->dashboardAmount->where('category_id', $idCategory)->get() as $amounts) {
                    $plurality += $amounts->amount;
                }

                return $plurality;
            } else {
                return null;
            }
        } else { return null; }
    }

    public function isActualYear($yearActual, $yearData)
    {
        if($yearActual == $yearData) {
            return 'in';
        } else {
            return '';
        }
    }

    public function isActualYearButton($yearActual, $yearData)
    {
        if($yearActual == $yearData) {
            return 'active';
        } else {
            return '';
        }
    }

    public function isActualMonth($monthActual, $yearActual, $monthData, $yearData)
    {
        if($monthActual == $monthData && $yearActual == $yearData) {
            return 'active';
        } else {
            return '';
        }
    }

    /**
     * Vérifie si l'agent ciblé est en congé dans la date donnée.
     * @param $idAgent, $date
     * @return true
     * @exception false
     * @see dashboardAgent() ; tempsClass()
     */
    public function isInHoliday($idAgent, $date)
    {
        if($this->dashboardAgent->find($idAgent)) {
            /** On prend la date et cherche dans les congés si il y est présent */
            if($this->dashboardHoliday->where([
                ['debut', '<=', $date],
                ['fin', '>=', $date],
                ['agent_id', $idAgent]
            ])->count() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Renvoie l'ID d'un congé s'il y a lieu d'être.
     * @param $idAgent, $date
     * @return $id
     * @exception false
     * @see dashbordHoliday() ; TempsClass()
     */

    public function isInHolidayId($idAgent, $date)
    {
        if($this->dashboardAgent->find($idAgent)) {
            /** On prend la date et cherche dans les congés si il y est présent */
            if($this->dashboardHoliday->where([
                ['debut', '<=', $date],
                ['fin', '>=', $date],
                ['agent_id', $idAgent]
            ])->count() > 0) {
                return $this->dashboardHoliday->where([
                    ['debut', '<=', $date],
                    ['fin', '>=', $date],
                    ['agent_id', $idAgent]
                ])->first()->id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Renvoie la date de début et de fin d'une période de congé
     * @param $idAgent, $date
     * @return array
     * @exception
     * @see DashboardClass::
     */
    public function isInHolidayDates($idAgent, $date)
    {
        if($this->dashboardAgent->find($idAgent)) {
            /** On prend la date et cherche dans les congés si il y est présent */
            if($this->dashboardHoliday->where([
                ['debut', '<=', $date],
                ['fin', '>=', $date],
                ['agent_id', $idAgent]
            ])->count() > 0) {
                /** Si il est présent, on se permet alors de récupérer la date de début et la date de fin */
                $debut = $this->dashboardHoliday->where([
                    ['debut', '<=', $date],
                    ['fin', '>=', $date],
                    ['agent_id', $idAgent]
                ])->first()->debut;

                $fin = $this->dashboardHoliday->where([
                    ['debut', '<=', $date],
                    ['fin', '>=', $date],
                    ['agent_id', $idAgent]
                ])->first()->fin;

                return [
                    "debut" => $debut,
                    "fin" => $fin
                ];
            } else {
                return [
                    "debut" => null,
                    "fin" => null
                ];
            }
        } else {
            return [
                "debut" => null,
                "fin" => null
            ];
        }
    }
}