<?php
namespace App\Classes;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Reunion;
use App\ReunionParticipant;
use App\ReunionSujet;

use App\Classes\TempsClass;

class ReunionClass extends TempsClass
{
    public function __construct()
    {
        $this->reunion = new Reunion;
        $this->reunionParticipant = new ReunionParticipant;
        $this->reunionSujet = new ReunionSujet;

        $this->carbon = new Carbon;
    }

    public function nbParticipant($id)
    {
        return $this->reunionParticipant->where('reunion_id', $id)->count();
    }

    /**
     * Ajoute une réunion avec des valeurs par défaut.
     * @param void
     * @return json.status = "success"
     * @exception json.status = "error"
     * @see Reunion()
     */
    public function add()
    {
        $default = [
            "sujet" => "Nouvelle réunion",
            "date" => Carbon::now(),
            "date_prochain" => ""
        ];

        $this->reunion->sujet = $default['sujet'];
        $this->reunion->date = $default['date'];
        $this->reunion->date_prochain = $default['date_prochain'];

        if($this->reunion->save()) {
            $response = [
                "status" => "success",
                "message" => "Une réunion vien d'être créé."
            ];
        } else {
            $response = [
                "status" => "error"
            ];
        }

        return json_encode($response);
    }

    /**
     * Ajoute un sujet dans une réunion
     * @param $id
     * @return json.status = "success"
     * @exception json.status = "error"
     * @see Reunion();
     */
    public function addSujet($id)
    {
        $default = [
            "sujet" => "Nouveau sujet",
            "observation" => "Observation associée",
            "action" => "Action à entreprendre associée"
        ];

        if($this->reunion->find($id)) {
            $this->reunionSujet->reunion_id = $id;
            $this->reunionSujet->sujet = $default['sujet'];
            $this->reunionSujet->observation = $default['observation'];
            $this->reunionSujet->action = $default['action'];

            $this->reunionSujet->save();

            $resultat = [
                "status" => "success",
                "id" => $this->reunionSujet->id,
                "sujet" => $default['sujet'],
                "observation" => $default['observation'],
                "action" => $default['action']
            ];
        } else {
            $resultat = [
                "status" => "error"
            ];
        }

        return json_encode($resultat);
    }

    /**
     * Ajoute un participant dans une réunion
     * @param $request
     * @return json.status = "success"
     * @exception json.status = "error"
     * @see Reunion(); ReunionParticipant; Request()
     */
    public function addParticipant($request)
    {
        $id = $request->get('id');
        $type = $request->get('type');
        $nom = $request->get('nom');

        if($this->reunion->find($id)) {
            $this->reunionParticipant->reunion_id = $id;
            $this->reunionParticipant->type = $type;
            $this->reunionParticipant->nom = $nom;

            $this->reunionParticipant->save();

            $resultat = [
                "status" => "success",
                "id" => $this->reunionParticipant->id,
                "reunion_id" => $id,
                "type" => $type,
                "nom" => $nom
            ];
        } else {
            $resultat = [
                "status" => "error"
            ];
        }

        return json_encode($resultat);
    }

    /**
     * Modification du sujet d'une réunion
     * @param $request
     * @return json.status = "success"
     * @exception json.status = "error"
     * @see ReunionSujetRequest() ; Middlewares
     */
    public function editSujet($request)
    {
        $id = $request->get("id");
        $sujet = $request->get("sujet");

        if($this->reunionSujet->find($id)) {
            $this->reunionSujet->where('id', $id)->update([
                'sujet' => $sujet
            ]);

            $resultat = [
                "status" => "success",
                "sujet" => $sujet
            ];
        } else {
            $resultat = [
                "status" => "error"
            ];
        }

        return json_encode($resultat);
    }

    /**
     * Modification de l'observation d'un sujet de réunion.
     * @param $request
     * @return json.status = "success"
     * @exception json.status = "error"
     * @see ReunionSujetRequest() ; Middlewares
     */
    public function editObservation($request)
    {
        $id = $request->get("id");
        $observation = $request->get("observation");

        if($this->reunionSujet->find($id)) {
            $this->reunionSujet->where('id', $id)->update([
                'observation' => $observation
            ]);

            $resultat = [
                "status" => "success",
                "observation" => $observation
            ];
        } else {
            $resultat = [
                "status" => "error"
            ];
        }

        return json_encode($resultat);
    }

