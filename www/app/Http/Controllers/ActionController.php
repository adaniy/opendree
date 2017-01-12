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
    		'action' => $action->orderBy('date_creation', 'DESC')->get(),
            'actionCurrent' => $action->find($id),
    		'actionClass' => $actionClass,
    		'temps' => new TempsClass(),
    		'carbon' => new Carbon()
    	]);
    }

    public function redirectFirst(Action $action)
    {
        $firstId = $action->orderBy("date_creation", "ASC")->first()->id;

        return redirect('action/'.$firstId);
    }

    public function editActionTitre(ActionRequest $request, ActionClass $actionClass)
    {
        return $actionClass->ajax('edit', 'nom', $request);
    }

    public function ajoutAction(ActionRequest $request, ActionClass $actionClass)
    {
        return $actionClass->ajax('add', null, $request);
    }
}