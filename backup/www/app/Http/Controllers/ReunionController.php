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
    
    public function index(Reunion $reunion, ReunionClass $reunionClass, TempsClass $tempsClass)
    {
    	return view("reunion.index")->with([
    		'reunion' => $reunion->orderBy('id', 'desc')->paginate($this->nbParPage),
    		'reunionClass' => $reunionClass,
    		'temps' => $tempsClass,
    		'carbon' => new Carbon()
    	]);
    }

    public function postRecherche(ReunionRechercheRequest $request, Reunion $reunion, ReunionClass $reunionClass, TempsClass $temps)
    {
        $id = $request->input('id');
        $sujet = $request->input('sujet');
        $date = $request->input('date');

        // Si l'id est remplis, mais que le sujet et la date ne le sont pas...
        if(!empty($id)) {
            return view('reunion.recherche')->with([
                'reunion' => $reunion->where("id", "=", $id)->orderBy('id', 'desc')->get(),
                'reunionClass' => $reunionClass,
                'temps' => $temps
            ]);
        } elseif(empty($id) AND !empty($sujet) AND empty($date)) {
            return view('reunion.recherche')->with([
                'reunion' => $reunion->where("sujet", "LIKE", "%$sujet%")->orderBy('id', 'desc')->get(),
                'reunionClass' => $reunionClass,
                'temps' => $temps
            ]);
        } elseif(empty($id) AND empty($sujet) AND !empty($date)) {
            return view('reunion.recherche')->with([
                'reunion' => $reunion->where("date", "LIKE", "%$date%")->orderBy('id', 'desc')->get(),
                'reunionClass' => $reunionClass,
                'temps' => $temps
            ]);
        } elseif(empty($id) AND !empty($sujet) AND !empty($date)) {
            return view('reunion.recherche')->with([
                'reunion' => $reunion->where("date", "LIKE", "%$date%")->orWhere("sujet", "LIKE", "#$sujet#")->orderBy('id', 'desc')->get(),
                'reunionClass' => $reunionClass,
                'temps' => $temps
            ]);
        } else {
            return back()->with("erreur", "Vous devez remplir un champs de recherche afin d'effectuer une recherche.");
        }
    }

    // accède à une réunion
    public function access($id, Reunion $reunion, ReunionParticipant $reunionParticipant, ReunionSujet $reunionSujet, ReunionClass $reunionClass, TempsClass $tempsClass) 
    {
    	return view('reunion.access')->with([
    		'id' => $id,
    		'reunion' => $reunion->find($id),
    		'reunionParticipant' => $reunionParticipant->where('reunion_id', $id),
    		'reunionParticipant2' => $reunionParticipant->where('reunion_id', $id),
    		'reunionParticipant3' => $reunionParticipant->where('reunion_id', $id),
    		'reunionSujet' => $reunionSujet->where('reunion_id', $id)->get(),
    		'reunionClass' => $reunionClass,
    		'temps' => $tempsClass
    	]);
    }

    // version imprimable d'une réunion
    public function printable($id, Reunion $reunion, ReunionParticipant $reunionParticipant, ReunionSujet $reunionSujet, ReunionClass $reunionClass, TempsClass $tempsClass) 
    {
    	return view('reunion.printable')->with([
    		'id' => $id,
    		'reunion' => $reunion->find($id),
    		'reunionParticipant' => $reunionParticipant->where('reunion_id', $id),
    		'reunionParticipant2' => $reunionParticipant->where('reunion_id', $id),
    		'reunionParticipant3' => $reunionParticipant->where('reunion_id', $id),
    		'reunionSujet' => $reunionSujet->where('reunion_id', $id)->get(),
    		'reunionClass' => $reunionClass,
    		'temps' => $tempsClass
    	]);
    }

    public function deleteReunionParticipant($id, ReunionClass $reunionClass)
    {
    	return $reunionClass->deleteParticipant($id);
    }

    public function deleteReunion($id, ReunionClass $reunionClass)
    {
    	return $reunionClass->delete($id);
    }

    public function getReunion()
    {
    	return view("reunion.insert");
    }

    public function postReunion(ReunionRequest $request, ReunionClass $reunionClass)
    {
    	return $reunionClass->insert($request);
    }

    public function getEditReunion($id, Reunion $reunion, ReunionClass $reunionClass)
    {	
    	return view("reunion.edit")->with([
    		'id' => $id,
    		'reunionClass' => $reunionClass,
    		'reunion' => $reunion->find($id)
    	]);
    }

    public function postEditReunion($id, ReunionRequest $request, ReunionClass $reunionClass)
    {	
    	return $reunionClass->edit($request, $id);
    }

    public function getReunionSujet($id)
    {	
    	return view("reunion.insert-sujet")->with([
    		'id' => $id
    	]);
    }

    public function deleteReunionSujet($id, ReunionClass $reunionClass)
    {
    	return $reunionClass->deleteSujet($id);
    }

    public function postReunionSujet(ReunionSujetRequest $request, ReunionClass $reunionClass)
    {
    	return $reunionClass->insertSujet($request);
    }

    public function getEditReunionSujet($id, ReunionSujet $reunionSujet, ReunionClass $reunionClass)
    {	
    	return view("reunion.edit-sujet")->with([
    		'id' => $id,
    		'reunionClass' => $reunionClass,
    		'reunionSujet' => $reunionSujet->find($id)
    	]);
    }

    public function postEditReunionSujet($id, ReunionSujetRequest $request, ReunionClass $reunionClass)
    {
    	return $reunionClass->editSujet($request, $id);
    }

    public function postReunionParticipant(ReunionParticipantRequest $request, ReunionClass $reunionClass)
    {
    	return $reunionClass->insertParticipant($request);
    }
}