    /**
     * Modification de l'action d'un sujet de réunion.
     * @param $request
     * @return json.status = "success"
     * @exception json.status = "error"
     * @see ReunionSujetRequest() ; Middlewares
     */
    public function editAction($request)
    {
        $id = $request->get("id");
        $action = $request->get("action");

        if($this->reunionSujet->find($id)) {
            $this->reunionSujet->where('id', $id)->update([
                'action' => $action
            ]);

            $resultat = [
                "status" => "success",
                "action" => $action
            ];
        } else {
            $resultat = [
                "status" => "error"
            ];
        }

        return json_encode($resultat);
    }

    /**
     * Supprime une réunion.
     * @param $id
     * @return json.status = "success"
     * @exception json.status = "error"
     * @see Reunion(); softDeletes()
     */
    public function delete($id)
    {
        if($this->reunion->find($id)) {
            $this->reunion->find($id)->delete();

            $response = [
                "status" => "success",
                "message" => "La réunion selectionnée a bien été supprimée.",
                "id" => $id,
            ];
        } else {
            $response = [
                "status" => "error"
            ];
        }

        return json_encode($response);
    }

    /**
     * Supprime un sujet de réunion.
     * @param $id
     * @return json.status = "success"
     * @exception json.status = "error"
     * @see Reunion();
     */
    public function deleteSujet($id)
    {
        if($this->reunionSujet->find($id)) {
            $this->reunionSujet->find($id)->delete();

            $response = [
                "status" => "success",
                "message" => "Le sujet selectionné a bien été supprimée.",
                "id" => $id,
            ];
        } else {
            $response = [
                "status" => "error"
            ];
        }

        return json_encode($response);
    }

    /**
     * Supprime le participant d'une réunion.
     * @param $id
     * @return json.status = "success"
     * @exception json.status = "error"
     * @see ReunionParticipant()
     */
    public function deleteParticipant($id)
    {
        if($this->reunionParticipant->find($id)) {
            $this->reunionParticipant->find($id)->delete();

            $response = [
                "status" => "success",
                "message" => "Le participant selectionné a bien été supprimée.",
                "id" => $id,
            ];
        } else {
            $response = [
                "status" => "error"
            ];
        }

        return json_encode($response);
    }

    /**
     * Retourne la date d'une réunion, partie "date"
     * @param $id
     * @return $date
     * @exception null
     * @see TempsClass() ; Carbon() ; HTML5's input date
     */
    public function getDateDate($id)
    {
        if($this->reunion->find($id)) {
            return $this->carbon->parse($this->reunion->find($id)->date)->format("Y-m-d");
        } else {
            return null;
        }

        return $date;
    }

    /**
     * Retourne la date d'une réunion, partie "time"
     * @param $id
     * @return $date
     * @exception null
     * @see TempsClass() ; Carbon() ; HTML5's input date
     */
    public function getDateTime($id)
    {
        if($this->reunion->find($id)) {
            return $this->carbon->parse($this->reunion->find($id)->date)->format("H:i");
        } else {
            return null;
        }

        return $date;
    }

    /**
     * Retourne la date prochaine d'une réunion, partie "date"
     * @param $id
     * @return $date
     * @exception null || empty
     * @see TempsClass() ; Carbon() ; HTML5's input date
     */
    public function getDateProchainDate($id)
    {
        if($this->reunion->find($id)) {
            /** S'il n'y a pas de date prochaine, on ne renvoie rien */
            if(!empty($this->reunion->find($id)->date_prochain)) {
                return $this->carbon->parse($this->reunion->find($id)->date_prochain)->format("Y-m-d");
            } else {
                return '';
            }
        } else {
            return null;
        }

        return $date;
    }

    /**
     * Retourne la date prochaine d'une réunion, partie "time"
     * @param $id
     * @return $date
     * @exception null
     * @see TempsClass() ; Carbon() ; HTML5's input date
     */
    public function getDateProchainTime($id)
    {
        if($this->reunion->find($id)) {
            /** S'il n'y a pas de date prochaine, on ne renvoie rien */
            if(!empty($this->reunion->find($id)->date_prochain)) {
                return $this->carbon->parse($this->reunion->find($id)->date_prochain)->format("H:i");
            } else {
                return '';
            }
        } else {
            return null;
        }

        return $date;
    }
}