<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ActionRequest;

use Carbon\Carbon;
use App\Action;

use App\Classes\ActionClass;
use App\Classes\TempsClass;

class ActionController extends Controller
{
    public function index(Action $action, $id, ActionClass $actionClass) 
    {
    	return view("action")->with([
    		'action' => $action->where('deleted', 0)->orderBy('id', 'DESC')->get(),
            'actionCurrent' => $action->find($id),
    		'actionClass' => $actionClass,
    		'temps' => new TempsClass(),
    		'carbon' => new Carbon(),
            'id' => $id
    	]);
    }

    public function redirectFirst(Action $action)
    {
        $firstId = $action->where('deleted', 0)->orderBy("id", "ASC")->first()->id;

        return redirect('action/'.$firstId);
    }

    public function delete($id, ActionClass $actionClass)
    {
        return $actionClass->delete($id);
    }

    public function editActionTitre(ActionRequest $request, ActionClass $actionClass)
    {
        return $actionClass->ajax('edit', 'nom', $request);
    }

    public function editActionDescription(ActionRequest $request, ActionClass $actionClass)
    {
        return $actionClass->ajax('edit', 'description', $request);
    }

    public function editActionDateCreation(ActionRequest $request, ActionClass $actionClass)
    {
        return $actionClass->ajax('edit', 'date-creation', $request);
    }

    public function editActionDateRealisation(ActionRequest $request, ActionClass $actionClass)
    {
        return $actionClass->ajax('edit', 'date-realisation', $request);
    }

    public function editActionDateButoire(ActionRequest $request, ActionClass $actionClass)
    {
        return $actionClass->ajax('edit', 'date-butoire', $request);
    }

    public function ajoutAction(ActionRequest $request, ActionClass $actionClass)
    {
        return $actionClass->ajax('add', null, $request);
    }

    public function getAlert(Request $request, ActionClass $actionClass)
    {
        return $actionClass->ajax('get', 'alerte', $request);
    }

    public function getJourRestant(ActionRequest $request, ActionClass $actionClass)
    {
        return $actionClass->ajax('get', 'date_butoire', $request);
    }
}