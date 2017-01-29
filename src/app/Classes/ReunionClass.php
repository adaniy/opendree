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
                "status" => "success"
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