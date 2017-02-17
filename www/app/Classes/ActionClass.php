<?php
namespace App\Classes;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Action;

use App\Classes\TempsClass;

class ActionClass extends TempsClass
{
    public function ajax($method, $change, $request)
    {
        if($request->ajax()) {
            $action = new Action;
            $temps = new TempsClass;

            if($method == "edit") {
                $id = $request->get('id');

                if($action->find($id)) {
                    if($change == "nom") {
                        $nom = e($request->get('nom'));

                        $action->where('id', $id)->update([
                            'nom' => $nom
                        ]);

                        $response = array(
                            'status' => 'success',
                            'id' => $id,
                        );

                        return json_encode($response);
                    } elseif($change == "description") {
                        $description = $request->get('description');


                        $action->where('id', $id)->update([
                            'description' => $description
                        ]);

                        $response = array(
                            'status' => 'success',
                            'id' => $id,
                        );

                        return json_encode($response);
                    } elseif($change == "date-creation") {
                        $dateCreation = $temps->convert($request->get('date_creation'));


                        $action->where('id', $id)->update([
                            'date_creation' => $dateCreation
                        ]);

                        $response = array(
                            'status' => 'success',
                            'id' => $id,
                        );

                        return json_encode($response);
                    } elseif($change == "date-realisation") {
                        $dateRealisation = $temps->convert($request->get('date_realisation'));


                        $action->where('id', $id)->update([
                            'date_realisation' => $dateRealisation
                        ]);

                        $response = array(
                            'status' => 'success',
                            'id' => $id,
                        );

                        return json_encode($response);
                    } elseif($change == "date-butoir") {
                        $dateButoir = $temps->convert($request->get('date_butoir'));


                        $action->where('id', $id)->update([
                            'date_butoir' => $dateButoir
                        ]);

                        $response = array(
                            'status' => 'success',
                            'id' => $id,
                        );

                        return json_encode($response);
                    } else {

                    }
                } else {
                    $response = array(
                        'status' => $id,
                    );

                    return json_encode($response);
                }
            }  elseif($method == "add") {
                // l'ajout via ajax ne comprend que le titre
                $nom = $request->get('nom');

                // le reste sont des valeurs vides
                $description = null;
                $alert = null;
                $date_creation = Carbon::now();
                $date_butoir = null;
                $date_realisation = null;

                $action->nom = $nom;
                $action->description = $description;
                $action->alert = $alert;
                $action->date_creation = $date_creation;
                $action->date_butoir = $date_butoir;
                $action->date_realisation = $date_realisation;

                if($action->save()) {
                    $response = array(
                        'status' => 'success',
                        'id' => $action->id,
                    );

                    return json_encode($response);
                } else {
                    $response = array(
                        'status' => 'error',
                    );

                    return json_encode($response);
                }
            } elseif($method == "get") {
                if($change == "date_butoir") {
                    $date = $temps->convert($request->get("date_butoir"));
                    $newDate = $temps->diff($date);

                    $response = array(
                        'status' => 'success',
                        'newDate' => $newDate
                    );

                    return json_encode($response);
                } elseif($change == "alerte") {
                    $alerte = $request->get("alerte");
                    $id = $request->get("id");

                    $action->where('id', $id)->update([
                        'alert' => $alerte
                    ]);

                    $response = array(
                        'status' => 'success',
                    );

                    return json_encode($response);
                }
            } else {
                $response = array(
                    'status' => 'error',
                );

                return json_encode($response);
            }
        }
    }

    public function insert(Request $request)
    {
        if(empty($request->input('alert'))) {
            $alert = 0;
        } else {
            $alert = $request->input('alert');
        }

        if(empty($request->input('realise'))) {
            $realise = 0;
        } else {
            $realise = $request->input('realise');
        }

        $nom = $request->input('nom');
        $alertStart = $request->input('alertStart');
        $date_creation = $request->input('date_creation');
        $date_butoir = $request->input('date_butoir');
        $date_realisation = $request->input('date_realisation');

        // On empêche de décocher "réalisé" tout en laissant une date de réalisation, et inversement
        if($realise == 0 AND !empty($date_realisation)) {
            return back()->with("erreur", "Lorsque l'action n'a pas été réalisée, il ne faut pas remplir de date de réalisation.")->withInput();
        } elseif($realise == 1 AND empty($date_realisation)) {
            return back()->with("erreur", "Lorsque l'action a été réalisée, il faut remplir une date de réalisation.")->withInput();
        } else {
            $action = new Action;
            $action->nom = $nom;
            $action->alert = $alert;

            $action->date_creation = $date_creation;
            $action->date_butoir = $date_butoir;
            $action->date_realisation = $date_realisation;

            if($action->save()) {
                return back()->with("valide", "L'action a bien été ajoutée.");
            } else {
                return back()->with("erreur", "L'action n'a pas pu être ajoutée.")->withInput();
            }
        }
    }

