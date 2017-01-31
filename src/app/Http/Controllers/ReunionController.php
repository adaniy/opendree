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
    
    public function index(Reunion $reunion, ReunionClass $reunionClass)
    {
    	return view("reunion.index")->with([
    		'reunion' => $reunion->orderBy('id', 'desc')->paginate($this->nbParPage),
    		'reunionClass' => $reunionClass,
    		'carbon' => new Carbon()
    	]);
    }

    public function add(ReunionClass $reunionClass)
    {
        return $reunionClass->add();
    }

    public function addSujet($id, ReunionClass $reunionClass)
    {
        return $reunionClass->addSujet($id);
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

    public function delete($id, ReunionClass $reunionClass)
    {
        return $reunionClass->delete($id);
    }

    public function deleteSujet($id, ReunionClass $reunionClass)
    {
        return $reunionClass->deleteSujet($id);
    }
}
