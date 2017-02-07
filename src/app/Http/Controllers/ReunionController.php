<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReunionRequest;
use App\Http\Requests\ReunionSujetRequest;
use App\Http\Requests\ReunionParticipantRequest;
use App\Http\Requests\ReunionRechercheRequest;

use Carbon\Carbon;

use App\Action;
use App\Reunion;
use App\ReunionParticipant;
use App\ReunionSujet;

use App\Classes\ReunionClass;
use App\Classes\TempsClass;

class ReunionController extends Controller
{
    private $nbParPage = 20;

    public function index(Reunion $reunion, ReunionParticipant $reunionParticipant, ReunionClass $reunionClass)
    {
        return view("reunion.index")->with([
            'reunion' => $reunion->orderBy('id', 'desc')->paginate($this->nbParPage),
            'reunionParticipant' => $reunionParticipant,
            'reunionClass' => $reunionClass,
            'carbon' => new Carbon()
        ]);
    }

    public function get()
    {
        return Reunion::all();
    }

    public function add(ReunionClass $reunionClass)
    {
        return $reunionClass->add();
    }

    public function addSujet($id, ReunionClass $reunionClass)
    {
        return $reunionClass->addSujet($id);
    }

    public function addParticipant(ReunionParticipantRequest $request, ReunionClass $reunionClass)
    {
        return $reunionClass->addParticipant($request);
    }

    public function edit(ReunionRequest $request)
    {
        $id = $request->get('id');
        $sujet = $request->get('sujet');
        $reunion = Reunion::find($id);

        if($reunion) {
            $reunion->sujet = $sujet;
            $reunion->save();

            $response = [
                "status" => "success"
            ];
        } else {
            $response = [];
        }

        return json_encode($response);
    }

    public function editSujet(ReunionSujetRequest $request, ReunionClass $reunionClass)
    {
        return $reunionClass->editSujet($request);
    }

    public function editObservation(ReunionSujetRequest $request, ReunionClass $reunionClass)
    {
        return $reunionClass->editObservation($request);
    }

    public function editAction(ReunionSujetRequest $request, ReunionClass $reunionClass)
    {
        return $reunionClass->editAction($request);
    }

    public function editParticipant(ReunionParticipantRequest $request, ReunionClass $reunionClass)
    {
        return $reunionClass->editParticipant($request);
    }

    public function delete($id)
    {
        $reunion = Reunion::find($id);

        if($reunion->delete()) {
            $response = [
                "status" => "success"
            ];
        } else {
            $response = [];
        }

        return json_encode($response);
    }

    public function deleteSujet($id, ReunionClass $reunionClass)
    {
        return $reunionClass->deleteSujet($id);
    }

    public function deleteParticipant($id, ReunionClass $reunionClass)
    {
        return $reunionClass->deleteParticipant($id);
    }
}
