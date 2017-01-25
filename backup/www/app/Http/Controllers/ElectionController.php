<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ElectionRequest;
use App\Http\Requests\ElectionRechercheRequest;

use App\Election;

use Carbon\Carbon;

use App\Classes\TempsClass;
use App\Classes\ElectionClass;

class ElectionController extends Controller
{
	private $nbParPage = 20;

    public function index(Election $election, ElectionClass $electionClass, TempsClass $tempsClass, Carbon $carbon)
	{
		return view('election.index')->with([
			'election' => $election,
			'electionClass' => $electionClass,
			'tempsClass' => $tempsClass,
			'carbon' => $carbon
		]);
	}

	public function printable(Election $election, ElectionClass $electionClass, TempsClass $tempsClass, Carbon $carbon)
	{
		return view('election.printable')->with([
			'election' => $election,
			'electionClass' => $electionClass,
			'tempsClass' => $tempsClass,
			'carbon' => $carbon
		]);
	}

	public function insert(ElectionRequest $request, ElectionClass $electionClass)
	{
		return $electionClass->insert($request);
	}

	public function indexBrut(Election $election, ElectionClass $electionClass, TempsClass $tempsClass, Carbon $carbon)
	{
		return view('election.index-brut')->with([
			'election' => $election->orderBy('id', 'desc')->paginate($this->nbParPage),
			'electionClass' => $electionClass,
			'tempsClass' => $tempsClass,
			'carbon' => $carbon
		]);
	}

	public function rechercheBrut(ElectionRechercheRequest $request, Election $election, ElectionClass $electionClass, TempsClass $tempsClass, Carbon $carbon)
	{
		$type = $request->input('type');
		$date = $request->input('date');

		if(empty($type) && !empty($date)) {
			return view('election.recherche-brut')->with([
			'election' => $election
			->where("date", "LIKE", "%$date%")
			->orderBy('id', 'desc')
			->get(),
			'electionClass' => $electionClass,
			'tempsClass' => $tempsClass,
			'carbon' => $carbon
			]);
		} elseif(!empty($type) && empty($date)) {
			return view('election.recherche-brut')->with([
			'election' => $election
			->where("type", "LIKE", "%$type%")
			->orderBy('id', 'desc')
			->get(),
			'electionClass' => $electionClass,
			'tempsClass' => $tempsClass,
			'carbon' => $carbon
			]);
		} elseif(!empty($type) && !empty($date)) {
			return view('election.recherche-brut')->with([
			'election' => $election
			->where("type", "LIKE", "%$type%")
			->where("date", "LIKE", "%$date%")
			->orderBy('id', 'desc')
			->get(),
			'electionClass' => $electionClass,
			'tempsClass' => $tempsClass,
			'carbon' => $carbon
			]);
		} else {

		}
	}

	public function supprimer($id, ElectionClass $electionClass)
	{
		return $electionClass->delete($id);
	}
}
