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
    public function index(Action $action, ActionClass $actionClass)
    {
        return view("action.index")->with([
    		'action' => $action->where('deleted', 0)->orderBy('alert', 'DESC')->orderBy('date_butoir', 'ASC')->orderBy('id', 'DESC')->get(),
    		'actionClass' => $actionClass,
    		'temps' => new TempsClass(),
    		'carbon' => new Carbon()
    	]);
    }
    
    public function getAction(Action $action, $id, ActionClass $actionClass) 
    {
    	return view("action.get")->with([
    		'action' => $action->where('deleted', 0)->orderBy('alert', 'DESC')->orderBy('date_butoir', 'ASC')->orderBy('id', 'DESC')->get(),
            'actionCurrent' => $action->find($id),
    		'actionClass' => $actionClass,
    		'temps' => new TempsClass(),
    		'carbon' => new Carbon(),
            'id' => $id
    	]);
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

    public function editActionDateButoir(ActionRequest $request, ActionClass $actionClass)
    {
        return $actionClass->ajax('edit', 'date-butoir', $request);
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
        return $actionClass->ajax('get', 'date_butoir', $request);
    }

    public function stats(ActionClass $actionClass)
    {
        return $actionClass->stats();
    }

    public function actionAlert($id, ActionClass $actionClass)
    {
        return $actionClass->canAlertBoolean($id);
    }
}