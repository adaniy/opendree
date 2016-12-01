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
    	return view("index")->with([
    		'action' => $action->orderBy('date_butoire', 'ASC')->get(),
    		'actionClass' => $actionClass,
    		'temps' => new TempsClass(),
    		'carbon' => new Carbon()
    	]);
    }

    public function getAction(Action $action) 
    {
    	return view("action.insert");
    }

    public function postAction(ActionRequest $request, ActionClass $actionClass)
    {
    	return $actionClass->insert($request);
    }

    public function getEditAction($id, Action $action) 
    {
    	return view("action.edit")->with([
    		'id' => $id,
    		'action' => $action->find($id)
    	]);
    }

    public function postEditAction($id, ActionRequest $request)
    {
    	$actionClass = new ActionClass();

    	return $actionClass->update($id, $request);
    }

    public function deleteAction($id, ActionClass $actionClass)
    {
    	return $actionClass->delete($id);
    }
}