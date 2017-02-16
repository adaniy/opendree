<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Action;
use App\Reunion;
use App\Election;

class ArchiveController extends Controller
{
    protected $nbParPage = 30;

    public function index()
    {
        return view('archive.index')->with([
            "nbAction" => Action::count(),
            "nbReunion" => Reunion::count(),
            "nbElection" => Election::count(),
            "nbActionDeleted" => (Action::withTrashed()->count() - Action::count()),
            "nbReunionDeleted" => (Reunion::withTrashed()->count() - Reunion::count())
        ]);
    }

    public function indexAction()
    {
        return view('archive.action')->with([
            "action" => Action::onlyTrashed()->paginate($this->nbParPage)
        ]);
    }

    public function indexReunion()
    {
        return view('archive.reunion')->with([
            "reunion" => Reunion::onlyTrashed()->paginate($this->nbParPage)
        ]);
    }

    public function indexElection()
    {
        return view('archive.election')->with([
            "election" => Election::paginate($this->nbParPage)
        ]);
    }

    public function deleteElection($id)
    {
        $election = Election::find($id);

        if($election) {
            $election->where('id', $id)->delete();
        }

        return back();
    }
}