    public function update($id, Request $request)
    {
        $nom = $request->input('nom');
        $alert = $request->input('alert');
        $alertStart = $request->input('alertStart');
        $realise = $request->input('realise');
        $date_creation = $request->input('date_creation');
        $date_butoir = $request->input('date_butoir');
        $date_realisation = $request->input('date_realisation');

        // On empêche de décocher "réalisé" tout en laissant une date de réalisation, et inversement
        if($realise == 0 AND !empty($date_realisation)) {
            return back()->with("erreur", "Lorsque l'action n'a pas été réalisée, il ne faut pas remplir de date de réalisation.")->withInput();
        } elseif($realise == 1 AND empty($date_realisation)) {
            return back()->with("erreur", "Lorsque l'action a été réalisée, il faut remplir une date de réalisation.")->withInput();
        } else {
            $action = new Action;

            if($action->where('id', $id)
               ->update([
                   'nom' => $nom,
                   'alert' => $alert,
                   'alertStart' => $alertStart,
                   'realise' => $realise,
                   'date_creation' => $date_creation,
                   'date_butoir' => $date_butoir,
                   'date_realisation' => $date_realisation,
               ])) {
                return redirect('/')->with("valide", "L'action a bien été modifiée.");
            } else {
                return back()->with("erreur", "L'action n'a pas pu être modifiée.")->withInput();
            }
        }
    }

    public function delete($id)
    {
        $action = new Action;
        $deleted = $action->find($id);

        if($deleted) {
            $action->where('id', $id)->delete();
        }

        return redirect("action");
    }

    public function date($date)
    {
        $tempsClass = new TempsClass();

        if($date == null) {
            return "non complété";
        } else {
            return $tempsClass->parseDate($date);
        }
    }

    // Donne la différence en jour de l'action
    public function diff($date)
    {
        $tempsClass = new TempsClass();

        if($date == null) {
            return "non complété";
        } else {
            return $tempsClass->diff($date);
        }
    }

    public function description($string)
    {
        if($string == null) {
            return "non complété";
        } else {
            return $string;
        }
    }

    // Détecte si une action a une alerte enclenchable, si oui, retourne un script Javascript d'alerte basique.
    public function canAlert()
    {
        $action = new Action();
        $now = Carbon::now();
        $nb = 0;

        foreach($action->get() as $actions) {
            if(Carbon::createFromFormat("d/m/Y", $actions->date_butoir)->diffInDays($now) <= $actions->alertStart && $actions->alert == 1) {
                $nb++;
            }
        }

        // Si au moins 1 alerte est enclenchable, alors on peut afficher l'alerte, sinon rien
        if($nb > 0) {
            return "<script>self.alert(\"GDMC : une action ou plus arrive à la date butoir sans avoir été réalisée. Ouvrez le gestionnaire des actions pour voir le ou lesquelles.\")</script>";
        } else {
            return "";
        }
    }

    // Même chose qu'au-dessus, mais ne retourne qu'un 1 ou 0, afin d'effectuer des vérifications
    public function canAlertBoolean($id)
    {
        $action = new Action;
        $temps = new TempsClass;

        $now = Carbon::now();
        $alertStart = 30;

        if($action->find($id)->date_butoir != null) {
            if(Carbon::parse($action->find($id)->date_butoir)->diffInDays($now) <= $alertStart && $action->find($id)->alert == 1
               OR Carbon::parse($action->find($id)->date_butoir) <= $now && $action->find($id)->alert == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function alertButton($id) // retourne le bouton des alertes
    {
        $action = new Action;
        if($action->find($id)->alert == 1) {
            $button = '<button class="btn btn-md btn-danger action-alerte" value="0">ne pas recevoir d\'alerte</button>';
        } else {
            $button = '<button class="btn btn-md btn-success action-alerte" value="1">recevoir une alerte</button>';
        }

        return $button;
    }

    public function stats()
    {
        $carbon = new Carbon;
        $action = new Action;
        $realise = $action->where('deleted', 0)->whereNotNull("date_realisation")->count();
        $nonRealise = $action->where('deleted', 0)->whereNull("date_realisation")->count();
        $nb = $action->where('deleted', 0)->count();

        $resultat = array(
            'status' => 'success',
            'realise' => $realise,
            'nonRealise' => $nonRealise,
            'nb' => $nb,
            'line' => array(
                'annee' => array(),
                'nbRealise' => array(),
                'nbNonRealise' => array()
            )
        );

        // on récupère les années où des actions ont eu lieu
        $actionPeriod = $action->where('deleted', 0)->orderBy('date_creation')->get();

        foreach($actionPeriod as $actionPeriods) {
            // pour chaque année
            $year = $carbon->parse($actionPeriods->date_creation)->year;


            if(!in_array($year, $resultat['line']['annee'], true)) {
                $nbRealise = $action->where('deleted', 0)->whereYear('date_creation', (string) $year)->where('deleted', 0)->whereNotNull('date_realisation')->count();
                $nbNonRealise = $action->where('deleted', 0)->whereYear('date_creation', (string) $year)->where('deleted', 0)->whereNull('date_realisation')->count();

                array_push($resultat['line']['annee'], $year);
                array_push($resultat['line']['nbRealise'], $nbRealise);
                array_push($resultat['line']['nbNonRealise'], $nbNonRealise);
            }
        }

        return json_encode($resultat);
    }
}