<?php
namespace App\Classes;

use Illuminate\Http\Request;

use App\Election;

use Carbon\Carbon;

use App\Classes\TempsClass;

class ElectionClass
{
	public function insert($request)
	{
		$election = new Election();

		$election->date = $request->input('date');
		$election->type = $request->input('type');
		$election->nb = $request->input('nb');

		if($election->save()) {
			return back()->with('valide', "Les données ont bien été insérées.");
		} else {
			return back()->with('erreur', "Les données n'ont pas pu être insérées.");
		}
	}

	public function delete($id)
	{
		$election = new Election();

		if($election->find($id)->delete()) {
			return back()->with('valide', "Le nombre d'inscription désigné a bien été supprimé.");
		} else {
			return back()->with('erreur', "Le nombre d'inscription désigné n'a pas pu être supprimé, peut-être n'existe-t-il pas.");
		}
	}

	public function totalRecensementNbPerDay($day, $month, $year)
	{
		$election = new Election();
		$nb = 0;

		foreach($election->where('type', "recensement")->get() as $elections) {
			if(Carbon::createFromFormat("d/m/Y", $elections->date)->day == $day && Carbon::createFromFormat("d/m/Y", $elections->date)->month == $month && Carbon::createFromFormat("d/m/Y", $elections->date)->year == $year) {
				$nb += $elections->nb;
			}
		}

		return $nb;
	}

	public function totalRecensementNbPerMonth($month, $year)
	{
		$election = new Election();
		$nb = 0;

		foreach($election->where('type', "recensement")->get() as $elections) {
			if(Carbon::createFromFormat("d/m/Y", $elections->date)->month == $month && Carbon::createFromFormat("d/m/Y", $elections->date)->year == $year) {
				$nb += $elections->nb;
			}
		}

		return $nb;
	}

	public function totalRecensementNbPerYear($year)
	{
		$election = new Election();
		$nb = 0;

		foreach($election->where('type', "recensement")->get() as $elections) {
			if(Carbon::createFromFormat("d/m/Y", $elections->date)->year == $year) {
				$nb += $elections->nb;
			}
		}

		return $nb;
	}

	public function totalRecensementNbPerSpecial($day, $month)
	{
		$election = new Election();
		$nb = 0;

		foreach($election->where('type', "recensement")->get() as $elections) {
			if(Carbon::createFromFormat("d/m/Y", $elections->date)->day == $day && Carbon::createFromFormat("d/m/Y", $elections->date)->month == $month) {
				$nb += $elections->nb;
			}
		}

		return $nb;
	}

	public function totalVoteNbPerDay($day, $month, $year)
	{
		$election = new Election();
		$nb = 0;

		foreach($election->where('type', "vote")->get() as $elections) {
			if(Carbon::createFromFormat("d/m/Y", $elections->date)->day == $day && Carbon::createFromFormat("d/m/Y", $elections->date)->month == $month && Carbon::createFromFormat("d/m/Y", $elections->date)->year == $year) {
				$nb += $elections->nb;
			}
		}

		return $nb;
	}

	public function totalVoteNbPerMonth($month, $year)
	{
		$election = new Election();
		$nb = 0;

		foreach($election->where('type', "vote")->get() as $elections) {
			if(Carbon::createFromFormat("d/m/Y", $elections->date)->month == $month && Carbon::createFromFormat("d/m/Y", $elections->date)->year == $year) {
				$nb += $elections->nb;
			}
		}

		return $nb;
	}

	public function totalVoteNbPerYear($year)
	{
		$election = new Election();
		$nb = 0;

		foreach($election->where('type', "vote")->get() as $elections) {
			if(Carbon::createFromFormat("d/m/Y", $elections->date)->year == $year) {
				$nb += $elections->nb;
			}
		}

		return $nb;
	}

	public function totalVoteNbPerSpecial($day, $month)
	{
		$election = new Election();
		$nb = 0;

		foreach($election->where('type', "vote")->get() as $elections) {
			if(Carbon::createFromFormat("d/m/Y", $elections->date)->day == $day && Carbon::createFromFormat("d/m/Y", $elections->date)->month == $month) {
				$nb += $elections->nb;
			}
		}

		return $nb;
	}
}